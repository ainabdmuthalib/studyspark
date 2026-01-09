<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
include('dbcon.php');

// Validate required POST fields
if (!isset($_POST['un'], $_POST['fn'], $_POST['ln'], $_POST['class_id'], $_POST['password'], $_POST['retype_password'])) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit();
}

$un = trim($_POST['un']);
$fn = trim($_POST['fn']);
$ln = trim($_POST['ln']);
$class_id = (int)$_POST['class_id'];
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

$location = 'uploads/NO-IMAGE-AVAILABLE.jpg';
$status = 'Unregistered';

// Insert into MySQL (plain text password)
$insert = mysqli_query($conn, "INSERT INTO student (username, password, firstname, lastname, location, class_id, status)
    VALUES ('$un', '$password', '$fn', '$ln', '$location', '$class_id', '$status')");

if (!$insert) {
    echo json_encode(['success' => false, 'error' => 'MySQL Error: ' . mysqli_error($conn)]);
    exit();
}

$student_id = mysqli_insert_id($conn);

echo json_encode(['success' => true]);
?>
