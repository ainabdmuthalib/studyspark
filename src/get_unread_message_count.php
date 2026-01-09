<?php
include('session.php');
include('dbcon.php');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
} else {
    $user_id = $session_id;
}

// Get count of unread messages
$query = mysqli_query($conn, "SELECT COUNT(*) as count FROM message WHERE reciever_id = '$user_id' AND message_status != 'read'") or die(mysqli_error());
$result = mysqli_fetch_assoc($query);

echo json_encode(['count' => (int)$result['count']]);
?> 