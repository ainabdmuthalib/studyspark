			<form id="login_form1" class="form-signin" method="post">
						<h3 class="form-signin-heading"><i class="icon-lock"></i> Log in</h3>
						<style>
						.form-signin input[type="text"],
						.form-signin input[type="password"] {
							height: 40px !important;
							box-sizing: border-box !important;
						}
						.form-signin .input-append .btn {
							height: 40px !important;
							width: 40px !important;
							box-sizing: border-box !important;
						}
						.form-signin .input-append {
							display: flex !important;
							align-items: stretch !important;
						}
						.form-signin .input-append input {
							flex: 1 !important;
						}
						</style>
						<input type="text" class="input-block-level" id="username" name="username" placeholder="Matric Number" required>
						<div class="input-append">
							<input type="password" class="input-block-level" id="password" name="password" placeholder="Password" required>
							<button class="btn" type="button" onclick="toggleLoginPassword()"><i class="icon-eye-open"></i></button>
						</div>
						<button data-placement="right" title="Click Here to Sign In" id="signin" name="login" class="btn btn-info" type="submit"><i class="icon-signin icon-large"></i> Log in</button>
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin').tooltip('show');
															$('#signin').tooltip('hide');
														});
														</script>		
			</form>
						<script>
						// Password toggle function for login form
						function toggleLoginPassword() {
							var passwordField = document.getElementById('password');
							var button = passwordField.nextElementSibling;
							var icon = button.querySelector('i');
							
							if (passwordField.type === 'password') {
								passwordField.type = 'text';
								icon.className = 'icon-eye-close';
							} else {
								passwordField.type = 'password';
								icon.className = 'icon-eye-open';
							}
						}
						
						jQuery(document).ready(function(){
						jQuery("#login_form1").submit(function(e){
								e.preventDefault();
								var formData = jQuery(this).serialize();
								$.ajax({
									type: "POST",
									url: "login.php",
									data: formData,
									success: function(html){
									if(html=='true')
									{
									$.jGrowl("Loading File Please Wait......", { sticky: true });
									$.jGrowl("Welcome to Study Spark", { header: 'Access Granted' });
									var delay = 1000;
									setTimeout(function(){ window.location = 'dasboard_teacher.php'  }, delay);  
									}else if (html == 'true_student'){
										$.jGrowl("Welcome to Study Spark", { header: 'Access Granted' });
										// Start timer session immediately after student login
										$.ajax({
											url: 'start_study_session.php',
											type: 'GET',
											complete: function() {
												var delay = 1000;
												setTimeout(function(){ window.location = 'student_notification.php'  }, delay);  
											}
										});
									}else
									{
									$.jGrowl("Please Check your username and Password", { header: 'Login Failed' });
									}
									}
								});
								return false;
							});
						});
						</script>
			<!-- <div id="button_form" class="form-signin" >
			New to Study Spark
			<hr>
				<h3 class="form-signin-heading"><i class="icon-edit"></i> Sign up</h3>
				<button data-placement="top" title="Sign In as Student" id="signin_student" onclick="window.location='signup_student.php'" id="btn_student" name="login" class="btn btn-info" type="submit">I`m a Student</button>
				<div class="pull-right">
					<button data-placement="top" title="Sign In as Teacher" id="signin_teacher" onclick="window.location='signup_teacher.php'" name="login" class="btn btn-info" type="submit">I`m a Teacher</button>
				</div>
			</div> -->
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin_student').tooltip('show'); $('#signin_student').tooltip('hide');
														});
														</script>	
														<script type="text/javascript">
														$(document).ready(function(){
															$('#signin_teacher').tooltip('show'); $('#signin_teacher').tooltip('hide');
														});
														</script>	