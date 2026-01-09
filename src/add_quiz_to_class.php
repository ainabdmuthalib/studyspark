<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('quiz_sidebar_teacher.php'); ?>
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
										<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
										<li><a href="#"><b>Quiz</b></a></li>
									</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-right"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<?php
									$error = '';
									$quiz_id = '';
									$time = '';
									if (isset($_POST['save'])){
										$quiz_id = isset($_POST['quiz_id']) ? $_POST['quiz_id'] : '';
										$time = isset($_POST['time']) ? $_POST['time'] : '';
										$id = isset($_POST['selector']) ? $_POST['selector'] : array();
										if ($quiz_id == '') {
											$error = 'Please select a Quiz.';
										} elseif (!is_numeric($time) || $time === '') {
											$error = 'Test Time must be a number.';
										} elseif (empty($id)) {
											$error = 'Please select at least one class.';
										} else {
											$quiz_time = $time * 60;
											$name_notification  = 'Add Practice Quiz file';
											$N = count($id);
											for($i=0; $i < $N; $i++) {
												mysqli_query($conn,"insert into class_quiz (teacher_class_id,quiz_time,quiz_id) values('$id[$i]','$quiz_time','$quiz_id')")or die(mysqli_error());
												mysqli_query($conn,"insert into notification (teacher_class_id,notification,date_of_notification,link) value('$id[$i]','$name_notification',NOW(),'student_quiz_list.php')")or die(mysqli_error());
											}
											echo '<script>window.location = "teacher_quiz.php";</script>';
											exit;
										}
									}
									?>
									<div class="pull-right">
									<a href="teacher_quiz.php" class="btn btn-info"><i class="icon-arrow-left"></i> Back</a>
									</div>
								
									    <form class="form-horizontal" method="post">
										<div class="control-group">
											<label class="control-label" for="inputEmail">Quiz</label>
											<div class="controls">
											<select name="quiz_id">
											<option></option>
												<?php  $query = mysqli_query($conn,"select * from quiz where teacher_id = '$session_id'")or die(mysqli_error());
												while ($row = mysqli_fetch_array($query)){ $id_option = $row['quiz_id']; ?>
												<option value="<?php echo $id_option; ?>" <?php if($quiz_id == $id_option) echo 'selected'; ?>><?php echo $row['quiz_title']; ?></option>
												<?php } ?>
											</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputPassword">Test Time (in minutes)</label>
											<div class="controls">
											<input type="text" class="span3" name="time" id="inputPassword" placeholder="Test Time" required value="<?php echo htmlspecialchars($time); ?>">
											</div>
										</div>
		
												<table class="table" id="question">
                <th></th>
                <th>Class</th>
                <th>Course</th>
                <th></th>
				
				<tbody>
					<?php $query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_id = '$session_id' and school_year = '$school_year' ")or die(mysqli_error());
										$count = mysqli_num_rows($query);
										

										while($row = mysqli_fetch_array($query)){
										$id_class = $row['teacher_class_id'];
				
										?>
					<tr>
					<td width="30">
						<input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id_class; ?>" <?php if(isset($_POST['selector']) && in_array($id_class, $_POST['selector'])) echo 'checked'; ?>>
					</td>
					<td><?php echo $row['class_name']; ?></td>
					<td><?php echo $row['subject_code']; ?></td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
		
											
										<div class="control-group">
										<div class="controls">
										
										<button name="save" type="submit" class="btn btn-info"><i class="icon-save"></i> Save</button>
										</div>
										</div>
										</form>
										
									
										
										<?php
										if ($error) { ?>
											<div class="alert alert-danger" style="margin-bottom:15px;"><i class="icon-warning-sign"></i> <?php echo $error; ?></div>
										<?php }
										?>
								
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