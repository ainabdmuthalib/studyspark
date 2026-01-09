<?php
include('admin/dbcon.php');

// Test script to verify message synchronization
echo "<h2>Message Synchronization Test</h2>";

// Function to display messages in both tables
function displayMessages($conn) {
    echo "<h3>Current Messages:</h3>";
    
    echo "<h4>Message Table (Inbox):</h4>";
    $query = mysqli_query($conn, "SELECT message_id, sender_id, reciever_id, content, date_sended FROM message ORDER BY date_sended DESC LIMIT 5");
    if ($query && mysqli_num_rows($query) > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Sender</th><th>Receiver</th><th>Content</th><th>Date</th></tr>";
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr><td>{$row['message_id']}</td><td>{$row['sender_id']}</td><td>{$row['reciever_id']}</td><td>" . substr($row['content'], 0, 50) . "...</td><td>{$row['date_sended']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No messages in message table</p>";
    }
    
    echo "<h4>Message_Sent Table (Sent Items):</h4>";
    $query = mysqli_query($conn, "SELECT message_sent_id, sender_id, reciever_id, content, date_sended FROM message_sent ORDER BY date_sended DESC LIMIT 5");
    if ($query && mysqli_num_rows($query) > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Sender</th><th>Receiver</th><th>Content</th><th>Date</th></tr>";
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr><td>{$row['message_sent_id']}</td><td>{$row['sender_id']}</td><td>{$row['reciever_id']}</td><td>" . substr($row['content'], 0, 50) . "...</td><td>{$row['date_sended']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No messages in message_sent table</p>";
    }
}

// Display current messages
displayMessages($conn);

// Test deletion if a message ID is provided
if (isset($_GET['test_delete']) && isset($_GET['message_id'])) {
    $test_id = $_GET['message_id'];
    $delete_type = $_GET['delete_type']; // 'inbox' or 'sent'
    
    echo "<h3>Testing Deletion:</h3>";
    echo "<p>Deleting message ID: $test_id from $delete_type</p>";
    
    if ($delete_type == 'inbox') {
        // Simulate inbox deletion
        $_POST['id'] = $test_id;
        ob_start();
        include('remove_inbox_message.php');
        $result = ob_get_clean();
        echo "<p>Inbox deletion result: $result</p>";
    } else {
        // Simulate sent message deletion
        $_POST['id'] = $test_id;
        ob_start();
        include('remove_sent_message.php');
        $result = ob_get_clean();
        echo "<p>Sent message deletion result: $result</p>";
    }
    
    echo "<h3>Messages After Deletion:</h3>";
    displayMessages($conn);
}

echo "<hr>";
echo "<h3>Test Links:</h3>";
echo "<p><a href='?test_delete=1&message_id=1&delete_type=inbox'>Test Delete Message ID 1 from Inbox</a></p>";
echo "<p><a href='?test_delete=1&message_id=1&delete_type=sent'>Test Delete Message ID 1 from Sent</a></p>";
echo "<p><a href='test_message_sync.php'>Refresh</a></p>";
?> 