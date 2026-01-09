<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('session.php');
include('dbcon.php');
header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$content = trim($_POST['content'] ?? '');
$user_id = $_SESSION['id'];

$allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
$allowed_video = ['mp4'];
$allowed_docs = ['pdf', 'docx', 'pptx'];
$max_size_image = 200 * 1024 * 1024;
$max_size_video = 200 * 1024 * 1024;
$max_size_docs  = 200 * 1024 * 1024;

function handle_upload($file, $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return [null, null];
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

function generateMediaHtml($media_types, $media_paths) {
    $mediaHtml = '';
    for ($i = 0; $i < 3; $i++) {
        $media_type = $media_types[$i];
        $media_path = $media_paths[$i];
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
                $mediaHtml .= '<iframe src="' . $media_path_esc . '" style="width:100%; max-width:600px; height:400px;" frameborder="0"></iframe>';
            } else {
                $mediaHtml .= '<p><a href="' . $media_path_esc . '" target="_blank" download>' . htmlspecialchars($file_name) . '</a> (Preview not available, please download to view)</p>';
            }
        } elseif ($media_type == 'link') {
            if (preg_match('%(?:youtube(?:-nocookie)?\\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\\.be/)([^"&?/ ]{11})%i', $media_path, $match)) {
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

if (!$type || !$id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

if ($type === 'post') {
    $q = mysqli_query($conn, "SELECT student_id, teacher_id FROM discussion_post WHERE discussion_post_id = '$id'");
    if (!$q || mysqli_num_rows($q) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Post not found.']);
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    if ($row['student_id'] != $user_id && $row['teacher_id'] != $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }
    $content_escaped = mysqli_real_escape_string($conn, $content);
    $media_types = [];
    $media_paths = [];
    for ($i = 1; $i <= 3; $i++) {
        $fileKey = 'media_' . $i;
        $linkKey = 'link_' . $i;
        $media_type = null;
        $media_path = null;
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = handle_upload($_FILES[$fileKey], $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);
            if (is_array($upload_result)) {
                list($media_type, $media_path) = $upload_result;
            } elseif (is_string($upload_result) && !empty($upload_result)) {
                echo json_encode(['status' => 'error', 'message' => $upload_result]);
                exit;
            }
        } elseif (!empty($_POST[$linkKey])) {
            $link = trim($_POST[$linkKey]);
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                $media_type = 'link';
                $media_path = $link;
            } elseif ($link !== '') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid URL in link ' . $i]);
                exit;
            }
        }
        $media_types[] = $media_type;
        $media_paths[] = $media_path;
    }
    $set_media = '';
    for ($i = 0; $i < 3; $i++) {
        $idx = $i + 1;
        $set_media .= ", media_type_$idx = " . ($media_types[$i] ? "'" . mysqli_real_escape_string($conn, $media_types[$i]) . "'" : "NULL");
        $set_media .= ", media_path_$idx = " . ($media_paths[$i] ? "'" . mysqli_real_escape_string($conn, $media_paths[$i]) . "'" : "NULL");
    }
    $query = "UPDATE discussion_post SET post_content = '$content_escaped' $set_media, last_edited = NOW() WHERE discussion_post_id = '$id'";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
    $last_edited = date('Y-m-d H:i:s');
    $updated_text = $content;
    $updated_item = [
        'type' => 'post',
        'id' => $id,
        'content' => $updated_text,
        'media_types' => $media_types,
        'media_paths' => $media_paths,
        'last_edited' => $last_edited
    ];
    $is_edit_successful = true;
} elseif ($type === 'reply') {
    $q = mysqli_query($conn, "SELECT student_id, teacher_id FROM discussion_reply WHERE discussion_reply_id = '$id'");
    if (!$q || mysqli_num_rows($q) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Reply not found.']);
        exit;
    }
    $row = mysqli_fetch_assoc($q);
    if ($row['student_id'] != $user_id && $row['teacher_id'] != $user_id) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }
    $content_escaped = mysqli_real_escape_string($conn, $content);
    $media_types = [];
    $media_paths = [];
    for ($i = 1; $i <= 3; $i++) {
        $fileKey = 'media_' . $i;
        $linkKey = 'link_' . $i;
        $media_type = null;
        $media_path = null;
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload_result = handle_upload($_FILES[$fileKey], $allowed_image, $allowed_video, $allowed_docs, $max_size_image, $max_size_video, $max_size_docs);
            if (is_array($upload_result)) {
                list($media_type, $media_path) = $upload_result;
            } elseif (is_string($upload_result) && !empty($upload_result)) {
                echo json_encode(['status' => 'error', 'message' => $upload_result]);
                exit;
            }
        } elseif (!empty($_POST[$linkKey])) {
            $link = trim($_POST[$linkKey]);
            if (filter_var($link, FILTER_VALIDATE_URL)) {
                $media_type = 'link';
                $media_path = $link;
            } elseif ($link !== '') {
                echo json_encode(['status' => 'error', 'message' => 'Invalid URL in link ' . $i]);
                exit;
            }
        }
        $media_types[] = $media_type;
        $media_paths[] = $media_path;
    }
    $set_media = '';
    for ($i = 0; $i < 3; $i++) {
        $idx = $i + 1;
        $set_media .= ", media_type_$idx = " . ($media_types[$i] ? "'" . mysqli_real_escape_string($conn, $media_types[$i]) . "'" : "NULL");
        $set_media .= ", media_path_$idx = " . ($media_paths[$i] ? "'" . mysqli_real_escape_string($conn, $media_paths[$i]) . "'" : "NULL");
    }
    $query = "UPDATE discussion_reply SET reply_content = '$content_escaped' $set_media, last_edited = NOW() WHERE discussion_reply_id = '$id'";
    if (!mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        exit;
    }
    $last_edited = date('Y-m-d H:i:s');
    $updated_text = $content;
    $updated_item = [
        'type' => 'reply',
        'id' => $id,
        'content' => $updated_text,
        'media_types' => $media_types,
        'media_paths' => $media_paths,
        'last_edited' => $last_edited
    ];
    $is_edit_successful = true;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid type.']);
    exit;
}

if ($is_edit_successful) {
    $updated_content = nl2br(htmlspecialchars($updated_text));
    $updated_media = generateMediaHtml($media_types, $media_paths);
    echo json_encode([
        'status' => 'success',
        'message' => 'Item updated successfully',
        'updated_content' => $updated_content,
        'updated_media' => $updated_media,
        'edited' => true,
        'last_edited' => $last_edited
    ]);
    exit;
} 