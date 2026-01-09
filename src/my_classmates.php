<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('my_classmates_link.php'); ?>
            <div class="span9" id="content">
                <div class="row-fluid">
                    <!-- breadcrumb -->
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM teacher_class_student
                        LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id
                        JOIN class ON class.class_id = teacher_class.class_id
                        JOIN subject ON subject.subject_id = teacher_class.subject_id
                        WHERE student_id = ?");
                    $stmt->bind_param("s", $session_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    // Fetch latest school year for breadcrumb
                    $latest_school_year_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
                    $latest_school_year_row = mysqli_fetch_array($latest_school_year_query);
                    $latest_school_year = $latest_school_year_row['school_year'];
                    ?>
                    <ul class="breadcrumb">
                        <li><a href="#"><?php echo $row['class_name']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><?php echo $row['subject_code']; ?></a> <span class="divider">/</span></li>
                        <li><a href="#">Semester <?php echo $latest_school_year; ?></a> <span class="divider">/</span></li>
                        <li><a href="#"><b>My Classmates</b></a></li>
                    </ul>
                    <!-- end breadcrumb -->

                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Your Total Study Time</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <?php include('timer.php'); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Controls -->
                    <div class="block" style="margin-bottom: 20px;">
                        <div class="block-content collapse in">
                            <br><div class="span12" style="display: flex; gap: 20px; align-items: center;">
                                <label for="leaderboard-date">Date:</label>
                                <input type="date" id="leaderboard-date" value="<?php echo date('Y-m-d'); ?>" />
                                <label for="class-filter">Class:</label>
                                <select id="class-filter">
                                    <option value="all">All</option>
                                    <?php
                                    // Fetch current semester
                                    $current_semester_query = mysqli_query($conn, "SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
                                    $current_semester_row = mysqli_fetch_array($current_semester_query);
                                    $current_semester = $current_semester_row['school_year'];
                                    
                                    // Fetch only current semester's classes for the student
                                    $student_classes = [];
                                    $class_stmt = $conn->prepare("SELECT teacher_class.teacher_class_id, class.class_name, subject.subject_code FROM teacher_class_student
                                        LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id
                                        JOIN class ON class.class_id = teacher_class.class_id
                                        JOIN subject ON subject.subject_id = teacher_class.subject_id
                                        WHERE student_id = ? AND teacher_class.school_year = ?");
                                    $class_stmt->bind_param("ss", $session_id, $current_semester);
                                    $class_stmt->execute();
                                    $class_result = $class_stmt->get_result();
                                    while ($class_row = $class_result->fetch_assoc()) {
                                        $student_classes[] = $class_row;
                                    }
                                    ?>
                                    <?php foreach ($student_classes as $class): ?>
                                      <option value="<?php echo htmlspecialchars($class['teacher_class_id']); ?>" <?php if ($get_id == $class['teacher_class_id']) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($class['class_name'] . ' (' . $class['subject_code'] . ')'); ?>
                                      </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Leaderboard Section -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Study Leaderboard</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <div class="leaderboard-container">
                                    <!-- Leaderboard will be loaded here via AJAX -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Leaderboard Section -->

                    <!-- Classmates Section -->
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div id="" class="muted pull-left">Classmates</div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <ul id="da-thumbs" class="da-thumbs">
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM teacher_class_student
                                        LEFT JOIN student ON student.student_id = teacher_class_student.student_id
                                        INNER JOIN class ON class.class_id = student.class_id
                                        WHERE teacher_class_id = ? AND student.student_id != ? ORDER BY lastname");
                                    $stmt->bind_param("ss", $get_id, $session_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    while ($row = $result->fetch_assoc()) {
                                        $student_id = $row['student_id'];
                                        echo '<li id="del'.$row['teacher_class_student_id'].'">';
                                        echo '<a class="classmate_cursor" href="#">';
                                        echo '<img id="student_avatar_class" src="admin/'.$row['location'].'" width="124" height="140" class="img-polaroid">';
                                        echo '<div><span></span></div>';
                                        echo '</a>';
                                        echo '<p class="class">'.$row['firstname'].'</p>';
                                        echo '<p class="subject">'.$row['lastname'].'</p>';
                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <?php include('script.php'); ?>
    
    <style>
    /* Leaderboard Styles */
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
    
    /* Classmates grid styles */
    .da-thumbs li {
        width: 23%;
        margin: 1%;
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
        color: #43a047;
        margin-left: 5px;
        display: inline-flex;
        align-items: center;
    }
    .live-dot {
        width: 8px;
        height: 8px;
        background-color: #43a047;
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
    </style>
    
    <script>
    function updateTimeTracking() {
        $.ajax({
            url: 'get_time_tracking.php',
            type: 'GET',
            success: function(response) {
                try {
                    const timeData = JSON.parse(response);
                    if (timeData.status === 'error' && (timeData.message === 'No active session found' || timeData.message === 'User not logged in')) {
                        window.location.href = 'index.php';
                        return;
                    }
                    timeData.forEach(function(student) {
                        const formattedTime = formatTime(student.total_time);
                        const timerElement = $(`#time_spent_${student.id}`);
                        
                        if (timerElement.length) {
                            timerElement.text(formattedTime);
                        } else {
                            $('#timer-container').append(`
                                <div id="user_${student.id}">
                                    <strong>${student.name}:</strong>
                                    <span id="time_spent_${student.id}">${formattedTime}</span>
                                </div>
                            `);
                        }
                    });
                } catch (err) {
                    console.error('Invalid JSON or update error:', err);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                $('#timer-container').html('<p>Error loading timers. Please try again later.</p>');
            }
        });
    }


    // Update every 1 seconds
    setInterval(updateTimeTracking, 1000);


    
   /* // Function to update leaderboard periodically
    function updateLeaderboard() {
    $.ajax({
        url: 'get_leaderboard.php',
        type: 'GET',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    const leaderboard = data.leaderboard;
                    const leaderboardContainer = $('.leaderboard-container');
                    leaderboardContainer.empty(); // Clear the existing leaderboard
                    
                    leaderboard.forEach((user, index) => {
                        const totalTime = user.total_time;
                        const hours = Math.floor(totalTime / 3600);
                        const minutes = Math.floor((totalTime % 3600) / 60);
                        const seconds = totalTime % 60;

                        const medalClass = index === 0 ? 'gold' :
                            index === 1 ? 'silver' :
                            index === 2 ? 'bronze' : '';

                        leaderboardContainer.append(`
                            <div class="leaderboard-item ${medalClass}">
                                <div class="rank">${index + 1}</div>
                                <div class="avatar">
                                    <img src="${user.avatar}" 
                                        alt="${user.firstname} ${user.lastname}" 
                                        class="img-circle">
                                </div>
                                <div class="details">
                                    <div class="name">${user.firstname} ${user.lastname}</div>
                                    <div class="time" data-user-id="${user.user_id}" data-initial-time="${totalTime}">
                                        <span class="hours">${hours.toString().padStart(2, '0')}</span>h
                                        <span class="minutes">${minutes.toString().padStart(2, '0')}</span>m
                                        <span class="seconds">${seconds.toString().padStart(2, '0')}</span>s
                                    </div>
                                </div>
                                ${medalClass ? `<div class="medal ${medalClass}"></div>` : ''}
                            </div>
                        `);
                    });

                    // Restart timer updates
                    updateTimers();
                } else {
                    console.error('Error in leaderboard data:', data.message);
                }
            } catch (error) {
                console.error('Error parsing leaderboard response:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching leaderboard:", error);
        }
    });
}

function updateTimers() {
    setInterval(() => {
        $('.time').each(function () {
            const timerElement = $(this);
            const initialTime = parseInt(timerElement.data('initial-time'), 10);

            // Increment and format time
            const updatedTime = initialTime + 1;
            const hours = Math.floor(updatedTime / 3600);
            const minutes = Math.floor((updatedTime % 3600) / 60);
            const seconds = updatedTime % 60;

            // Update DOM
            timerElement.data('initial-time', updatedTime);
            timerElement.find('.hours').text(hours.toString().padStart(2, '0'));
            timerElement.find('.minutes').text(minutes.toString().padStart(2, '0'));
            timerElement.find('.seconds').text(seconds.toString().padStart(2, '0'));
        });
    }, 1000);
}
*/

function updateTimers() {
    // Clear existing timer interval if it exists
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    timerInterval = setInterval(() => {
        $('.time').each(function () {
            const timerElement = $(this);
            const isActiveSession = timerElement.data('active-session') === 'true';
            const isCurrentUser = timerElement.closest('.leaderboard-item').hasClass('current-user');
            const selectedDate = $('#leaderboard-date').val();
            const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
            
            // Only update timers if viewing today's date
            if (selectedDate === today) {
                // Update timer for current user continuously while on the website
                if (isCurrentUser) {
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
                // Also update timers for other users with active sessions
                else if (isActiveSession) {
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
            }
            // For previous dates, timers remain static (no updates)
        });
    }, 1000);
}

// Replace the old updateLeaderboard with a new one using filters
function updateLeaderboard() {
    const date = $('#leaderboard-date').val();
    const classId = $('#class-filter').val();
    let url = 'get_leaderboard.php?date=' + encodeURIComponent(date);
    if (classId !== 'all') url += '&class_id=' + encodeURIComponent(classId);
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            try {
                const data = JSON.parse(response);
                if (data.status === 'error' && (data.message === 'No active session found' || data.message === 'User not logged in')) {
                    window.location.href = 'index.php';
                    return;
                }
                if (data.status === 'success') {
                    const leaderboard = data.leaderboard;
                    const leaderboardContainer = $('.leaderboard-container');
                    leaderboardContainer.empty();
                    if (leaderboard.length === 0) {
                        leaderboardContainer.append('<div class="alert alert-info">No classmates found or no study sessions for this day.</div>');
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
                        const isCurrent = user.is_current_user ? 'current-user' : '';
                        const progress = maxTime > 0 ? Math.round((totalTime / maxTime) * 100) : 0;
                        const isActiveSession = user.is_active_session ? 'true' : 'false';
                        const streak = user.streak || 0;
                        const streakClass = getStreakClass(streak);
                        const streakHtml = streak > 0 ? `<span class="streak ${streakClass}" title="Current streak">🔥 ${streak} day${streak === 1 ? '' : 's'}</span>` : '';
                        const crownHtml = user.is_crown ? '<span class="crown" title="Longest all-time streak in class">👑</span>' : '';
                        const badges = (user.badges || []).map(b => `<span class="badge-icon" title="${b.label}">${b.icon}</span>`).join('');
                        const liveIndicatorHtml = isActiveSession === 'true' ? '<span class="live-indicator"><span class="live-dot"></span> Online</span>' : '';
                        leaderboardContainer.append(`
                            <div class="leaderboard-item ${medalClass} ${isCurrent}" title="${user.is_current_user ? 'You!' : ''}">
                                <div class="rank">${index + 1}</div>
                                <div class="avatar">
                                    <img src="${user.avatar || 'admin/images/ain.PNG'}" alt="${user.firstname} ${user.lastname}" class="img-circle" onerror="this.src='admin/images/ain.PNG'">
                                </div>
                                <div class="details">
                                    <div class="name">${user.firstname} ${user.lastname} ${crownHtml} ${badges} ${user.is_current_user ? '<span class="badge badge-info" style="margin-left:5px;">You</span>' : ''}
                                        ${streakHtml}
                                    </div>
                                    <div class="time" data-user-id="${user.user_id}" data-initial-time="${totalTime}" data-active-session="${isActiveSession}">
                                        <span class="hours" style="display: inline-block; min-width: 20px; text-align: right;">${hours.toString().padStart(2, '0')}</span>h
                                        <span class="minutes" style="display: inline-block; min-width: 20px; text-align: right;">${minutes.toString().padStart(2, '0')}</span>m
                                        <span class="seconds" style="display: inline-block; min-width: 20px; text-align: right;">${seconds.toString().padStart(2, '0')}</span>s
                                    </div>
                                    <div class="sessions" style="font-size:12px;color:#888;">
                                        <span title="Total Sessions"><i class="icon-list"></i> ${user.session_count} sessions</span> |
                                        <span title="Average Session"><i class="icon-time"></i> Avg: ${avgH.toString().padStart(2, '0')}:${avgM.toString().padStart(2, '0')}:${avgS.toString().padStart(2, '0')}</span>
                                    </div>
                                    <div class="progress" style="height:10px;margin-top:5px;background:#e0e0e0;">
                                        <div class="progress-bar" style="width:${progress}%;background:#00796b;height:100%;border-radius:5px;"></div>
                                    </div>
                                    ${liveIndicatorHtml}
                                </div>
                                ${medalClass ? `<div class="medal ${medalClass}" title="${medalClass.charAt(0).toUpperCase() + medalClass.slice(1)} Medal"></div>` : ''}
                            </div>
                        `);
                    });
                    // Start timer updates after leaderboard is loaded
                    setTimeout(function() {
                    updateTimers();
                    }, 100);
                } else {
                    console.error('Error in leaderboard data:', data.message);
                }
            } catch (error) {
                console.error('Error parsing leaderboard response:', error);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching leaderboard:", error);
        }
    });
}

// Update leaderboard when filters change
$('#leaderboard-date, #class-filter').on('change', function() {
    updateLeaderboard();
    // Also update timer.php
    window.updateTimerWithFilters && window.updateTimerWithFilters();
});

// Initial leaderboard load with a small delay to ensure proper initialization
setTimeout(function() {
    updateLeaderboard();
}, 100);

// Update leaderboard every 1 second to show real-time changes
let leaderboardInterval = setInterval(function() {
updateLeaderboard();
}, 1000);

// Timer update interval
let timerInterval = null;

$(document).ready(function() {
    // Hide any open Bootstrap modals and remove lingering backdrops
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');

    // Start study session on page load
    $.ajax({
        url: 'start_study_session.php',
        type: 'GET'
    });
});

// Handle page unload (logout, close tab, etc.)
$(window).on('beforeunload', function() {
    // Clear all intervals to stop timers
    if (leaderboardInterval) {
        clearInterval(leaderboardInterval);
    }
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    // End study session when user leaves the page
    $.ajax({
        url: 'end_study_session.php',
        type: 'GET',
        async: false // Force synchronous request
    });
});

// Handle page visibility change (tab switch, minimize, etc.)
$(document).on('visibilitychange', function() {
    if (document.hidden) {
        // Page is hidden, stop timers
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
    } else {
        // Page is visible again, restart timers if needed
        const selectedDate = $('#leaderboard-date').val();
        const today = new Date().toISOString().split('T')[0];
        if (selectedDate === today) {
            updateTimers();
        }
    }
});

function getStreakClass(streak) {
    if (streak >= 7) return 'streak-gold';
    if (streak >= 3) return 'streak-silver';
    if (streak >= 1) return 'streak-bronze';
    return '';
}

// Function to stop all timers
function stopAllTimers() {
    if (leaderboardInterval) {
        clearInterval(leaderboardInterval);
        leaderboardInterval = null;
    }
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

// Make stopAllTimers available globally
window.stopAllTimers = stopAllTimers;
</script>