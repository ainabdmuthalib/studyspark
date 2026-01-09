<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php $current_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null; ?>
<body>
    <?php include('navbar_teacher.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('leaderboard_progress_lecturer_link.php'); ?>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <ul class="breadcrumb">
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM teacher_class
                            LEFT JOIN class ON class.class_id = teacher_class.class_id
                            LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                            WHERE teacher_class_id = ?");
                        $stmt->bind_param("s", $get_id);
                        $stmt->execute();
                        $row = $stmt->get_result()->fetch_assoc();
                        ?>
                        <li><a href="#"><?php echo $row['class_name']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><?php echo $row['subject_code']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#">Semester <?php echo $row['school_year']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><b>Leaderboard Progress</b></a></li>
                    </ul>
                    
                    <!-- Class Leaderboard Pie Chart Section -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Class Performance Overview</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="pie-charts-indicator" style="margin-bottom: 15px; padding: 10px; background: #f8f9fa; border-radius: 5px; border-left: 4px solid #007bff;">
                                    <strong>Class Performance Overview:</strong> These pie charts provide a visual summary of how the class is performing across completion rates and academic achievement.
                                </div>
                                <div class="pie-charts-container" style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                                    <!-- Completion Pie Chart -->
                                    <div class="pie-chart-section" style="flex: 1; min-width: 300px; text-align: center;">
                                        <h4 style="margin-bottom: 15px; color: #333;">Completion Chart</h4>
                                        <div class="pie-chart-description" style="margin-bottom: 10px; font-size: 12px; color: #666;">
                                            Shows the distribution of students based on their overall completion percentage (assignments, quizzes and materials engagement).
                                        </div>
                                        <div id="completion-pie-chart" style="width: 200px; height: 200px; margin: 0 auto;">
                                            <div class="text-center">
                                                <i class="icon-spinner icon-spin"></i> Loading pie chart...
                                            </div>
                                        </div>
                                        <div class="pie-legend" style="margin-top: 15px; font-size: 12px;">
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #4CAF50; border-radius: 50%; margin-right: 5px;"></span>
                                                High (80-100%) - <span id="completion-high-count">0</span> students
                                            </div>
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #FF9800; border-radius: 50%; margin-right: 5px;"></span>
                                                Medium (50-79%) - <span id="completion-medium-count">0</span> students
                                            </div>
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #F44336; border-radius: 50%; margin-right: 5px;"></span>
                                                Low (0-49%) - <span id="completion-low-count">0</span> students
                                            </div>
                                        </div>
                                        <div class="total-students" style="margin-top: 10px; font-weight: bold; color: #333;">
                                            Total Students: <span id="completion-total-count">0</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Achievement Pie Chart -->
                                    <div class="pie-chart-section" style="flex: 1; min-width: 300px; text-align: center;">
                                        <h4 style="margin-bottom: 15px; color: #333;">Achievement Chart</h4>
                                        <div class="pie-chart-description" style="margin-bottom: 10px; font-size: 12px; color: #666;">
                                            Shows the distribution of students based on their average assignment and quiz grades.
                                        </div>
                                        <div id="achievement-pie-chart" style="width: 200px; height: 200px; margin: 0 auto;">
                                            <div class="text-center">
                                                <i class="icon-spinner icon-spin"></i> Loading pie chart...
                                            </div>
                                        </div>
                                        <div class="pie-legend" style="margin-top: 15px; font-size: 12px;">
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #42e695; border-radius: 50%; margin-right: 5px;"></span>
                                                Excellent (90-100%) - <span id="achievement-excellent-count">0</span> students
                                            </div>
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #f7971e; border-radius: 50%; margin-right: 5px;"></span>
                                                Good (70-89%) - <span id="achievement-good-count">0</span> students
                                            </div>
                                            <div class="legend-item" style="display: inline-block; margin: 0 10px;">
                                                <span style="display: inline-block; width: 12px; height: 12px; background: #9C27B0; border-radius: 50%; margin-right: 5px;"></span>
                                                Needs Improvement (0-69%) - <span id="achievement-needs-improvement-count">0</span> students
                                            </div>
                                        </div>
                                        <div class="total-students" style="margin-top: 10px; font-weight: bold; color: #333;">
                                            Total Students: <span id="achievement-total-count">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Class Leaderboard Pie Chart Section -->
                    
                    <!-- Leaderboard Indicators -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Student Progress Leaderboards</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="leaderboards-indicator-container" style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 10px;">
                                    <div class="leaderboard-indicator" style="flex: 1; min-width: 300px;">
                                        <strong>Completion Bar Chart Leaderboard:</strong> This leaderboard shows each student's progress in completing assignments, quizzes and engaging with class materials.
                                    </div>
                                    <div class="leaderboard-indicator" style="flex: 1; min-width: 300px;">
                                        <strong>Achievement  Bar Chart Leaderboard:</strong> This leaderboard displays each student's average assignment and quiz grades as achievement metrics.
                                    </div>
                                </div>
                                <div class="leaderboards-container" style="display: flex; gap: 20px; flex-wrap: wrap;">
                                    <!-- Completion Leaderboard -->
                                    <div class="leaderboard-section" style="flex: 1; min-width: 400px;">
                                        <div id="completion-charts-container">
                                            <div class="text-center">
                                                <i class="icon-spinner icon-spin"></i> Loading completion charts...
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Achievement Leaderboard -->
                                    <div class="leaderboard-section" style="flex: 1; min-width: 400px;">
                                        <div id="achievement-charts-container">
                                            <div class="text-center">
                                                <i class="icon-spinner icon-spin"></i> Loading achievement charts...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Completion Bar Charts Section -->
                    
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Class Progress Leaderboard</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="leaderboard-container">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Rank</th>
                                                <th>Student</th>
                                                <th>Assignments<br>Completed/Total</th>
                                                <th>Avg Assignment Grade</th>
                                                <th>Quizzes<br>Taken/Total</th>
                                                <th>Avg Quiz Grade</th>
                                                <th>Materials<br>Viewed/Total</th>
                                                <th>Materials<br>Downloaded/Total</th>
                                                <th>Overall Progress %</th>
                                            </tr>
                                        </thead>
                                        <tbody id="leaderboard-progress-tbody">
                                            <tr><td colspan="9" class="text-center"><i class="icon-spinner icon-spin"></i> Loading...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
    <script>
    // Expose current user id to JS
    const CURRENT_USER_ID = <?php echo json_encode($current_user_id); ?>;
    </script>
    <style>
    .leaderboard-container { margin-bottom: 20px; }
    .leaderboard-item.current-user { background: #e0f7fa; font-weight: bold; }
    .leaderboard-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }
    .completion-chart, .achievement-chart {
        flex: 1 1 320px;
        min-width: 300px;
        max-width: 420px;
    }
    .completion-chart { margin-bottom: 0; }
    .achievement-chart { margin-bottom: 0; }
    /* Completion Charts Styles */
    .completion-chart {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .completion-chart.current-user {
        background: #e0f7fa;
        border-color: #00acc1;
        box-shadow: 0 2px 8px rgba(0,150,136,0.3);
    }
    .student-info {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .rank-badge {
        background: #333;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
        border: 2px solid #ddd;
    }
    .student-name {
        font-weight: bold;
        font-size: 14px;
        color: #333;
        flex-grow: 1;
    }
    .current-user-badge {
        background: #00acc1;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin-left: 8px;
    }
    .overall-score {
        background: #333;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: bold;
        font-size: 12px;
        margin-left: 10px;
    }
    .progress-section {
        margin-bottom: 8px;
    }
    .progress-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 3px;
        display: flex;
        justify-content: space-between;
    }
    .progress-bar-container {
        background: #e0e0e0;
        border-radius: 10px;
        height: 8px;
        overflow: hidden;
        margin-bottom: 5px;
    }
    .progress-bar {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }
    .progress-assignments { background: linear-gradient(90deg, #4CAF50, #66BB6A); }
    .progress-quizzes { background: linear-gradient(90deg, #2196F3, #42A5F5); }
    .progress-materials-viewed { background: linear-gradient(90deg, #FF9800, #FFB74D); }
    .progress-materials-downloaded { background: linear-gradient(90deg, #9C27B0, #BA68C8); }
    .bar-assignment-grade { background: linear-gradient(90deg, #42e695, #3bb2b8); }
    .bar-quiz-grade { background: linear-gradient(90deg, #f7971e, #ffd200); }
    .completion-percentage {
        font-size: 11px;
        color: #888;
        text-align: right;
    }
    @media (max-width: 900px) {
        .leaderboard-row { flex-direction: column; gap: 0; }
        .completion-chart, .achievement-chart { max-width: 100%; min-width: 0; }
    }
    .completion-chart.rank-1 {
        background: linear-gradient(135deg, #FFF9E5, #FFE9B2);
        border-color: #FFE0A3;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.15);
    }
    .completion-chart.rank-2 {
        background: linear-gradient(135deg, #F4F4F7, #E3E6EC);
        border-color: #D1D5DB;
        box-shadow: 0 4px 12px rgba(192, 192, 192, 0.15);
    }
    .completion-chart.rank-3 {
        background: linear-gradient(135deg, #F8F1EC, #F3E3D3);
        border-color: #E2C9B0;
        box-shadow: 0 4px 12px rgba(205, 127, 50, 0.15);
    }
    .rank-1 .rank-badge {
        background: linear-gradient(135deg, #FFF3C1, #FFE9B2);
        color: #333;
        font-size: 16px;
    }
    .rank-2 .rank-badge {
        background: linear-gradient(135deg, #E9E9F2, #D1D5DB);
        color: #333;
        font-size: 16px;
    }
    .rank-3 .rank-badge {
        background: linear-gradient(135deg, #F3E3D3, #E2C9B0);
        color: #7A5A3A;
        font-size: 16px;
    }
    .rank-1 .overall-score {
        background: linear-gradient(135deg, #FFF3C1, #FFE9B2);
        color: #333;
    }
    .rank-2 .overall-score {
        background: linear-gradient(135deg, #E9E9F2, #D1D5DB);
        color: #333;
    }
    .rank-3 .overall-score {
        background: linear-gradient(135deg, #F3E3D3, #E2C9B0);
        color: #7A5A3A;
    }
    .leaderboard-description { margin-bottom: 10px; color: #555; font-size: 13px; }
    
    /* Side-by-side leaderboard layout */
    .leaderboards-container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .leaderboard-section {
        flex: 1;
        min-width: 400px;
    }
    
    @media (max-width: 900px) {
        .leaderboards-container {
            flex-direction: column;
            gap: 30px;
        }
        
        .leaderboard-section {
            min-width: 100%;
        }
        
        .leaderboard-row { 
            flex-direction: column; 
            gap: 0; 
        }
        
        .completion-chart, .achievement-chart { 
            max-width: 100%; 
            min-width: 0; 
        }
    }
    </style>
    <script>
    function fetchLeaderboardProgress() {
        $.ajax({
            url: 'get_leaderboard_progress.php',
            type: 'GET',
            data: { class_id: '<?php echo $get_id; ?>' },
            dataType: 'json',
            success: function(response) {
                const tbody = $('#leaderboard-progress-tbody');
                const completionContainer = $('#completion-charts-container');
                const achievementContainer = $('#achievement-charts-container');
                const completionPieChart = $('#completion-pie-chart');
                const achievementPieChart = $('#achievement-pie-chart');
                
                tbody.empty();
                completionContainer.empty();
                achievementContainer.empty();
                
                if (response.status === 'success') {
                    // Calculate overall completion percentage and parse grades for each student
                    const studentsWithScores = response.leaderboard.map(function(user) {
                        const assignmentPercent = user.assignments_total > 0 ? (user.assignments_completed / user.assignments_total * 100) : 0;
                        const quizPercent = user.quizzes_total > 0 ? (user.quizzes_taken / user.quizzes_total * 100) : 0;
                        const materialsViewedPercent = user.materials_total > 0 ? (user.materials_viewed / user.materials_total * 100) : 0;
                        const materialsDownloadedPercent = user.materials_total > 0 ? (user.materials_downloaded / user.materials_total * 100) : 0;
                        // Parse grades as numbers (if available)
                        let assignmentGrade = user.assignment_avg_grade;
                        let quizGrade = user.quiz_avg_grade;
                        if (typeof assignmentGrade === 'string' && assignmentGrade.endsWith('%')) assignmentGrade = parseFloat(assignmentGrade);
                        if (typeof quizGrade === 'string' && quizGrade.endsWith('%')) quizGrade = parseFloat(quizGrade);
                        assignmentGrade = assignmentGrade !== null && !isNaN(assignmentGrade) ? parseFloat(assignmentGrade) : 0;
                        quizGrade = quizGrade !== null && !isNaN(quizGrade) ? parseFloat(quizGrade) : 0;
                        // Calculate overall completion score with equal weightage (25% each)
                        let overallScore = 0;
                        let weightSum = 0;
                        
                        // Completion metrics (25% each)
                        if (user.assignments_total > 0) {
                            overallScore += assignmentPercent * 0.25; // 25%
                            weightSum += 0.25;
                        }
                        if (user.quizzes_total > 0) {
                            overallScore += quizPercent * 0.25; // 25%
                            weightSum += 0.25;
                        }
                        if (user.materials_total > 0) {
                            overallScore += materialsViewedPercent * 0.25; // 25%
                            weightSum += 0.25;
                            overallScore += materialsDownloadedPercent * 0.25; // 25%
                            weightSum += 0.25;
                        }
                        
                        const overallCompletionPercent = weightSum > 0 ? overallScore / weightSum : 0;
                        return {
                            ...user,
                            assignmentPercent: (isNaN(assignmentPercent) ? 0 : assignmentPercent).toFixed(1),
                            quizPercent: (isNaN(quizPercent) ? 0 : quizPercent).toFixed(1),
                            materialsViewedPercent: (isNaN(materialsViewedPercent) ? 0 : materialsViewedPercent).toFixed(1),
                            materialsDownloadedPercent: (isNaN(materialsDownloadedPercent) ? 0 : materialsDownloadedPercent).toFixed(1),
                            overallCompletionPercent: (isNaN(overallCompletionPercent) ? 0 : overallCompletionPercent).toFixed(1),
                            assignmentGrade: assignmentGrade,
                            quizGrade: quizGrade
                        };
                    });
                    
                    // Calculate pie chart data
                    let completionHigh = 0, completionMedium = 0, completionLow = 0;
                    let achievementExcellent = 0, achievementGood = 0, achievementNeedsImprovement = 0;
                    
                    console.log('Calculating pie chart data for', studentsWithScores.length, 'students');
                    
                    studentsWithScores.forEach(function(user) {
                        // Completion distribution
                        const completionPercent = parseFloat(user.overallCompletionPercent);
                        if (completionPercent >= 80) completionHigh++;
                        else if (completionPercent >= 50) completionMedium++;
                        else completionLow++;
                        
                        // Achievement distribution
                        const avgScore = (
                            user.assignmentGrade * 0.5 +
                            user.quizGrade * 0.5
                        ) / 1.0;
                        if (avgScore >= 90) achievementExcellent++;
                        else if (avgScore >= 70) achievementGood++;
                        else achievementNeedsImprovement++;
                    });
                    
                    console.log('Completion data:', { completionHigh, completionMedium, completionLow });
                    console.log('Achievement data:', { achievementExcellent, achievementGood, achievementNeedsImprovement });
                    
                    // Create completion pie chart
                    console.log('Creating completion pie chart...');
                    createPieChart(completionPieChart[0], [
                        { value: completionHigh, color: '#4CAF50', label: 'High' },
                        { value: completionMedium, color: '#FF9800', label: 'Medium' },
                        { value: completionLow, color: '#F44336', label: 'Low' }
                    ]);
                    
                    // Update completion student counts
                    $('#completion-high-count').text(completionHigh);
                    $('#completion-medium-count').text(completionMedium);
                    $('#completion-low-count').text(completionLow);
                    $('#completion-total-count').text(studentsWithScores.length);
                    
                    // Create achievement pie chart
                    console.log('Creating achievement pie chart...');
                    createPieChart(achievementPieChart[0], [
                        { value: achievementExcellent, color: '#42e695', label: 'Excellent' },
                        { value: achievementGood, color: '#f7971e', label: 'Good' },
                        { value: achievementNeedsImprovement, color: '#9C27B0', label: 'Needs Improvement' }
                    ]);
                    
                    // Update achievement student counts
                    $('#achievement-excellent-count').text(achievementExcellent);
                    $('#achievement-good-count').text(achievementGood);
                    $('#achievement-needs-improvement-count').text(achievementNeedsImprovement);
                    $('#achievement-total-count').text(studentsWithScores.length);
                    
                    // Sort by overall progress percentage (descending) - NEW: includes both completion and grades
                    const tableSorted = [...studentsWithScores].sort((a, b) => parseFloat(b.overallCompletionPercent) - parseFloat(a.overallCompletionPercent));
                    
                    // Sort by completion percentage (descending) - for completion charts only
                    const completionSorted = [...studentsWithScores].sort((a, b) => parseFloat(b.overallCompletionPercent) - parseFloat(a.overallCompletionPercent));
                    
                    // Sort by achievement (average of assignment and quiz grade, descending)
                    const achievementSorted = [...studentsWithScores].sort((a, b) => {
                        // Calculate weighted achievement scores with 50% weight each
                        const aAvg = (
                            a.assignmentGrade * 0.5 +
                            a.quizGrade * 0.5
                        ) / 1.0;
                        
                        const bAvg = (
                            b.assignmentGrade * 0.5 +
                            b.quizGrade * 0.5
                        ) / 1.0;
                        
                        return bAvg - aAvg;
                    });
                    
                    // Render completion leaderboard
                    completionSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        const currentUserBadge = user.is_current_user ? '<span class=\'current-user-badge\'>You</span>' : '';
                        
                        // Completion chart HTML
                        const completionChartHtml = `
                            <div class=\"completion-chart ${isCurrent} ${idx < 3 ? 'rank-' + (idx + 1) : ''}\">
                                <div class=\"student-info\">
                                    <div class=\"rank-badge\">${idx + 1}</div>
                                    <img src=\"${user.avatar}\" class=\"student-avatar\" onerror=\"this.src='admin/images/default-avatar.png'\">
                                    <div class=\"student-name\">${user.firstname} ${user.lastname} ${currentUserBadge}</div>
                                    <div class=\"overall-score\">${user.overallCompletionPercent}%</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Assignments</span>
                                        <span>${user.assignments_completed}/${user.assignments_total}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar progress-assignments\" style=\"width: ${isNaN(parseFloat(user.assignmentPercent)) ? 0 : parseFloat(user.assignmentPercent)}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.assignmentPercent}%</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Quizzes</span>
                                        <span>${user.quizzes_taken}/${user.quizzes_total}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar progress-quizzes\" style=\"width: ${isNaN(parseFloat(user.quizPercent)) ? 0 : parseFloat(user.quizPercent)}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.quizPercent}%</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Materials Viewed</span>
                                        <span>${user.materials_viewed}/${user.materials_total}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar progress-materials-viewed\" style=\"width: ${isNaN(parseFloat(user.materialsViewedPercent)) ? 0 : parseFloat(user.materialsViewedPercent)}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.materialsViewedPercent}%</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Materials Downloaded</span>
                                        <span>${user.materials_downloaded}/${user.materials_total}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar progress-materials-downloaded\" style=\"width: ${isNaN(parseFloat(user.materialsDownloadedPercent)) ? 0 : parseFloat(user.materialsDownloadedPercent)}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.materialsDownloadedPercent}%</div>
                                </div>
                            </div>
                        `;
                        completionContainer.append(`<div class=\"leaderboard-row\">${completionChartHtml}</div>`);
                    });
                    
                    // Render table rows separately using tableSorted (arranged by Overall Progress %)
                    tableSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        tbody.append(`
                            <tr class="leaderboard-item ${isCurrent}">
                                <td>${idx + 1}</td>
                                <td><img src="${user.avatar}" style="width:32px;height:32px;border-radius:50%;margin-right:8px;"> ${user.firstname} ${user.lastname} ${user.is_current_user ? '<span class=\'badge badge-info\'>You</span>' : ''}</td>
                                <td>${user.assignments_completed} / ${user.assignments_total}</td>
                                <td>${user.assignment_avg_grade ?? '0.0'}</td>
                                <td>${user.quizzes_taken} / ${user.quizzes_total}</td>
                                <td>${user.quiz_avg_grade ?? '0.0'}</td>
                                <td>${user.materials_viewed} / ${user.materials_total}</td>
                                <td>${user.materials_downloaded} / ${user.materials_total}</td>
                                <td>${user.overallCompletionPercent}</td>
                            </tr>
                        `);
                    });
                    
                    // Render achievement leaderboard separately in its own ranking order
                    achievementSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        const currentUserBadge = user.is_current_user ? '<span class=\'current-user-badge\'>You</span>' : '';
                        
                        // Achievement chart HTML
                        const avgScore = (
                            user.assignmentGrade * 0.5 +
                            user.quizGrade * 0.5
                        ) / 1.0;
                        const achievementChartHtml = `
                            <div class=\"completion-chart ${isCurrent} ${idx < 3 ? 'rank-' + (idx + 1) : ''}\">
                                <div class=\"student-info\">
                                    <div class=\"rank-badge\">${idx + 1}</div>
                                    <img src=\"${user.avatar}\" class=\"student-avatar\" onerror=\"this.src='admin/images/default-avatar.png'\">
                                    <div class=\"student-name\">${user.firstname} ${user.lastname} ${currentUserBadge}</div>
                                    <div class=\"overall-score\">${(isNaN(avgScore) ? 0 : avgScore).toFixed(1)}%</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Avg Assignment Grade</span>
                                        <span>${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade + '%' : '0.0%'}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar bar-assignment-grade\" style=\"width: ${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade : 0}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade + '%' : '0.0%'}</div>
                                </div>
                                <div class=\"progress-section\">
                                    <div class=\"progress-label\">
                                        <span>Avg Quiz Grade</span>
                                        <span>${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade + '%' : '0.0%'}</span>
                                    </div>
                                    <div class=\"progress-bar-container\">
                                        <div class=\"progress-bar bar-quiz-grade\" style=\"width: ${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade : 0}%\"></div>
                                    </div>
                                    <div class=\"completion-percentage\">${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade + '%' : '0.0%'}</div>
                                </div>
                            </div>
                        `;
                        achievementContainer.append(`<div class=\"leaderboard-row\">${achievementChartHtml}</div>`);
                    });
                } else {
                    tbody.append('<tr><td colspan="9" class="text-center text-danger">No data available</td></tr>');
                    completionContainer.html('<div class="text-center text-danger">No data available</div>');
                    achievementContainer.html('<div class="text-center text-danger">No data available</div>');
                    completionPieChart.html('<div class="text-center text-danger">No data available</div>');
                    achievementPieChart.html('<div class="text-center text-danger">No data available</div>');
                }
            },
            error: function() {
                $('#leaderboard-progress-tbody').html('<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>');
                $('#completion-charts-container').html('<div class="text-center text-danger">Error loading data</div>');
                $('#achievement-charts-container').html('<div class="text-center text-danger">Error loading data</div>');
                $('#completion-pie-chart').html('<div class="text-center text-danger">Error loading data</div>');
                $('#achievement-pie-chart').html('<div class="text-center text-danger">Error loading data</div>');
            }
        });
    }
    
    // Function to create pie chart
    function createPieChart(container, data) {
        console.log('Creating pie chart with data:', data);
        
        const total = data.reduce((sum, item) => sum + item.value, 0);
        console.log('Total value:', total);
        
        if (total === 0) {
            container.innerHTML = '<div class="text-center">No data available</div>';
            return;
        }
        
        // Filter out items with zero values
        const validData = data.filter(item => item.value > 0);
        
        if (validData.length === 0) {
            container.innerHTML = '<div class="text-center">No data available</div>';
            return;
        }
        
        let svg = '<svg width="200" height="200" viewBox="0 0 200 200">';
        const radius = 80;
        const centerX = 100;
        const centerY = 100;
        
        // If only one category has data (100% pie chart)
        if (validData.length === 1) {
            const item = validData[0];
            const percentage = (item.value / total) * 100;
            
            // Create a full circle with the category color
            svg += `<circle cx="${centerX}" cy="${centerY}" r="${radius}" fill="${item.color}" stroke="#fff" stroke-width="2"/>`;
            
            // Add percentage text in the center
            const displayPercentage = isNaN(percentage) ? 0 : percentage;
            svg += `<text x="${centerX}" y="${centerY}" text-anchor="middle" dominant-baseline="middle" fill="white" font-size="14" font-weight="bold">${displayPercentage.toFixed(1)}%</text>`;
            
            // Add category label below
            svg += `<text x="${centerX}" y="${centerY + radius + 20}" text-anchor="middle" dominant-baseline="middle" fill="#333" font-size="12" font-weight="bold">${item.label}</text>`;
        } else {
            // Multiple categories - create traditional pie chart
            let currentAngle = 0;
            
            validData.forEach(function(item) {
                const percentage = (item.value / total) * 100;
                const angle = (percentage / 100) * 360;
                
                const startAngle = currentAngle * Math.PI / 180;
                const endAngle = (currentAngle + angle) * Math.PI / 180;
                
                const x1 = centerX + radius * Math.cos(startAngle);
                const y1 = centerY + radius * Math.sin(startAngle);
                const x2 = centerX + radius * Math.cos(endAngle);
                const y2 = centerY + radius * Math.sin(endAngle);
                
                const largeArcFlag = angle > 180 ? 1 : 0;
                
                const pathData = [
                    `M ${centerX} ${centerY}`,
                    `L ${x1} ${y1}`,
                    `A ${radius} ${radius} 0 ${largeArcFlag} 1 ${x2} ${y2}`,
                    'Z'
                ].join(' ');
                
                svg += `<path d="${pathData}" fill="${item.color}" stroke="#fff" stroke-width="2"/>`;
                
                // Add percentage text
                const textAngle = currentAngle + angle / 2;
                const textRadius = radius * 0.6;
                const textX = centerX + textRadius * Math.cos(textAngle * Math.PI / 180);
                const textY = centerY + textRadius * Math.sin(textAngle * Math.PI / 180);
                
                // Ensure percentage is a valid number and not NaN
                const displayPercentage = isNaN(percentage) ? 0 : percentage;
                svg += `<text x="${textX}" y="${textY}" text-anchor="middle" dominant-baseline="middle" fill="white" font-size="12" font-weight="bold">${displayPercentage.toFixed(1)}%</text>`;
                
                currentAngle += angle;
            });
            }
        
        svg += '</svg>';
        container.innerHTML = svg;
        console.log('Pie chart created successfully');
    }

    $(document).ready(fetchLeaderboardProgress);

    // Track material view when file icon is clicked (if such icons exist on this page)
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.material-icon-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var fileId = this.getAttribute('data-file-id');
                var classId = this.getAttribute('data-class-id');
                fetch('track_material_access.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'file_id=' + encodeURIComponent(fileId) + '&class_id=' + encodeURIComponent(classId) + '&scroll_view=0'
                }).then(function() {
                    // Refresh leaderboard after tracking
                    fetchLeaderboardProgress();
                });
            });
        });
    });

    window.addEventListener('storage', function(event) {
        if (event.key === 'refreshLeaderboard') {
            fetchLeaderboardProgress();
        }
    });
    </script>
</body>
</html> 