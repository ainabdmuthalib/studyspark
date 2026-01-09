<?php include('dbcon.php'); ?>
<?php
$id = $_POST['id'];

// First, check if this is a message_id (from message table) or message_sent_id (from message_sent table)
// Try to find the message in message table first (for teacher sent messages)
$query = mysqli_query($conn, "SELECT sender_id, reciever_id, content, date_sended FROM message WHERE message_id = '$id'") or die(mysqli_error());
if ($row = mysqli_fetch_array($query)) {
    // This is a message from the message table (teacher sent messages)
    $sender_id = $row['sender_id'];
    $reciever_id = $row['reciever_id'];
    $content = mysqli_real_escape_string($conn, $row['content']);
    $date_sended = $row['date_sended'];
    
    // Try multiple deletion strategies to ensure synchronization
    
    // Strategy 1: Exact match
    $delete_sent_query = "DELETE FROM message_sent WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content' AND date_sended = '$date_sended'";
    $delete_sent_result = mysqli_query($conn, $delete_sent_query);
    $deleted_sent_count = mysqli_affected_rows($conn);
    
    // Strategy 2: If no exact match, try matching by sender, receiver, and content only
    if ($deleted_sent_count == 0) {
        $delete_sent_query2 = "DELETE FROM message_sent WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content'";
        $delete_sent_result2 = mysqli_query($conn, $delete_sent_query2);
        $deleted_sent_count = mysqli_affected_rows($conn);
        error_log("Used fallback deletion strategy for teacher sent message_id: $id");
    }
    
    // Strategy 3: If still no match, try matching by sender, receiver, and approximate date
    if ($deleted_sent_count == 0) {
        $date_start = date('Y-m-d H:i:s', strtotime($date_sended) - 60); // 1 minute before
        $date_end = date('Y-m-d H:i:s', strtotime($date_sended) + 60);   // 1 minute after
        $delete_sent_query3 = "DELETE FROM message_sent WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content' AND date_sended BETWEEN '$date_start' AND '$date_end'";
        $delete_sent_result3 = mysqli_query($conn, $delete_sent_query3);
        $deleted_sent_count = mysqli_affected_rows($conn);
        error_log("Used time-based fallback deletion strategy for teacher sent message_id: $id");
    }
    
    if ($deleted_sent_count > 0) {
        error_log("Successfully deleted $deleted_sent_count message(s) from message_sent table for teacher sent message_id: $id");
    } else {
        error_log("No matching message found in message_sent table for teacher sent message_id: $id");
    }
    
    // Delete from message table (teacher's sent items)
    $delete_message_query = "DELETE FROM message WHERE message_id = '$id'";
    $delete_message_result = mysqli_query($conn, $delete_message_query);
    
    if ($delete_message_result) {
        $deleted_message_count = mysqli_affected_rows($conn);
        error_log("Deleted $deleted_message_count message(s) from message table for teacher sent message_id: $id");
    } else {
        error_log("Error deleting from message table: " . mysqli_error($conn));
    }
} else {
    // Try to find the message in message_sent table (for student sent messages)
    $query = mysqli_query($conn, "SELECT sender_id, reciever_id, content, date_sended FROM message_sent WHERE message_sent_id = '$id'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($query)) {
        $sender_id = $row['sender_id'];
        $reciever_id = $row['reciever_id'];
        $content = mysqli_real_escape_string($conn, $row['content']);
        $date_sended = $row['date_sended'];
        
        // Try multiple deletion strategies to ensure synchronization
        
        // Strategy 1: Exact match
        $delete_message_query = "DELETE FROM message WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content' AND date_sended = '$date_sended'";
        $delete_message_result = mysqli_query($conn, $delete_message_query);
        $deleted_message_count = mysqli_affected_rows($conn);
        
        // Strategy 2: If no exact match, try matching by sender, receiver, and content only
        if ($deleted_message_count == 0) {
            $delete_message_query2 = "DELETE FROM message WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content'";
            $delete_message_result2 = mysqli_query($conn, $delete_message_query2);
            $deleted_message_count = mysqli_affected_rows($conn);
            error_log("Used fallback deletion strategy for student sent message_sent_id: $id");
        }
        
        // Strategy 3: If still no match, try matching by sender, receiver, and approximate date
        if ($deleted_message_count == 0) {
            $date_start = date('Y-m-d H:i:s', strtotime($date_sended) - 60); // 1 minute before
            $date_end = date('Y-m-d H:i:s', strtotime($date_sended) + 60);   // 1 minute after
            $delete_message_query3 = "DELETE FROM message WHERE sender_id = '$sender_id' AND reciever_id = '$reciever_id' AND content = '$content' AND date_sended BETWEEN '$date_start' AND '$date_end'";
            $delete_message_result3 = mysqli_query($conn, $delete_message_query3);
            $deleted_message_count = mysqli_affected_rows($conn);
            error_log("Used time-based fallback deletion strategy for student sent message_sent_id: $id");
        }
        
        if ($deleted_message_count > 0) {
            error_log("Successfully deleted $deleted_message_count message(s) from message table for student sent message_sent_id: $id");
        } else {
            error_log("No matching message found in message table for student sent message_sent_id: $id");
        }
        
        // Delete from message_sent table (student's sent items)
        $delete_sent_query = "DELETE FROM message_sent WHERE message_sent_id = '$id'";
        $delete_sent_result = mysqli_query($conn, $delete_sent_query);
        
        if ($delete_sent_result) {
            $deleted_sent_count = mysqli_affected_rows($conn);
            error_log("Deleted $deleted_sent_count message(s) from message_sent table for student sent message_sent_id: $id");
        } else {
            error_log("Error deleting from message_sent table: " . mysqli_error($conn));
        }
    } else {
        error_log("Message not found in either message or message_sent table for ID: $id");
    }
}

// Return success response
echo "success";
?>

