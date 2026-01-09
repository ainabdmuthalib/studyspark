<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('admin/dbcon.php');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$class_id = $_POST['class_id'];

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// 1. Check if the username already exists
$stmt_check = $conn->prepare("SELECT student_id FROM student WHERE username = ?");
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Username already exists
    echo 'exists';
    $stmt_check->close();
    exit();
}
$stmt_check->close();

// 2. Insert new student into the database
$stmt_insert = $conn->prepare("INSERT INTO student (username, password, firstname, lastname, class_id, status) VALUES (?, ?, ?, ?, ?, 'Registered')");
$stmt_insert->bind_param("ssssi", $username, $hashed_password, $firstname, $lastname, $class_id);

if ($stmt_insert->execute()) {
    // Successfully inserted, set session
    $student_id = $stmt_insert->insert_id;
    $_SESSION['id'] = $student_id;
    // Insert into MongoDB
    try {
        require_once __DIR__ . '/admin/vendor/autoload.php'; // MongoDB
        $mongo = new MongoDB\Client("mongodb://localhost:27017");
        $collection = $mongo->studyspark->students;
        $mongoResult = $collection->insertOne([
            'student_id' => $student_id,
            'username' => $username,
            'password' => $hashed_password,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'class_id' => $class_id,
            'status' => 'Registered'
        ]);
        if ($mongoResult->getInsertedCount() !== 1) {
            // Rollback MySQL insert
            $conn->query("DELETE FROM student WHERE student_id = '$student_id'");
            echo 'false';
            exit();
        }
        echo 'true';
    } catch (Exception $e) {
        // Rollback MySQL insert
        $conn->query("DELETE FROM student WHERE student_id = '$student_id'");
        error_log("MongoDB insert failed: " . $e->getMessage());
        echo 'false';
    }
} else {
    echo 'false'; // Insertion failed
}
$stmt_insert->close();
?>
