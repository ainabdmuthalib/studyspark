<?php
include('session.php');
include('dbcon.php');

$teacher_class_id = $_GET['id'];
$last_post_id = isset($_GET['last_post_id']) ? (int)$_GET['last_post_id'] : 0;
$last_reply_id = isset($_GET['last_reply_id']) ? (int)$_GET['last_reply_id'] : 0;
$user_id = $_SESSION['id'];

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

// Function to generate media HTML
function generateMediaHtml($post_or_reply) {
    $mediaHtml = '';
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $post_or_reply["media_type_$i"];
        $media_path = $post_or_reply["media_path_$i"];
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

// Helper to get reactions for a post or reply
function getReactions($conn, $type, $item_id, $user_id) {
    $counts = [];
    $user_reacted = [];
    $res = $conn->query("SELECT emoji, COUNT(*) as cnt FROM discussion_reaction WHERE type='$type' AND item_id='$item_id' GROUP BY emoji");
    while ($row = $res->fetch_assoc()) {
        $counts[$row['emoji']] = (int)$row['cnt'];
    }
    $res2 = $conn->query("SELECT emoji FROM discussion_reaction WHERE type='$type' AND item_id='$item_id' AND user_id='$user_id'");
    while ($row = $res2->fetch_assoc()) {
        $user_reacted[] = $row['emoji'];
    }
    $reactions = [];
    foreach ($counts as $emj => $cnt) {
        $reactions[$emj] = [
            'count' => $cnt,
            'reacted' => in_array($emj, $user_reacted)
        ];
    }
    return $reactions;
}

// Get new posts
$posts_query = "SELECT * FROM discussion_post WHERE teacher_class_id = '$teacher_class_id' AND discussion_post_id > '$last_post_id' ORDER BY post_date DESC";
$posts_result = mysqli_query($conn, $posts_query) or die(mysqli_error($conn));

$new_posts = [];
while ($post = mysqli_fetch_assoc($posts_result)) {
    $poster_name = getUserName($conn, $post['student_id'], $post['teacher_id']);
    $post['poster_name'] = $poster_name;
    $post['post_date_formatted'] = date('d M Y, H:i', strtotime($post['post_date']));
    $post['media_html'] = generateMediaHtml($post);
    $post['last_edited'] = $post['last_edited'] ?? null;
    $post['edited'] = ($post['last_edited'] && $post['last_edited'] != $post['post_date']);
    $post['reactions'] = getReactions($conn, 'post', $post['discussion_post_id'], $user_id);
    $new_posts[] = $post;
}

// Get new replies
$replies_query = "SELECT * FROM discussion_reply WHERE discussion_reply_id > '$last_reply_id' ORDER BY reply_date ASC";
$replies_result = mysqli_query($conn, $replies_query) or die(mysqli_error($conn));

$new_replies = [];
while ($reply = mysqli_fetch_assoc($replies_result)) {
    // Check if this reply belongs to a post in the current class
    $post_check = mysqli_query($conn, "SELECT teacher_class_id FROM discussion_post WHERE discussion_post_id = '{$reply['discussion_post_id']}' AND teacher_class_id = '$teacher_class_id'");
    if (mysqli_num_rows($post_check) > 0) {
        $replier_name = getUserName($conn, $reply['student_id'], $reply['teacher_id']);
        $reply['replier_name'] = $replier_name;
        $reply['reply_date_formatted'] = date('d M Y, H:i', strtotime($reply['reply_date']));
        $reply['media_html'] = generateMediaHtml($reply);
        $reply['last_edited'] = $reply['last_edited'] ?? null;
        $reply['edited'] = ($reply['last_edited'] && $reply['last_edited'] != $reply['reply_date']);
        $reply['reactions'] = getReactions($conn, 'reply', $reply['discussion_reply_id'], $user_id);
        $new_replies[] = $reply;
    }
}

$response = [
    'new_posts' => $new_posts,
    'new_replies' => $new_replies
];

header('Content-Type: application/json');
echo json_encode($response);
?> 