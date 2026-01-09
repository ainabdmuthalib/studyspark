<?php
include('admin/dbcon.php');
include('session.php');

// Debug: Test if file is being reached
echo "<!-- copy_file.php loaded -->";

// Test handler
if (isset($_POST['test'])) {
    echo "<script>alert('Test form submission successful!'); window.history.back();</script>";
    exit;
}

// GET test handler
if (isset($_GET['test'])) {
    echo "<script>alert('copy_file.php is accessible via GET!'); window.history.back();</script>";
    exit;
}
if (isset($_POST['delete_user'])){
$id=$_POST['selector'];
$class_id = $_POST['teacher_class_id'];
 $get_id=$_POST['get_id']; 
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($conn,"select * from files  where file_id = '$id[$i]' ")or die(mysqli_error());
	while($row = mysqli_fetch_array($result)){
	
	$fname = $row['fname'];
	$floc = $row['floc'];
	$fdesc = $row['fdesc'];
	$uploaded_by = $row['uploaded_by'];

	
	
	mysqli_query($conn,"insert into files (floc,fdatein,fdesc,class_id,fname,uploaded_by) value('$floc',NOW(),'$fdesc','$class_id','$fname','$uploaded_by')")or die(mysqli_error());
	
	
	}
}
?>
<script>
window.location = 'downloadable.php<?php echo '?id='.$get_id; ?>';
</script>
<?php
}

if (isset($_POST['copy'])){
// Debug: Log the POST data
error_log("Copy to backpack triggered");
error_log("POST data: " . print_r($_POST, true));
echo "<!-- Copy action detected -->";

$id=$_POST['selector'];

// Check if any files are selected
if (!isset($id) || empty($id)) {
    echo "<script>alert('Please select at least one file to copy to backpack.'); window.history.back();</script>";
    exit;
}

$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($conn,"select * from files  where file_id = '$id[$i]' ")or die(mysqli_error());
	while($row = mysqli_fetch_array($result)){
	

		$fname = $row['fname'];
	$floc = $row['floc'];
	$fdesc = $row['fdesc'];

	
	mysqli_query($conn,"insert into teacher_backpack (floc,fdatein,fdesc,teacher_id,fname) value('$floc',NOW(),'$fdesc','$session_id','$fname')")or die(mysqli_error());
	
	
	}
}
?>
<script>
window.location = 'teacher_backack.php';
</script>
<?php
}
?>
<?php

if (isset($_POST['share'])){
$id=$_POST['selector'];
$teacher_id = $_POST['teacher_id1'];
echo $teacher_id ; 
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($conn,"select * from files  where file_id = '$id[$i]' ")or die(mysqli_error());
	while($row = mysqli_fetch_array($result)){
	

		$fname = $row['fname'];
	$floc = $row['floc'];
	$fdesc = $row['fdesc'];

	
	mysqli_query($conn,"insert into teacher_shared (floc,fdatein,fdesc,teacher_id,fname,shared_teacher_id) value('$floc',NOW(),'$fdesc','$session_id','$fname','$teacher_id')")or die(mysqli_error());
	
	
	}
}
?>
<script>
alert('Files successfully shared with the selected lecturer!');
window.history.back();
</script>
<?php
}

if (isset($_POST['copy_to_class'])){
$id=$_POST['selector'];
$target_class_id = $_POST['teacher_class_id'];
$get_id = $_POST['get_id'];

// Check if any files are selected
if (!isset($id) || empty($id)) {
    echo "<script>alert('Please select at least one file to copy.'); window.history.back();</script>";
    exit;
}

// Check if target class is selected
if (!isset($target_class_id) || empty($target_class_id)) {
    echo "<script>alert('Please select a target class.'); window.history.back();</script>";
    exit;
}

$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysqli_query($conn,"select * from files  where file_id = '$id[$i]' ")or die(mysqli_error());
	while($row = mysqli_fetch_array($result)){
	
		$fname = $row['fname'];
		$floc = $row['floc'];
		$fdesc = $row['fdesc'];
		$uploaded_by = $row['uploaded_by'];

		mysqli_query($conn,"insert into files (floc,fdatein,fdesc,class_id,fname,uploaded_by) value('$floc',NOW(),'$fdesc','$target_class_id','$fname','$uploaded_by')")or die(mysqli_error());
	}
}
?>
<script>
window.location = 'downloadable.php<?php echo '?id='.$target_class_id; ?>';
</script>
<?php
}
?>