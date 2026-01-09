<?php
include('header.php');
include('session.php'); // assumes $conn is set here

// Pagination setup
$posts_per_page = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $posts_per_page;

function getPosterName($post) {
    if (!empty($post['teacher_id'])) {
        return htmlspecialchars($post['teacher_firstname'] . ' ' . $post['teacher_lastname'] . ' (Teacher)');
    } elseif (!empty($post['student_id'])) {
        return htmlspecialchars($post['student_firstname'] . ' ' . $post['student_lastname'] . ' (Student)');
    } else {
        return "Unknown";
    }
}

function getReplyPosterName($reply) {
    if (!empty($reply['teacher_id'])) {
        return htmlspecialchars($reply['teacher_firstname'] . ' ' . $reply['teacher_lastname'] . ' (Teacher)');
    } elseif (!empty($reply['student_id'])) {
        return htmlspecialchars($reply['student_firstname'] . ' ' . $reply['student_lastname'] . ' (Student)');
    } else {
        return "Unknown";
    }
}

// Display media files (images, videos, docs, links) for post or reply
function displayMultipleMedia($post_or_reply) {
    for ($i = 1; $i <= 3; $i++) {
        $media_type = $post_or_reply["media_type_$i"] ?? null;
        $media_path = $post_or_reply["media_path_$i"] ?? null;
        if (!$media_type || !$media_path) continue;

        $media_path_esc = htmlspecialchars($media_path);

        echo '<div style="margin-top:10px; margin-bottom:10px;">';

        // Base URL relative to your web root (adjust if needed)
        $base_url = '../';  // <-- adjust this based on your setup, usually relative path from web root
        
        if ($media_type == 'image') {
            echo '<img src="' . htmlspecialchars($base_url . $media_path) . '" style="max-width:300px; max-height:300px;">';
        } elseif ($media_type == 'video') {
            echo '<video controls style="max-width:300px; max-height:300px;">
                    <source src="' . htmlspecialchars($base_url . $media_path) . '" type="video/mp4">
                Your browser does not support the video tag.
                </video>';
        } elseif ($media_type == 'document') {
            $file_name = basename($media_path);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($file_ext === 'pdf') {
                echo '<iframe src="' . htmlspecialchars($base_url . $media_path) . '" style="width:100%; max-width:600px; height:400px;" frameborder="0"></iframe>';
            } else {
                echo '<p><a href="' . htmlspecialchars($base_url . $media_path) . '" target="_blank" download>' . htmlspecialchars($file_name) . '</a> (Preview not available, please download to view)</p>';
            }
        } elseif ($media_type == 'link') {
            // Embed YouTube if applicable
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media_path, $match)) {
                $youtube_id = $match[1];
                echo '<iframe width="300" height="169" src="https://www.youtube.com/embed/' . htmlspecialchars($youtube_id) . '" frameborder="0" allowfullscreen></iframe>';
            } else {
                echo '<p><a href="' . $media_path_esc . '" target="_blank">' . $media_path_esc . '</a></p>';
            }
        }

        echo '</div>';
    }
}

// Display text content and attached media together
function displayFullContentWithMedia($post_or_reply, $content_field = 'post_content') {
    echo '<div style="white-space: pre-wrap; margin-bottom: 10px;">';
    echo htmlspecialchars($post_or_reply[$content_field] ?? '');
    echo '</div>';

    displayMultipleMedia($post_or_reply);
}

// Get total posts count for pagination
$total_posts_result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM discussion_post");
$total_posts_row = mysqli_fetch_assoc($total_posts_result);
$total_posts = intval($total_posts_row['total']);
$total_pages = ceil($total_posts / $posts_per_page);
?>

<body>
<?php include('navbar.php'); ?>

