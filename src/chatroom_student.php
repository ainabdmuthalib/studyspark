<?php 
include('session.php');  // Make sure this sets $conn and $session_id properly
include('header_dashboard.php'); 

$get_id = $_GET['id'];
$user_id = $session_id; // from session.php

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
    return "Unknown";  // Return "Unknown" if neither student nor teacher ID is found
}


// Handle deletion requests before output
if (isset($_GET['delete_message_id'])) {
    $delete_message_id = intval($_GET['delete_message_id']);
    // Only allow deletion if the message belongs to the logged-in student
    $check = mysqli_query($conn, "SELECT student_id FROM chat_message WHERE message_id = '$delete_message_id'");
    if ($check && mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        if ($row['student_id'] == $user_id) {
            mysqli_query($conn, "DELETE FROM chat_message WHERE message_id = '$delete_message_id'") or die(mysqli_error($conn));
        }
    }
            header("Location: chatroom_student.php?id=$get_id");
            exit;
}

// Allowed extensions and size limits for uploads
$allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
$allowed_video = ['mp4'];
$allowed_docs = ['pdf', 'docx', 'pptx'];
$max_size_image = 200 * 1024 * 1024;  // 200MB
$max_size_video = 200 * 1024 * 1024;  // 200MB
$max_size_docs  = 200 * 1024 * 1024;  // 200MB

// Helper functions for file upload & media processing

function handle_upload($file, $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null]; // No file uploaded
        }
        return "File upload error code: " . $file['error'];
    }

    $file_tmp = $file['tmp_name'];
    $file_name = basename($file['name']);
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_image) && $file_size <= $max_size_image) {
        $media_type = 'image';
        $upload_dir = 'uploads/images/';
    } elseif (in_array($file_ext, $allowed_video) && $file_size <= $max_size_video) {
        $media_type = 'video';
        $upload_dir = 'uploads/videos/';
    } elseif (in_array($file_ext, $allowed_docs) && $file_size <= $max_size_docs) {
        $media_type = 'document';
        $upload_dir = 'uploads/docs/';
    } else {
        return "Invalid file type or file too large.";
    }

    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            return "Failed to create upload directory.";
        }
    }

    $new_file_name = uniqid() . '.' . $file_ext;
    $destination = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        return [$media_type, $destination];
    } else {
        return "Failed to move uploaded file.";
    }
}

function processMultipleMedia($prefix, $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs) {
    $all_media_types = [];
    $all_media_paths = [];

    // First, collect all files
    for ($i = 1; $i <= 3; $i++) {
        $fileKey = $prefix . '_media_' . $i;
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = handle_upload($_FILES[$fileKey], $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);
            if (is_array($upload_result)) {
                list($media_type, $media_path) = $upload_result;
                $all_media_types[] = $media_type;
                $all_media_paths[] = $media_path;
            } elseif (is_string($upload_result) && !empty($upload_result)) {
                die(ucfirst($prefix) . " file upload error for file $i: " . htmlspecialchars($upload_result));
            }
        }
    }

    // Then, collect all links
    for ($i = 1; $i <= 3; $i++) {
        $linkKey = $prefix . '_link_' . $i;
        if (!empty($_POST[$linkKey])) {
            $link = trim($_POST[$linkKey]);
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                $all_media_types[] = 'link';
                $all_media_paths[] = $link;
            } elseif ($link !== '') {
                die("Invalid URL provided in $prefix link $i.");
            }
        }
    }

    // Pad arrays to exactly 3 elements
    while (count($all_media_types) < 3) {
        $all_media_types[] = null;
        $all_media_paths[] = null;
    }

    // Return only first 3 elements
    return [array_slice($all_media_types, 0, 3), array_slice($all_media_paths, 0, 3)];
}

