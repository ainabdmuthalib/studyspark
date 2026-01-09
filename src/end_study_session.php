<?php
include('admin/dbcon.php');
include('session.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No active session']);
    exit;
}

$user_id = $_SESSION['id'];

try {
    require 'vendor/autoload.php';
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->studyspark->study_sessions;

    // Find the active session for this user
    $filter = [
        'user_id' => $user_id,
        'end_time' => null
    ];

    // Get the current session to calculate proper duration
    $session = $collection->findOne($filter);
    
    if ($session) {
        $startTime = $session['start_time']->toDateTime()->getTimestamp();
        $endTime = time();
        $duration = $endTime - $startTime;
        
        $update = [
            '$set' => [
                'end_time' => new MongoDB\BSON\UTCDateTime($endTime * 1000),
                'duration' => $duration
            ]
        ];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No active session found']);
        exit;
    }

    $result = $collection->updateOne($filter, $update);

    if ($result->getModifiedCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Study session ended']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No active session found']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} 
?> 