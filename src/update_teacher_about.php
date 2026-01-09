<?php
include('session.php');
include('admin/dbcon.php');

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo 'Not logged in.';
    exit;
}

$teacher_id = $_SESSION['id'];
$about = isset($_POST['about']) ? mysqli_real_escape_string($conn, $_POST['about']) : '';

if ($about === '') {
    http_response_code(400);
    echo 'About info cannot be empty.';
    exit;
}

$result = mysqli_query($conn, "UPDATE teacher SET about = '$about' WHERE teacher_id = '$teacher_id'");

if ($result) {
    echo 'success';
} else {
    http_response_code(500);
    echo 'Failed to update.';
} 