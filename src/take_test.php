<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php $class_quiz_id = $_GET['class_quiz_id']; ?>
<?php $quiz_id = $_GET['quiz_id']; ?>
<?php $quiz_time = $_GET['quiz_time']; ?>

<?php $query1 = mysqli_query($conn,"select * from student_class_quiz where student_id = '$session_id' and class_quiz_id = '$class_quiz_id' ")or die(mysqli_error());
	  $count = mysqli_num_rows($query1);
?>

<?php
if ($count > 0){
}else{
 mysqli_query($conn,"insert into student_class_quiz (class_quiz_id,student_id,student_quiz_time) values('$class_quiz_id','$session_id','$quiz_time')");
}
 ?>

<?php
// Save answers to session if form was submitted with errors
if(isset($_POST['submit_answer'])){
    $x1 = $_POST['x'];
    $unanswered = [];
    for($x=1;$x<=$x1;$x++){
        $x2 = $_POST["x-$x"];
        if (isset($_POST["q-$x2"])) {
            $_SESSION['quiz_answers'][$x2] = $_POST["q-$x2"];
        } else {
            $unanswered[] = $x;
        }
    }
    if (count($unanswered) > 0) {
        // Store the unanswered questions for error message
        $_SESSION['unanswered_questions'] = $unanswered;
        // Redirect back to quiz with saved answers
        header("Location: take_test.php?id=$get_id&class_quiz_id=$class_quiz_id&test=ok&quiz_id=$quiz_id&quiz_time=$quiz_time&error=1");
        exit;
    }
}
?>

    <body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('student_quiz_link.php'); ?>
                <div class="span9" id="content">
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
							<li><a href="#"><b>Practice Quiz</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">

							
							<?php
