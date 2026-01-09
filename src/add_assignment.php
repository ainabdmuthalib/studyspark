<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php
$error = '';
$name = '';
$desc = '';
if (isset($_POST['Upload'])){
    $uploaded_file = isset($_FILES['uploaded_file']) ? $_FILES['uploaded_file'] : null;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    $selector = isset($_POST['selector']) ? $_POST['selector'] : array();
    
    if (!$uploaded_file || $uploaded_file['error'] == UPLOAD_ERR_NO_FILE) {
        $error = 'Please select a file to upload.';
    } elseif ($name == '') {
        $error = 'Please provide a file name.';
    } elseif (empty($selector)) {
        $error = 'Please select at least one class.';
    } else {
        // Proceed with upload
        echo '<script>
            $.jGrowl("Uploading File Please Wait......", { sticky: true });
            var formData = new FormData(document.getElementById("add_downloadble"));
            $.ajax({
                type: "POST",
                url: "add_assignment_save.php",
                data: formData,
                success: function(html){
                    $.jGrowl("Assignment Successfully Added", { header: "Assignment Added" });
                    setTimeout(function() {
                        window.location = "add_assignment.php";
                    }, 5000);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        </script>';
    }
}
?>
    <body id="class_div">
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_add_assignment_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
					     <ul class="breadcrumb">
								<?php
								$school_year_query = mysqli_query($conn,"SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>
								<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
								<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a></li>
						</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="count_class" class="muted pull-right">

								</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span4">
										<?php if ($error) { ?>
											<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> <?php echo $error; ?></div>
										<?php } ?>
										<form class="" id="add_downloadble" method="post" enctype="multipart/form-data" name="upload" >
												<div class="control-group">
													<label class="control-label" for="inputEmail">File</label>
													<div class="controls">
														<input name="uploaded_file"  class="input-file uniform_on" id="fileInput" type="file" >
														<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
														<input type="hidden" name="id" value="<?php echo $session_id ?>"/>
													</div>
												</div>
												<div class="control-group">
													<div class="controls">
														<input type="text" name="name" Placeholder="File Name"  class="input" value="<?php echo htmlspecialchars($name); ?>">
													</div>
												</div>
												<div class="control-group">
													<div class="controls">
													<textarea id="assigntextare" placeholder="Description" name="desc" required><?php echo htmlspecialchars($desc); ?></textarea>
													</div>
												</div>
                
					
											<script>
			jQuery(document).ready(function($){
				$("#add_downloadble").submit(function(e){
					e.preventDefault();
					
					// Client-side validation
					var fileInput = $('input[name="uploaded_file"]')[0];
					var fileName = $('input[name="name"]').val().trim();
					var selectedClasses = $('input[name="selector[]"]:checked').length;
					
					var errorMessage = '';
					if (!fileInput.files || fileInput.files.length === 0) {
						errorMessage = 'Please select a file to upload.';
					} else if (fileName === '') {
						errorMessage = 'Please provide a file name.';
					} else if (selectedClasses === 0) {
						errorMessage = 'Please select at least one class.';
					}
					
					if (errorMessage !== '') {
						// Show error message
						if ($('.alert-danger').length === 0) {
							$('.span4').prepend('<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> ' + errorMessage + '</div>');
						} else {
							$('.alert-danger').html('<i class="icon-warning-sign"></i> ' + errorMessage);
						}
						return false;
					}
					
					// Remove any existing error messages
					$('.alert-danger').remove();
					
					$.jGrowl("Uploading File Please Wait......", { sticky: true });
					var formData = new FormData($(this)[0]);
					$.ajax({
						type: "POST",
						url: "add_assignment_save.php",
						data: formData,
						success: function(html){
							$.jGrowl("Assignment Successfully Added", { header: 'Assignment Added' });
							setTimeout(function() {
								window.location = 'add_assignment.php';
							}, 1500);
						},
						cache: false,
						contentType: false,
						processData: false
					});
				});
			});
			</script>	
	
	
									</div>
									<div class="span8">
											
			<div class="alert alert-info">Select the class to assign this assignment</div>
					
									<div class="pull-left">
							Check All <input type="checkbox"  name="selectAll" id="checkAll" />
								<script>
								$("#checkAll").click(function () {
									$('input:checkbox').not(this).prop('checked', this.checked);
								});
								</script>					
							</div>
											<table cellpadding="0" cellspacing="0" border="0" class="table" id="">

										<thead>
										        <tr>
												<th></th>
												<th>Class Name</th>
												<th>Course Code</th>
												</tr>
												
										</thead>
										<tbody>
											
                              	<?php $query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_id = '$session_id' and school_year = '$school_year' ")or die(mysqli_error());
										$count = mysqli_num_rows($query);
										
									
										while($row = mysqli_fetch_array($query)){
										$id = $row['teacher_class_id'];
				
										?>                             
										<tr id="del<?php echo $id; ?>">
											<td width="30">
												<input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>" <?php if(isset($_POST['selector']) && in_array($id, $_POST['selector'])) echo 'checked'; ?>>
											</td>
											<td><?php echo $row['class_name']; ?></td>
											<td><?php echo $row['subject_code']; ?></td>                                                                   
										</tr>
                         
						<?php } ?>
							
						   
                              
										</tbody>
									</table>
						
									
                                </div>
								<div class="span10">
								<hr>
									<center>
									<div class="control-group">
												<div class="controls">
													<button name="Upload" type="submit" value="Upload" class="btn btn-success" /><i class="icon-upload-alt"></i>&nbsp;Upload</button>
												</div>
									</div>
									</center>
             
						       </form>		
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
			

                </div>
							<?php/*  include('teacher_right_sidebar.php')  */?>
	
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>