<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php
$error = '';
$content = '';
if (isset($_POST['Upload'])){
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $selector = isset($_POST['selector']) ? $_POST['selector'] : array();
    
    if ($content == '') {
        $error = 'Please write an announcement.';
    } elseif (empty($selector)) {
        $error = 'Please select at least one class.';
    } else {
        // Proceed with posting
        echo '<script>
            var formData = $("form#add_downloadble").serialize();
            $.ajax({
                type: "POST",
                url: "add_announcement_save.php",
                data: formData,
                success: function(html){
                    $.jGrowl("Announcement Successfully Posted", { header: "Announcement Posted" });
                    window.location = "add_announcement.php";
                }
            });
        </script>';
    }
}
?>
    <body id="class_div">
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_add_announcement_sidebar.php'); ?>
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
                                <div class="span8">
										<?php if ($error) { ?>
											<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> <?php echo $error; ?></div>
										<?php } ?>
										<form class="" id="add_downloadble" method="post"  >
                        <div class="control-group">
                     
                            <div class="controls">
				
									
							<textarea name="content" id="ckeditor_full"><?php echo htmlspecialchars($content); ?></textarea>
                            </div>
                        </div>

                
					
											<script>
			jQuery(document).ready(function($){
				$("#add_downloadble").submit(function(e){
					e.preventDefault();
					
					// Client-side validation
					var content = CKEDITOR.instances.ckeditor_full.getData().trim();
					var selectedClasses = $('input[name="selector[]"]:checked').length;
					
					var errorMessage = '';
					if (content === '') {
						errorMessage = 'Please write an announcement.';
					} else if (selectedClasses === 0) {
						errorMessage = 'Please select at least one class.';
					}
					
					if (errorMessage !== '') {
						// Show error message
						if ($('.alert-danger').length === 0) {
							$('.span8').prepend('<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> ' + errorMessage + '</div>');
						} else {
							$('.alert-danger').html('<i class="icon-warning-sign"></i> ' + errorMessage);
						}
						return false;
					}
					
					// Remove any existing error messages
					$('.alert-danger').remove();
					
					var formData = $(this).serialize();
					$.ajax({
						type: "POST",
						url: "add_announcement_save.php",
						data: formData,
						success: function(html){
							$.jGrowl("Announcement Successfully Posted", { header: 'Announcement Posted' });
							window.location = 'add_announcement.php';
						}
					});
				});
			});
			</script>	
	
	
									</div>
									<div class="span4">
											
			<div class="alert alert-info">Select the class to share this announcement</div>
					
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
													<button name="Upload" type="submit" value="Upload" class="btn btn-success" /><i class="icon-check"></i>&nbsp;Post</button>
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