// Handle new message submission by student
if (isset($_POST['new_message'])) {
    // Ensure required variables are set
    if (!isset($get_id) || !isset($user_id)) {
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required session data']);
            exit;
        } else {
            die("Missing required session data");
        }
    }
    
    $content = trim($_POST['message_content']);
    list($media_types, $media_paths) = processMultipleMedia('message', $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);

    $hasContentOrMedia = !empty($content);
    foreach ($media_types as $mt) {
        if ($mt !== null) $hasContentOrMedia = true;
    }

    if ($hasContentOrMedia) {
        $content_escaped = mysqli_real_escape_string($conn, $content);
        for ($i = 0; $i < 3; $i++) {
            $media_types[$i] = $media_types[$i] ? mysqli_real_escape_string($conn, $media_types[$i]) : null;
            $media_paths[$i] = $media_paths[$i] ? mysqli_real_escape_string($conn, $media_paths[$i]) : null;
        }

        // Debug: Log the data being processed
        if (isset($_POST['ajax_request'])) {
            error_log("Chat message data - Content: " . $content . ", Media types: " . print_r($media_types, true) . ", Media paths: " . print_r($media_paths, true));
        }

        // Since this page is for students, we insert student_id and skip teacher_id
        $query = "INSERT INTO chat_message 
            (teacher_class_id, student_id, message_content,
             media_type_1, media_path_1,
             media_type_2, media_path_2,
             media_type_3, media_path_3)
            VALUES (
             '$get_id', '$user_id', '$content_escaped',
             " . ($media_types[0] ? "'{$media_types[0]}'" : "NULL") . ",
             " . ($media_paths[0] ? "'{$media_paths[0]}'" : "NULL") . ",
             " . ($media_types[1] ? "'{$media_types[1]}'" : "NULL") . ",
             " . ($media_paths[1] ? "'{$media_paths[1]}'" : "NULL") . ",
             " . ($media_types[2] ? "'{$media_types[2]}'" : "NULL") . ",
             " . ($media_paths[2] ? "'{$media_paths[2]}'" : "NULL") . "
             )";

        $result = mysqli_query($conn, $query);
        if (!$result) {
            $error = mysqli_error($conn);
            if (isset($_POST['ajax_request'])) {
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $error]);
        exit;
    } else {
                die("Database error: " . $error);
            }
        }
        
        // Check if this is an AJAX request
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
            exit;
        } else {
            header("Location: chatroom_student.php?id=$get_id");
            exit;
        }
    } else {
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'error', 'message' => 'Message content or media required.']);
            exit;
        } else {
            die("Message content or media required.");
        }
    }
}


// Fetch class and subject info for breadcrumb
$class_query = mysqli_query($conn, "
    SELECT class.class_name, subject.subject_code 
    FROM teacher_class
    LEFT JOIN class ON class.class_id = teacher_class.class_id
    LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
    WHERE teacher_class.teacher_class_id = '$get_id'
") or die(mysqli_error($conn));
$class_row = mysqli_fetch_assoc($class_query);

// Media display function
function displayMultipleMedia($message) {
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $message["media_type_$i"];
        $media_path = $message["media_path_$i"];
        if (!$media_type || !$media_path) continue;

        $media_path_esc = htmlspecialchars($media_path);

        echo '<div style="margin-top:10px; margin-bottom:10px;">';

        if ($media_type == 'image') {
            echo '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" title="Click to open in new tab">
                    <img src="' . $media_path_esc . '" style="width:100%; height:100%; object-fit: cover;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                  </div>';
        } elseif ($media_type == 'video') {
            echo '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" title="Click to open in new tab">
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
                echo '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
                    <div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" title="Click to open in new tab">
                        <iframe src="' . $media_path_esc . '" style="width:100%; height:100%; border: none;"></iframe>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                    </div>
                </a>';
        } else {
                echo '<a href="' . $media_path_esc . '" target="_blank" style="text-decoration: none; display: block;">
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
                echo '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'https://www.youtube.com/watch?v=' . htmlspecialchars($youtube_id) . '\', \'_blank\')" title="Click to open in new tab">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allowfullscreen style="border: none;"></iframe>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                      </div>';
    } else {
                echo '<div style="width:300px; height:169px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#adb5bd\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'" title="Click to open in new tab">
                        <div style="text-align: center;">
                            <i class="icon-link" style="font-size: 2em; color: #666; margin-bottom: 8px;"></i><br>
                            <span style="color: #666; font-size: 12px; word-break: break-all;">' . htmlspecialchars($media_path) . '</span>
                        </div>
                      </div>';
            }
        }

        echo '</div>';
    }
}
?>

