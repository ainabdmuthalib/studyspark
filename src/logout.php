<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
require 'vendor/autoload.php';
include('admin/dbcon.php'); // Ensure DB connection is available

// Place at the top of your main page after session_start()
if (isset($_SESSION['id'])) {
    $today = date('Y-m-d');
    if (!isset($_SESSION['study_start_time']) || date('Y-m-d', $_SESSION['study_start_time']) !== $today) {
        $_SESSION['study_start_time'] = time();
    }
}

if (isset($_SESSION['id']) && isset($_SESSION['study_start_time'])) {
    $session_id = $_SESSION['id'];
    $start_time = $_SESSION['study_start_time'];
    $end_time = time();
    $duration = $end_time - $start_time;

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $collection = $client->studyspark->study_sessions;

    $collection->insertOne([
        'user_id' => $session_id,
        'start_time' => new MongoDB\BSON\UTCDateTime($start_time * 1000),
        'end_time' => new MongoDB\BSON\UTCDateTime($end_time * 1000),
        'duration' => $duration
    ]);

    unset($_SESSION['study_start_time']);
}

$is_student = false;
if (isset($_SESSION['id'])) {
    $session_id = $_SESSION['id'];
    // Check if this id exists in the student table
    $student_check = mysqli_query($conn, "SELECT student_id FROM student WHERE student_id = '$session_id'");
    if (mysqli_num_rows($student_check) > 0) {
        $is_student = true;
    }
}

// End study session before logout, but only for students
if ($is_student) {
    try {
        ob_start();
        include_once 'end_study_session.php';
        ob_end_clean();
    } catch (Exception $e) {
        // Log or ignore error
    }
}

session_destroy();
header('location:index.php');
exit();
?>
