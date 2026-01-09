<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php $current_user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null; ?>
<body>
    <?php include('navbar_student.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('leaderboard_progress_link.php'); ?>
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
                    
                    <!-- Completion Bar Charts Section -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Student Progress Leaderboards</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="leaderboards-container" style="display: flex; gap: 20px; flex-wrap: wrap;">
                                    <!-- Completion Leaderboard -->
                                    <div class="leaderboard-section" style="flex: 1; min-width: 400px;">
                                        <div class="leaderboard-description" style="margin-bottom:10px;color:#555;font-size:13px;">
                                            <strong>Completion Bar Chart Leaderboard:</strong> This leaderboard shows each student's progress in completing assignments, quizzes, and engaging with class materials.
                                        </div>
                                        <div id="completion-charts-container"></div>
                                    </div>
                                    
                                    <!-- Achievement Leaderboard -->
                                    <div class="leaderboard-section" style="flex: 1; min-width: 400px;">
                                        <div class="leaderboard-description" style="margin-bottom:10px;color:#555;font-size:13px;">
                                            <strong>Achievement Bar Chart Leaderboard:</strong> This leaderboard displays each student's average assignment and quiz grades as achievement metrics.
                                        </div>
                                        <div id="achievement-charts-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
    
    /* Completion Charts Styles */
    .completion-chart {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .completion-chart.current-user {
        background: #e0f7fa;
        border-color: #00acc1;
        box-shadow: 0 2px 8px rgba(0,150,136,0.3);
    }
    
    /* Rank-specific styling */
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
    
    .overall-score {
        background: #333;
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: bold;
        font-size: 12px;
        margin-left: 10px;
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
    
    .current-user-badge {
        background: #00acc1;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin-left: 8px;
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
    
    .completion-percentage {
        font-size: 11px;
        color: #888;
        text-align: right;
    }
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
    .achievement-chart {
        background: #f7fafd;
        border: 1px solid #e0e5ea;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .achievement-title {
        font-weight: bold;
        font-size: 14px;
        color: #3a3a3a;
        margin-bottom: 10px;
    }
    .achievement-section {
        margin-bottom: 12px;
    }
    .achievement-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 3px;
        display: flex;
        justify-content: space-between;
    }
    .achievement-bar-container {
        background: #e0e0e0;
        border-radius: 10px;
        height: 10px;
        overflow: hidden;
        margin-bottom: 5px;
    }
    .achievement-bar {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
    }
    .bar-assignment-grade { background: linear-gradient(90deg, #42e695, #3bb2b8); }
    .bar-quiz-grade { background: linear-gradient(90deg, #f7971e, #ffd200); }
    .achievement-percentage {
        font-size: 11px;
        color: #888;
        text-align: right;
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
                tbody.empty();
                completionContainer.empty();
                achievementContainer.empty();
                if (response.status === 'success') {
                    // Calculate overall completion percentage for each student
                    const studentsWithScores = response.leaderboard.map(function(user) {
                        const assignmentPercent = user.assignments_total > 0 ? (user.assignments_completed / user.assignments_total * 100) : 0;
                        const quizPercent = user.quizzes_total > 0 ? (user.quizzes_taken / user.quizzes_total * 100) : 0;
                        const materialsViewedPercent = user.materials_total > 0 ? (user.materials_viewed / user.materials_total * 100) : 0;
                        const materialsDownloadedPercent = user.materials_total > 0 ? (user.materials_downloaded / user.materials_total * 100) : 0;
                        // Calculate overall completion score with new weightage including grades
                        let overallScore = 0;
                        let weightSum = 0;
                        
                        // Completion metrics (80% total)
                        if (user.assignments_total > 0) {
                            overallScore += assignmentPercent * 0.20; // 20%
                            weightSum += 0.20;
                        }
                        if (user.quizzes_total > 0) {
                            overallScore += quizPercent * 0.20; // 20%
                            weightSum += 0.20;
                        }
                        if (user.materials_total > 0) {
                            overallScore += materialsViewedPercent * 0.20; // 20%
                            weightSum += 0.20;
                            overallScore += materialsDownloadedPercent * 0.20; // 20%
                            weightSum += 0.20;
                        }
                        
                        // Grade performance (20% total)
                        if (user.assignmentGrade !== null && !isNaN(user.assignmentGrade)) {
                            overallScore += user.assignmentGrade * 0.10; // 10%
                            weightSum += 0.10;
                        }
                        if (user.quizGrade !== null && !isNaN(user.quizGrade)) {
                            overallScore += user.quizGrade * 0.10; // 10%
                            weightSum += 0.10;
                        }
                        
                        const overallCompletionPercent = weightSum > 0 ? overallScore / weightSum : 0;
                        
                        // Map backend grade data to frontend variables for achievement calculations
                        const assignmentGrade = user.assignment_avg_grade;
                        const quizGrade = user.quiz_avg_grade;
                        
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
                    // Sort by overall progress percentage (descending) - NEW: includes both completion and grades
                    const tableSorted = [...studentsWithScores].sort((a, b) => parseFloat(b.overallCompletionPercent) - parseFloat(a.overallCompletionPercent));
                    
                    // Sort by completion percentage (descending) - for completion charts only
                    const completionSorted = [...studentsWithScores].sort((a, b) => parseFloat(b.overallCompletionPercent) - parseFloat(a.overallCompletionPercent));
                    
                    // Sort by achievement (average of assignment and quiz grade, descending)
                    const achievementSorted = [...studentsWithScores].sort((a, b) => {
                        // Calculate weighted achievement scores with 50% weight each
                        const aAssignmentWeight = a.assignmentGrade !== null ? 0.5 : 0;
                        const aQuizWeight = a.quizGrade !== null ? 0.5 : 0;
                        const aTotalWeight = aAssignmentWeight + aQuizWeight;
                        const aAvg = aTotalWeight > 0 ? (
                            (a.assignmentGrade !== null ? a.assignmentGrade * 0.5 : 0) +
                            (a.quizGrade !== null ? a.quizGrade * 0.5 : 0)
                        ) / aTotalWeight : 0;
                        
                        const bAssignmentWeight = b.assignmentGrade !== null ? 0.5 : 0;
                        const bQuizWeight = b.quizGrade !== null ? 0.5 : 0;
                        const bTotalWeight = bAssignmentWeight + bQuizWeight;
                        const bAvg = bTotalWeight > 0 ? (
                            (b.assignmentGrade !== null ? b.assignmentGrade * 0.5 : 0) +
                            (b.quizGrade !== null ? b.quizGrade * 0.5 : 0)
                        ) / bTotalWeight : 0;
                        
                        return bAvg - aAvg;
                    });
                    // Render completion leaderboard
                    completionSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        const currentUserBadge = user.is_current_user ? '<span class="current-user-badge">You</span>' : '';
                        const rankClass = idx === 0 ? 'rank-1' : idx === 1 ? 'rank-2' : idx === 2 ? 'rank-3' : '';
                        const completionChartHtml = `
                            <div class="completion-chart ${isCurrent} ${rankClass}">
                                <div class="student-info">
                                    <div class="rank-badge">${idx + 1}</div>
                                    <img src="${user.avatar}" class="student-avatar" onerror="this.src='admin/images/default-avatar.png'">
                                    <div class="student-name">${user.firstname} ${user.lastname} ${currentUserBadge}</div>
                                    <div class="overall-score">${(isNaN(parseFloat(user.overallCompletionPercent)) ? 0 : parseFloat(user.overallCompletionPercent)).toFixed(1)}%</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Assignments</span>
                                        <span>${user.assignments_completed}/${user.assignments_total}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar progress-assignments" style="width: ${isNaN(parseFloat(user.assignmentPercent)) ? 0 : parseFloat(user.assignmentPercent)}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.assignmentPercent}%</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Quizzes</span>
                                        <span>${user.quizzes_taken}/${user.quizzes_total}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar progress-quizzes" style="width: ${isNaN(parseFloat(user.quizPercent)) ? 0 : parseFloat(user.quizPercent)}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.quizPercent}%</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Materials Viewed</span>
                                        <span>${user.materials_viewed}/${user.materials_total}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar progress-materials-viewed" style="width: ${isNaN(parseFloat(user.materialsViewedPercent)) ? 0 : parseFloat(user.materialsViewedPercent)}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.materialsViewedPercent}%</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Materials Downloaded</span>
                                        <span>${user.materials_downloaded}/${user.materials_total}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar progress-materials-downloaded" style="width: ${isNaN(parseFloat(user.materialsDownloadedPercent)) ? 0 : parseFloat(user.materialsDownloadedPercent)}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.materialsDownloadedPercent}%</div>
                                </div>
                            </div>
                        `;
                        completionContainer.append(`<div class="leaderboard-row">${completionChartHtml}</div>`);
                    });
                    // Render achievement leaderboard
                    achievementSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        const currentUserBadge = user.is_current_user ? '<span class="current-user-badge">You</span>' : '';
                        const rankClass = idx === 0 ? 'rank-1' : idx === 1 ? 'rank-2' : idx === 2 ? 'rank-3' : '';
                        // Calculate weighted achievement score with 50% weight each
                        const assignmentWeight = user.assignmentGrade !== null ? 0.5 : 0;
                        const quizWeight = user.quizGrade !== null ? 0.5 : 0;
                        const totalWeight = assignmentWeight + quizWeight;
                        const avgScore = totalWeight > 0 ? (
                            (user.assignmentGrade !== null ? user.assignmentGrade * 0.5 : 0) +
                            (user.quizGrade !== null ? user.quizGrade * 0.5 : 0)
                        ) / totalWeight : 0;
                        const achievementChartHtml = `
                            <div class="completion-chart ${isCurrent} ${rankClass}">
                                <div class="student-info">
                                    <div class="rank-badge">${idx + 1}</div>
                                    <img src="${user.avatar}" class="student-avatar" onerror="this.src='admin/images/default-avatar.png'">
                                    <div class="student-name">${user.firstname} ${user.lastname} ${currentUserBadge}</div>
                                    <div class="overall-score">${(isNaN(avgScore) ? 0 : avgScore).toFixed(1)}%</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Avg Assignment Grade</span>
                                        <span>${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade + '%' : '0.0%'}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar bar-assignment-grade" style="width: ${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade : 0}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.assignmentGrade !== null && !isNaN(user.assignmentGrade) ? user.assignmentGrade + '%' : '0.0%'}</div>
                                </div>
                                <div class="progress-section">
                                    <div class="progress-label">
                                        <span>Avg Quiz Grade</span>
                                        <span>${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade + '%' : '0.0%'}</span>
                                    </div>
                                    <div class="progress-bar-container">
                                        <div class="progress-bar bar-quiz-grade" style="width: ${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade : 0}%"></div>
                                    </div>
                                    <div class="completion-percentage">${user.quizGrade !== null && !isNaN(user.quizGrade) ? user.quizGrade + '%' : '0.0%'}</div>
                                </div>
                            </div>
                        `;
                        achievementContainer.append(`<div class="leaderboard-row">${achievementChartHtml}</div>`);
                    });
                    // Render table row (unchanged)
                    tableSorted.forEach(function(user, idx) {
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        tbody.append(`
                            <tr class="leaderboard-item ${isCurrent}">
                                <td>${idx + 1}</td>
                                <td><img src="${user.avatar}" style="width:32px;height:32px;border-radius:50%;margin-right:8px;"> ${user.firstname} ${user.lastname} ${user.is_current_user ? '<span class=\'badge badge-info\'>You</span>' : ''}</td>
                                <td>${user.assignments_completed} / ${user.assignments_total}</td>
                                <td>${user.assignment_avg_grade ?? '0.0%'}</td>
                                <td>${user.quizzes_taken} / ${user.quizzes_total}</td>
                                <td>${user.quiz_avg_grade ?? '0.0%'}</td>
                                <td>${user.materials_viewed} / ${user.materials_total}</td>
                                <td>${user.materials_downloaded} / ${user.materials_total}</td>
                                <td>${user.overallCompletionPercent ?? '0.0%'}</td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append('<tr><td colspan="9" class="text-center text-danger">No data available</td></tr>');
                    completionContainer.html('<div class="text-center text-danger">No data available</div>');
                    achievementContainer.html('<div class="text-center text-danger">No data available</div>');
                }
            },
            error: function() {
                $('#leaderboard-progress-tbody').html('<tr><td colspan="9" class="text-center text-danger">Error loading data</td></tr>');
                $('#completion-charts-container').html('<div class="text-center text-danger">Error loading data</div>');
                $('#achievement-charts-container').html('<div class="text-center text-danger">Error loading data</div>');
            }
        });
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