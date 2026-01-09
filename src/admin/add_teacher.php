   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Lecturer</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form id="add_teacher" method="post">
								<!--
										<label>Photo:</label>
										<div class="control-group">
                                          <div class="controls">
                                               <input class="input-file uniform_on" id="fileInput" type="file" required>
                                          </div>
                                        </div>
									-->	
										
										  <div class="control-group">
											<label>Faculty </label>
                                          <div class="controls">
                                            <select name="department"  class="" required>
                                             	<option></option>
											<?php
											$query = mysqli_query($conn,"select * from department order by department_name");
											while($row = mysqli_fetch_array($query)){
											
											?>
											<option value="<?php echo $row['department_id']; ?>"><?php echo $row['department_name']; ?></option>
											<?php } ?>
                                            </select>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="username" id="teacherUsernameInput" type="text" placeholder="Username" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="firstname" id="teacherFirstNameInput" type="text" placeholder="First Name" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="lastname" id="teacherLastNameInput" type="text" placeholder="Last Name" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <div class="input-append">
                                              <input name="password" class="input focused" id="teacherPasswordInput" type="password" placeholder="Password" required autocomplete="new-password">
                                              <button class="btn" type="button" tabindex="-1" onclick="togglePassword('teacherPasswordInput', this)"><i class="icon-eye-open"></i></button>
                                            </div>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <div class="input-append">
                                              <input name="retype_password" class="input focused" id="teacherRetypePasswordInput" type="password" placeholder="Retype Password" required autocomplete="new-password">
                                              <button class="btn" type="button" tabindex="-1" onclick="togglePassword('teacherRetypePasswordInput', this)"><i class="icon-eye-open"></i></button>
                                            </div>
                                          </div>
                                        </div>
										
										<div id="teacherPasswordRequirements" style="margin-bottom:10px;">
										  <small>Password must have:
											<ul style="margin-bottom:0;">
											  <li id="tpw-length" style="color:#a94442;">At least 8 characters</li>
											  <li id="tpw-case" style="color:#a94442;">Uppercase & lowercase letter</li>
											  <li id="tpw-num" style="color:#a94442;">Number or special character</li>
											  <li id="tpw-match" style="color:#a94442;">Passwords match</li>
											</ul>
										  </small>
										</div>
										
										<div class="control-group">
                                          <div class="controls">
												<button name="save" id="addTeacherBtn" class="btn btn-info" disabled><i class="icon-plus-sign icon-large"></i> Add Lecturer</button>

                                          </div>
                                        </div>
                                </form>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
					
					    <?php
                            // Remove the old PHP form handler
                            ?>
						 
						 
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
function validateTeacherPasswordFields() {
  var pw = document.getElementById('teacherPasswordInput').value;
  var repw = document.getElementById('teacherRetypePasswordInput').value;
  var valid = true;
  var length = pw.length >= 8;
  var caseCheck = /[a-z]/.test(pw) && /[A-Z]/.test(pw);
  var numCheck = /[0-9]/.test(pw) || /[^A-Za-z0-9]/.test(pw);
  var match = pw === repw && pw.length > 0;
  document.getElementById('tpw-length').style.color = length ? '#3c763d' : '#a94442';
  document.getElementById('tpw-case').style.color = caseCheck ? '#3c763d' : '#a94442';
  document.getElementById('tpw-num').style.color = numCheck ? '#3c763d' : '#a94442';
  document.getElementById('tpw-match').style.color = match ? '#3c763d' : '#a94442';
  valid = length && caseCheck && numCheck && match;
  document.getElementById('addTeacherBtn').disabled = !valid;
}
document.getElementById('teacherPasswordInput').addEventListener('input', validateTeacherPasswordFields);
document.getElementById('teacherRetypePasswordInput').addEventListener('input', validateTeacherPasswordFields);
jQuery(document).ready(function($){
  $("#add_teacher").submit(function(e){
    e.preventDefault();
    var _this = $(e.target);
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "save_teacher.php",
      data: formData,
      dataType: "json",
      success: function(response){
        if (response.success) {
          $.jGrowl("Lecturer Successfully Added", { header: 'Lecturer Added' });
          location.reload();
        } else {
          alert("Error: " + response.error);
        }
      },
      error: function(xhr, status, error){
        alert("AJAX error: " + error);
      }
    });
  });
  validateTeacherPasswordFields();
});
</script>
						 
						 