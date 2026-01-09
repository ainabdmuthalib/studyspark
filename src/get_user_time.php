<?php
session_start();
require 'vendor/autoload.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['id'];

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->studyspark->study_sessions;

    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
    $startOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 00:00:00') * 1000);
    $endOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 23:59:59') * 1000);

    // Get active sessions for the selected date
    $activeSession = $collection->findOne([
        'user_id' => $userId,
        'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay],
        'end_time' => null
    ]);

    // Calculate active session time if any
    $activeTime = 0;
    if ($activeSession) {
        $activeTime = time() - $activeSession['start_time']->toDateTime()->getTimestamp();
    }

    // Get past sessions for the selected date
    $pastSessions = $collection->find([
        'user_id' => $userId,
        'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay],
        'end_time' => ['$ne' => null]
    ]);

    $totalTime = $activeTime;
    foreach ($pastSessions as $session) {
        $totalTime += $session['duration']; // Sum up the durations of past sessions
    }

    // Format the total time into hours, minutes, and seconds
    $hours = floor($totalTime / 3600);
    $minutes = floor(($totalTime % 3600) / 60);
    $seconds = $totalTime % 60;

    echo json_encode([
        'status' => 'success',
        'total_time' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
