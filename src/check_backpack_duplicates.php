<?php
include('admin/dbcon.php');
include('session.php');

// Set content type to JSON
header('Content-Type: application/json');

if (isset($_POST['file_ids']) && is_array($_POST['file_ids'])) {
    $file_ids = $_POST['file_ids'];
    $teacher_id = $session_id;
    
    // Get file names from the files table
    $file_ids_str = implode(',', array_map('intval', $file_ids));
    $query = mysqli_query($conn, "SELECT file_id, fname FROM files WHERE file_id IN ($file_ids_str)") or die(mysqli_error());
    
    $file_names = array();
    while ($row = mysqli_fetch_array($query)) {
        $file_names[$row['file_id']] = $row['fname'];
    }
    
    // Check which files already exist in teacher_backpack
    $duplicates = array();
    foreach ($file_ids as $file_id) {
        if (isset($file_names[$file_id])) {
            $fname = $file_names[$file_id];
            $check_query = mysqli_query($conn, "SELECT COUNT(*) as count FROM teacher_backpack WHERE teacher_id = '$teacher_id' AND fname = '$fname'") or die(mysqli_error());
            $result = mysqli_fetch_array($check_query);
            
            if ($result['count'] > 0) {
                $duplicates[] = $fname;
            }
        }
    }
    
    // Return JSON response
    echo json_encode(array(
        'duplicates' => $duplicates,
        'total_duplicates' => count($duplicates)
    ));
} else {
    echo json_encode(array(
        'error' => 'No file IDs provided'
    ));
}
?> 