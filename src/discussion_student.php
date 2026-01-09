<?php 
include('session.php');  // Make sure this sets $conn and $session_id properly
include('header_dashboard.php'); 

$get_id = $_GET['id'];
$user_id = $session_id; // from session.php

// Handle deletion requests before any output
if (isset($_GET['delete_post'])) {
    $delete_post_id = intval($_GET['delete_post']);
    // Verify ownership: user must own the post (student_id = $user_id)
    $check = mysqli_query($conn, "SELECT student_id FROM discussion_post WHERE discussion_post_id = $delete_post_id");
    if ($check && mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        if ($row['student_id'] == $user_id) {
            // Delete replies related to the post first (optional if no ON DELETE CASCADE)
            mysqli_query($conn, "DELETE FROM discussion_reply WHERE discussion_post_id = $delete_post_id");
            // Delete the post
            mysqli_query($conn, "DELETE FROM discussion_post WHERE discussion_post_id = $delete_post_id");
            header("Location: discussion_student.php?id=$get_id");
            exit;
        } else {
            die("Unauthorized to delete this post.");
        }
    } else {
        die("Post not found.");
    }
}

if (isset($_GET['delete_reply'])) {
    $delete_reply_id = intval($_GET['delete_reply']);
    // Verify ownership: user must own the reply (student_id = $user_id)
    $check = mysqli_query($conn, "SELECT student_id FROM discussion_reply WHERE discussion_reply_id = $delete_reply_id");
    if ($check && mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        if ($row['student_id'] == $user_id) {
            mysqli_query($conn, "DELETE FROM discussion_reply WHERE discussion_reply_id = $delete_reply_id");
            header("Location: discussion_student.php?id=$get_id");
            exit;
        } else {
            die("Unauthorized to delete this reply.");
        }
    } else {
        die("Reply not found.");
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

// Allowed extensions and size limits
$allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
$allowed_video = ['mp4'];
$allowed_docs = ['pdf', 'docx', 'pptx'];

$max_size_image = 200 * 1024 * 1024;  // 200MB
$max_size_video = 200 * 1024 * 1024;  // 200MB
$max_size_docs  = 200 * 1024 * 1024;  // 200MB

// Helper function to validate and upload file, returns array(media_type, media_path) or error string
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

// Process up to 3 media uploads or links for posts/replies
function processMultipleMedia($prefix, $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs) {
    $media_types = [];
    $media_paths = [];

    // First, collect all files (in order)
    for ($i = 1; $i <= 3; $i++) {
        $fileKey = $prefix . '_media_' . $i;
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = handle_upload($_FILES[$fileKey], $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);
            if (is_array($upload_result)) {
                list($media_type, $media_path) = $upload_result;
                if ($media_type && $media_path) {
                    $media_types[] = $media_type;
                    $media_paths[] = $media_path;
                }
            } elseif (is_string($upload_result) && !empty($upload_result)) {
                die(ucfirst($prefix) . " file upload error for file $i: " . htmlspecialchars($upload_result));
            }
        }
    }
    
    // Then, collect all links (in order)
    for ($i = 1; $i <= 3; $i++) {
        $linkKey = $prefix . '_link_' . $i;
        if (!empty($_POST[$linkKey])) {
            $link = trim($_POST[$linkKey]);
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                if (count($media_types) < 3) {
                    $media_types[] = 'link';
                    $media_paths[] = $link;
                }
            } elseif ($link !== '') {
                die("Invalid URL provided in $prefix link $i.");
            }
        }
    }
    
    // Pad to 3 slots with nulls if needed
    while (count($media_types) < 3) {
        $media_types[] = null;
        $media_paths[] = null;
    }
    
    return [$media_types, $media_paths];
}

// Handle new post submission (before any output)
if (isset($_POST['new_post'])) {
    $content = trim($_POST['post_content']);
    list($media_types, $media_paths) = processMultipleMedia('post', $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);

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

        $query = "INSERT INTO discussion_post 
            (teacher_class_id, student_id, post_content,
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

        mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        // Check if this is an AJAX request
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'success', 'message' => 'Post created successfully']);
            exit;
        } else {
            header("Location: discussion_student.php?id=$get_id");
            exit;
        }
    } else {
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'error', 'message' => 'Post content or media required.']);
            exit;
        } else {
            die("Post content or media required.");
        }
    }
}

