<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('subject_overview_link_student.php'); ?>
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
							<li><a href="#"><b>Course Overview</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-left"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								
  											<?php $query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										LEFT JOIN teacher ON teacher.teacher_id = teacher_class.teacher_id
										
										where teacher_class_id = '$get_id'")or die(mysqli_error());
										$row = mysqli_fetch_array($query);
										$id = $row['teacher_class_id'];
				
										?>
										<?php
										// Fetch all info from subject table for the current subject
										$subject_id = $row['subject_id'];
										$subject_query = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id = '$subject_id'") or die(mysqli_error());
										if ($subject_info = mysqli_fetch_assoc($subject_query)) {
											echo '<div style="margin-top:20px;"><strong> </strong>';
											foreach ($subject_info as $key => $value) {
												if (!is_numeric($key) && strtolower($key) !== 'subject_id' && strtolower($key) !== 'semester' && strtolower($key) !== 'description') {
													if (strtolower($key) === 'unit') {
														echo htmlspecialchars($value) . ' MQF Credit<br>';
													} else {
														echo htmlspecialchars($value) . '<br>';
													}
												}
											}
											echo '</div><br>';
										}
										?>

										<?php $query = mysqli_query($conn,"select * from teacher_class
											LEFT JOIN class_subject_overview ON class_subject_overview.teacher_class_id = teacher_class.teacher_class_id
											where class_subject_overview.teacher_class_id = '$get_id'")or die(mysqli_error());
											$row_subject = mysqli_fetch_array($query); ?>
										<?php echo $row_subject['content']; ?>
										<hr>
										
										Lecturer: <strong><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></strong>
															<br>
															<img id="avatar" class="img-polaroid" src="admin/<?php echo $row['location']; ?>" width>
															<?php if (!empty($row['email'])): ?>
																<br>Email: <strong><?php echo htmlspecialchars($row['email']); ?></strong>
															<?php endif; ?>
															<?php if (!empty($row['phone'])): ?>
																<br>Phone: <strong><?php echo htmlspecialchars($row['phone']); ?></strong>
															<?php endif; ?>
															<?php if (!empty($row['about'])): ?>
																<br><div style="margin-top:10px;"><strong></strong> <?php echo nl2br(htmlspecialchars($row['about'])); ?></div>
															<?php endif; ?>
															
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>