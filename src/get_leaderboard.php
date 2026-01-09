<?php
require 'vendor/autoload.php';
require 'dbcon.php'; // or dbConnector.php if that's the main MySQL connection
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No active session found']);
    exit();
}

function calculate_streak($collection, $uid, $today) {
    // Get all unique days with at least one session, up to today
    $sessions = $collection->aggregate([
        ['$match' => [
            'user_id' => $uid,
            'start_time' => ['$lte' => new MongoDB\BSON\UTCDateTime(strtotime($today . ' 23:59:59') * 1000)]
        ]],
        ['$group' => [
            '_id' => [
                'year' => ['$year' => ['$toDate' => '$start_time']],
                'month' => ['$month' => ['$toDate' => '$start_time']],
                'day' => ['$dayOfMonth' => ['$toDate' => '$start_time']]
            ]]
        ]
    ]);
    $days = [];
    foreach ($sessions as $s) {
        $y = $s['_id']['year'];
        $m = $s['_id']['month'];
        $d = $s['_id']['day'];
        $days[] = sprintf('%04d-%02d-%02d', $y, $m, $d);
    }
    // Sort days descending
    rsort($days);
    // Calculate streak
    $streak = 0;
    $current = $today;
    while (in_array($current, $days)) {
        $streak++;
        $current = date('Y-m-d', strtotime($current . ' -1 day'));
    }
    return $streak;
}

