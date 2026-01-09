<?php
include('session.php');
include('dbcon.php');
header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$user_id = $_SESSION['id'];

if (!$type || !$id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

if ($type === 'post') {
    // Check ownership (student or teacher)
    $q = mysqli_query($conn, "SELECT student_id, teacher_id FROM discussion_post WHERE discussion_post_id = '$id'");
    if (!$q || mysqli_num_rows($q) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Post not found.']);
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    if ($row['student_id'] != $user_id && $row['teacher_id'] != $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }
    // Delete replies
    mysqli_query($conn, "DELETE FROM discussion_reply WHERE discussion_post_id = '$id'");
    // Delete post
    mysqli_query($conn, "DELETE FROM discussion_post WHERE discussion_post_id = '$id'");
    echo json_encode(['status' => 'success']);
    exit;
} elseif ($type === 'reply') {
    // Check ownership (student or teacher)
    $q = mysqli_query($conn, "SELECT student_id, teacher_id FROM discussion_reply WHERE discussion_reply_id = '$id'");
    if (!$q || mysqli_num_rows($q) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Reply not found.']);
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    if ($row['student_id'] != $user_id && $row['teacher_id'] != $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }
    mysqli_query($conn, "DELETE FROM discussion_reply WHERE discussion_reply_id = '$id'");
    echo json_encode(['status' => 'success']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid type.']);
    exit;
} 