<body>
<?php include('navbar_student.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <?php include('chatroom_link_student.php'); // Chatroom navigation ?>
        <div class="span9" id="content">
            <div class="row-fluid">
                <ul class="breadcrumb">
                    <li><a href="#"><?php echo htmlspecialchars($class_row['class_name']); ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><?php echo htmlspecialchars($class_row['subject_code']); ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><b>Chatroom</b></a></li>
                </ul>

                <!-- Chat Messages -->
                <div class="chatroom-container">
                    <div class="message-list" id="message-list">
                        <?php
                        // Fetch all messages for this chatroom
                        $messages_q = mysqli_query($conn, "SELECT * FROM chat_message WHERE teacher_class_id = '$get_id' ORDER BY message_date ASC") or die(mysqli_error($conn));

                        if (mysqli_num_rows($messages_q) == 0) {
                            echo "<p>No messages yet.</p>";
                        } else {
                            while ($message = mysqli_fetch_assoc($messages_q)) {
                                $message_id = $message['message_id'];
                                $sender_name = '';
                                $is_own_message = false;
                                if (isset($message['teacher_id']) && $message['teacher_id']) {
                                    $sender_name = getUserName($conn, null, $message['teacher_id']);
                                    $is_own_message = false;
                                } elseif (isset($message['student_id']) && $message['student_id']) {
                                    $sender_name = getUserName($conn, $message['student_id']);
                                    $is_own_message = ($message['student_id'] == $user_id);
                                } else {
                                    $sender_name = "Unknown";
                                    $is_own_message = false;
                                }
                                $message_date = date('d M Y, H:i', strtotime($message['message_date']));
                                ?>
                                                                <div class="dm-message-row <?php echo $is_own_message ? 'dm-own' : 'dm-other'; ?>" data-message-id="<?php echo $message_id; ?>">
                                    <?php if (!$is_own_message) { ?>
                                        <div class="dm-sender-name"><?php echo $sender_name; ?></div>
                                    <?php } ?>
                                    <div class="dm-bubble">
                                        <div class="dm-bubble-content">
                                            <div class="dm-message-text"><?php echo nl2br(htmlspecialchars($message['message_content'])); ?></div>
                                <?php displayMultipleMedia($message); ?>
                            </div>
                                        <div class="dm-meta-row">
                                            <span class="dm-date-time"><?php echo $message_date; ?></span>
                                            <?php if ($is_own_message): ?>
                                            <a href="chatroom_student.php?id=<?php echo $get_id; ?>&delete_message_id=<?php echo $message_id; ?>" 
                                                onclick="return confirm('Delete this message?');"
                                                class="dm-delete-btn" title="Delete message">
                                                <i class="icon-trash"></i>
                                            </a>
                                            <?php endif; ?>
                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <!-- Message Form -->
                    <div class="message-form-container">
                    <form id="message-form" class="message-form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="new_message" value="1">
                        <input type="hidden" name="ajax_request" value="1">
                            
                            <!-- Main Message Input -->
                            <div class="message-input-section">
                                <div class="input-group">
                                    <textarea name="message_content" rows="3" class="form-control message-textarea" 
                                              placeholder="Type your message here..." required></textarea>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary reset-btn" id="reset-form-btn">
                                            <i class="icon-clear"></i> Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary send-btn">
                                            <i class="icon-send"></i> Send
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Upload Section -->
                            <div class="media-upload-section" id="media-upload-section" style="display: none;">
                                <div class="media-tabs">
                                    <button type="button" class="tab-btn active" data-tab="files">
                                        <i class="icon-file"></i> Files
                                    </button>
                                    <button type="button" class="tab-btn" data-tab="links">
                                        <i class="icon-link"></i> Links
                                    </button>
                                </div>
                                
                                <!-- Files Tab -->
                                <div class="tab-content active" id="files-tab">
                                    <div class="file-upload-area">
                                        <div class="upload-grid">
                                            <div class="upload-item">
                                                <input type="file" name="message_media_1" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="message_media_1" class="file-input">
                                                <label for="message_media_1" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 1</span>
                                                </label>
                                                <div class="file-preview" id="preview-1"></div>
                                            </div>
                                            <div class="upload-item">
                                                <input type="file" name="message_media_2" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="message_media_2" class="file-input">
                                                <label for="message_media_2" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 2</span>
                                                </label>
                                                <div class="file-preview" id="preview-2"></div>
                                            </div>
                                            <div class="upload-item">
                                                <input type="file" name="message_media_3" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="message_media_3" class="file-input">
                                                <label for="message_media_3" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 3</span>
                                                </label>
                                                <div class="file-preview" id="preview-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Links Tab -->
                                <div class="tab-content" id="links-tab">
                                    <div class="link-input-area">
                                        <div class="link-input-group">
                                            <input type="url" name="message_link_1" class="form-control link-input" 
                                                   placeholder="Enter URL 1" id="message_link_1">
                                            <div class="link-preview" id="link-preview-1"></div>
                                        </div>
                                        <div class="link-input-group">
                                            <input type="url" name="message_link_2" class="form-control link-input" 
                                                   placeholder="Enter URL 2" id="message_link_2">
                                            <div class="link-preview" id="link-preview-2"></div>
                                        </div>
                                        <div class="link-input-group">
                                            <input type="url" name="message_link_3" class="form-control link-input" 
                                                   placeholder="Enter URL 3" id="message_link_3">
                                            <div class="link-preview" id="link-preview-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Controls -->
                            <div class="media-controls">
                                <button type="button" class="btn btn-outline-secondary media-toggle-btn" id="media-toggle">
                                    <i class="icon-paperclip"></i> Add Media
                                </button>
                                <div class="media-info" id="media-info"></div>
                        </div>
                    </form>
                </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); // Include footer ?>
<?php include('script.php'); // Include script ?>
<style>
/* Modern Chatroom Styles */
.chatroom-container {
    background: #f5f5f5;
    border-radius: 0;
    box-shadow: none;
    overflow: hidden;
    margin-bottom: 0;
    padding-bottom: 70px; /* for fixed input bar */
}

.message-list {
    max-height: 70vh;
    overflow-y: auto;
    padding: 16px 0 0 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.dm-message-row {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    margin-bottom: 2px;
    padding: 0 12px;
}
.dm-own {
    align-items: flex-end;
}

.dm-sender-name {
    font-size: 12px;
    color: #888;
    margin-bottom: 2px;
    margin-left: 8px;
}

.dm-bubble {
    position: relative;
    max-width: 80vw;
    padding: 0;
    border-radius: 22px;
    background: #f1f1f1;
    color: #222;
    padding: 10px 16px 6px 16px;
    font-size: 15px;
    word-break: break-word;
    display: flex;
    flex-direction: column;
    min-width: 40px;
    min-height: 32px;
    transition: background 0.2s;
}
.dm-own .dm-bubble {
    background: #3797f0;
    color: #fff;
    border-bottom-right-radius: 6px;
    border-bottom-left-radius: 22px;
    border-top-right-radius: 22px;
    border-top-left-radius: 22px;
}
.dm-other .dm-bubble {
    background: #fff;
    color: #222;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 22px;
    border-top-right-radius: 22px;
    border-top-left-radius: 22px;
}

.dm-bubble-content {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.dm-message-text {
    white-space: pre-line;
    font-size: 15px;
    line-height: 1.5;
}

.dm-meta-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 2px;
}
.dm-date-time {
    font-size: 11px;
    color: #aaa;
    margin-top: 2px;
}
.dm-delete-btn {
    display: none;
    color: #aaa;
    font-size: 14px;
    margin-left: 4px;
    transition: color 0.2s;
}
.dm-bubble:hover .dm-delete-btn {
    display: inline;
    color: #e74c3c;
}
.dm-delete-btn:hover {
    color: #c0392b;
}

/* Media inside bubble */
.dm-bubble img,
.dm-bubble video,
.dm-bubble iframe {
    max-width: 220px;
    max-height: 180px;
    border-radius: 14px;
    margin: 6px 0 2px 0;
    display: block;
}
.dm-bubble .icon-file,
.dm-bubble .icon-link {
    font-size: 1.2em;
    margin-right: 4px;
}

/* Message Form Container */
.message-form-container {
    background: #f5f5f5;
    border-top: 1px solid #e9ecef;
    padding: 15px;
}

.message-input-section {
    margin-bottom: 12px;
}

.input-group {
    display: flex;
    align-items: flex-end;
    gap: 8px;
}

.message-textarea {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 10px;
    font-size: 14px;
    resize: vertical;
    min-height: 50px;
    max-height: 100px;
    transition: all 0.2s ease;
    font-family: inherit;
}

.message-textarea:focus {
    border-color: #666;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    outline: none;
}

.send-btn {
    background: #666;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    color: white;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-size: 14px;
}

.send-btn:hover {
    background: #555;
}

.reset-btn {
    background: #6c757d;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    color: white;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-size: 14px;
    margin-right: 8px;
}

.reset-btn:hover {
    background: #5a6268;
}

/* Media Upload Section */
.media-upload-section {
    background: #f8f9fa;
    border-radius: 4px;
    padding: 12px;
    margin-bottom: 12px;
    border: 1px dashed #ccc;
    transition: all 0.2s ease;
}

.media-upload-section.active {
    border-color: #666;
    background: #f5f5f5;
}

.media-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
}

.tab-btn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 13px;
}

.tab-btn.active {
    background: #666;
    border-color: #666;
    color: white;
}

.tab-btn:hover {
    border-color: #666;
    color: #666;
}

.tab-btn.active:hover {
    color: white;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* File Upload Area */
.upload-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
}

.upload-item {
    position: relative;
}

.file-input {
    display: none;
}

.upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #fff;
    border: 1px dashed #ccc;
    border-radius: 4px;
    padding: 15px 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.upload-label:hover {
    border-color: #666;
    background: #f5f5f5;
}

.upload-label i {
    font-size: 1.5em;
    color: #666;
    margin-bottom: 6px;
}

.upload-label span {
    color: #666;
    font-weight: 500;
    font-size: 12px;
}

.file-preview {
    margin-top: 8px;
    padding: 8px;
    background: #fff;
    border-radius: 4px;
    border: 1px solid #ddd;
    display: none;
}

.file-preview.active {
    display: block;
}

.file-preview img {
    max-width: 100%;
    border-radius: 3px;
}

.file-preview .file-info {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px;
    background: #f8f9fa;
    border-radius: 3px;
    margin-top: 6px;
}

.file-preview .file-name {
    flex: 1;
    font-weight: 500;
    color: #333;
    font-size: 12px;
}

.file-preview .remove-file {
    background: #666;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 3px 6px;
    cursor: pointer;
    font-size: 11px;
}

/* Link Input Area */
.link-input-area {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.link-input-group {
    position: relative;
}

.link-input {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px 10px;
    font-size: 13px;
    transition: all 0.2s ease;
}

.link-input:focus {
    border-color: #666;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    outline: none;
}

.link-preview {
    margin-top: 8px;
    padding: 8px;
    background: #fff;
    border-radius: 4px;
    border: 1px solid #ddd;
    display: none;
}

.link-preview.active {
    display: block;
}

.link-preview .link-info {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px;
    background: #f8f9fa;
    border-radius: 3px;
}

.link-preview .link-url {
    flex: 1;
    color: #666;
    text-decoration: none;
    word-break: break-all;
    font-size: 12px;
}

.link-preview .remove-link {
    background: #666;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 3px 6px;
    cursor: pointer;
    font-size: 11px;
}

/* Media Controls */
.media-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.media-toggle-btn {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 13px;
}

.media-toggle-btn:hover {
    border-color: #666;
    color: #666;
}

.media-toggle-btn.active {
    background: #666;
    border-color: #666;
    color: white;
}

.media-info {
    flex: 1;
    font-size: 12px;
    color: #666;
}

/* Responsive Design */
@media (max-width: 768px) {
    .upload-grid {
        grid-template-columns: 1fr;
    }
    
    .input-group {
        flex-direction: column;
        align-items: stretch;
    }
    
    .send-btn {
        align-self: flex-end;
        width: auto;
    }
    
    .media-tabs {
        flex-direction: column;
    }
    
    .media-controls {
        flex-direction: column;
        align-items: stretch;
    }
}

@media (max-width: 600px) {
    .dm-bubble {
        max-width: 95vw;
        font-size: 14px;
    }
    .message-form-container {
        padding: 6px 2vw 6px 2vw;
    }
    .message-list {
        max-height: 60vh;
    }
}

/* Loading States */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Success/Error Messages */
.message-status {
    padding: 8px 12px;
    border-radius: 4px;
    margin: 8px 0;
    font-weight: 500;
    font-size: 13px;
}

.message-status.success {
    background: #f0f0f0;
    color: #333;
    border: 1px solid #ddd;
}

.message-status.error {
    background: #f0f0f0;
    color: #333;
    border: 1px solid #ddd;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Media toggle functionality
    const mediaToggle = document.getElementById('media-toggle');
    const mediaSection = document.getElementById('media-upload-section');
    
    if (mediaToggle && mediaSection) {
        mediaToggle.addEventListener('click', function() {
            mediaSection.style.display = mediaSection.style.display === 'none' ? 'block' : 'none';
            mediaToggle.classList.toggle('active');
            mediaSection.classList.toggle('active');
        });
    }

    // Tab functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and contents
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab + '-tab').classList.add('active');
        });
    });

    // File upload preview functionality
    const fileInputs = document.querySelectorAll('.file-input');
    
    fileInputs.forEach((input, index) => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-' + (index + 1));
            
            if (file) {
                const reader = new FileReader();
                const fileInfo = document.createElement('div');
                fileInfo.className = 'file-info';
                
                if (file.type.startsWith('image/')) {
                    reader.onload = function(e) {
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview">
                            <div class="file-info">
                                <span class="file-name">${file.name}</span>
                                <button type="button" class="remove-file" onclick="removeFile(${index + 1})">Remove</button>
                            </div>
                        `;
                        preview.classList.add('active');
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `
                        <div class="file-info">
                            <i class="icon-file"></i>
                            <span class="file-name">${file.name}</span>
                            <button type="button" class="remove-file" onclick="removeFile(${index + 1})">Remove</button>
                        </div>
                    `;
                    preview.classList.add('active');
                }
                
                updateMediaInfo();
            }
        });
    });

    // Link input preview functionality
    const linkInputs = document.querySelectorAll('.link-input');
    
    linkInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            const url = this.value.trim();
            const preview = document.getElementById('link-preview-' + (index + 1));
            
            if (url && isValidUrl(url)) {
                preview.innerHTML = `
                    <div class="link-info">
                        <i class="icon-link"></i>
                        <a href="${url}" class="link-url" target="_blank">${url}</a>
                        <button type="button" class="remove-link" onclick="removeLink(${index + 1})">Remove</button>
                    </div>
                `;
                preview.classList.add('active');
            } else {
                preview.classList.remove('active');
            }
            
            updateMediaInfo();
        });
    });

    // Form submission with enhanced UX
    const messageForm = document.getElementById('message-form');
    const sendBtn = document.querySelector('.send-btn');
    let isSubmitting = false; // Flag to prevent double submission
    
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Prevent double submission
            if (isSubmitting) {
                return false;
            }
            
            const formData = new FormData(this);
            const messageContent = formData.get('message_content').trim();
            
            // Check if there's content or media
            let hasContent = messageContent.length > 0;
            let hasMedia = false;
            
            for (let i = 1; i <= 3; i++) {
                if (formData.get('message_media_' + i) && formData.get('message_media_' + i).size > 0) {
                    hasMedia = true;
                    break;
                }
                if (formData.get('message_link_' + i) && formData.get('message_link_' + i).trim()) {
                    hasMedia = true;
                    break;
                }
            }
            
            if (!hasContent && !hasMedia) {
                // Silently return without showing error
                return false;
            }
            
            // Set submission flag
            isSubmitting = true;
            
            // Show loading state
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="icon-spinner icon-spin"></i> Sending...';
            messageForm.classList.add('loading');
            
            // Submit form
            fetch('chatroom_student.php?id=<?php echo $get_id; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status + ': ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (!data || typeof data !== 'object') {
                    throw new Error('Invalid response format from server');
                }
                
                if (data.status === 'success') {
                    console.log('Message sent successfully, clearing form...');
                    showMessage('Message sent successfully!', 'success');
                    
                    // Completely reset the form immediately
                    resetFormCompletely();
                    
                    // Scroll to bottom of message list to show new message
                    const messageList = document.getElementById('message-list');
                    if (messageList) {
                        messageList.scrollTop = messageList.scrollHeight;
                    }
                } else {
                    // Silently handle error without showing user prompt
                    console.error('Server error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Silently handle error without showing user prompt
            })
            .finally(() => {
                // Reset loading state and submission flag
                isSubmitting = false;
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="icon-send"></i> Send';
                messageForm.classList.remove('loading');
            });
        });
    }

    // Helper functions
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function updateMediaInfo() {
        const mediaInfo = document.getElementById('media-info');
        let fileCount = 0;
        let linkCount = 0;
        
        // Count files
        for (let i = 1; i <= 3; i++) {
            const input = document.getElementById('message_media_' + i);
            if (input && input.files && input.files[0]) {
                fileCount++;
            }
        }
        
        // Count links
        for (let i = 1; i <= 3; i++) {
            const input = document.getElementById('message_link_' + i);
            if (input && input.value.trim()) {
                linkCount++;
            }
        }
        
        let info = '';
        if (fileCount > 0) {
            info += `${fileCount} file(s) selected`;
        }
        if (linkCount > 0) {
            if (info) info += ', ';
            info += `${linkCount} link(s) added`;
        }
        
        mediaInfo.textContent = info;
    }

    function clearAllPreviews() {
        // Clear file previews
        for (let i = 1; i <= 3; i++) {
            const preview = document.getElementById('preview-' + i);
            if (preview) {
                preview.classList.remove('active');
                preview.innerHTML = '';
            }
        }
        
        // Clear link previews
        for (let i = 1; i <= 3; i++) {
            const preview = document.getElementById('link-preview-' + i);
            if (preview) {
                preview.classList.remove('active');
                preview.innerHTML = '';
            }
        }
    }

    function showMessage(message, type) {
        const statusDiv = document.createElement('div');
        statusDiv.className = `message-status ${type}`;
        statusDiv.textContent = message;
        
        const container = document.querySelector('.message-form-container');
        container.insertBefore(statusDiv, container.firstChild);
        
        setTimeout(() => {
            statusDiv.remove();
        }, 5000);
    }

    // Comprehensive form reset function
    function resetFormCompletely() {
        console.log('Resetting form completely...');
        
        // Clear the message textarea
        const textarea = messageForm.querySelector('textarea[name="message_content"]');
        if (textarea) {
            textarea.value = '';
            textarea.style.height = 'auto'; // Reset height if it was resized
            console.log('Textarea cleared');
        } else {
            console.log('Textarea not found');
        }
        
        // Clear all file inputs
        for (let i = 1; i <= 3; i++) {
            const fileInput = document.getElementById('message_media_' + i);
            if (fileInput) {
                fileInput.value = '';
            }
        }
        
        // Clear all link inputs
        for (let i = 1; i <= 3; i++) {
            const linkInput = document.getElementById('message_link_' + i);
            if (linkInput) {
                linkInput.value = '';
            }
        }
        
        // Clear all previews
        clearAllPreviews();
        
        // Update media info display
        updateMediaInfo();
        
        // Hide media section if it's open
        const mediaSection = document.getElementById('media-upload-section');
        const mediaToggle = document.getElementById('media-toggle');
        if (mediaSection && mediaToggle) {
            mediaSection.style.display = 'none';
            mediaToggle.classList.remove('active');
            mediaSection.classList.remove('active');
        }
        
        // Reset tab to files tab
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabBtns.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Activate files tab
        const filesTabBtn = document.querySelector('[data-tab="files"]');
        const filesTabContent = document.getElementById('files-tab');
        if (filesTabBtn && filesTabContent) {
            filesTabBtn.classList.add('active');
            filesTabContent.classList.add('active');
        }
        
        // Focus back to textarea for immediate typing
        if (textarea) {
            textarea.focus();
        }
        
        // Reset any form validation states
        messageForm.classList.remove('was-validated');
        
        // Clear any error messages
        const errorMessages = document.querySelectorAll('.message-status.error');
        errorMessages.forEach(msg => msg.remove());
    }

    // Reset button functionality
    const resetBtn = document.getElementById('reset-form-btn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to reset the form? This will clear all content and media.')) {
                resetFormCompletely();
            }
        });
    }

    // Enter key to send message
    const messageTextarea = document.querySelector('textarea[name="message_content"]');
    if (messageTextarea) {
        messageTextarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const form = document.getElementById('message-form');
                if (form && !isSubmitting) {
                    form.dispatchEvent(new Event('submit'));
                }
            }
        });
    }

    // Auto-refresh functionality
    const messageList = document.getElementById('message-list');
    let lastMessageId = 0;

    // Find the last message id on the page
    const existingMessages = messageList.querySelectorAll('.dm-message-row');
    if (existingMessages.length > 0) {
        const lastMessage = existingMessages[existingMessages.length - 1];
        const messageIdAttr = lastMessage.getAttribute('data-message-id');
        if (messageIdAttr) {
            lastMessageId = parseInt(messageIdAttr);
        }
    }

    // Function to append a new message to the list
    function appendMessage(message) {
        const isOwnMessage = message.student_id == <?php echo $user_id; ?>;
        const rowClass = isOwnMessage ? 'dm-message-row dm-own' : 'dm-message-row dm-other';
        let senderName = '';
        if (!isOwnMessage) senderName = `<div class=\"dm-sender-name\">${DOMPurify.sanitize(message.sender_name)}</div>`;
        const dateTime = `<span class=\"dm-date-time\">${message.message_date_formatted}</span>`;
        let deleteBtn = '';
        if (isOwnMessage) {
            deleteBtn = `<a href=\"chatroom_student.php?id=<?php echo $get_id; ?>&delete_message_id=${message.message_id}\" onclick=\"return confirm('Delete this message?');\" class=\"dm-delete-btn\" title=\"Delete message\"><i class=\"icon-trash\"></i></a>`;
        }
        
        const messageHtml = `<div class=\"${rowClass}\" data-message-id=\"${message.message_id}\">` +
                senderName +
                `<div class=\"dm-bubble\">` +
                    `<div class=\"dm-bubble-content\">` +
                        `<div class=\"dm-message-text\">${DOMPurify.sanitize(message.message_content)}</div>` +
                        message.media_html +
                    `</div>` +
                    `<div class=\"dm-meta-row\">` +
                        dateTime + deleteBtn +
                    `</div>` +
                `</div>` +
            `</div>`;
        
        messageList.insertAdjacentHTML('beforeend', messageHtml);
        messageList.scrollTop = messageList.scrollHeight;
    }

    // Function to fetch new messages
    function fetchMessages() {
        fetch(`get_messages_student.php?id=<?php echo $get_id; ?>&last_message_id=${lastMessageId}`)
            .then(response => response.json())
            .then(messages => {
                if (messages && messages.length > 0) {
                    messages.forEach(message => {
                        const existingMessage = messageList.querySelector(`[data-message-id="${message.message_id}"]`);
                        if (!existingMessage) {
                            appendMessage(message);
                            lastMessageId = Math.max(lastMessageId, parseInt(message.message_id));
                        }
                    });
                }
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // Periodically fetch new messages every 3 seconds
    setInterval(fetchMessages, 3000);

    // Initial scroll to bottom
    messageList.scrollTop = messageList.scrollHeight;

    // Global functions for remove buttons
    window.removeFile = function(index) {
        const input = document.getElementById('message_media_' + index);
        const preview = document.getElementById('preview-' + index);
        
        if (input) input.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
        }
        
        updateMediaInfo();
    };

    window.removeLink = function(index) {
        const input = document.getElementById('message_link_' + index);
        const preview = document.getElementById('link-preview-' + index);
        
        if (input) input.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
            }
        
        updateMediaInfo();
    };
});
</script>
</body>
</html>