<?php
include('admin/dbcon.php');
session_start();

// Get user input from form
$username = $_POST['username'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$department_id = $_POST['department_id'];

$username = trim($_POST['username']);

$stmt = $conn->prepare("SELECT * FROM teacher WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'exists'; // Username already taken
    exit();
}


// Insert new account
$insert = mysqli_query($conn, "INSERT INTO teacher (username, password, firstname, lastname, department_id, teacher_status) 
    VALUES ('$username', '$password', '$firstname', '$lastname', '$department_id', 'Registered')") or die(mysqli_error($conn));

if ($insert) {
    // Get the inserted teacher ID
    $new_id = mysqli_insert_id($conn);
    $_SESSION['id'] = $new_id;
    echo 'true'; // Account created
} else {
    echo 'false'; // Error inserting
}
?>
