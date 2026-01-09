<?php
include('session.php');
include('dbcon.php');

$teacher_class_id = $_GET['id'];
$last_message_id = isset($_GET['last_message_id']) ? (int)$_GET['last_message_id'] : 0;

function getUserName($conn, $student_id = null, $teacher_id = null) {
    if ($student_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname FROM student WHERE student_id = '$student_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return ['name' => htmlspecialchars($row['firstname'] . ' ' . $row['lastname']), 'type' => 'student'];
        }
    } elseif ($teacher_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname FROM teacher WHERE teacher_id = '$teacher_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return ['name' => htmlspecialchars($row['firstname'] . ' ' . $row['lastname']), 'type' => 'teacher'];
        }
    }
    return ['name' => "Unknown", 'type' => 'unknown']; 
}

$query = "SELECT * FROM chat_message WHERE teacher_class_id = '$teacher_class_id' AND message_id > '$last_message_id' ORDER BY message_date ASC";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $user_info = getUserName($conn, $row['student_id'], $row['teacher_id']);
    $row['sender_name'] = $user_info['name'];
    $row['is_own_message'] = ($user_info['type'] == 'student' && $row['student_id'] == $session_id);
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?> 