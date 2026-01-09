<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php
// Get the count of students for this class
$count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM teacher_class_student WHERE teacher_class_id = '$get_id'") or die(mysqli_error());
$count_row = mysqli_fetch_assoc($count_result);
$count_my_student = $count_row['total'];
// Fetch the current semester (school_year)
$school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
$school_year_query_row = mysqli_fetch_array($school_year_query);
$school_year = $school_year_query_row['school_year'];
?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('class_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
						<div class="pull-right">
							<a href="add_student.php<?php echo '?id='.$get_id; ?>" class="btn btn-info"><i class="icon-plus-sign"></i> Add Student</a>
							<a onclick="window.open('print_student.php<?php echo '?id='.$get_id; ?>')"  class="btn btn-success"><i class="icon-list"></i> Student List</a>
						</div>
						<?php include('my_students_breadcrums.php'); ?>
                        
                        <!-- Leaderboard Filters -->
                        <div class="block" style="margin-bottom: 20px;">
                            <br>
                            <div class="block-content collapse in">
                                <div class="span12" style="display: flex; gap: 20px; align-items: center;">
                                    <label for="leaderboard-date">Date:</label>
                                    <input type="date" id="leaderboard-date" value="<?php echo date('Y-m-d'); ?>" />
                                    <label for="class-filter">Class:</label>
                                    <select id="class-filter">
                                        <option value="all">All</option>
                                        <?php
                                        // Fetch only current semester's classes for the teacher
                                        $teacher_classes = [];
                                        $class_stmt = $conn->prepare("SELECT teacher_class.teacher_class_id, class.class_name, subject.subject_code FROM teacher_class
                                            JOIN class ON class.class_id = teacher_class.class_id
                                            JOIN subject ON subject.subject_id = teacher_class.subject_id
                                            WHERE teacher_class.teacher_id = ? AND teacher_class.school_year = ?");
                                        $class_stmt->bind_param("ss", $session_id, $school_year);
                                        $class_stmt->execute();
                                        $class_result = $class_stmt->get_result();
                                        while ($class_row = $class_result->fetch_assoc()) {
                                            $teacher_classes[] = $class_row;
                                        }
                                        ?>
                                        <?php foreach ($teacher_classes as $class): ?>
                                          <option value="<?php echo htmlspecialchars($class['teacher_class_id']); ?>" <?php if ($get_id == $class['teacher_class_id']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($class['class_name'] . ' (' . $class['subject_code'] . ')'); ?>
                                          </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Study Leaderboard Section -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Study Leaderboard</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div class="leaderboard-container" id="teacher-leaderboard-container">
                                        <!-- Leaderboard will be loaded here by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Students Tab -->
                            <div class="tab-pane active" id="students">
                                <!-- block -->
                                <div id="block_bg" class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div id="" class="muted pull-left">
                                        Number of Students: <span class="badge badge-info"><?php echo $count_my_student; ?></span>
                                        </div>
                                    </div>
                                    <div class="block-content collapse in">
                                        <div class="span12">
                                            <ul id="da-thumbs" class="da-thumbs">
                                                <?php
                                                $my_student = mysqli_query($conn,"SELECT * FROM teacher_class_student
                                                LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
                                                INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ")or die(mysqli_error());
                                                while($row = mysqli_fetch_array($my_student)){
                                                $id = $row['teacher_class_student_id'];
                                                ?>
                                                <li id="del<?php echo $id; ?>">
                                                    <a >
                                                        <img id="student_avatar_class" src ="admin/<?php echo $row['location'] ?>" width="124" height="140" class="img-polaroid">
                                                    <div>
                                                    <span>
                                                    <p><?php ?></p>
                                                    
                                                    </span>
                                                    </div>
                                                    </a>
                                                    <p class="class"><?php echo $row['firstname']; ?></p>
                                                    <p class="subject"><?php echo $row['lastname'];?></p>
                                                    <a  href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-trash"></i> Remove</a>	
                                                </li>
                                                <?php include("remove_student_modal.php"); ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- /block -->
                            </div>

                            <!-- Leaderboard Tab -->
                            <div class="tab-pane" id="leaderboard">
                                <div id="block_bg" class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-right">
                                            <div class="btn-group">
                                                <button class="btn btn-small" onclick="refreshLeaderboard()">
                                                    <i class="icon-refresh"></i> Refresh
                                                </button>
                                                <button class="btn btn-small btn-success" onclick="exportLeaderboardData()">
                                                    <i class="icon-download"></i> Export
                                                </button>
                                            </div>
                                        </div>
                                        <div class="muted pull-left">
                                            <i class="icon-trophy"></i> Real-time Study Leaderboard
                                            <span class="live-indicator" style="display: inline-block; width: 8px; height: 8px; background: #4CAF50; border-radius: 50%; margin-left: 5px; animation: pulse 2s infinite;"></span>
                                        </div>
                                    </div>
                                    <div class="block-content collapse in">
                                        <div class="span12">
                                            <!-- Leaderboard Stats -->
                                            <div class="row-fluid" style="margin-bottom: 20px;">
                                                <div class="span3">
                                                    <div class="stat-card" style="background: #e8f5e8; padding: 15px; border-radius: 8px; text-align: center;">
                                                        <h4 style="color: #28a745; margin: 0;"><i class="icon-users"></i> Active Students</h4>
                                                        <div id="active-students" style="font-size: 2em; font-weight: bold; color: #333;">0</div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="stat-card" style="background: #e8f4fd; padding: 15px; border-radius: 8px; text-align: center;">
                                                        <h4 style="color: #007bff; margin: 0;"><i class="icon-clock"></i> Total Study Time</h4>
                                                        <div id="total-study-time" style="font-size: 1.5em; font-weight: bold; color: #333;">00:00:00</div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="stat-card" style="background: #fff3cd; padding: 15px; border-radius: 8px; text-align: center;">
                                                        <h4 style="color: #856404; margin: 0;"><i class="icon-chart-bar"></i> Average Time</h4>
                                                        <div id="average-study-time" style="font-size: 1.5em; font-weight: bold; color: #333;">00:00:00</div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="stat-card" style="background: #f8d7da; padding: 15px; border-radius: 8px; text-align: center;">
                                                        <h4 style="color: #721c24; margin: 0;"><i class="icon-calendar"></i> Today's Date</h4>
                                                        <div id="current-date" style="font-size: 1.2em; font-weight: bold; color: #333;"><?php echo date('M d, Y'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Leaderboard Table -->
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered" id="leaderboard-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 60px;">Rank</th>
                                                            <th style="width: 80px;">Avatar</th>
                                                            <th>Student Name</th>
                                                            <th>Study Time</th>
                                                            <th>Sessions</th>
                                                            <th>Average Session</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="leaderboard-tbody">
                                                        <tr>
                                                            <td colspan="6" class="text-center">
                                                                <i class="icon-spinner icon-spin"></i> Loading leaderboard...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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

        <style>
        /* Leaderboard Styles (identical to my_classmates.php) */
        .leaderboard-container {
            margin-bottom: 20px;
        }
        .leaderboard-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: relative;
            transition: all 0.3s ease;
        }
        .leaderboard-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .leaderboard-item.gold {
            background: linear-gradient(90deg, rgba(255,215,0,0.1) 0%, rgba(255,215,0,0.05) 100%);
            border-left: 4px solid #FFD700;
        }
        .leaderboard-item.silver {
            background: linear-gradient(90deg, rgba(192,192,192,0.1) 0%, rgba(192,192,192,0.05) 100%);
            border-left: 4px solid #C0C0C0;
        }
        .leaderboard-item.bronze {
            background: linear-gradient(90deg, rgba(205,127,50,0.1) 0%, rgba(205,127,50,0.05) 100%);
            border-left: 4px solid #CD7F32;
        }
        .rank {
            font-weight: bold;
            font-size: 18px;
            width: 30px;
            text-align: center;
            color: #6c757d;
        }
        .leaderboard-item.gold .rank,
        .leaderboard-item.silver .rank,
        .leaderboard-item.bronze .rank {
            color: #343a40;
        }
        .avatar {
            width: 50px;
            height: 50px;
            margin-right: 15px;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .details {
            flex-grow: 1;
        }
        .name {
            font-weight: 600;
            margin-bottom: 3px;
        }
        .time {
            display: flex;
            gap: 10px;
            font-size: 14px;
            color: #6c757d;
        }
        .time span {
            font-weight: bold;
            color: #495057;
        }
        .medal {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
        }
        .medal.gold {
            background: #FFD700;
            box-shadow: 0 0 0 3px rgba(255,215,0,0.3);
        }
        .medal.silver {
            background: #C0C0C0;
            box-shadow: 0 0 0 3px rgba(192,192,192,0.3);
        }
        .medal.bronze {
            background: #CD7F32;
            box-shadow: 0 0 0 3px rgba(205,127,50,0.3);
        }
        .leaderboard-item.current-user {
            border: 2px solid #00796b;
            background: #e0f7fa;
            box-shadow: 0 0 8px #00796b33;
        }
        .progress {
            width: 100%;
            background: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 0.5s;
        }
        .badge-info {
            background: #00796b;
            color: #fff;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 0.9em;
        }
        .streak {
            margin-left: 10px;
            font-size: 1em;
            vertical-align: middle;
        }
        .streak-bronze { color: #cd7f32; }
        .streak-silver { color: #b0b0b0; }
        .streak-gold   { color: #ffd700; }
        .crown {
            color: #ffd700;
            font-size: 1.2em;
            margin-left: 4px;
            vertical-align: middle;
        }
        .badge-icon {
            margin-left: 4px;
            font-size: 1.2em;
            vertical-align: middle;
            cursor: pointer;
        }
        .live-indicator {
            font-size: 0.8em;
            color: #28a745;
            margin-left: 5px;
            display: inline-flex;
            align-items: center;
        }
        .live-dot {
            width: 8px;
            height: 8px;
            background-color: #28a745;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }
            @keyframes pulse {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .da-thumbs li {
            width: 23%;
            margin: 1%;
            transition: none !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        #student_avatar_class {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        @media (max-width: 768px) {
            .da-thumbs li {
                width: 48%;
                margin: 1%;
            }
            }
        </style>

        <script>
            let currentLeaderboardData = null;
            let updateCount = 0;

            function formatTime(seconds) {
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            function updateLeaderboard() {
                // Get the class ID from the current page
                const classId = '<?php echo $get_id; ?>';
                
                $.ajax({
                    url: 'get_leaderboard_teacher.php',
                    type: 'GET',
                    data: {
                        date: new Date().toISOString().split('T')[0],
                        class_id: classId,
                        limit: 50
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.status === 'error' && response.message === 'No active session found') {
                            window.location.href = 'index.php';
                            return;
                        }
                        if (response.status === 'success') {
                            currentLeaderboardData = response;
                            const leaderboard = response.leaderboard;
                            const tbody = $('#leaderboard-tbody');
                            
                            // Update statistics
                            $('#active-students').text(response.summary.total_students);
                            $('#total-study-time').text(formatTime(response.summary.total_study_time));
                            $('#average-study-time').text(formatTime(response.summary.average_study_time));
                            $('#current-date').text(new Date(response.summary.date).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric',
                                year: 'numeric'
                            }));
                            
                            // Update leaderboard count badge
                            $('#leaderboard-count').text(leaderboard.length);
                            
                            if (leaderboard.length === 0) {
                                tbody.html('<tr><td colspan="6" class="text-center">No study data available for today</td></tr>');
                                return;
                            }

                            let html = '';
                            leaderboard.forEach((user, index) => {
                                const totalTime = user.total_time;
                                const rankClass = index === 0 ? 'rank-1' : index === 1 ? 'rank-2' : index === 2 ? 'rank-3' : '';
                                const medalIcon = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : '';

                                html += `
                                    <tr class="leaderboard-item ${rankClass}">
                                        <td class="text-center">
                                            <strong>#${index + 1}</strong>
                                            ${medalIcon ? `<br><span style="font-size: 1.2em;">${medalIcon}</span>` : ''}
                                        </td>
                                        <td class="text-center">
                                            <img src="${user.avatar}" 
                                                alt="${user.firstname} ${user.lastname}" 
                                                class="student-avatar"
                                                onerror="this.src='admin/images/default-avatar.png'">
                                        </td>
                                        <td><strong>${user.firstname} ${user.lastname}</strong></td>
                                        <td><strong>${formatTime(totalTime)}</strong></td>
                                        <td class="text-center">${user.session_count}</td>
                                        <td>${formatTime(user.average_session)}</td>
                                    </tr>
                                `;
                            });

                            tbody.html(html);
                            updateCount++;
                            
                        } else {
                            $('#leaderboard-tbody').html('<tr><td colspan="6" class="text-center text-danger">Error loading leaderboard data</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#leaderboard-tbody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load leaderboard. Please refresh the page.</td></tr>');
                    }
                });
            }

            function refreshLeaderboard() {
                updateLeaderboard();
                $.jGrowl("Leaderboard refreshed!", { header: 'Success' });
            }

            function exportLeaderboardData() {
                if (!currentLeaderboardData) {
                    $.jGrowl("No data to export", { header: 'Error' });
                    return;
                }

                const csvContent = "data:text/csv;charset=utf-8," 
                    + "Rank,Name,Class,Total Time (seconds),Sessions,Average Session (seconds)\n"
                    + currentLeaderboardData.leaderboard.map((user, index) => 
                        `${index + 1},"${user.firstname} ${user.lastname}","${user.class_name}",${user.total_time},${user.session_count},${user.average_session}`
                    ).join("\n");

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", `leaderboard_${currentLeaderboardData.summary.date}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                $.jGrowl("Data exported successfully!", { header: 'Success' });
            }

            // Initialize leaderboard when tab is shown
            $('#myTab a[href="#leaderboard"]').on('shown', function (e) {
                updateLeaderboard();
            });

            // Update leaderboard every 5 seconds when on leaderboard tab
            setInterval(function() {
                if ($('#leaderboard').hasClass('active')) {
                    updateLeaderboard();
                }
            }, 5000);

            // Original remove student functionality
            $(document).ready( function() {
                $('.remove').click( function() {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "POST",
                        url: "remove_student.php",
                        data: ({id: id}),
                        cache: false,
                        success: function(html){
                            $("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
                            $('#'+id).modal('hide');
                            $.jGrowl("Your Student is Successfully Remove", { header: 'Student Remove' });
                        }
                    }); 	
                    return false;
                });				
            });

            // --- Study Leaderboard for Teachers ---
            function getStreakClass(streak) {
                if (streak >= 7) return 'streak-gold';
                if (streak >= 3) return 'streak-silver';
                if (streak >= 1) return 'streak-bronze';
                return '';
            }

            function updateTeacherLeaderboard() {
                const date = $('#leaderboard-date').val();
                const classId = $('#class-filter').val();
                let url = 'get_leaderboard.php?date=' + encodeURIComponent(date);
                if (classId !== 'all') url += '&class_id=' + encodeURIComponent(classId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        try {
                            const data = typeof response === 'string' ? JSON.parse(response) : response;
                            if (data.status === 'error' && data.message === 'No active session found') {
                                window.location.href = 'index.php';
                                return;
                            }
                            const leaderboard = data.leaderboard;
                            const leaderboardContainer = $('#teacher-leaderboard-container');
                            leaderboardContainer.empty();
                            if (!leaderboard || leaderboard.length === 0) {
                                leaderboardContainer.append('<div class="alert alert-info">No study sessions for this day.</div>');
                                return;
                            }
                            // Find max time for progress bar
                            const maxTime = Math.max(...leaderboard.map(u => u.total_time));
                            leaderboard.forEach((user, index) => {
                                const totalTime = user.total_time;
                                const hours = Math.floor(totalTime / 3600);
                                const minutes = Math.floor((totalTime % 3600) / 60);
                                const seconds = totalTime % 60;
                                const avg = user.average_session;
                                const avgH = Math.floor(avg / 3600);
                                const avgM = Math.floor((avg % 3600) / 60);
                                const avgS = avg % 60;
                                const medalClass = index === 0 ? 'gold' :
                                    index === 1 ? 'silver' :
                                    index === 2 ? 'bronze' : '';
                                const progress = maxTime > 0 ? Math.round((totalTime / maxTime) * 100) : 0;
                                const isActiveSession = user.is_active_session ? 'true' : 'false';
                                const streak = user.streak || 0;
                                const streakClass = getStreakClass(streak);
                                const streakHtml = streak > 0 ? `<span class=\"streak ${streakClass}\" title=\"Current streak\">🔥 ${streak} day${streak === 1 ? '' : 's'}</span>` : '';
                                const crownHtml = user.is_crown ? '<span class="crown" title="Longest all-time streak in class">👑</span>' : '';
                                const badges = (user.badges || []).map(b => `<span class=\"badge-icon\" title=\"${b.label}\">${b.icon}</span>`).join('');
                                const liveIndicatorHtml = isActiveSession === 'true' ? '<span class="live-indicator"><span class="live-dot"></span> Online</span>' : '';
                                leaderboardContainer.append(`
                                    <div class="leaderboard-item ${medalClass}">
                                        <div class="rank">${index + 1}</div>
                                        <div class="avatar">
                                            <img src="${user.avatar}" alt="${user.firstname} ${user.lastname}" class="img-circle" style="width:50px;height:50px;object-fit:cover;border-radius:50%;">
                                        </div>
                                        <div class="details">
                                            <div class="name">${user.firstname} ${user.lastname} ${crownHtml} ${badges}
                                                ${streakHtml}
                                            </div>
                                            <div class="time" data-user-id="${user.user_id}" data-initial-time="${totalTime}" data-active-session="${isActiveSession}">
                                                <span class="hours">${hours.toString().padStart(2, '0')}</span>h
                                                <span class="minutes">${minutes.toString().padStart(2, '0')}</span>m
                                                <span class="seconds">${seconds.toString().padStart(2, '0')}</span>s
                                            </div>
                                            <div class="sessions" style="font-size:12px;color:#888;">
                                                <span title="Total Sessions"><i class='icon-list'></i> ${user.session_count} sessions</span> |
                                                <span title="Average Session"><i class='icon-time'></i> Avg: ${avgH.toString().padStart(2, '0')}:${avgM.toString().padStart(2, '0')}:${avgS.toString().padStart(2, '0')}</span>
                                            </div>
                                            <div class="progress" style="height:10px;margin-top:5px;background:#e0e0e0;">
                                                <div class="progress-bar" style="width:${progress}%;background:#00796b;height:100%;border-radius:5px;"></div>
                                            </div>
                                            ${liveIndicatorHtml}
                                        </div>
                                        ${medalClass ? `<div class=\"medal ${medalClass}\" title=\"${medalClass.charAt(0).toUpperCase() + medalClass.slice(1)} Medal\"></div>` : ''}
                                    </div>
                                `);
                            });
                            updateTimers();
                        } catch (error) {
                            leaderboardContainer.html('<div class="alert alert-danger">Error loading leaderboard.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#teacher-leaderboard-container').html('<div class="alert alert-danger">Error fetching leaderboard data.</div>');
                    }
                });
            }

            // Update leaderboard when filters change
            $('#leaderboard-date, #class-filter').on('change', function() {
                updateTeacherLeaderboard();
            });

            // Initial leaderboard load
            $(document).ready(function() {
                updateTeacherLeaderboard();
            });

            // Timer update for live sessions
            function updateTimers() {
                setInterval(() => {
                    $('.time').each(function () {
                        const timerElement = $(this);
                        const isActive = timerElement.data('active-session');
                        if (isActive) {
                            let initialTime = parseInt(timerElement.data('initial-time'), 10);
                            initialTime++;
                            timerElement.data('initial-time', initialTime);
                            const hours = Math.floor(initialTime / 3600);
                            const minutes = Math.floor((initialTime % 3600) / 60);
                            const seconds = initialTime % 60;
                            timerElement.find('.hours').text(hours.toString().padStart(2, '0'));
                            timerElement.find('.minutes').text(minutes.toString().padStart(2, '0'));
                            timerElement.find('.seconds').text(seconds.toString().padStart(2, '0'));
                        }
                    });
                }, 1000);
            }
        </script>
    </body>
</html>