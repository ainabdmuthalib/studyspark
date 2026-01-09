<?php

include('session.php');
//Include database connection details
require("opener_db.php");
/* $errmsg_arr = array();
//Validation error flag
$errflag = false; */
$conn= $connector->DbConnector();
$id_class=$_POST['id_class'];
$name=trim($_POST['name']);
$filedesc=$_POST['desc'];
$get_id  = $_GET['id'];

// Server-side validation
$errors = array();

// Check if file name is provided
if (empty($name)) {
    $errors[] = "File name is required.";
}

// File upload is optional, so we don't need to validate it

// If there are errors, redirect back with error message
if (!empty($errors)) {
    $error_message = implode(" ", $errors);
    ?>
    <script>
        alert("<?php echo addslashes($error_message); ?>");
        window.location = 'assignment.php<?php echo '?id='.$get_id; ?>';
    </script>
    <?php
    exit();
}

$input_name = basename($_FILES['uploaded_file']['name']);
 
//Function to sanitize values received from the form. Prevents SQL injection
/* function clean($str) {
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($str);
}

 */

// Since we already validated that a file is uploaded, we can proceed with file processing
$name_notification  = 'Add Assignment file name'." ".'<b>'.$name.'</b>';

//upload random name/number
$rd2 = mt_rand(1000, 9999) . "_File";
$filename = basename($_FILES['uploaded_file']['name']);
$ext = substr($filename, strrpos($filename, '.') + 1);

$newname = "admin/uploads/" . $rd2 . "_" . $filename;

//Attempt to move the uploaded file to it's new place
if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname)) {
    //successful upload
    $qry2 = "INSERT INTO assignment (fdesc,floc,fdatein,teacher_id,class_id,fname) VALUES ('$filedesc','$newname',NOW(),'$session_id','$id_class','$name')";
    $query = mysqli_query($conn,"insert into notification (teacher_class_id,notification,date_of_notification,link) value('$get_id','$name_notification',NOW(),'assignment_student.php')")or die(mysqli_error());               
    $result2 = $connector->query($qry2);
    if ($result2) {
        $errmsg_arr[] = 'record was saved in the database and the file was uploaded';
        $errflag = true;
        if ($errflag) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
            ?>
            <script>
                window.location = 'assignment.php<?php echo '?id='.$get_id;  ?>';
            </script>
            <?php
            exit();
        }
    }
} else {
    // File upload failed
    ?>
    <script>
        alert("File upload failed. Please try again.");
        window.location = 'assignment.php<?php echo '?id='.$get_id;  ?>';
    </script>
    <?php
    exit();
}
				?>