if($_GET['test'] == 'ok'){
/* $sqlp = mysqli_query($conn,"SELECT * FROM groupcode WHERE course_code = '".$row['course_code']."'"); */
$sqlp = mysqli_query($conn,"SELECT * FROM class_quiz WHERE class_quiz_id = '$class_quiz_id'")or die(mysqli_error());
$rowp = mysqli_fetch_array($sqlp);
/* mysqli_query($conn,"UPDATE students SET `time-left` = ".$rowp['time']." WHERE stud_id = '".$_SESSION['user_id']."'"); */
/* echo $rowp['time']; */
$x=0;
?>
										<script>
										jQuery(document).ready(function(){
											var timer = 1;
											jQuery(".questions-table input").hide();
										setInterval(function(){
											var timer = jQuery("#timer").text();
											jQuery("#timer").load("timer.ajax.php?class_quiz_id=<?php echo $class_quiz_id; ?>");	
											if(timer == 0){
												jQuery(".questions-table input").hide();
												jQuery("#submit-test").show();
												jQuery("#msg").text("Time's up!!!\nPlease Submit your Answers");
											} else {
												jQuery(".questions-table input").show();
											}
										},990);	
										});
										</script>
<form action="take_test.php<?php echo '?id='.$get_id; ?>&<?php echo 'class_quiz_id='.$class_quiz_id; ?>&<?php echo 'test=done' ?>&<?php echo 'quiz_id='.$quiz_id; ?>&<?php echo 'quiz_time='.$quiz_time; ?>" name="testform" method="POST" id="test-form">
<?php
										// Fetch the current quiz details using class_quiz_id
										$sqla = mysqli_query($conn,"SELECT * FROM class_quiz 
											LEFT JOIN quiz ON quiz.quiz_id = class_quiz.quiz_id
											WHERE class_quiz.class_quiz_id = '$class_quiz_id'") or die(mysqli_error());
										$rowa = mysqli_fetch_array($sqla);

?>
										<h3>Test Title: <b><?php echo $rowa['quiz_title'];?></b></h3>
										<p><b>Description:<?php echo $rowa['quiz_description'];?></b></p>
										<p></p>
										
										<!-- Show error message if there was a validation error -->
										<?php if(isset($_GET['error']) && $_GET['error'] == '1' && isset($_SESSION['unanswered_questions'])): ?>
											<div class="alert alert-danger" id="error-message">
												You did not answer all questions. Please answer all questions before submitting.
												<?php unset($_SESSION['unanswered_questions']); ?>
											</div>
											<script>
											setTimeout(function() {
												var errorMsg = document.getElementById('error-message');
												if (errorMsg) {
													errorMsg.style.transition = 'opacity 0.5s ease-out';
													errorMsg.style.opacity = '0';
													setTimeout(function() {
														errorMsg.style.display = 'none';
													}, 500);
												}
											}, 3000);
											</script>
										<?php endif; ?>
										
										Time Remaining:<div id="timer">1</div>
										<div id="msg"></div>

										<!-- Question Navigation Bar -->
										<div class="question-nav" style="margin: 20px 0; padding: 15px; background: #f5f5f5; border-radius: 5px;">
											<div class="question-numbers" id="question-numbers">
												<!-- Question numbers will be populated by JavaScript -->
											</div>
										</div>

					<script>
					jQuery(document).ready(function(){	
						jQuery(".questions").each(function(){
							jQuery(this).hide();
						});
						jQuery("#q_1").show();
						
						// Initialize question navigation
						initializeQuestionNav();
					});
					</script>
										<script>
										jQuery(document).ready(function(){
										var nq = 0;
										var qn = 0;
											jQuery(".nextq").click(function(){
												qn = jQuery(this).attr('qn');
												nq = parseInt(qn) + 1;
												jQuery('#q_' + qn ).fadeOut();
												jQuery('#q_' + nq ).show();
												updateQuestionNav(qn, nq);
											});
											
											jQuery(".prevq").click(function(){
												qn = jQuery(this).attr('qn');
												nq = parseInt(qn) - 1;
												jQuery('#q_' + qn ).fadeOut();
												jQuery('#q_' + nq ).show();
												updateQuestionNav(qn, nq);
											});
										});
										
										// Function to initialize question navigation
										function initializeQuestionNav() {
											var totalQuestions = <?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM quiz_question where quiz_id = '$quiz_id'")); ?>;
											var navHtml = '';
											
											for(var i = 1; i <= totalQuestions; i++) {
												navHtml += '<span class="question-number" data-question="' + i + '" onclick="goToQuestion(' + i + ')" style="display: inline-block; width: 35px; height: 35px; line-height: 35px; text-align: center; margin: 3px; border: 2px solid #ddd; border-radius: 5px; cursor: pointer; background: #d9534f; color: white; font-weight: bold;">' + i + '</span>';
											}
											
											document.getElementById('question-numbers').innerHTML = navHtml;
											updateQuestionNav(0, 1); // Start with question 1
										}
										
										// Function to update question navigation
										function updateQuestionNav(prevQ, currentQ) {
											var totalQuestions = <?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM quiz_question where quiz_id = '$quiz_id'")); ?>;
											
											// Update current question
											document.querySelector('[data-question="' + currentQ + '"]').style.background = '#337ab7';
											
											// Reset previous question if it exists
											if(prevQ > 0) {
												var prevElement = document.querySelector('[data-question="' + prevQ + '"]');
												if(prevElement) {
													// Check if question is answered
													var questionId = '<?php echo $quiz_id; ?>_' + prevQ;
													var answered = isQuestionAnswered(prevQ);
													prevElement.style.background = answered ? '#5cb85c' : '#d9534f';
												}
											}
											
											// Update all answered questions
											for(var i = 1; i <= totalQuestions; i++) {
												if(i != currentQ) {
													var element = document.querySelector('[data-question="' + i + '"]');
													if(element && isQuestionAnswered(i)) {
														element.style.background = '#5cb85c';
													}
												}
											}
										}
										
										// Function to check if a question is answered
										function isQuestionAnswered(questionNum) {
											var questionId = '<?php echo $quiz_id; ?>_' + questionNum;
											var inputs = document.querySelectorAll('input[name^="q-"]');
											for(var i = 0; i < inputs.length; i++) {
												if(inputs[i].checked) {
													var name = inputs[i].name;
													var questionIdFromName = name.replace('q-', '');
													// Check if this input belongs to the current question
													var questionElement = document.querySelector('input[name="x-' + questionNum + '"]');
													if(questionElement && questionElement.value == questionIdFromName) {
														return true;
													}
												}
											}
											return false;
										}
										
										// Function to go to specific question
										function goToQuestion(questionNum) {
											var totalQuestions = <?php echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM quiz_question where quiz_id = '$quiz_id'")); ?>;
											
											// Hide all questions
											for(var i = 1; i <= totalQuestions; i++) {
												jQuery('#q_' + i).hide();
											}
											
											// Show selected question
											jQuery('#q_' + questionNum).show();
											
											// Update navigation
											updateQuestionNav(0, questionNum);
										}
										
										// Update navigation when answers are selected
										jQuery(document).on('change', 'input[type="radio"]', function() {
											var currentQuestion = jQuery('.questions:visible').find('td:first').text();
											updateQuestionNav(0, parseInt(currentQuestion));
										});
										</script>
<table class="questions-table table">
<tr>
<th>#</th>
<th>Question</th>
</tr>
<?php
	$sqlw = mysqli_query($conn,"SELECT * FROM quiz_question where quiz_id = '$quiz_id'  ORDER BY RAND()");
	$qt = mysqli_num_rows($sqlw); 
	while($roww = mysqli_fetch_array($sqlw)){
?>
<tr id="q_<?php echo $x=$x+1;?>" class="questions">
<td width="30" id="qa"><?php echo $x;?></td>
<td id="qa">
<?php echo $roww['question_text'];?>
<br>
<hr>
<?php
if($roww['question_type_id']=='2'){
	$saved_answer = isset($_SESSION['quiz_answers'][$roww['quiz_question_id']]) ? $_SESSION['quiz_answers'][$roww['quiz_question_id']] : '';
?>
	<input name="q-<?php echo $roww['quiz_question_id'];?>" value="True" type="radio" <?php echo ($saved_answer == 'True') ? 'checked' : ''; ?>> True&nbsp;        &nbsp;<input name="q-<?php echo $roww['quiz_question_id'];?>" value="False" type="radio" <?php echo ($saved_answer == 'False') ? 'checked' : ''; ?>> False
<?php
} else if($roww['question_type_id']=='1') {
	$saved_answer = isset($_SESSION['quiz_answers'][$roww['quiz_question_id']]) ? $_SESSION['quiz_answers'][$roww['quiz_question_id']] : '';
	$sqly = mysqli_query($conn,"SELECT * FROM answer WHERE quiz_question_id = '".$roww['quiz_question_id']."'");
	while($rowy = mysqli_fetch_array($sqly)){
	if($rowy['choices'] == 'A') {
	?>
	A.)<input name="q-<?php echo $roww['quiz_question_id'];?>" value="A" type="radio" <?php echo ($saved_answer == 'A') ? 'checked' : ''; ?>> <?php echo $rowy['answer_text'];?><br /><br />
	<?php } else if ($rowy['choices'] == 'B') {?>                                 
	B.) <input name="q-<?php echo $roww['quiz_question_id'];?>" value="B" type="radio" <?php echo ($saved_answer == 'B') ? 'checked' : ''; ?>> <?php echo $rowy['answer_text'];?><br /><br />
	<?php } else if ($rowy['choices'] == 'C') {?>                                 
	C.) <input name="q-<?php echo $roww['quiz_question_id'];?>" value="C" type="radio" <?php echo ($saved_answer == 'C') ? 'checked' : ''; ?>> <?php echo $rowy['answer_text'];?><br /><br />
	<?php } else if ($rowy['choices'] == 'D') {?>                                 
	D.) <input name="q-<?php echo $roww['quiz_question_id'];?>" value="D" type="radio" <?php echo ($saved_answer == 'D') ? 'checked' : ''; ?>> <?php echo $rowy['answer_text'];?><br /><br />
	<?php
		}
	}
}
?>
<br/>
<?php if($x > 1): ?>
<button onclick="return false;" qn="<?php echo $x;?>" class="prevq btn btn-warning" id="prev_<?php echo $x;?>"><i class="icon-arrow-left"></i> PREVIOUS</button>
<?php endif; ?>
<button onclick="return false;" qn="<?php echo $x;?>" class="nextq btn btn-success" id="next_<?php echo $x;?>">NEXT<i class="icon-arrow-right"></i> </button>
<input type="hidden" name="x-<?php echo $x;?>" value="<?php echo $roww['quiz_question_id'];?>">
</td>
</tr>
<?php
	}
