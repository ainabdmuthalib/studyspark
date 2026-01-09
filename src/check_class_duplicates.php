<?php
include('admin/dbcon.php');
include('session.php');

header('Content-Type: application/json');

if (!isset($_POST['file_ids']) || !isset($_POST['target_class_id'])) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$file_ids = $_POST['file_ids'];
$target_class_id = $_POST['target_class_id'];

// Get filenames of selected files
$selected_files = [];
foreach ($file_ids as $file_id) {
    $query = mysqli_query($conn, "SELECT fname FROM files WHERE file_id = '$file_id'") or die(mysqli_error());
    if ($row = mysqli_fetch_array($query)) {
        $selected_files[] = $row['fname'];
    }
}

// Check which files already exist in target class
$duplicates = [];
foreach ($selected_files as $filename) {
    $query = mysqli_query($conn, "SELECT fname FROM files WHERE class_id = '$target_class_id' AND fname = '$filename'") or die(mysqli_error());
    if (mysqli_num_rows($query) > 0) {
        $duplicates[] = $filename;
    }
}

echo json_encode([
    'duplicates' => $duplicates,
    'has_duplicates' => count($duplicates) > 0
]);
?> 