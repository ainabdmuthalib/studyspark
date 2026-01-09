<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('change_password_sidebar_student.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
					     <ul class="breadcrumb">
								<?php
								$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>
								<li><a href="#"><b>Change Password</b></a><span class="divider">/</span></li>
								<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-left"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
  								<div class="alert alert-info"><i class="icon-info-sign"></i> Please Fill in required details</div>
								<?php
								$query = mysqli_query($conn,"select * from student where student_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
								?>								
										
								    <form  method="post" id="change_password" class="form-horizontal">
										<div class="control-group">
											<label class="control-label" for="inputEmail">Current Password</label>
											<div class="controls">
											<input type="hidden" id="password" name="password" value="<?php echo $row['password']; ?>"  placeholder="Current Password">
											<div class="input-append">
												<input type="password" id="current_password" name="current_password"  placeholder="Current Password">
												<button class="btn" type="button" onclick="togglePassword('current_password')"><i class="icon-eye-open"></i></button>
											</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputPassword">New Password</label>
											<div class="controls">
											<div class="input-append">
												<input type="password" id="new_password" name="new_password" placeholder="New Password">
												<button class="btn" type="button" onclick="togglePassword('new_password')"><i class="icon-eye-open"></i></button>
											</div>
											<!-- Password Requirements -->
											<div class="password-requirements" style="margin-top: 10px; font-size: 12px;">
												<div class="requirement" id="req-length">
													<span class="requirement-icon" id="icon-length">❌</span> Minimum 8 characters
												</div>
												<div class="requirement" id="req-case">
													<span class="requirement-icon" id="icon-case">❌</span> Must include uppercase and lowercase letters
												</div>
												<div class="requirement" id="req-special">
													<span class="requirement-icon" id="icon-special">❌</span> Must include numbers or special characters
												</div>
											</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="inputPassword">Re-type Password</label>
											<div class="controls">
											<div class="input-append">
												<input type="password" id="retype_password" name="retype_password" placeholder="Re-type Password">
												<button class="btn" type="button" onclick="togglePassword('retype_password')"><i class="icon-eye-open"></i></button>
											</div>
											<div class="password-match" style="margin-top: 5px; font-size: 12px;">
												<span class="match-icon" id="match-icon">❌</span> <span id="match-text">Passwords do not match</span>
											</div>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
											<button type="submit" class="btn btn-info" id="submit-btn" disabled><i class="icon-save"></i> Save</button>
											</div>
										</div>
									</form>
									
												<script>
			jQuery(document).ready(function(){
				
				// Password toggle function
				window.togglePassword = function(fieldId) {
					var field = document.getElementById(fieldId);
					var button = field.nextElementSibling;
					var icon = button.querySelector('i');
					
					if (field.type === 'password') {
						field.type = 'text';
						icon.className = 'icon-eye-close';
					} else {
						field.type = 'password';
						icon.className = 'icon-eye-open';
					}
				};
				
				// Password validation function
				function validatePassword(password) {
					var requirements = {
						length: password.length >= 8,
						case: /[a-z]/.test(password) && /[A-Z]/.test(password),
						special: /[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)
					};
					
					// Update requirement indicators
					updateRequirementIcon('length', requirements.length);
					updateRequirementIcon('case', requirements.case);
					updateRequirementIcon('special', requirements.special);
					
					return requirements.length && requirements.case && requirements.special;
				}
				
				// Update requirement icon
				function updateRequirementIcon(req, isValid) {
					var icon = document.getElementById('icon-' + req);
					var element = document.getElementById('req-' + req);
					
					if (isValid) {
						icon.textContent = '✅';
						element.style.color = '#5cb85c';
					} else {
						icon.textContent = '❌';
						element.style.color = '#d9534f';
					}
				}
				
				// Check password match
				function checkPasswordMatch() {
					var newPassword = jQuery('#new_password').val();
					var retypePassword = jQuery('#retype_password').val();
					var matchIcon = document.getElementById('match-icon');
					var matchText = document.getElementById('match-text');
					
					if (retypePassword === '') {
						matchIcon.textContent = '❌';
						matchText.textContent = 'Passwords do not match';
						matchText.style.color = '#d9534f';
						return false;
					} else if (newPassword === retypePassword) {
						matchIcon.textContent = '✅';
						matchText.textContent = 'Passwords match';
						matchText.style.color = '#5cb85c';
						return true;
					} else {
						matchIcon.textContent = '❌';
						matchText.textContent = 'Passwords do not match';
						matchText.style.color = '#d9534f';
						return false;
					}
				}
				
				// Enable/disable submit button
				function updateSubmitButton() {
					var newPassword = jQuery('#new_password').val();
					var retypePassword = jQuery('#retype_password').val();
					var isPasswordValid = validatePassword(newPassword);
					var isPasswordMatch = checkPasswordMatch();
					
					if (isPasswordValid && isPasswordMatch && newPassword !== '' && retypePassword !== '') {
						jQuery('#submit-btn').prop('disabled', false);
					} else {
						jQuery('#submit-btn').prop('disabled', true);
					}
				}
				
				// Event listeners
				jQuery('#new_password').on('input', function() {
					validatePassword(jQuery(this).val());
					checkPasswordMatch();
					updateSubmitButton();
				});
				
				jQuery('#retype_password').on('input', function() {
					checkPasswordMatch();
					updateSubmitButton();
				});
				
				jQuery('#current_password').on('input', function() {
					updateSubmitButton();
				});
				
			jQuery("#change_password").submit(function(e){
					e.preventDefault();
						
						var password = jQuery('#password').val();
						var current_password = jQuery('#current_password').val();
						var new_password = jQuery('#new_password').val();
						var retype_password = jQuery('#retype_password').val();
						
						// Validate current password
						if (password != current_password)
						{
						$.jGrowl("Password does not match with your current password  ", { header: 'Change Password Failed' });
						return;
						}
						
						// Validate new password requirements
						if (!validatePassword(new_password)) {
							$.jGrowl("New password does not meet the requirements", { header: 'Change Password Failed' });
							return;
						}
						
						// Validate password match
						if (new_password != retype_password){
						$.jGrowl("Password does not match with your new password  ", { header: 'Change Password Failed' });
						return;
						}
						
						// If all validations pass
						if ((password == current_password) && (new_password == retype_password) && validatePassword(new_password)){
					var formData = jQuery(this).serialize();
					$.ajax({
						type: "POST",
						url: "update_password_student.php",
						data: formData,
						success: function(html){
					
						$.jGrowl("Your password is successfully change", { header: 'Change Password Success' });
						var delay = 2000;
							setTimeout(function(){ window.location = 'dashboard_student.php'  }, delay);  
						
						}
						
						
					});
			
					}
				});
			});
			</script>
										
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