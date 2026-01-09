<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php

 $get_id1 = $_POST['id'];
 ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('annoucement_link.php'); ?>
                <div class="span9" id="content">
				
                     <div class="row-fluid">
					  <!-- breadcrumb -->
				
										<?php $class_query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_class_id = '$get_id'")or die(mysqli_error());
										$class_row = mysqli_fetch_array($class_query);
										?>
				
					     <ul class="breadcrumb">
							<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><b>Announcements</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
						
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-left"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<a href="announcements.php<?php echo '?id='.$get_id; ?>"><i class="icon-arrow-left icon-large"></i> Back</a>
								<br>
								<br>
								<form method="post" id="edit-announcement-form">
									 <?php
								 $query_announcement = mysqli_query($conn,"select * from teacher_class_announcements
																	where teacher_id = '$session_id' and teacher_class_announcements_id = '$get_id1'  and  teacher_class_id = '$get_id' order by date DESC
																	")or die(mysqli_error());
								$row = mysqli_fetch_array($query_announcement);
								 $id = $row['teacher_class_announcements_id'];
								 ?>
								 <input type="hidden" name="id" value="<?php echo $id; ?>">
								<textarea name="content" id="ckeditor_full">
								<?php echo $row['content']; ?>
								</textarea>
								<br>
								<button name="post" class="btn btn-info" onclick="return validateEditAnnouncement()"><i class="icon-check icon-large"></i> Update</button>
								</form>
                                </div>
								
								<?php
									if (isset($_POST['post'])){
									$content = $_POST['content'];
									$id = $_POST['id'];
									
									if (trim($content) == '') {
										echo '<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> Please write an announcement before updating.</div>';
									} else {
										mysqli_query($conn,"update teacher_class_announcements  set content = '$content' where teacher_class_announcements_id = '$id' ")or die(mysqli_error());
										?>
										<script>
										 window.location = 'announcements.php<?php echo '?id='.$get_id; ?>'; 
										</script>
										<?php
									}
									}
								?>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>


                </div>
				
			


					<script type="text/javascript">
	$(document).ready( function() {

		
		$('.remove').click( function() {
		
		var id = $(this).attr("id");
			$.ajax({
			type: "POST",
			url: "remove_announcements.php",
			data: ({id: id}),
			cache: false,
			success: function(html){
			$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
			$('#'+id).modal('hide');
			$.jGrowl("Your Post is Successfully Deleted", { header: 'Data Delete' });
		
			}
			}); 
			
			return false;
		});				
	});

</script>
					
                </div>
				
			
            </div>
			
		
		
		
			
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
		
		<script>
		function validateEditAnnouncement() {
			// Get the content from CKEditor
			var content = '';
			if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.ckeditor_full) {
				content = CKEDITOR.instances.ckeditor_full.getData();
			} else {
				// Fallback to regular textarea if CKEditor is not available
				content = document.getElementById('ckeditor_full').value;
			}
			
			// Remove HTML tags and trim whitespace
			var plainText = content.replace(/<[^>]*>/g, '').trim();
			
			if (plainText === '') {
				// Show error message
				var errorDiv = document.createElement('div');
				errorDiv.className = 'alert alert-danger';
				errorDiv.style.marginBottom = '15px';
				errorDiv.innerHTML = '<i class="icon-warning-sign"></i> Please write an announcement before updating.';
				
				// Remove any existing error messages
				var existingError = document.querySelector('.alert-danger');
				if (existingError) {
					existingError.remove();
				}
				
				// Insert error message before the form
				var form = document.getElementById('edit-announcement-form');
				form.parentNode.insertBefore(errorDiv, form);
				
				// Focus on the editor
				if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.ckeditor_full) {
					CKEDITOR.instances.ckeditor_full.focus();
				} else {
					document.getElementById('ckeditor_full').focus();
				}
				
				return false;
			}
			
			// Remove any existing error messages if validation passes
			var existingError = document.querySelector('.alert-danger');
			if (existingError) {
				existingError.remove();
			}
			
			return true;
		}
		
		// Also validate on form submit
		document.getElementById('edit-announcement-form').addEventListener('submit', function(e) {
			return validateEditAnnouncement();
		});
		</script>
		
    </body>
</html>