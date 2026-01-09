<?php
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("location: index.php");
    exit();
}

$session_id = $_SESSION['id'];
?>
