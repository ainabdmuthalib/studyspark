<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('session.php');
//Include database connection details
require("opener_db.php");
$errmsg_arr = array();
//Validation error flag
$errflag = false;
$conn = $connector->DbConnector();
// var_dump($conn);
// exit;       
$uploaded_by_query = mysqli_query($conn,"select * from teacher where teacher_id = '$session_id'")or die(mysqli_error());
$uploaded_by_query_row = mysqli_fetch_array($uploaded_by_query);
$uploaded_by = $uploaded_by_query_row['firstname']."".$uploaded_by_query_row['lastname'];

/* $id_class=$_POST['id_class']; */
$name=$_POST['name'];


									


//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    global $conn;
    $str = @trim($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($conn,$str);
}

//Sanitize the POST values
$filedesc = clean($_POST['desc']);

//$subject= clean($_POST['upname']);

if ($filedesc == '') {
    $errmsg_arr[] = ' file discription is missing';
    $errflag = true;
}

if ($_FILES['uploaded_file']['size'] >= 1048576 * 5) {
    $errmsg_arr[] = 'file selected exceeds 5MB size limit';
    $errflag = true;
}


//If there are input validations, redirect back to the registration form
if ($errflag) {
    $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
    session_write_close();
	?>

   <script>
   window.location = 'downloadable.php<?php echo '?id='.$get_id;  ?>';
   </script>
   <?php exit();
}
//upload random name/number
$rd2 = mt_rand(1000, 9999) . "_File";

//Check that we have a file
if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
    // Debug: Check for upload errors
    if ($_FILES['uploaded_file']['error'] !== 0) {
        echo "Upload error code: " . $_FILES['uploaded_file']['error'] . "<br>";
        switch ($_FILES['uploaded_file']['error']) {
            case 1: echo "Error: Exceeds upload_max_filesize in php.ini"; break;
            case 2: echo "Error: Exceeds MAX_FILE_SIZE in HTML form"; break;
            case 3: echo "Error: File only partially uploaded"; break;
            case 4: echo "Error: No file uploaded"; break;
            case 6: echo "Error: Missing a temporary folder"; break;
            case 7: echo "Error: Failed to write file to disk"; break;
            case 8: echo "Error: A PHP extension stopped the file upload"; break;
        }
        exit;
    }
    // Debug: Check if upload directory is writable
    if (!is_writable('admin/uploads/')) {
        echo "Error: Upload directory 'admin/uploads/' is not writable.";
        exit;
    }
    //Check if the file is JPEG image and it's size is less than 350Kb
    $filename = basename($_FILES['uploaded_file']['name']);

    $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
    $allowed_exts = array('pdf', 'ppt', 'pptx', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov', 'zip', 'rar');
    $allowed_mime = array(
        'application/pdf',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
        'image/jpeg',
        'image/png',
        'image/gif',
        'video/mp4',
        'video/x-msvideo',
        'video/quicktime',
        'application/zip',
        'application/x-rar-compressed'
    );
    $file_mime = $_FILES["uploaded_file"]["type"];

    if (!in_array($ext, $allowed_exts)) {
        $errmsg_arr[] = 'File type not allowed. Only PDF, PPT, PPTX, DOC, DOCX, XLS, XLSX, TXT, images, video, ZIP, and RAR are supported.';
        $errflag = true;
    }
    if (($ext == "exe") || ($file_mime == "application/x-msdownload")) {
        $errmsg_arr[] = 'Executable files are not allowed.';
        $errflag = true;
    }

    if (($_FILES["uploaded_file"]["size"] > 1048576 * 5)) {
        $errmsg_arr[] = 'file selected exceeds 5MB size limit';
        $errflag = true;
    }

    if ($errflag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        ?>

       <script>
       window.location = 'downloadable.php<?php echo '?id='.$get_id;  ?>';
       </script>
       <?php exit();
    }

    //Determine the path to which we want to save this file      
    //$newname = dirname(__FILE__).'/upload/'.$filename;
    $newname = "admin/uploads/" . $rd2 . "_" . $filename;
	$name_notification  = 'Add Downloadable Materials file name'." ".'<b>'.$name.'</b>';
    //Check if the file with the same name is already exists on the server
    if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname))) {
            //successful upload
            // echo "It's done! The file has been saved as: ".$newname;		   
					
							$id=$_POST['selector'];
											$N = count($id);
											for($i=0; $i < $N; $i++)
											{			
										
               /*  $qry2 = "INSERT INTO files (fdesc,floc,fdatein,teacher_id,class_id,fname,uploaded_by) VALUES ('$filedesc','$newname',NOW(),'$session_id','$id[$i]','$name','$uploaded_by')"; */
               // echo "INSERT INTO files (fdesc,floc,fdatein,teacher_id,class_id,fname,uploaded_by) VALUES ('$filedesc','$newname',NOW(),'$session_id','$id[$i]','$name','$uploaded_by')";
                // exit;
				mysqli_query($conn,"INSERT INTO files (fdesc,floc,fdatein,teacher_id,class_id,fname,uploaded_by) VALUES ('$filedesc','$newname',NOW(),'$session_id','$id[$i]','$name','$uploaded_by')");
				mysqli_query($conn,"insert into notification (teacher_class_id,notification,date_of_notification,link) value('$id[$i]','$name_notification',NOW(),'downloadable_student.php')")or die(mysqli_error());
			   
			  }
			   
}
}
}
?>


