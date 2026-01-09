<?php
include('dbcon.php');
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403);
    exit('error');
}
if (isset($_POST['id'], $_POST['name'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    if ($id > 0 && $name !== '') {
        // Get old name for logging
        $result = mysqli_query($conn, "SELECT school_year FROM school_year WHERE school_year_id = $id LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $old_name = $row ? $row['school_year'] : '';
        // Update
        $update = mysqli_query($conn, "UPDATE school_year SET school_year = '" . mysqli_real_escape_string($conn, $name) . "' WHERE school_year_id = $id");
        if ($update) {
            // Log activity
            $user_id = $_SESSION['id'];
            $desc = 'Edited semester name from "' . addslashes($old_name) . '" to "' . addslashes($name) . '"';
            mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (NOW(), '$user_id', '$desc')");
            echo 'success';
            exit();
        }
    }
}
echo 'error'; 