// Handle new reply submission (before any output)
if (isset($_POST['new_reply'])) {
    $post_id = intval($_POST['post_id']);
    $content = trim($_POST['reply_content']);
    list($media_types, $media_paths) = processMultipleMedia('reply', $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);

    $hasContentOrMedia = !empty($content);
    foreach ($media_types as $mt) {
        if ($mt !== null) $hasContentOrMedia = true;
    }

    if ($post_id > 0 && $hasContentOrMedia) {
        $content_escaped = mysqli_real_escape_string($conn, $content);
        for ($i = 0; $i < 3; $i++) {
            $media_types[$i] = $media_types[$i] ? mysqli_real_escape_string($conn, $media_types[$i]) : null;
            $media_paths[$i] = $media_paths[$i] ? mysqli_real_escape_string($conn, $media_paths[$i]) : null;
        }

        $query = "INSERT INTO discussion_reply 
            (discussion_post_id, student_id, reply_content,
             media_type_1, media_path_1,
             media_type_2, media_path_2,
             media_type_3, media_path_3)
            VALUES (
             '$post_id', '$user_id', '$content_escaped',
             " . ($media_types[0] ? "'{$media_types[0]}'" : "NULL") . ",
             " . ($media_paths[0] ? "'{$media_paths[0]}'" : "NULL") . ",
             " . ($media_types[1] ? "'{$media_types[1]}'" : "NULL") . ",
             " . ($media_paths[1] ? "'{$media_paths[1]}'" : "NULL") . ",
             " . ($media_types[2] ? "'{$media_types[2]}'" : "NULL") . ",
             " . ($media_paths[2] ? "'{$media_paths[2]}'" : "NULL") . "
             )";

        mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        // Check if this is an AJAX request
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'success', 'message' => 'Reply posted successfully']);
            exit;
        } else {
            header("Location: discussion_student.php?id=$get_id#post$post_id");
            exit;
        }
    } else {
        if (isset($_POST['ajax_request'])) {
            echo json_encode(['status' => 'error', 'message' => 'Reply content or media required.']);
            exit;
        } else {
            die("Reply content or media required.");
        }
    }
}

// Helper function to get full name by student_id or teacher_id
function getUserName($conn, $student_id = null, $teacher_id = null) {
    if ($student_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname, location FROM student WHERE student_id = '$student_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return [
                'name' => htmlspecialchars($row['firstname'] . ' ' . $row['lastname']),
                'avatar' => $row['location'] ? 'admin/' . $row['location'] : 'admin/images/default-avatar.png'
            ];
        }
    } elseif ($teacher_id !== null) {
        $res = mysqli_query($conn, "SELECT firstname, lastname, location FROM teacher WHERE teacher_id = '$teacher_id'");
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            return [
                'name' => htmlspecialchars($row['firstname'] . ' ' . $row['lastname']),
                'avatar' => $row['location'] ? 'admin/' . $row['location'] : 'admin/images/default-avatar.png'
            ];
        }
    }
    return [
        'name' => "Unknown",
        'avatar' => 'admin/images/default-avatar.png'
    ];
}

