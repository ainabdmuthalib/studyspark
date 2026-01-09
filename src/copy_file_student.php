<?php
include('admin/dbcon.php');
include('session.php');

// Debug: Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	error_log("POST data received: " . print_r($_POST, true));
}

if (isset($_POST['selector']) && is_array($_POST['selector'])){
	$id = $_POST['selector'];
	$success_count = 0;
	$error_count = 0;

	$N = count($id);
	for($i=0; $i < $N; $i++)
	{
		// Sanitize the input
		$file_id = mysqli_real_escape_string($conn, $id[$i]);
		
		$result = mysqli_query($conn,"select * from files where file_id = '$file_id'") or die(mysqli_error($conn));
		
		if($result && mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_array($result)){
				$fname = mysqli_real_escape_string($conn, $row['fname']);
				$floc = mysqli_real_escape_string($conn, $row['floc']);
				$fdesc = mysqli_real_escape_string($conn, $row['fdesc']);
				$teacher_id = mysqli_real_escape_string($conn, $row['teacher_id']);
				
				// Check if file already exists in backpack
				$check_query = mysqli_query($conn,"select * from student_backpack where student_id = '$session_id' and fname = '$fname'") or die(mysqli_error($conn));
				
				if(mysqli_num_rows($check_query) == 0) {
					$insert_query = mysqli_query($conn,"insert into student_backpack (floc,fdatein,fdesc,student_id,fname) values('$floc',NOW(),'$fdesc','$session_id','$fname')") or die(mysqli_error($conn));
					if($insert_query) {
						$success_count++;
					} else {
						$error_count++;
					}
				} else {
					$error_count++; // File already exists
				}
			}
		} else {
			$error_count++;
		}
	}
	
	// Set success/error message
	if($success_count > 0) {
		$_SESSION['copy_message'] = "Successfully copied $success_count file(s) to backpack.";
	}
	if($error_count > 0) {
		$_SESSION['copy_error'] = "Failed to copy $error_count file(s). Some files may already exist in your backpack.";
	}
} else {
	// Debug: Log if no selector data
	error_log("No selector data found in POST request");
}
?>
<script>
window.location = 'backpack.php';
</script>
<?php
?>