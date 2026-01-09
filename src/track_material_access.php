<?php
include('session.php');
include('dbcon.php');

// Accept file_id and class_id from POST or GET
$file_id = isset($_POST['file_id']) ? intval($_POST['file_id']) : (isset($_GET['file_id']) ? intval($_GET['file_id']) : 0);
$class_id = isset($_POST['class_id']) ? intval($_POST['class_id']) : (isset($_GET['class_id']) ? intval($_GET['class_id']) : 0);
$scroll_view = (isset($_POST['scroll_view']) && $_POST['scroll_view'] == '1') || (isset($_GET['scroll_view']) && $_GET['scroll_view'] == '1');
// Always use the current logged-in user from session for student_id
$student_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

if ($file_id && $class_id && $student_id) {
    // Log access (ignore duplicate) if table exists
    if ($conn->query("SHOW TABLES LIKE 'student_material_access'")->num_rows) {
        $access_type = $scroll_view ? 'view' : 'download';
        $stmt = $conn->prepare("INSERT IGNORE INTO student_material_access (student_id, class_id, file_id, access_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $student_id, $class_id, $file_id, $access_type);
        $stmt->execute();
    }
    if ($scroll_view) {
        // For scroll-based view, just return 204 No Content (no redirect)
        http_response_code(204);
        exit;
    }
    // Get file location
    $stmt = $conn->prepare("SELECT floc FROM files WHERE file_id = ?");
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $file_url = $row['floc'];
        if (file_exists($file_url)) {
            $filename = basename($file_url);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_url));
            readfile($file_url);
            exit;
        } else {
            // File not found, redirect back
            header("Location: downloadable_student.php?id=$class_id");
            exit;
        }
    }
}
// If something went wrong, redirect back
header("Location: downloadable_student.php?id=$class_id");
exit; 