?>
<tr>
<td></td>
<td>
<button class="btn btn-info" id="submit-test" name="submit_answer"><i class="icon-check"></i> Submit Quiz</button>
<!-- <input type="submit" value="Submit My Answers"  class="btn btn-info" id="submit-test" name="submit_answer"><br /> -->
</td>
</tr>
</table>
<input type="hidden" name="x" value="<?php echo $x;?>">
</form>
<?php
} else if(isset($_POST['submit_answer'])){
	$x1 = $_POST['x'];
	$score = 0;
	$unanswered = [];
	for($x=1;$x<=$x1;$x++){
		$x2 = $_POST["x-$x"];
		if (!isset($_POST["q-$x2"])) {
			$unanswered[] = $x;
			continue;
		}
		$q = $_POST["q-$x2"];
		$sql = mysqli_query($conn,"SELECT * FROM quiz_question WHERE quiz_question_id = ".$x2."");
		$row = mysqli_fetch_array($sql);
		if($row['answer'] == $q) {
			$score= $score + 1;
		}
	}
	if (count($unanswered) > 0) {
		echo "<div class='alert alert-danger'> You did not answer all questions. Please answer all questions before submitting.</div>";
		echo "<a href='javascript:history.back()' class='btn btn-warning'>Go Back to Quiz</a>";
	} else {
		// Clear saved answers after successful submission
		unset($_SESSION['quiz_answers']);
		?>
		<a href="student_quiz_list.php<?php echo '?id='.$get_id; ?>"><i class="icon-arrow-left"></i> Back</a>
		<center>
		<h3><br>Your score is <b><?php echo $score; ?></b> out of <b><?php echo ($x-1); ?></b><br/></h3>
		</center>
		<?php
		/* echo "Your Percentage Grade is : <b>".$per."%</b>"; */
		mysqli_query($conn,"UPDATE student_class_quiz SET `student_quiz_time` = 3600, `grade` = '".$score." out of ".($x-1)."' WHERE student_id = '$session_id' and class_quiz_id = '$class_quiz_id'")or die(mysqli_error());
		?>
		<script>
			  window.location = 'student_quiz_list.php<?php echo '?id='.$get_id; ?>'; 
		</script>
		<?php
	}
}
?>
<br />
<?php
/* $sql = mysqli_query($conn,"SELECT * FROM students WHERE stud_id = '".$_SESSION['user_id']."'");
$row = mysqli_fetch_array($sql);
	if(is_null($row['grade']) AND $row['time-left'] == 3600){ */
?>
<!--	<a href="?test=ok">Take the test now</a> -->
<?php
/* 	} else if(is_null($row['grade']) AND $row['time-left'] < 3600 AND $row['time-left'] > 0){ */
?>
<!--	<a href="?test=ok">Continue your test</a> -->
<?php
/* 	} else if(!is_null($row['grade'])){
		$sqlg = mysqli_query($conn,"SELECT * FROM groupcode WHERE course_code = '".$row['course_code']."'");
		$rowg = mysqli_fetch_array($sqlg);
		echo "You have already taken <b>".$sqlg['course_title']."</b> - <b>".$sqlg['course_code']."</b> test.";
	}
	if($row['grade']!=''){
		mysqli_query($conn,"UPDATE students SET `time-left` = 3600 WHERE stud_id = '".$_SESSION['user_id']."'");
		echo "<br />Your Grade for this Test is :  <b>".$row['grade']."</b>";		
	}
} */
?>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
							
	
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