<div class="container-fluid">
    <div class="row-fluid">
        <?php include('discussion_sidebar.php'); ?>

        <div class="span9" id="content">
            <div class="row-fluid">
                <!-- block -->
                <div id="block_bg" class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">Discussion Posts Management</div>
                    </div>
                    <div class="block-content collapse in">
                        <div class="span12">

                            <?php 
                            // Fetch paginated posts with joins
                            $query = mysqli_query($conn, "
                                SELECT 
                                    dp.discussion_post_id, dp.post_content, dp.post_date, 
                                    dp.teacher_id, dp.student_id,
                                    tc.teacher_class_id, 
                                    c.class_name, 
                                    s.subject_code,
                                    t.firstname AS teacher_firstname, t.lastname AS teacher_lastname,
                                    st.firstname AS student_firstname, st.lastname AS student_lastname,
                                    dp.media_type_1, dp.media_path_1,
                                    dp.media_type_2, dp.media_path_2,
                                    dp.media_type_3, dp.media_path_3
                                FROM discussion_post dp
                                LEFT JOIN teacher_class tc ON dp.teacher_class_id = tc.teacher_class_id
                                LEFT JOIN class c ON tc.class_id = c.class_id
                                LEFT JOIN subject s ON tc.subject_id = s.subject_id
                                LEFT JOIN teacher t ON dp.teacher_id = t.teacher_id
                                LEFT JOIN student st ON dp.student_id = st.student_id
                                ORDER BY dp.post_date DESC
                                LIMIT $posts_per_page OFFSET $offset
                            ") or die(mysqli_error($conn));

                            if (mysqli_num_rows($query) == 0) {
                                echo "<p>No discussion posts found.</p>";
                            } else {
                                while($post = mysqli_fetch_assoc($query)) { 
                            ?>
                                <div style="border:1px solid #ccc; padding:15px; margin-bottom:20px;">
                                    
                                    <strong></strong> <?php echo getPosterName($post); ?><br>
                                    <?php displayFullContentWithMedia($post, 'post_content'); ?>

                                    <strong>Date </strong> <?php echo date('d M Y, H:i', strtotime($post['post_date'])); ?><br>
                                    <strong>Class </strong> <?php echo htmlspecialchars($post['class_name']); ?><br>
                                    <strong>Subject </strong> <?php echo htmlspecialchars($post['subject_code']); ?><br>

                                    <!-- Replies -->
                                    <div style="margin-top:15px; padding-left:20px; border-left: 3px solid #888;">
                                        <strong>Replies:</strong><br>

                                        <?php
                                        $post_id = $post['discussion_post_id'];
                                        $replies_query = mysqli_query($conn, "
                                            SELECT 
                                                dr.discussion_reply_id, dr.reply_content, dr.reply_date,
                                                dr.teacher_id, dr.student_id,
                                                t.firstname AS teacher_firstname, t.lastname AS teacher_lastname,
                                                st.firstname AS student_firstname, st.lastname AS student_lastname,
                                                dr.media_type_1, dr.media_path_1,
                                                dr.media_type_2, dr.media_path_2,
                                                dr.media_type_3, dr.media_path_3
                                            FROM discussion_reply dr
                                            LEFT JOIN teacher t ON dr.teacher_id = t.teacher_id
                                            LEFT JOIN student st ON dr.student_id = st.student_id
                                            WHERE dr.discussion_post_id = '$post_id'
                                            ORDER BY dr.reply_date ASC
                                        ") or die(mysqli_error($conn));

                                        if(mysqli_num_rows($replies_query) > 0) {
                                            while($reply = mysqli_fetch_assoc($replies_query)) {
                                                echo '<div style="margin-bottom:10px; padding:10px; background:#f9f9f9; white-space: pre-wrap;">';
                                                echo '<strong>' . getReplyPosterName($reply) . '</strong> <em>(' . date('d M Y, H:i', strtotime($reply['reply_date'])) . ')</em><br>';
                                                displayFullContentWithMedia($reply, 'reply_content');
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<em>No replies yet.</em>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php 
                                } // end while
                            } // end else
                            ?>

                            <!-- Pagination Controls -->
                            <nav aria-label="Page navigation" style="text-align:center;">
                                <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li><a href="?page=1">&laquo; First</a></li>
                                        <li><a href="?page=<?php echo $page - 1; ?>">&lt; Prev</a></li>
                                    <?php else: ?>
                                        <li class="disabled"><span>&laquo; First</span></li>
                                        <li class="disabled"><span>&lt; Prev</span></li>
                                    <?php endif; ?>

                                    <?php
                                    // Show page links with some limits around current page
                                    $start_page = max(1, $page - 3);
                                    $end_page = min($total_pages, $page + 3);
                                    for ($p = $start_page; $p <= $end_page; $p++):
                                    ?>
                                        <?php if ($p == $page): ?>
                                            <li class="active"><span><?php echo $p; ?></span></li>
                                        <?php else: ?>
                                            <li><a href="?page=<?php echo $p; ?>"><?php echo $p; ?></a></li>
                                        <?php endif; ?>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <li><a href="?page=<?php echo $page + 1; ?>">Next &gt;</a></li>
                                        <li><a href="?page=<?php echo $total_pages; ?>">Last &raquo;</a></li>
                                    <?php else: ?>
                                        <li class="disabled"><span>Next &gt;</span></li>
                                        <li class="disabled"><span>Last &raquo;</span></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
                <!-- /block -->
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<?php include('script.php'); ?>
</body>
</html>
