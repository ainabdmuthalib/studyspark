<?php
require 'dbcon.php';
session_start();
header('Content-Type: application/json');

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
if (!$class_id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing class_id']);
    exit;
}

$session_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

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
            'is_current_user' => ($session_id && $row['student_id'] == $session_id),
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

    // Get total materials for the class
    $materials_total = 0;
    $res = $conn->query("SELECT file_id FROM files WHERE class_id = '".$conn->real_escape_string($class_id)."'");
    $materials_total = $res->num_rows;

    $leaderboard = [];
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

        // Materials viewed and downloaded
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

        $leaderboard[] = array_merge($student, [
            'assignments_completed' => $ac,
            'assignments_total' => $assignments_total,
            'assignment_avg_grade' => $assignment_avg_grade,
            'quizzes_taken' => $qc,
            'quizzes_total' => $quizzes_total,
            'quiz_avg_grade' => $quiz_avg_grade,
            'materials_viewed' => $materials_viewed,
            'materials_downloaded' => $materials_downloaded,
            'materials_total' => $materials_total,
        ]);
    }

    // Sort leaderboard by assignments_completed, quizzes_taken, then name
    usort($leaderboard, function($a, $b) {
        if ($b['assignments_completed'] !== $a['assignments_completed'])
            return $b['assignments_completed'] - $a['assignments_completed'];
        if ($b['quizzes_taken'] !== $a['quizzes_taken'])
            return $b['quizzes_taken'] - $a['quizzes_taken'];
        return strcmp($a['lastname'], $b['lastname']);
    });

    echo json_encode(['status' => 'success', 'leaderboard' => $leaderboard]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} 