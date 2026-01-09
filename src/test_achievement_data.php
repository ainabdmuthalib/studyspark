<?php
require 'dbcon.php';
session_start();

// Test class ID (you can change this to test different classes)
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '1';

echo "<h2>Testing Achievement Bar Chart Leaderboard Data</h2>";
echo "<p>Class ID: $class_id</p>";
echo "<p><strong>Note:</strong> The Class Progress Leaderboard is now arranged by Overall Progress % (which includes both completion metrics and grade performance).</p>";

try {
    // Get all students in the class
    $students = [];
    $stmt = $conn->prepare("SELECT student.student_id, student.firstname, student.lastname, student.location FROM teacher_class_student LEFT JOIN student ON student.student_id = teacher_class_student.student_id WHERE teacher_class_id = ?");
    $stmt->bind_param("s", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $students[$row['student_id']] = [
            'user_id' => $row['student_id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'avatar' => isset($row['location']) ? 'admin/' . $row['location'] : '',
        ];
    }

    // Get total assignments for the class
    $assignments_total = 0;
    $assignments = [];
    $res = $conn->query("SELECT assignment_id FROM assignment WHERE class_id = '".$conn->real_escape_string($class_id)."'");
    while ($row = $res->fetch_assoc()) {
        $assignments[] = $row['assignment_id'];
    }
    $assignments_total = count($assignments);

    // Get total quizzes for the class
    $quizzes_total = 0;
    $quizzes = [];
    $res = $conn->query("SELECT class_quiz_id FROM class_quiz WHERE teacher_class_id = '".$conn->real_escape_string($class_id)."'");
    while ($row = $res->fetch_assoc()) {
        $quizzes[] = $row['class_quiz_id'];
    }
    $quizzes_total = count($quizzes);

    echo "<h3>Class Summary:</h3>";
    echo "<ul>";
    echo "<li>Total Students: " . count($students) . "</li>";
    echo "<li>Total Assignments: $assignments_total</li>";
    echo "<li>Total Quizzes: $quizzes_total</li>";
    echo "</ul>";

    echo "<h3>Student Achievement Data:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>Student</th>";
    echo "<th>Assignments Completed</th>";
    echo "<th>Assignment Avg Grade</th>";
    echo "<th>Quizzes Taken</th>";
    echo "<th>Quiz Avg Grade</th>";
    echo "<th>Achievement Score (50% each)</th>";
    echo "<th>Overall Progress (New Weightage)</th>";
    echo "</tr>";

    foreach ($students as $student_id => $student) {
        // Assignments completed and average grade
        $ac = 0; $ag_sum = 0; $ag_count = 0;
        if ($assignments_total > 0) {
            $res = $conn->query("SELECT grade FROM student_assignment WHERE student_id = '".$conn->real_escape_string($student_id)."' AND assignment_id IN (".implode(',', array_map('intval', $assignments)).")");
            while ($row = $res->fetch_assoc()) {
                $ac++;
                if (is_numeric($row['grade'])) {
                    $ag_sum += floatval($row['grade']);
                    $ag_count++;
                }
            }
        }
        $assignment_avg_grade = $ag_count > 0 ? round($ag_sum / $ag_count, 2) : null;

        // Quizzes taken and average grade
        $qc = 0; $qg_sum = 0; $qg_count = 0;
        if ($quizzes_total > 0) {
            $res = $conn->query("SELECT grade FROM student_class_quiz WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_quiz_id IN (".implode(',', array_map('intval', $quizzes)).")");
            while ($row = $res->fetch_assoc()) {
                $qc++;
                if (is_numeric($row['grade'])) {
                    $qg_sum += floatval($row['grade']);
                    $qg_count++;
                } elseif (preg_match('/([\\d.]+)\\s*out\\s*of\\s*([\\d.]+)/i', $row['grade'], $m)) {
                    $score = floatval($m[1]);
                    $total = floatval($m[2]);
                    if ($total > 0) {
                        $percent = ($score / $total) * 100;
                        $qg_sum += $percent;
                        $qg_count++;
                    }
                }
            }
        }
        $quiz_avg_grade = $qg_count > 0 ? round($qg_sum / $qg_count, 2) : null;

        // Calculate achievement score (50% weight each)
        $assignmentWeight = $assignment_avg_grade !== null ? 0.5 : 0;
        $quizWeight = $quiz_avg_grade !== null ? 0.5 : 0;
        $totalWeight = $assignmentWeight + $quizWeight;
        $achievementScore = $totalWeight > 0 ? (
            ($assignment_avg_grade !== null ? $assignment_avg_grade * 0.5 : 0) +
            ($quiz_avg_grade !== null ? $quiz_avg_grade * 0.5 : 0)
        ) / $totalWeight : 0;

        // Calculate overall progress with new weightage
        $assignmentPercent = $assignments_total > 0 ? ($ac / $assignments_total * 100) : 0;
        $quizPercent = $quizzes_total > 0 ? ($qc / $quizzes_total * 100) : 0;
        
        // Get materials data for this student
        $materials_viewed = 0;
        $materials_downloaded = 0;
        $table_check = $conn->query("SHOW TABLES LIKE 'student_material_access'");
        if ($table_check && $table_check->num_rows) {
            $res2 = $conn->query("SELECT COUNT(DISTINCT file_id) AS viewed FROM student_material_access WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_id = '".$conn->real_escape_string($class_id)."' AND access_type = 'view'");
            $row2 = $res2 ? $res2->fetch_assoc() : ['viewed' => 0];
            $materials_viewed = intval($row2['viewed']);
            $res3 = $conn->query("SELECT COUNT(DISTINCT file_id) AS downloaded FROM student_material_access WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_id = '".$conn->real_escape_string($class_id)."' AND access_type = 'download'");
            $row3 = $res3 ? $res3->fetch_assoc() : ['downloaded' => 0];
            $materials_downloaded = intval($row3['downloaded']);
        }
        
        $materialsViewedPercent = $materials_total > 0 ? ($materials_viewed / $materials_total * 100) : 0;
        $materialsDownloadedPercent = $materials_total > 0 ? ($materials_downloaded / $materials_total * 100) : 0;
        
        $overallScore = 0;
        $weightSum = 0;
        
        // Completion metrics (80% total)
        if ($assignments_total > 0) {
            $overallScore += $assignmentPercent * 0.20; // 20%
            $weightSum += 0.20;
        }
        if ($quizzes_total > 0) {
            $overallScore += $quizPercent * 0.20; // 20%
            $weightSum += 0.20;
        }
        if ($materials_total > 0) {
            $overallScore += $materialsViewedPercent * 0.20; // 20%
            $weightSum += 0.20;
            $overallScore += $materialsDownloadedPercent * 0.20; // 20%
            $weightSum += 0.20;
        }
        
        // Grade performance (20% total)
        if ($assignment_avg_grade !== null) {
            $overallScore += $assignment_avg_grade * 0.10; // 10%
            $weightSum += 0.10;
        }
        if ($quiz_avg_grade !== null) {
            $overallScore += $quiz_avg_grade * 0.10; // 10%
            $weightSum += 0.10;
        }
        
        $overallProgress = $weightSum > 0 ? $overallScore / $weightSum : 0;

        echo "<tr>";
        echo "<td>{$student['firstname']} {$student['lastname']}</td>";
        echo "<td>$ac / $assignments_total</td>";
        echo "<td>" . ($assignment_avg_grade !== null ? $assignment_avg_grade . '%' : '0.0%') . "</td>";
        echo "<td>$qc / $quizzes_total</td>";
        echo "<td>" . ($quiz_avg_grade !== null ? $quiz_avg_grade . '%' : '0.0%') . "</td>";
        echo "<td>" . round($achievementScore, 2) . "%</td>";
        echo "<td>" . round($overallProgress, 2) . "%</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Create a summary ranking by overall progress
    echo "<h3>Class Progress Leaderboard Ranking (by Overall Progress %):</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 10px;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>Rank</th>";
    echo "<th>Student</th>";
    echo "<th>Overall Progress %</th>";
    echo "<th>Breakdown</th>";
    echo "</tr>";
    
    // Collect all students with their overall progress for ranking
    $studentsWithProgress = [];
    foreach ($students as $student_id => $student) {
        // Recalculate the same metrics as above
        $ac = 0; $ag_sum = 0; $ag_count = 0;
        if ($assignments_total > 0) {
            $res = $conn->query("SELECT grade FROM student_assignment WHERE student_id = '".$conn->real_escape_string($student_id)."' AND assignment_id IN (".implode(',', array_map('intval', $assignments)).")");
            while ($row = $res->fetch_assoc()) {
                $ac++;
                if (is_numeric($row['grade'])) {
                    $ag_sum += floatval($row['grade']);
                    $ag_count++;
                }
            }
        }
        $assignment_avg_grade = $ag_count > 0 ? round($ag_sum / $ag_count, 2) : null;

        $qc = 0; $qg_sum = 0; $qg_count = 0;
        if ($quizzes_total > 0) {
            $res = $conn->query("SELECT grade FROM student_class_quiz WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_quiz_id IN (".implode(',', array_map('intval', $quizzes)).")");
            while ($row = $res->fetch_assoc()) {
                $qc++;
                if (is_numeric($row['grade'])) {
                    $qg_sum += floatval($row['grade']);
                    $qg_count++;
                } elseif (preg_match('/([\\d.]+)\\s*out\\s*of\\s*([\\d.]+)/i', $row['grade'], $m)) {
                    $score = floatval($m[1]);
                    $total = floatval($m[2]);
                    if ($total > 0) {
                        $percent = ($score / $total) * 100;
                        $qg_sum += $percent;
                        $qg_count++;
                    }
                }
            }
        }
        $quiz_avg_grade = $qg_count > 0 ? round($qg_sum / $qg_count, 2) : null;

        // Get materials data
        $materials_viewed = 0;
        $materials_downloaded = 0;
        $table_check = $conn->query("SHOW TABLES LIKE 'student_material_access'");
        if ($table_check && $table_check->num_rows) {
            $res2 = $conn->query("SELECT COUNT(DISTINCT file_id) AS viewed FROM student_material_access WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_id = '".$conn->real_escape_string($class_id)."' AND access_type = 'view'");
            $row2 = $res2 ? $res2->fetch_assoc() : ['viewed' => 0];
            $materials_viewed = intval($row2['viewed']);
            $res3 = $conn->query("SELECT COUNT(DISTINCT file_id) AS downloaded FROM student_material_access WHERE student_id = '".$conn->real_escape_string($student_id)."' AND class_id = '".$conn->real_escape_string($class_id)."' AND access_type = 'download'");
            $row3 = $res3 ? $res3->fetch_assoc() : ['downloaded' => 0];
            $materials_downloaded = intval($row3['downloaded']);
        }

        // Calculate overall progress
        $assignmentPercent = $assignments_total > 0 ? ($ac / $assignments_total * 100) : 0;
        $quizPercent = $quizzes_total > 0 ? ($qc / $quizzes_total * 100) : 0;
        $materialsViewedPercent = $materials_total > 0 ? ($materials_viewed / $materials_total * 100) : 0;
        $materialsDownloadedPercent = $materials_total > 0 ? ($materials_downloaded / $materials_total * 100) : 0;
        
        $overallScore = 0;
        $weightSum = 0;
        
        // Completion metrics (80% total)
        if ($assignments_total > 0) {
            $overallScore += $assignmentPercent * 0.20;
            $weightSum += 0.20;
        }
        if ($quizzes_total > 0) {
            $overallScore += $quizPercent * 0.20;
            $weightSum += 0.20;
        }
        if ($materials_total > 0) {
            $overallScore += $materialsViewedPercent * 0.20;
            $weightSum += 0.20;
            $overallScore += $materialsDownloadedPercent * 0.20;
            $weightSum += 0.20;
        }
        
        // Grade performance (20% total)
        if ($assignment_avg_grade !== null) {
            $overallScore += $assignment_avg_grade * 0.10;
            $weightSum += 0.10;
        }
        if ($quiz_avg_grade !== null) {
            $overallScore += $quiz_avg_grade * 0.10;
            $weightSum += 0.10;
        }
        
        $overallProgress = $weightSum > 0 ? $overallScore / $weightSum : 0;
        
        $studentsWithProgress[] = [
            'name' => $student['firstname'] . ' ' . $student['lastname'],
            'progress' => $overallProgress,
            'breakdown' => "Assignments: " . round($assignmentPercent, 1) . "%, Quizzes: " . round($quizPercent, 1) . "%, Materials Viewed: " . round($materialsViewedPercent, 1) . "%, Materials Downloaded: " . round($materialsDownloadedPercent, 1) . "%, Assignment Grade: " . ($assignment_avg_grade !== null ? $assignment_avg_grade . '%' : '0.0%') . ", Quiz Grade: " . ($quiz_avg_grade !== null ? $quiz_avg_grade . '%' : '0.0%')
        ];
    }
    
    // Sort by overall progress (descending)
    usort($studentsWithProgress, function($a, $b) {
        return $b['progress'] - $a['progress'];
    });
    
    foreach ($studentsWithProgress as $idx => $student) {
        echo "<tr>";
        echo "<td>" . ($idx + 1) . "</td>";
        echo "<td>" . $student['name'] . "</td>";
        echo "<td><strong>" . round($student['progress'], 2) . "%</strong></td>";
        echo "<td style='font-size: 11px;'>" . $student['breakdown'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<h3>Raw Data from get_leaderboard_progress.php:</h3>";
    $api_url = "get_leaderboard_progress.php?class_id=" . urlencode($class_id);
    $api_response = file_get_contents($api_url);
    $api_data = json_decode($api_response, true);
    
    if ($api_data && $api_data['status'] === 'success') {
        echo "<pre>" . json_encode($api_data, JSON_PRETTY_PRINT) . "</pre>";
    } else {
        echo "<p style='color: red;'>Error fetching API data: " . ($api_data['message'] ?? 'Unknown error') . "</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { margin-top: 10px; }
th, td { padding: 8px; text-align: left; }
pre { background-color: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
</style> 