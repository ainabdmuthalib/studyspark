<?php
include('session.php');
include('dbcon.php');

if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    $user_id = $session_id;
    
    // Update message status to 'read'
    $result = mysqli_query($conn, "UPDATE message SET message_status = 'read' WHERE message_id = '$message_id' AND reciever_id = '$user_id'");
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Message marked as read']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to mark message as read']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No message ID provided']);
}
?> 