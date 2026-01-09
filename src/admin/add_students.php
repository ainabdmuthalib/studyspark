   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Student</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form id="add_student" method="post">
								
								        <div class="control-group">
                                   
                                          <div class="controls">
                                            <select  name="class_id" class="" required>
                                             	<option></option>
											<?php
											$cys_query = mysqli_query($conn,"select * from class order by class_name");
											while($cys_row = mysqli_fetch_array($cys_query)){
											
											?>
											<option value="<?php echo $cys_row['class_id']; ?>"><?php echo $cys_row['class_name']; ?></option>
											<?php } ?>
                                            </select>
                                          </div>
                                        </div>
								
										<div class="control-group">
                                          <div class="controls">
                                            <input name="un" class="input focused" id="matricNumberInput" type="text" placeholder = "Matric Number" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input name="fn" class="input focused" id="firstNameInput" type="text" placeholder = "First Name" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input name="ln" class="input focused" id="lastNameInput" type="text" placeholder = "Last Name" required>
                                          </div>
                                        </div>
								
										<div class="control-group">
                                          <div class="controls">
                                            <div class="input-append">
                                              <input name="password" class="input focused" id="passwordInput" type="password" placeholder="Password" required autocomplete="new-password">
                                              <button class="btn" type="button" tabindex="-1" onclick="togglePassword('passwordInput', this)"><i class="icon-eye-open"></i></button>
                                            </div>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <div class="controls">
                                            <div class="input-append">
                                              <input name="retype_password" class="input focused" id="retypePasswordInput" type="password" placeholder="Retype Password" required autocomplete="new-password">
                                              <button class="btn" type="button" tabindex="-1" onclick="togglePassword('retypePasswordInput', this)"><i class="icon-eye-open"></i></button>
                                            </div>
                                          </div>
                                        </div>
										<div id="passwordRequirements" style="margin-bottom:10px;">
										  <small>Password must have:
											<ul style="margin-bottom:0;">
											  <li id="pw-length" style="color:#a94442;">At least 8 characters</li>
											  <li id="pw-case" style="color:#a94442;">Uppercase & lowercase letter</li>
											  <li id="pw-num" style="color:#a94442;">Number or special character</li>
											  <li id="pw-match" style="color:#a94442;">Passwords match</li>
											</ul>
										  </small>
										</div>
										
											<div class="control-group">
                                          <div class="controls">
												<button name="save" id="addStudentBtn" class="btn btn-info" disabled><i class="icon-plus-sign icon-large"></i> Add Student</button>

                                          </div>
                                        </div>
                                </form>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
			<script>
			function togglePassword(inputId, btn) {
			  var input = document.getElementById(inputId);
			  var icon = btn.querySelector('i');
			  if (input.type === 'password') {
				input.type = 'text';
				icon.className = 'icon-eye-close';
			  } else {
				input.type = 'password';
				icon.className = 'icon-eye-open';
			  }
			}

			function validatePasswordFields() {
			  var pw = document.getElementById('passwordInput').value;
			  var repw = document.getElementById('retypePasswordInput').value;
			  var valid = true;

			  // Requirement checks
			  var length = pw.length >= 8;
			  var caseCheck = /[a-z]/.test(pw) && /[A-Z]/.test(pw);
			  var numCheck = /[0-9]/.test(pw) || /[^A-Za-z0-9]/.test(pw);
			  var match = pw === repw && pw.length > 0;

			  document.getElementById('pw-length').style.color = length ? '#3c763d' : '#a94442';
			  document.getElementById('pw-case').style.color = caseCheck ? '#3c763d' : '#a94442';
			  document.getElementById('pw-num').style.color = numCheck ? '#3c763d' : '#a94442';
			  document.getElementById('pw-match').style.color = match ? '#3c763d' : '#a94442';

			  valid = length && caseCheck && numCheck && match;
			  document.getElementById('addStudentBtn').disabled = !valid;
			}

			document.getElementById('passwordInput').addEventListener('input', validatePasswordFields);
			document.getElementById('retypePasswordInput').addEventListener('input', validatePasswordFields);

			jQuery(document).ready(function($){
				$("#add_student").submit(function(e){
					e.preventDefault();
					var _this = $(e.target);
					var formData = $(this).serialize();
					$.ajax({
						type: "POST",
						url: "save_student.php",
						data: formData,
						dataType: "json",
						success: function(response){
							if (response.success) {
								$.jGrowl("Student Successfully  Added", { header: 'Student Added' });
								$('#studentTableDiv').load('student_table.php', function(response){
									$("#studentTableDiv").html(response);
									$('#example').dataTable( {
										"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
										"sPaginationType": "bootstrap",
										"oLanguage": {
											"sLengthMenu": "_MENU_ records per page"
										}
									} );
									_this.find(":input").val('');
									_this.find('select option').attr('selected',false);
									_this.find('select option:first').attr('selected',true);
									validatePasswordFields();
								});
							} else {
								alert("Error: " + response.error);
							}
						},
						error: function(xhr, status, error){
							alert("AJAX error: " + error + "\nResponse: " + xhr.responseText);
						}
					});
				});
				validatePasswordFields();
			});
			</script>		