// Function to display media attachments (images, video, docs, links)
function displayMultipleMedia($post_or_reply) {
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $post_or_reply["media_type_$i"];
        $media_path = $post_or_reply["media_path_$i"];
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
                echo '<div style="width:300px; height:169px; position: relative; cursor: pointer; border-radius: 4px; overflow: hidden;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" title="Click to open in new tab">
                        <iframe src="' . $media_path_esc . '" style="width:100%; height:100%; border: none;"></iframe>
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.1); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0"></div>
                    </div>';
            } else {
                echo '<div style="width:300px; height:169px; background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 4px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;" onclick="window.open(\'' . $media_path_esc . '\', \'_blank\')" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#adb5bd\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'" title="Click to open in new tab">
                        <div style="text-align: center;">
                            <i class="icon-file" style="font-size: 2em; color: #666; margin-bottom: 8px;"></i><br>
                            <span style="color: #666; font-size: 12px;">' . htmlspecialchars($file_name) . '</span>
                        </div>
                    </div>';
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

// Display Delete button only if user owns the post/reply
function displayDeleteButton($type, $id) {
    global $user_id, $conn;

    if ($type === 'post') {
        $check = mysqli_query($conn, "SELECT student_id FROM discussion_post WHERE discussion_post_id = $id");
        if ($check && mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            if ($row['student_id'] == $user_id) {
                echo ' <a href="?id=' . htmlspecialchars($_GET['id']) . '&delete_post=' . $id . '" onclick="return showDeleteConfirmation(\'post\', ' . $id . ');" class="twitter-delete-btn">Delete</a>';
            }
        }
    } elseif ($type === 'reply') {
        $check = mysqli_query($conn, "SELECT student_id FROM discussion_reply WHERE discussion_reply_id = $id");
        if ($check && mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            if ($row['student_id'] == $user_id) {
                echo ' <a href="?id=' . htmlspecialchars($_GET['id']) . '&delete_reply=' . $id . '" onclick="return showDeleteConfirmation(\'reply\', ' . $id . ');" class="twitter-delete-btn">Delete</a>';
            }
        }
    }
}

?>

<body>
<?php include('navbar_student.php'); ?>

<div class="container-fluid">
    <div class="row-fluid">
        <?php include('discussion_link_student.php'); ?>
        <div class="span9" id="content">
            <div class="row-fluid">

                <ul class="breadcrumb">
                    <li><a href="#"><?php echo htmlspecialchars($class_row['class_name']); ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><?php echo htmlspecialchars($class_row['subject_code']); ?></a> <span class="divider">/</span></li>
                    <li><a href="#"><b>Discussion</b></a></li>
                </ul>

                <!-- New Post Form -->
                <div class="message-form-container">
                    <form id="new-post-form" class="message-form" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="new_post" value="1">
                            <input type="hidden" name="ajax_request" value="1">
                            
                            <!-- Main Message Input -->
                            <div class="message-input-section">
                                <div class="input-group">
                                    <textarea name="post_content" rows="3" class="form-control message-textarea" 
                                              placeholder="What's happening?" required></textarea>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary reset-btn" id="reset-form-btn">
                                            <i class="icon-clear"></i> Clear
                                        </button>
                                        <button type="submit" class="btn btn-primary send-btn">
                                            <i class="icon-send"></i> Post
                                        </button>
                            </div>
                    </div>
                            </div>

                            <!-- Media Upload Section -->
                            <div class="media-upload-section" id="media-upload-section" style="display: none;">
                                <!-- Files Section -->
                                <div class="media-section">
                                    <h6 class="section-title">
                                        <i class="icon-file"></i> Files
                                    </h6>
                                    <div class="file-upload-area">
                                        <div class="upload-grid">
                                            <div class="upload-item">
                                                <input type="file" name="post_media_1" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="post_media_1" class="file-input">
                                                <label for="post_media_1" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 1</span>
                                                </label>
                                                <div class="file-preview" id="preview-1"></div>
                                            </div>
                                            <div class="upload-item">
                                                <input type="file" name="post_media_2" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="post_media_2" class="file-input">
                                                <label for="post_media_2" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 2</span>
                                                </label>
                                                <div class="file-preview" id="preview-2"></div>
                                            </div>
                                            <div class="upload-item">
                                                <input type="file" name="post_media_3" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                       id="post_media_3" class="file-input">
                                                <label for="post_media_3" class="upload-label">
                                                    <i class="icon-upload"></i>
                                                    <span>Add File 3</span>
                                                </label>
                                                <div class="file-preview" id="preview-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Links Section -->
                                <div class="media-section">
                                    <h6 class="section-title">
                                        <i class="icon-link"></i> Links
                                    </h6>
                                    <div class="link-input-area">
                                        <div class="link-input-group">
                                            <input type="url" name="post_link_1" class="form-control link-input" 
                                                   placeholder="Enter URL 1" id="post_link_1">
                                            <div class="link-preview" id="link-preview-1"></div>
                                        </div>
                                        <div class="link-input-group">
                                            <input type="url" name="post_link_2" class="form-control link-input" 
                                                   placeholder="Enter URL 2" id="post_link_2">
                                            <div class="link-preview" id="link-preview-2"></div>
                                        </div>
                                        <div class="link-input-group">
                                            <input type="url" name="post_link_3" class="form-control link-input" 
                                                   placeholder="Enter URL 3" id="post_link_3">
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

                <!-- Discussion Posts -->
                <div id="discussion-posts">
                <?php
                $posts_q = mysqli_query($conn, "SELECT * FROM discussion_post WHERE teacher_class_id = '$get_id' ORDER BY post_date DESC") or die(mysqli_error($conn));

                if (mysqli_num_rows($posts_q) == 0) {
                    echo "<p>No discussion posts yet.</p>";
                } else {
                    while ($post = mysqli_fetch_assoc($posts_q)) {
                        $post_id = $post['discussion_post_id'];
                        $poster_name = getUserName($conn, $post['student_id'], $post['teacher_id']);
                        $post_date = date('d M Y, H:i', strtotime($post['post_date']));
                        ?>
                        <div class="twitter-post" id="post<?php echo $post_id; ?>" data-post-id="<?php echo $post_id; ?>">
                            <div class="post-avatar">
                                <img src="<?php echo $poster_name['avatar']; ?>" alt="User" class="avatar-img">
                            </div>
                            <div class="post-content">
                                <div class="post-header">
                                    <span class="post-author"><?php echo $poster_name['name']; ?></span>
                                    <span class="post-date"><?php echo $post_date; ?></span>
                                    <?php displayDeleteButton('post', $post_id); ?>
                                </div>
                                <div class="post-text">
                                    <?php echo nl2br(htmlspecialchars($post['post_content'])); ?>
                            </div>

                                <?php displayMultipleMedia($post); ?>

                                <!-- Replies Separator -->
                                <div class="replies-separator">
                                    <span class="replies-label">Replies</span>
                                </div>

                                <!-- Replies -->
                                <div class="replies-container" id="replies-<?php echo $post_id; ?>">
                                    <?php
                                    $replies_q = mysqli_query($conn, "SELECT * FROM discussion_reply WHERE discussion_post_id = '$post_id' ORDER BY reply_date ASC") or die(mysqli_error($conn));
                                    if (mysqli_num_rows($replies_q) > 0) {
                                        while ($reply = mysqli_fetch_assoc($replies_q)) {
                                            $replier_name = getUserName($conn, $reply['student_id'], $reply['teacher_id']);
                                            $reply_date = date('d M Y, H:i', strtotime($reply['reply_date']));
                                            $reply_id = $reply['discussion_reply_id'];
                                            ?>
                                            <div class="twitter-reply" data-reply-id="<?php echo $reply_id; ?>">
                                                <div class="reply-avatar">
                                                    <img src="<?php echo $replier_name['avatar']; ?>" alt="User" class="avatar-img">
                                                </div>
                                                <div class="reply-content">
                                                    <div class="reply-header">
                                                        <span class="reply-author"><?php echo $replier_name['name']; ?></span>
                                                        <span class="reply-date"><?php echo $reply_date; ?></span>
                                                <?php displayDeleteButton('reply', $reply_id); ?>
                                                    </div>
                                                    <div class="reply-text">
                                                        <?php echo nl2br(htmlspecialchars($reply['reply_content'])); ?>
                                                    </div>
                                                <?php displayMultipleMedia($reply); ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<em>No replies yet.</em>";
                                    }
                                    ?>
                                </div>

                                <!-- Reply Form -->
                                <div class="message-form-container reply-form-container">
                                    <form class="reply-form message-form" method="post" action="" enctype="multipart/form-data" data-post-id="<?php echo $post_id; ?>">
                                    <input type="hidden" name="new_reply" value="1">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                    <input type="hidden" name="ajax_request" value="1">
                                        
                                        <!-- Main Message Input -->
                                        <div class="message-input-section">
                                            <div class="input-group">
                                                <textarea name="reply_content" rows="2" class="form-control message-textarea" 
                                                          placeholder="Post your reply..." required></textarea>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-secondary reset-reply-btn" data-post-id="<?php echo $post_id; ?>">
                                                        <i class="icon-clear"></i> Clear
                                                    </button>
                                                    <button type="submit" class="btn btn-primary send-btn">
                                                        <i class="icon-send"></i> Reply
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Media Upload Section -->
                                        <div class="media-upload-section" id="media-upload-section-<?php echo $post_id; ?>" style="display: none;">
                                            <!-- Files Section -->
                                            <div class="media-section">
                                                <h6 class="section-title">
                                                    <i class="icon-file"></i> Files
                                                </h6>
                                                <div class="file-upload-area">
                                                    <div class="upload-grid">
                                                        <div class="upload-item">
                                                            <input type="file" name="reply_media_1" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                                   id="reply_media_1_<?php echo $post_id; ?>" class="file-input">
                                                            <label for="reply_media_1_<?php echo $post_id; ?>" class="upload-label">
                                                                <i class="icon-upload"></i>
                                                                <span>Add File 1</span>
                                                            </label>
                                                            <div class="file-preview" id="preview-1-<?php echo $post_id; ?>"></div>
                                                        </div>
                                                        <div class="upload-item">
                                                            <input type="file" name="reply_media_2" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                                   id="reply_media_2_<?php echo $post_id; ?>" class="file-input">
                                                            <label for="reply_media_2_<?php echo $post_id; ?>" class="upload-label">
                                                                <i class="icon-upload"></i>
                                                                <span>Add File 2</span>
                                                            </label>
                                                            <div class="file-preview" id="preview-2-<?php echo $post_id; ?>"></div>
                                                        </div>
                                                        <div class="upload-item">
                                                            <input type="file" name="reply_media_3" accept=".jpg,.jpeg,.png,.gif,.mp4,.pdf,.docx,.pptx" 
                                                                   id="reply_media_3_<?php echo $post_id; ?>" class="file-input">
                                                            <label for="reply_media_3_<?php echo $post_id; ?>" class="upload-label">
                                                                <i class="icon-upload"></i>
                                                                <span>Add File 3</span>
                                                            </label>
                                                            <div class="file-preview" id="preview-3-<?php echo $post_id; ?>"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Links Section -->
                                            <div class="media-section">
                                                <h6 class="section-title">
                                                    <i class="icon-link"></i> Links
                                                </h6>
                                                <div class="link-input-area">
                                                    <div class="link-input-group">
                                                        <input type="url" name="reply_link_1" class="form-control link-input" 
                                                               placeholder="Enter URL 1" id="reply_link_1_<?php echo $post_id; ?>">
                                                        <div class="link-preview" id="link-preview-1-<?php echo $post_id; ?>"></div>
                                                    </div>
                                                    <div class="link-input-group">
                                                        <input type="url" name="reply_link_2" class="form-control link-input" 
                                                               placeholder="Enter URL 2" id="reply_link_2_<?php echo $post_id; ?>">
                                                        <div class="link-preview" id="link-preview-2-<?php echo $post_id; ?>"></div>
                                                    </div>
                                                    <div class="link-input-group">
                                                        <input type="url" name="reply_link_3" class="form-control link-input" 
                                                               placeholder="Enter URL 3" id="reply_link_3_<?php echo $post_id; ?>">
                                                        <div class="link-preview" id="link-preview-3-<?php echo $post_id; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="media-controls">
                                            <button type="button" class="btn btn-outline-secondary media-toggle-btn" data-post-id="<?php echo $post_id; ?>">
                                                <i class="icon-paperclip"></i> Add Media
                                            </button>
                                            <div class="media-info" id="media-info-<?php echo $post_id; ?>"></div>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <h4>Confirm Deletion</h4>
        </div>
        <div class="delete-modal-body">
            <p id="deleteMessage">Are you sure you want to delete this item?</p>
            <p class="delete-warning">This action cannot be undone.</p>
        </div>
        <div class="delete-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hideDeleteModal()">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<?php include('script.php'); ?>
<script src="js/discussion.js"></script>
<style>
/* Modern Message Form Styles */
.message-form-container {
    background: #f5f5f5;
    border-top: 1px solid #e9ecef;
    padding: 15px;
    margin-bottom: 20px;
}

.reply-form-container {
    background: #f7f9fa;
    border: 1px solid #e1e8ed;
    border-radius: 12px;
    padding: 12px;
    margin: 12px 0;
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
    background: #1da1f2;
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
    background: #1a91da;
}

.send-btn:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.reset-btn, .reset-reply-btn {
    background: #6c757d;
    border: none;
    border-radius: 4px;
    padding: 8px 16px;
    color: white;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-size: 14px;
}

.reset-btn:hover, .reset-reply-btn:hover {
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

.media-section {
    margin-bottom: 20px;
    padding: 15px;
    background: #fff;
    border-radius: 6px;
    border: 1px solid #e1e8ed;
}

.media-section:last-child {
    margin-bottom: 0;
}

.section-title {
    margin: 0 0 12px 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 6px;
}

.section-title i {
    color: #666;
    font-size: 16px;
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

/* File/Link Info */
.file-info, .link-info {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 0;
}

.file-info i, .link-info i {
    color: #666;
}

.file-name, .link-url {
    flex: 1;
    word-break: break-all;
    color: #333;
    text-decoration: none;
}

.file-name:hover, .link-url:hover {
    text-decoration: underline;
}

.remove-file, .remove-link {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 3px;
    padding: 2px 6px;
    font-size: 11px;
    cursor: pointer;
    transition: background 0.2s;
}

.remove-file:hover, .remove-link:hover {
    background: #c82333;
}

/* Twitter Post Styles */
.twitter-post {
    display: flex;
    gap: 12px;
    padding: 20px;
    border-bottom: 2px solid #e1e8ed;
    transition: background-color 0.2s;
    position: relative;
    background-color: #ffffff;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 8px;
    border-radius: 8px;
}

.twitter-post:hover {
    background-color: #f8f9fa;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.twitter-post::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 60px; /* Align with the start of post content (avatar width + gap) */
    right: 0;
    height: 1px;
    background-color: #e1e8ed;
}

.post-avatar {
    flex-shrink: 0;
}

.avatar-img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}

.post-content {
    flex: 1;
}

.post-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.post-author {
    font-weight: 700;
    color: #14171a;
    font-size: 16px;
}

.post-author::after {
    color: #1da1f2;
    font-weight: 500;
    font-size: 13px;
    margin-left: 8px;
}

.post-date {
    color: #657786;
    font-size: 14px;
}

.post-text {
    font-size: 16px;
    line-height: 22px;
    color: #14171a;
    margin-bottom: 12px;
    font-weight: 400;
}

/* Replies Separator */
.replies-separator {
    display: flex;
    align-items: center;
    margin: 20px 0 15px 0;
    position: relative;
}

.replies-separator::before {
    content: '';
    flex: 1;
    height: 1px;
    background-color: #e1e8ed;
    margin-right: 15px;
}

.replies-separator::after {
    content: '';
    flex: 1;
    height: 1px;
    background-color: #e1e8ed;
    margin-left: 15px;
}

.replies-label {
    background-color: #f8f9fa;
    color: #657786;
    font-size: 13px;
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 12px;
    border: 1px solid #e1e8ed;
    white-space: nowrap;
}

/* Twitter Reply Styles */
.twitter-reply {
    display: flex;
    gap: 12px;
    padding: 12px 16px;
    border-bottom: 1px solid #e1e8ed;
    transition: background-color 0.2s;
}

.twitter-reply:hover {
    background-color: #f7f9fa;
}

.reply-avatar {
    flex-shrink: 0;
}

.reply-content {
    flex: 1;
}

.reply-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.reply-author {
    font-weight: 700;
    color: #14171a;
    font-size: 14px;
}

.reply-date {
    color: #657786;
    font-size: 13px;
}

.reply-text {
    font-size: 14px;
    line-height: 18px;
    color: #14171a;
    margin-bottom: 8px;
}

/* Delete Button Styles */
.twitter-delete-btn {
    color: #e0245e;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: color 0.2s;
}

.twitter-delete-btn:hover {
    color: #c01e4e;
    text-decoration: underline;
}

/* Media Display Styles */
.media-addon-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin: 10px 0 10px 0;
    padding: 8px 0 4px 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    background: #f9f9fb;
}
.media-addon-item {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    padding: 6px 12px;
    min-width: 120px;
    max-width: 220px;
    overflow: hidden;
    font-size: 0.97em;
}
.media-addon-thumb {
    max-width: 90px;
    max-height: 90px;
    border-radius: 6px;
    margin-right: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}
.media-addon-icon {
    font-size: 1.3em;
    margin-right: 6px;
    vertical-align: middle;
}
.media-addon-item a {
    color: #00796b;
    text-decoration: none;
    word-break: break-all;
}
.media-addon-item a:hover {
    text-decoration: underline;
}
.media-link-item {
    background: #fff;
    border: none;
    color: #1565c0;
    font-weight: 500;
    padding: 6px 14px;
    min-width: 120px;
    max-width: 260px;
    overflow: hidden;
    text-overflow: ellipsis;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.media-link-label {
    font-size: 1.05em;
    font-weight: 600;
    color: #1565c0;
    word-break: break-all;
}
.media-link-item a {
    color: #1565c0;
    text-decoration: none;
}
.media-link-item a:hover {
    text-decoration: underline;
}

/* Delete Confirmation Modal */
.delete-modal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-modal-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 90%;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.delete-modal-header {
    padding: 20px 20px 0 20px;
    border-bottom: 1px solid #e1e8ed;
}

.delete-modal-header h4 {
    margin: 0;
    color: #14171a;
    font-size: 18px;
    font-weight: 700;
}

.delete-modal-body {
    padding: 20px;
}

.delete-modal-body p {
    margin: 0 0 10px 0;
    color: #14171a;
    font-size: 14px;
    line-height: 1.4;
}

.delete-warning {
    color: #e0245e !important;
    font-weight: 500;
    font-size: 13px !important;
}

.delete-modal-footer {
    padding: 0 20px 20px 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.delete-modal-footer .btn {
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.delete-modal-footer .btn-secondary {
    background-color: #6c757d;
    color: white;
}

.delete-modal-footer .btn-secondary:hover {
    background-color: #5a6268;
}

.delete-modal-footer .btn-danger {
    background-color: #dc3545;
    color: white;
}

.delete-modal-footer .btn-danger:hover {
    background-color: #c82333;
}

/* Prevent form from disappearing when clicking links */
.link-url {
    pointer-events: auto;
}

.link-url:hover {
    text-decoration: underline;
}

/* Ensure form container stays visible */
.message-form-container {
    position: relative;
    z-index: 10;
}

.reply-form-container {
    position: relative;
    z-index: 10;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all forms
    initializeForm('new-post-form');
    
    // Initialize reply forms
    const replyForms = document.querySelectorAll('.reply-form');
    console.log('Found', replyForms.length, 'reply forms');
    replyForms.forEach(function(form) {
        const postId = form.getAttribute('data-post-id');
        console.log('Processing reply form with postId:', postId);
        // Generate a unique ID for the form if it doesn't have one
        if (!form.id) {
            form.id = `reply-form-${postId}`;
        }
        initializeForm(form.id, postId);
    });

    function initializeForm(formId, postId = '') {
        console.log('Initializing form:', formId, 'with postId:', postId);
        const form = document.getElementById(formId);
        if (!form) {
            console.log('Form not found:', formId);
            return;
        }

        const prefix = postId ? 'reply' : 'post';
        const mediaSection = document.getElementById(postId ? `media-upload-section-${postId}` : 'media-upload-section');
        const mediaToggle = document.querySelector(postId ? `.media-toggle-btn[data-post-id="${postId}"]` : '#media-toggle');
        const mediaInfo = document.getElementById(postId ? `media-info-${postId}` : 'media-info');
        const resetBtn = document.querySelector(postId ? `.reset-reply-btn[data-post-id="${postId}"]` : '#reset-form-btn');
        
        console.log('Elements found for postId:', postId);
        console.log('  mediaSection:', mediaSection);
        console.log('  mediaToggle:', mediaToggle);
        console.log('  mediaInfo:', mediaInfo);
        console.log('  resetBtn:', resetBtn);

        // Media toggle functionality
        if (mediaToggle && mediaSection) {
            console.log('Setting up media toggle for postId:', postId, 'mediaToggle:', mediaToggle, 'mediaSection:', mediaSection);
            mediaToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Media toggle clicked for postId:', postId);
                const currentDisplay = mediaSection.style.display;
                const newDisplay = currentDisplay === 'none' ? 'block' : 'none';
                console.log('Changing display from', currentDisplay, 'to', newDisplay);
                mediaSection.style.display = newDisplay;
                mediaToggle.classList.toggle('active');
                mediaSection.classList.toggle('active');
            });
        } else {
            console.log('Media toggle setup failed for postId:', postId, 'mediaToggle:', mediaToggle, 'mediaSection:', mediaSection);
            // Fallback: try to find the media toggle within the form
            const fallbackToggle = form.querySelector('.media-toggle-btn');
            const fallbackSection = form.querySelector('.media-upload-section');
            if (fallbackToggle && fallbackSection) {
                console.log('Using fallback media toggle for postId:', postId);
                fallbackToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Fallback media toggle clicked for postId:', postId);
                    const currentDisplay = fallbackSection.style.display;
                    const newDisplay = currentDisplay === 'none' ? 'block' : 'none';
                    fallbackSection.style.display = newDisplay;
                    fallbackToggle.classList.toggle('active');
                    fallbackSection.classList.toggle('active');
                });
            }
        }

        // File input handling
        for (let i = 1; i <= 3; i++) {
            const fileInput = document.getElementById(`${prefix}_media_${i}${postId ? '_' + postId : ''}`);
            const preview = document.getElementById(`preview-${i}${postId ? '-' + postId : ''}`);
            
            if (fileInput && preview) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        
                        if (file.type.startsWith('image/')) {
                            reader.onload = function(e) {
                                preview.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview">
                                    <div class="file-info">
                                        <span class="file-name">${file.name}</span>
                                        <button type="button" class="remove-file" onclick="removeFile(${i}${postId ? ', \'' + postId + '\'' : ''})">Remove</button>
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
                                    <button type="button" class="remove-file" onclick="removeFile(${i}${postId ? ', \'' + postId + '\'' : ''})">Remove</button>
                                </div>
                            `;
                            preview.classList.add('active');
                        }
                        
                        updateMediaInfo(postId);
                    } else {
                        preview.classList.remove('active');
                        preview.innerHTML = '';
            }
        });
    }
        }

        // Link input handling
        for (let i = 1; i <= 3; i++) {
            const linkInput = document.getElementById(`${prefix}_link_${i}${postId ? '_' + postId : ''}`);
            const preview = document.getElementById(`link-preview-${i}${postId ? '-' + postId : ''}`);
            
            if (linkInput && preview) {
                linkInput.addEventListener('input', function() {
                    const url = this.value.trim();
                    if (url && isValidUrl(url)) {
                        preview.innerHTML = `
                            <div class="link-info">
                                <i class="icon-link"></i>
                                <a href="${url}" class="link-url" target="_blank" onclick="event.stopPropagation();">${url}</a>
                                <button type="button" class="remove-link" onclick="removeLink(${i}${postId ? ', \'${postId}\'' : ''})">Remove</button>
                            </div>
                        `;
                        preview.classList.add('active');
                    } else {
                        preview.classList.remove('active');
                        preview.innerHTML = '';
                    }
                    updateMediaInfo(postId);
                });
            }
        }

        // Reset button functionality
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                resetFormCompletely(formId, postId);
            });
        }

        // Enter key handling
        const textarea = form.querySelector('textarea');
        if (textarea) {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (!isSubmitting) {
                        form.dispatchEvent(new Event('submit'));
                    }
                }
            });
        }
    }

    // Global variables
    let isSubmitting = false;

    // Helper functions
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    function updateMediaInfo(postId = '') {
        const mediaInfo = document.getElementById(postId ? `media-info-${postId}` : 'media-info');
        if (mediaInfo) {
            let fileCount = 0;
            let linkCount = 0;
            const prefix = postId ? 'reply' : 'post';
            
            // Count files
            for (let i = 1; i <= 3; i++) {
                const input = document.getElementById(`${prefix}_media_${i}${postId ? '_' + postId : ''}`);
                if (input && input.files && input.files[0]) {
                    fileCount++;
                }
            }
            
            // Count links
            for (let i = 1; i <= 3; i++) {
                const input = document.getElementById(`${prefix}_link_${i}${postId ? '_' + postId : ''}`);
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
    }

    function removeFile(index, postId = '') {
        const prefix = postId ? 'reply' : 'post';
        const fileInput = document.getElementById(`${prefix}_media_${index}${postId ? '_' + postId : ''}`);
        const preview = document.getElementById(`preview-${index}${postId ? '-' + postId : ''}`);
        
        if (fileInput) fileInput.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
        }
        updateMediaInfo(postId);
    }

    function removeLink(index, postId = '') {
        const prefix = postId ? 'reply' : 'post';
        const linkInput = document.getElementById(`${prefix}_link_${index}${postId ? '_' + postId : ''}`);
        const preview = document.getElementById(`link-preview-${index}${postId ? '-' + postId : ''}`);
        
        if (linkInput) linkInput.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
        }
        
        updateMediaInfo(postId);
    }

    function resetFormCompletely(formId, postId = '') {
        const form = document.getElementById(formId);
        if (!form) return;

        const prefix = postId ? 'reply' : 'post';
        
        // Clear textarea
        const textarea = form.querySelector('textarea');
        if (textarea) {
            textarea.value = '';
            textarea.style.height = 'auto';
        }
        
        // Clear file inputs
        for (let i = 1; i <= 3; i++) {
            removeFile(i, postId);
        }
        
        // Clear link inputs
        for (let i = 1; i <= 3; i++) {
            removeLink(i, postId);
        }
        
        // Hide media section
        const mediaSection = document.getElementById(postId ? `media-upload-section-${postId}` : 'media-upload-section');
        const mediaToggle = document.querySelector(postId ? `.media-toggle-btn[data-post-id="${postId}"]` : '#media-toggle');
        
        if (mediaSection) mediaSection.style.display = 'none';
        if (mediaToggle) {
            mediaToggle.classList.remove('active');
            mediaSection.classList.remove('active');
        }
        
        // Focus back to textarea for immediate typing
        if (textarea) {
            textarea.focus();
        }
        
        updateMediaInfo(postId);
    }

    // Form submission handling
    document.querySelectorAll('.message-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (isSubmitting) return false;
            
            const formData = new FormData(this);
            const content = formData.get('post_content') || formData.get('reply_content');
            
            // Check if there's content or media
            let hasContent = content && content.trim().length > 0;
            let hasMedia = false;
            
            for (let i = 1; i <= 3; i++) {
                if (formData.get(`${prefix}_media_${i}`) && formData.get(`${prefix}_media_${i}`).size > 0) {
                    hasMedia = true;
                    break;
                }
                if (formData.get(`${prefix}_link_${i}`) && formData.get(`${prefix}_link_${i}`).trim()) {
                    hasMedia = true;
                    break;
                }
            }
            
            if (!hasContent && !hasMedia) {
                return false;
            }
            
            isSubmitting = true;
            const submitBtn = form.querySelector('.send-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="icon-spinner icon-spin"></i> Sending...';
            }
            
            // Submit form
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset form
                    const formId = form.id;
                    const postId = form.getAttribute('data-post-id');
                    resetFormCompletely(formId, postId);
                    
                    // Reload page to show new content
                    window.location.reload();
                } else {
                    console.error('Server error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = form.classList.contains('reply-form') ? 
                        '<i class="icon-send"></i> Reply' : 
                        '<i class="icon-send"></i> Post';
                }
            });
        });
    });

    // Global functions for remove buttons
    window.removeFile = function(index, postId = '') {
        const prefix = postId ? 'reply' : 'post';
        const fileInput = document.getElementById(`${prefix}_media_${index}${postId ? '_' + postId : ''}`);
        const preview = document.getElementById(`preview-${index}${postId ? '-' + postId : ''}`);
        
        if (fileInput) fileInput.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
        }
        
        updateMediaInfo(postId);
    };

    window.removeLink = function(index, postId = '') {
        const prefix = postId ? 'reply' : 'post';
        const linkInput = document.getElementById(`${prefix}_link_${index}${postId ? '_' + postId : ''}`);
        const preview = document.getElementById(`link-preview-${index}${postId ? '-' + postId : ''}`);
        
        if (linkInput) linkInput.value = '';
        if (preview) {
            preview.classList.remove('active');
            preview.innerHTML = '';
        }
        
        updateMediaInfo(postId);
    };

    // Prevent form from disappearing when clicking links
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('link-url')) {
            e.stopPropagation();
        }
    });

    // Ensure forms stay visible
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.message-form-container, .reply-form-container');
        forms.forEach(form => {
            form.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });

    // Delete confirmation functions
    window.showDeleteConfirmation = function(type, id) {
        const modal = document.getElementById('deleteModal');
        const message = document.getElementById('deleteMessage');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        
        if (type === 'post') {
            message.textContent = 'Are you sure you want to delete this post? This will also delete all replies.';
            confirmBtn.onclick = function() {
                window.location.href = `?id=${encodeURIComponent(window.location.search.match(/id=(\d+)/)[1])}&delete_post=${id}`;
            };
        } else if (type === 'reply') {
            message.textContent = 'Are you sure you want to delete this reply?';
            confirmBtn.onclick = function() {
                window.location.href = `?id=${encodeURIComponent(window.location.search.match(/id=(\d+)/)[1])}&delete_reply=${id}`;
            };
        }
        
        modal.style.display = 'flex';
        return false;
    };

    window.hideDeleteModal = function() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
    };

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideDeleteModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideDeleteModal();
        }
    });
});
</script>
</body>
</html>
