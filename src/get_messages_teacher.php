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

// Function to generate media HTML
function generateMediaHtml($message) {
    $mediaHtml = '';
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $message["media_type_$i"];
        $media_path = $message["media_path_$i"];
        if (!$media_type || !$media_path) continue;

        $media_path_esc = htmlspecialchars($media_path);

        $mediaHtml .= '<div style="margin-top:10px; margin-bottom:10px;">';

        if ($media_type == 'image') {
            $mediaHtml .= '<img src="' . $media_path_esc . '" style="max-width:300px; max-height:300px;">';
        } elseif ($media_type == 'video') {
            $mediaHtml .= '<video controls style="max-width:300px; max-height:300px;"><source src="' . $media_path_esc . '" type="video/mp4"></video>';
        } elseif ($media_type == 'document') {
            $file_name = basename($media_path);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($file_ext === 'pdf') {
                $mediaHtml .= '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
                    <iframe src="' . $media_path_esc . '" style="width:100%; max-width:600px; height:400px;" frameborder="0"></iframe>
                </a>';
            } else {
                $mediaHtml .= '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
                    <div style="background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 4px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#adb5bd\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'">
                        <i class="icon-file" style="font-size: 2em; color: #666; margin-bottom: 8px;"></i><br>
                        <span style="color: #666; font-size: 12px;">' . htmlspecialchars($file_name) . '</span>
                    </div>
                </a>';
            }
        } elseif ($media_type == 'link') {
            // Embed YouTube if applicable
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media_path, $match)) {
                $youtube_id = $match[1];
                $mediaHtml .= '<iframe width="300" height="169" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allowfullscreen></iframe>';
            } else {
                $mediaHtml .= '<p><a href="' . $media_path_esc . '" target="_blank">' . $media_path_esc . '</a></p>';
            }
        }

        $mediaHtml .= '</div>';
    }
    return $mediaHtml;
}

$query = "SELECT * FROM chat_message WHERE teacher_class_id = '$teacher_class_id' AND message_id > '$last_message_id' ORDER BY message_date ASC";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $user_info = getUserName($conn, $row['student_id'], $row['teacher_id']);
    $row['sender_name'] = $user_info['name'];
    $row['sender_type'] = $user_info['type'];
    $row['message_date_formatted'] = date('d M Y, H:i', strtotime($row['message_date']));
    $row['media_html'] = generateMediaHtml($row);
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
?> 