function get_badges($totalTime, $sessionCount, $streak) {
    $badges = [];
    if ($sessionCount >= 1) $badges[] = ['icon' => '🎉', 'label' => 'First session'];
    if ($sessionCount >= 10) $badges[] = ['icon' => '🔟', 'label' => '10 sessions'];
    if ($sessionCount >= 25) $badges[] = ['icon' => '🏅', 'label' => '25 sessions'];
    if ($sessionCount >= 50) $badges[] = ['icon' => '🥇', 'label' => '50 sessions'];
    if ($totalTime >= 3600 * 5) $badges[] = ['icon' => '⏰', 'label' => '5+ hours'];
    if ($totalTime >= 3600 * 10) $badges[] = ['icon' => '⏳', 'label' => '10+ hours'];
    if ($totalTime >= 3600 * 20) $badges[] = ['icon' => '🕰️', 'label' => '20+ hours'];
    if ($totalTime >= 3600 * 50) $badges[] = ['icon' => '🏆', 'label' => '50+ hours'];
    if ($streak >= 3) $badges[] = ['icon' => '🔥', 'label' => '3+ day streak'];
    if ($streak >= 7) $badges[] = ['icon' => '🥈', 'label' => '7+ day streak'];
    if ($streak >= 14) $badges[] = ['icon' => '🥇', 'label' => '14+ day streak'];
    if ($streak >= 30) $badges[] = ['icon' => '👑', 'label' => '30+ day streak'];
    return $badges;
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$classId = isset($_GET['class_id']) ? $_GET['class_id'] : null;

$startOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 00:00:00') * 1000);
$endOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 23:59:59') * 1000);

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->studyspark->study_sessions;

    $userIds = [];
    $isClassLeaderboard = ($classId && $classId !== 'all');
    $classmates = [];
    
    // Get current user's ID from session
    $currentUserId = isset($_SESSION['id']) ? (string)$_SESSION['id'] : null;
    
    if ($isClassLeaderboard) {
        // Get all classmates for the specific class
        $stmt = $conn->prepare("SELECT student.student_id, student.firstname, student.lastname, student.location FROM teacher_class_student LEFT JOIN student ON student.student_id = teacher_class_student.student_id WHERE teacher_class_id = ?");
        $stmt->bind_param("s", $classId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $userIds[] = (string)$row['student_id']; // Force to string
            $classmates[(string)$row['student_id']] = [
                'user_id' => (string)$row['student_id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'avatar' => isset($row['location']) ? 'admin/' . $row['location'] : '',
                'total_time' => 0,
                'session_count' => 0,
                'average_session' => 0,
                'is_current_user' => false,
                'is_active_session' => false,
                'streak' => 0
            ];
        }
    } else if ($classId === 'all') {
        // For "all" filter, we'll get students from MongoDB sessions first, then fetch their details
        // This ensures we only show students who have active sessions for the selected day
        $sessions = $collection->find([
            'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay]
        ]);
        
        $activeUserIds = [];
        foreach ($sessions as $session) {
            $activeUserIds[] = (string)$session['user_id'];
        }
        
        // Remove duplicates
        $activeUserIds = array_unique($activeUserIds);
        
        if (!empty($activeUserIds)) {
            // Get student details for users with active sessions (only students, not teachers)
            $placeholders = str_repeat('?,', count($activeUserIds) - 1) . '?';
            $stmt = $conn->prepare("SELECT student_id, firstname, lastname, location FROM student WHERE student_id IN ($placeholders)");
            $stmt->bind_param(str_repeat('s', count($activeUserIds)), ...$activeUserIds);
        $stmt->execute();
        $result = $stmt->get_result();
            
        while ($row = $result->fetch_assoc()) {
                $userIds[] = (string)$row['student_id'];
            $classmates[(string)$row['student_id']] = [
                'user_id' => (string)$row['student_id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'avatar' => isset($row['location']) ? 'admin/' . $row['location'] : '',
                'total_time' => 0,
                'session_count' => 0,
                'average_session' => 0,
                'is_current_user' => false,
                'is_active_session' => false,
                'streak' => 0
            ];
            }
        }
    }

    $match = [
        'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay]
    ];
    if (($isClassLeaderboard || $classId === 'all') && !empty($userIds)) {
        $match['user_id'] = ['$in' => $userIds];
    }

    $leaderboard = [];
    
    // Mark current user in classmates array
    if ($currentUserId && isset($classmates[$currentUserId])) {
        $classmates[$currentUserId]['is_current_user'] = true;
    }
    if ($isClassLeaderboard || $classId === 'all') {
        // For each classmate, sum all their sessions for the day
        foreach ($classmates as $uid => $classmate) {
            $userSessions = $collection->find([
                'user_id' => (string)$uid,
                'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay]
            ]);
            $totalTime = 0;
            $sessionCount = 0;
            $isActiveSession = false;
            foreach ($userSessions as $session) {
                $sessionCount++;
                if (isset($session['end_time']) && $session['end_time'] !== null) {
                    $totalTime += $session['duration'];
                } else {
                    $totalTime += time() - $session['start_time']->toDateTime()->getTimestamp();
                    $isActiveSession = true;
                }
            }
            $avgSession = $sessionCount > 0 ? round($totalTime / $sessionCount) : 0;
            $streak = calculate_streak($collection, (string)$uid, $date);
            $badges = get_badges($totalTime, $sessionCount, $streak);
            $classmate['total_time'] = $totalTime;
            $classmate['session_count'] = $sessionCount;
            $classmate['average_session'] = $avgSession;
            $classmate['is_active_session'] = $isActiveSession;
            $classmate['streak'] = $streak;
            $classmate['is_crown'] = false; // default
            $classmate['badges'] = $badges;
            $leaderboard[] = $classmate;
        }
        // Find the max all-time streak in the class
        $maxStreak = 0;
        foreach ($classmates as $uid => $classmate) {
            $allTimeStreak = calculate_streak($collection, (string)$uid, date('Y-m-d'));
            if ($allTimeStreak > $maxStreak) {
                $maxStreak = $allTimeStreak;
            }
            $classmates[$uid]['all_time_streak'] = $allTimeStreak;
        }
        // Mark the user(s) with the max all-time streak
        foreach ($leaderboard as &$entry) {
            $allTimeStreak = calculate_streak($collection, (string)$entry['user_id'], date('Y-m-d'));
            $entry['is_crown'] = ($allTimeStreak == $maxStreak && $maxStreak > 0);
        }
        unset($entry);
    } else {
        // For all students, only show those with data (only students, not teachers)
        $sessions = $collection->find($match);
        $userTotals = [];
        $activeSessionUsers = [];
        foreach ($sessions as $session) {
            $uid = (string)$session['user_id'];
            if (!isset($userTotals[$uid])) {
                $userTotals[$uid] = [
                    'total_time' => 0,
                    'session_count' => 0,
                    'active_session_time' => 0
                ];
            }
            $userTotals[$uid]['session_count']++;
            if (isset($session['end_time']) && $session['end_time'] !== null) {
                $userTotals[$uid]['total_time'] += $session['duration'];
            } else {
                $userTotals[$uid]['active_session_time'] += time() - $session['start_time']->toDateTime()->getTimestamp();
                $activeSessionUsers[$uid] = true;
            }
        }
        foreach ($userTotals as $uid => $totals) {
            $totalTime = $totals['total_time'] + $totals['active_session_time'];
            $sessionCount = $totals['session_count'];
            $avgSession = $sessionCount > 0 ? round($totalTime / $sessionCount) : 0;
            $streak = calculate_streak($collection, (string)$uid, $date);
            $badges = get_badges($totalTime, $sessionCount, $streak);
            // Get user details from MySQL (only students)
            $user_stmt = $conn->prepare("SELECT firstname, lastname, location FROM student WHERE student_id = ?");
            $user_stmt->bind_param("s", $uid);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user = $user_result->fetch_assoc();
            
            // Only include if user exists in student table (excludes teachers)
            if ($user) {
            $isCurrentUser = ($currentUserId && $uid == $currentUserId);
            $isActiveSession = isset($activeSessionUsers[$uid]) ? true : false;
            $leaderboard[] = [
                'user_id' => $uid,
                'firstname' => $user['firstname'] ?? '',
                'lastname' => $user['lastname'] ?? '',
                'avatar' => isset($user['location']) ? 'admin/' . $user['location'] : '',
                'total_time' => $totalTime,
                'session_count' => $sessionCount,
                'average_session' => $avgSession,
                'is_current_user' => $isCurrentUser,
                'is_active_session' => $isActiveSession,
                'streak' => $streak,
                'badges' => $badges
            ];
            }
        }
    }
    // Sort leaderboard by total_time descending
    usort($leaderboard, function($a, $b) {
        return $b['total_time'] <=> $a['total_time'];
    });
    echo json_encode(['status' => 'success', 'leaderboard' => $leaderboard]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} 