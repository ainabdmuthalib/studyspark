<?php
include('dbcon.php');
include('session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $session_id; // from session.php
    $reciever_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $content = mysqli_real_escape_string($conn, $_POST['my_message']);
    $date_sended = date('Y-m-d H:i:s');

    $query = "INSERT INTO message (sender_id, reciever_id, content, date_sended) VALUES ('$sender_id', '$reciever_id', '$content', '$date_sended')";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        http_response_code(500);
        echo 'error';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
} 