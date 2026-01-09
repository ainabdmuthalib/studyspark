<?php
include('session.php');
include('connection.php');

// Get parameters
$teacher_class_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$last_message_id = isset($_GET['last_message_id']) ? intval($_GET['last_message_id']) : 0;
$user_id = $session_id;

// Validate parameters
if (!$teacher_class_id || !$user_id) {
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

// Helper function to get full name by student_id or teacher_id
function getUserName($conn, $student_id = null, $teacher_id = null) {
    if ($student_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname FROM student WHERE student_id = '$student_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
        }
    } elseif ($teacher_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname FROM teacher WHERE teacher_id = '$teacher_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
        }
    }
    return "Unknown";
}

// Media display function (same as in main file)
function displayMultipleMedia($message) {
    $media_html = '';
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $message["media_type_$i"];
        $media_path = $message["media_path_$i"];
        if (!$media_type || !$media_path) continue;

        $media_path_esc = htmlspecialchars($media_path);

        $media_html .= '<div style="margin-top:10px; margin-bottom:10px;">';

        if ($media_type == 'image') {
            $media_html .= '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" title="Click to open in new tab">
                    <img src="' . $media_path_esc . '" style="width:100%; height:100%; object-fit: cover;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                  </div>';
        } elseif ($media_type == 'video') {
            $media_html .= '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" title="Click to open in new tab">
                    <video style="width:100%; height:100%; object-fit: cover;">
                    <source src="' . $media_path_esc . '" type="video/mp4">
                  Your browser does not support the video tag.
                    </video>
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                  </div>';
        } elseif ($media_type == 'document') {
            $file_name = basename($media_path);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($file_ext === 'pdf') {
                $media_html .= '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
                    <div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" title="Click to open in new tab">
                        <iframe src="' . $media_path_esc . '" style="width:100%; height:100%; border: none;"></iframe>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                    </div>
                </a>';
            } else {
                $media_html .= '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
                    <div style="width:300px; height:169px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#adb5bd\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'" title="Click to open in new tab">
                        <div style="text-align: center;">
                            <i class="icon-file" style="font-size: 2em; color: #666; margin-bottom: 8px;"></i><br>
                            <span style="color: #666; font-size: 12px;">' . htmlspecialchars($file_name) . '</span>
                        </div>
                    </div>
                </a>';
            }
        } elseif ($media_type == 'link') {
            // Embed YouTube if applicable
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media_path, $match)) {
                $youtube_id = $match[1];
                $media_html .= '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'https://www.youtube.com/watch?v=' . htmlspecialchars($youtube_id) . '\', \'_blank\')" title="Click to open in new tab">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allowfullscreen style="border: none;"></iframe>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                      </div>';
            } else {
                $media_html .= '<div style="width:300px; height:169px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#adb5bd\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'" title="Click to open in new tab">
                        <div style="text-align: center;">
                            <i class="icon-link" style="font-size: 2em; color: #666; margin-bottom: 8px;"></i><br>
                            <span style="color: #666; font-size: 12px; word-break: break-all;">' . htmlspecialchars($media_path) . '</span>
                        </div>
                      </div>';
            }
        }

        $media_html .= '</div>';
    }
    return $media_html;
}

// Fetch new messages
$query = "SELECT * FROM chat_message 
          WHERE teacher_class_id = '$teacher_class_id' 
          AND message_id > '$last_message_id' 
          ORDER BY message_date ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Database error: ' . mysqli_error($conn)]);
    exit;
}

$messages = [];
while ($message = mysqli_fetch_assoc($result)) {
    $sender_name = '';
    if (isset($message['teacher_id'])) {
        $sender_name = getUserName($conn, null, $message['teacher_id']);
    } elseif (isset($message['student_id'])) {
        $sender_name = getUserName($conn, $message['student_id']);
    }
    
    $message_date_formatted = date('d M Y, H:i', strtotime($message['message_date']));
    $media_html = displayMultipleMedia($message);
    
    $messages[] = [
        'message_id' => $message['message_id'],
        'message_content' => $message['message_content'],
        'sender_name' => $sender_name,
        'message_date_formatted' => $message_date_formatted,
        'student_id' => $message['student_id'],
        'teacher_id' => $message['teacher_id'],
        'media_html' => $media_html
    ];
}

// Return JSON response (matching teacher version format)
header('Content-Type: application/json');
echo json_encode($messages);
?> 