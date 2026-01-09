<?php
include('admin/dbcon.php');
include('session.php');
$sender_id = $_POST['sender_id'];
$sender_name = $_POST['name_of_sender'];
$my_name = $_POST['my_name'];
$my_message = $_POST['my_message'];

// Determine if recipient is a student or teacher
$recipient_name = '';
$res = mysqli_query($conn, "SELECT firstname, lastname FROM student WHERE student_id = '$sender_id'");
if ($res && mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $recipient_name = $row['firstname'] . ' ' . $row['lastname'];
} else {
    $res = mysqli_query($conn, "SELECT firstname, lastname FROM teacher WHERE teacher_id = '$sender_id'");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $recipient_name = $row['firstname'] . ' ' . $row['lastname'];
    } else {
        $recipient_name = 'Unknown';
    }
}

mysqli_query($conn,"insert into message (reciever_id,content,date_sended,sender_id,reciever_name,sender_name) values('$sender_id','$my_message',NOW(),'$session_id','$recipient_name','$my_name')")or die(mysqli_error());
mysqli_query($conn,"insert into message_sent (reciever_id,content,date_sended,sender_id,reciever_name,sender_name) values('$sender_id','$my_message',NOW(),'$session_id','$recipient_name','$my_name')")or die(mysqli_error());

// Redirect to sent message page
header("Location: sent_message.php");
exit();
?>