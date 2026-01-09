<?php
include('../dbcon.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $hashed_password = $new_password; // Change this to use password_hash if you want more security
    $result = mysqli_query($conn, "UPDATE users SET password = '$hashed_password' WHERE user_id = '$user_id'");
    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
} 