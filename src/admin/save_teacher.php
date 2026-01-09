<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include('dbcon.php');

// Validate required POST fields
if (!isset($_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['department'], $_POST['password'], $_POST['retype_password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit();
}

$username = trim($_POST['username']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$department_id = (int)$_POST['department'];
$password = $_POST['password'];
$retype_password = $_POST['retype_password'];

// Password validation
function valid_password($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password) && !preg_match('/[^A-Za-z0-9]/', $password)) return false;
    return true;
}
if ($password !== $retype_password) {
    echo json_encode(['success' => false, 'error' => 'Passwords do not match']);
    exit();
}
if (!valid_password($password)) {
    echo json_encode(['success' => false, 'error' => 'Password does not meet requirements']);
    exit();
}

// Check for duplicate username
$check = mysqli_query($conn, "SELECT * FROM teacher WHERE username = '$username'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['success' => false, 'error' => 'Username already exists']);
    exit();
}

$location = 'uploads/NO-IMAGE-AVAILABLE.jpg';
$teacher_stat = 'Activated';

$insert = mysqli_query($conn, "INSERT INTO teacher (username, password, firstname, lastname, location, department_id, teacher_stat)
    VALUES ('$username', '$password', '$firstname', '$lastname', '$location', '$department_id', '$teacher_stat')");

if (!$insert) {
    echo json_encode(['success' => false, 'error' => 'MySQL Error: ' . mysqli_error($conn)]);
    exit();
}

echo json_encode(['success' => true]); 