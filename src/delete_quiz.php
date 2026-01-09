<?php
include('dbcon.php');
if (isset($_POST['backup_delete'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	// Delete from class_quiz first
	mysqli_query($conn,"DELETE FROM class_quiz WHERE quiz_id='$id[$i]'");
	// Then delete the quiz itself
	$result = mysqli_query($conn,"DELETE FROM quiz where quiz_id='$id[$i]'");
}
header("location: teacher_quiz.php");
}
?>