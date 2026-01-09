<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('downloadable_link.php'); ?>
                <div class="span6" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->
										<?php $class_query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_class_id = '$get_id'")or die(mysqli_error());
										$class_row = mysqli_fetch_array($class_query);
										$class_id = $class_row['class_id'];
										$school_year = $class_row['school_year'];
										?>
					     <ul class="breadcrumb">
							<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
							<li><a href="#">Semester <?php echo $class_row['school_year']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><b>Downloadable Materials</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-left"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div id="downloadable_table.php" class="span12">
									<div class="pull-right">
							Check All <input type="checkbox"  name="selectAll" id="checkAll" />
								<script>
								$("#checkAll").click(function () {
									$('input:checkbox').not(this).prop('checked', this.checked);
								});
								</script>					
							</div>
								
									<?php
										$query = mysqli_query($conn,"select * FROM files where class_id = '$get_id'  order by fdatein DESC ")or die(mysqli_error());
										$count = mysqli_fetch_array($query);
										if ($count == '0'){ ?>
											<div class="alert alert-info"><i class="icon-info-sign"></i> Currently you did not upload any downloadable materials</div>
						
									<?php	}else{
									?>  
  								<form action="copy_file.php" method="post" id="copyForm">
									<input type="hidden" name="get_id" value="<?php echo $get_id; ?>">
									<a href="#" onclick="submitCopyForm()" class="btn btn-info"><i class="icon-briefcase"></i> Copy to Backpack</a>
									<a href="#" onclick="openShareModal()" class="btn btn-success"><i class="icon-share"></i> Share to Lecturer</a>
									<a href="#" onclick="openCopyToClassModal()" class="btn btn-warning"><i class="icon-file"></i> Copy to Other Class</a>
									

  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="">
									<?php include('move_to_school_year.php'); ?>
										<thead>
										        <tr>
												<th>Date Upload</th>
												<th>File Name</th>
												<th>Description</th>
												<th>Uploaded by</th>
												<th></th>
												<th></th>
												</tr>
												
										</thead>
										<tbody>
											
                              		<?php
										$query = mysqli_query($conn,"select * FROM files where class_id = '$get_id'  order by fdatein DESC ")or die(mysqli_error());
										while($row = mysqli_fetch_array($query)){
										$id  = $row['file_id'];
									?>                              
										<tr id="del<?php echo $id; ?>">
									
										 <td><?php echo date('Y-m-d H:i', strtotime($row['fdatein'])); ?></td>
                                         <td>
											<?php
											$ext = strtolower(pathinfo($row['fname'], PATHINFO_EXTENSION));
											$icon = 'icon-file';
											if ($ext == 'pdf') $icon = 'icon-file-text';
											elseif ($ext == 'ppt' || $ext == 'pptx') $icon = 'icon-desktop';
											elseif (in_array($ext, ['jpg','jpeg','png','gif'])) $icon = 'icon-picture';
											elseif (in_array($ext, ['mp4','avi','mov'])) $icon = 'icon-facetime-video';
											?>
											<i class="<?php echo $icon; ?> icon-large"></i>
											<a href="<?php echo $row['floc']; ?>" target="_blank" style="font-weight:bold; text-decoration:underline;">
												<?php echo $row['fname']; ?>
											</a>
											<?php if ($ext == 'ppt' || $ext == 'pptx'): ?>
												<span class="text-muted">(PowerPoint - download to view)</span>
											<?php endif; ?>
										</td>
                                         <td><?php echo $row['fdesc']; ?></td>                                      
                                         <td><?php echo $row['uploaded_by']; ?></td>                                      
                                         <td width="40">
										 <a  data-placement="bottom" title="Download" id="<?php echo $id; ?>download" href="<?php echo $row['floc']; ?>" download="<?php echo $row['fname']; ?>"><i class="icon-download icon-large"></i></a>
										 <a  data-placement="bottom" title="Remove" id="<?php echo $id; ?>remove" href="#<?php echo $id; ?>" data-toggle="modal"><i class="icon-remove icon-large"></i></a>
										 <?php include('delete_download_modal.php'); ?>
										 </td>                                      
										<td width="30">
											<input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
										</td>
                             
														<script type="text/javascript">
														$(document).ready(function(){
															$('#<?php echo $id; ?>download').tooltip('show');
															$('#<?php echo $id; ?>download').tooltip('hide');
															
															// Force download functionality
															$('#<?php echo $id; ?>download').click(function(e) {
																e.preventDefault();
																var link = document.createElement('a');
																link.href = '<?php echo $row['floc']; ?>';
																link.download = '<?php echo $row['fname']; ?>';
																link.target = '_blank';
																document.body.appendChild(link);
																link.click();
																document.body.removeChild(link);
															});
														});
														</script>
														<script type="text/javascript">
														$(document).ready(function(){
															$('#<?php echo $id; ?>remove').tooltip('show');
															$('#<?php echo $id; ?>remove').tooltip('hide');
														});
														</script>
                               
                                </tr>
                         
						 <?php } ?>
						   
                              
										</tbody>
									</table>




									<!-- Modal 3: Share to Lecturer -->
									<div id="shareToTeacherModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="shareToTeacherModalLabel" aria-hidden="true">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											<h3 id="shareToTeacherModalLabel">Share to Lecturer</h3>
										</div>
										<div class="modal-body">
											<center>
												<div class="control-group">
													<div class="controls">
														<input type="hidden" name="get_id" value="<?php echo $get_id; ?>">
														<p>Share To:</p>
														<div class="control-group">
															<label>To:</label>
															<div class="controls">
																<select name="teacher_id1" class="" required>
																	<option></option>
																	<?php
																	$query = mysqli_query($conn,"select * from teacher order by firstname");
																	while($row = mysqli_fetch_array($query)){
																	?>
																	<option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?> </option>
																	<?php } ?>
																</select>
															</div>
														</div>
														<button type="button" onclick="submitShareForm()" class="btn btn-success"><i class="icon-copy"></i> Share</button>
													</div>
												</div>
											</center>
										</div>
										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
										</div>
									</div>

									<!-- Modal: Copy to Other Class -->
									<div id="copyToClassModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="copyToClassModalLabel" aria-hidden="true">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											<h3 id="copyToClassModalLabel">Copy to Other Class</h3>
										</div>
										<div class="modal-body">
											<center>
												<div class="control-group">
													<label>Select Target Class</label>
													<div class="controls">
														<select name="target_class_id" class="" id="target_class_select">
															<option value="">Select Class</option>
															<?php
															$teacher_id = $session_id;
															$query_classes = mysqli_query($conn,"select tc.*, c.class_name, s.subject_code 
																from teacher_class tc 
																LEFT JOIN class c ON c.class_id = tc.class_id 
																LEFT JOIN subject s ON s.subject_id = tc.subject_id 
																where tc.teacher_id = '$teacher_id' 
																and tc.teacher_class_id != '$get_id' 
																order by c.class_name, tc.school_year")or die(mysqli_error());
															$has_classes = false;
															while($row = mysqli_fetch_array($query_classes)){
																$has_classes = true;
															?>
															<option value="<?php echo $row['teacher_class_id']; ?>">
																<?php echo $row['class_name']; ?> - <?php echo $row['subject_code']; ?> (<?php echo $row['school_year']; ?>)
															</option>
															<?php } ?>
														</select>
														<?php if (!$has_classes): ?>
															<p class="text-muted">No other classes available.</p>
														<?php endif; ?>
													</div>
												</div>
												<div class="control-group">
													<div class="controls">
														<button type="button" onclick="submitCopyToClassForm()" class="btn btn-warning" id="copyToClassBtn" disabled><i class="icon-copy"></i> Copy Files</button>
													</div>
												</div>
											</center>
										</div>
										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
										</div>
									</div>
									</form>
						<?php } ?>
					
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>


					
					<script type="text/javascript">
	$(document).ready( function() {

		
		$('.remove').click( function() {
		
		var id = $(this).attr("id");
			$.ajax({
			type: "POST",
			url: "delete_file.php",
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
 
		// Function to submit copy form
		window.submitCopyForm = function() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			if (checkedBoxes.length === 0) {
				alert('Please select at least one file to copy to backpack.');
				return false;
			}
			
			// Check for duplicates in backpack
			var fileIds = [];
			checkedBoxes.each(function() {
				fileIds.push($(this).val());
			});
			
			// AJAX call to check for duplicates
			$.ajax({
				type: "POST",
				url: "check_backpack_duplicates.php",
				data: { file_ids: fileIds },
				dataType: 'json',
				success: function(response) {
					if (response.duplicates && response.duplicates.length > 0) {
						var duplicateNames = response.duplicates.join(', ');
						var confirmMessage = 'The following files are already in your backpack:\n\n' + duplicateNames + '\n\nDo you want to copy them anyway?';
						
						if (confirm(confirmMessage)) {
							submitForm();
						}
					} else {
						submitForm();
					}
				},
				error: function() {
					// If check fails, proceed with copy anyway
					submitForm();
				}
			});
		};
		
		// Function to actually submit the form
		function submitForm() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			
			// Create a temporary form and submit it
			var form = document.createElement('form');
			form.method = 'POST';
			form.action = 'copy_file.php';
			
			// Add get_id
			var get_id_input = document.createElement('input');
			get_id_input.type = 'hidden';
			get_id_input.name = 'get_id';
			get_id_input.value = '<?php echo $get_id; ?>';
			form.appendChild(get_id_input);
			
			// Add copy action
			var copy_input = document.createElement('input');
			copy_input.type = 'hidden';
			copy_input.name = 'copy';
			copy_input.value = '1';
			form.appendChild(copy_input);
			
			// Add selected files
			checkedBoxes.each(function() {
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = 'selector[]';
				input.value = $(this).val();
				form.appendChild(input);
			});
			
			document.body.appendChild(form);
			form.submit();
		}
		
		// Function to open share modal
		window.openShareModal = function() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			if (checkedBoxes.length === 0) {
				alert('Please select at least one file to share.');
				return false;
			}
			
			// Open the modal
			$('#shareToTeacherModal').modal('show');
		};
		
		// Function to submit share form
		window.submitShareForm = function() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			var selectedTeacher = $('#shareToTeacherModal select[name="teacher_id1"]').val();
			
			if (!selectedTeacher || selectedTeacher === '') {
				alert('Please select a teacher to share with.');
				return false;
			}
			
			// Create a temporary form and submit it
			var form = document.createElement('form');
			form.method = 'POST';
			form.action = 'copy_file.php';
			
			// Add get_id
			var get_id_input = document.createElement('input');
			get_id_input.type = 'hidden';
			get_id_input.name = 'get_id';
			get_id_input.value = '<?php echo $get_id; ?>';
			form.appendChild(get_id_input);
			
			// Add share action
			var share_input = document.createElement('input');
			share_input.type = 'hidden';
			share_input.name = 'share';
			share_input.value = '1';
			form.appendChild(share_input);
			
			// Add selected teacher
			var teacher_input = document.createElement('input');
			teacher_input.type = 'hidden';
			teacher_input.name = 'teacher_id1';
			teacher_input.value = selectedTeacher;
			form.appendChild(teacher_input);
			
			// Add selected files
			checkedBoxes.each(function() {
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = 'selector[]';
				input.value = $(this).val();
				form.appendChild(input);
			});
			
			document.body.appendChild(form);
			form.submit();
		};
		
		// Function to open copy to class modal
		window.openCopyToClassModal = function() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			if (checkedBoxes.length === 0) {
				alert('Please select at least one file to copy to other class.');
				return false;
			}
			
			// Open the modal
			$('#copyToClassModal').modal('show');
		};
		
		// Function to submit copy to class form
		window.submitCopyToClassForm = function() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			var selectedClass = $('#copyToClassModal select[name="target_class_id"]').val();
			
			if (!selectedClass || selectedClass === '') {
				alert('Please select a target class.');
				return false;
			}
			
			// Check for duplicates in target class
			var fileIds = [];
			checkedBoxes.each(function() {
				fileIds.push($(this).val());
			});
			
			// AJAX call to check for duplicates
			$.ajax({
				type: "POST",
				url: "check_class_duplicates.php",
				data: { 
					file_ids: fileIds,
					target_class_id: selectedClass
				},
				dataType: 'json',
				success: function(response) {
					if (response.duplicates && response.duplicates.length > 0) {
						var duplicateNames = response.duplicates.join(', ');
						var confirmMessage = 'The following files already exist in the selected class:\n\n' + duplicateNames + '\n\nDo you want to copy them anyway?';
						
						if (confirm(confirmMessage)) {
							submitCopyToClassForm();
						}
					} else {
						submitCopyToClassForm();
					}
				},
				error: function() {
					// If check fails, proceed with copy anyway
					submitCopyToClassForm();
				}
			});
		};
		
		// Function to actually submit the copy to class form
		function submitCopyToClassForm() {
			var checkedBoxes = $('input[name="selector[]"]:checked');
			var selectedClass = $('#copyToClassModal select[name="target_class_id"]').val();
			
			// Create a temporary form and submit it
			var form = document.createElement('form');
			form.method = 'POST';
			form.action = 'copy_file.php';
			
			// Add get_id (source class)
			var get_id_input = document.createElement('input');
			get_id_input.type = 'hidden';
			get_id_input.name = 'get_id';
			get_id_input.value = '<?php echo $get_id; ?>';
			form.appendChild(get_id_input);
			
			// Add copy_to_class action
			var copy_to_class_input = document.createElement('input');
			copy_to_class_input.type = 'hidden';
			copy_to_class_input.name = 'copy_to_class';
			copy_to_class_input.value = '1';
			form.appendChild(copy_to_class_input);
			
			// Add target class
			var target_class_input = document.createElement('input');
			target_class_input.type = 'hidden';
			target_class_input.name = 'teacher_class_id';
			target_class_input.value = selectedClass;
			form.appendChild(target_class_input);
			
			// Add selected files
			checkedBoxes.each(function() {
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = 'selector[]';
				input.value = $(this).val();
				form.appendChild(input);
			});
			
			document.body.appendChild(form);
			form.submit();
		}
		
		// Handle target class dropdown selection
		$('#target_class_select').change(function() {
			var selectedValue = $(this).val();
			if (selectedValue) {
				$('#copyToClassBtn').prop('disabled', false);
			} else {
				$('#copyToClassBtn').prop('disabled', true);
			}
		});
		
		// Reset dropdown when modal is closed
		$('#copyToClassModal').on('hidden', function() {
			$('#target_class_select').val('');
			$('#copyToClassBtn').prop('disabled', true);
		});
 
	});

</script>
					
                </div>
				<?php include('downloadable_sidebar.php') ?>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>