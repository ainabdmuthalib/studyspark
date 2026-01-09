<?php
session_start();
require 'vendor/autoload.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['id'];
$date = date('Y-m-d');
$startOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 00:00:00') * 1000);
$endOfDay = new MongoDB\BSON\UTCDateTime(strtotime($date . ' 23:59:59') * 1000);

try {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->studyspark->study_sessions;

    // Check for active session for today
    $activeSession = $collection->findOne([
        'user_id' => $userId,
        'start_time' => ['$gte' => $startOfDay, '$lte' => $endOfDay],
        'end_time' => null
    ]);

    if (!$activeSession) {
        // Create new session
        $collection->insertOne([
            'user_id' => $userId,
            'start_time' => new MongoDB\BSON\UTCDateTime(),
            'end_time' => null,
            'duration' => 0
        ]);
        echo json_encode(['status' => 'started']);
    } else {
        echo json_encode(['status' => 'already_active']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} 