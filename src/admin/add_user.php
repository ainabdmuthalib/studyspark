   <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Add Admin</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form method="post" id="add_user_form">
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="firstname" id="firstname" type="text" placeholder = "Firstname" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="lastname" id="lastname" type="text" placeholder = "Lastname" required>
                                          </div>
                                        </div>
										
											<div class="control-group">
                                          <div class="controls">
                                            <input class="input focused" name="username" id="username" type="text" placeholder = "Username" required>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <div class="controls">
                                            <div style="position:relative; display:flex; align-items:center;">
                                              <input class="input focused" name="password" id="password" type="password" placeholder="Password" required >
                                              <button class="btn" type="button" onclick="togglePassword('password')" ><i class="icon-eye-open"></i></button>
                                            </div>
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
                                          <div class="controls">
												<button name="save" class="btn btn-info" id="submit-btn" disabled><i class="icon-plus-sign icon-large"></i></button>

                                          </div>
                                        </div>
                                </form>
								<script>
// Password toggle function
function togglePassword(fieldId) {
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
}
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
function updateSubmitButton() {
    var password = document.getElementById('password').value;
    var isPasswordValid = validatePassword(password);
    document.getElementById('submit-btn').disabled = !isPasswordValid;
}
document.getElementById('password').addEventListener('input', updateSubmitButton);
</script>
								</div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
					<?php
if (isset($_POST['save'])){
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

// Server-side password validation
function valid_password($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[0-9]/', $password) && !preg_match('/[^A-Za-z0-9]/', $password)) return false;
    return true;
}

if (!valid_password($password)) {
    echo "<script>alert('Password does not meet requirements!');</script>";
} else {
    $query = mysqli_query($conn,"select * from users where username = '$username' and password = '$password' and firstname = '$firstname' and password = '$password' ")or die(mysqli_error());
    $count = mysqli_num_rows($query);
    if ($count > 0){ ?>
<script>
alert('Data Already Exist');
</script>
<?php
    }else{
        mysqli_query($conn,"insert into users (username,password,firstname,lastname) values('$username','$password','$firstname','$lastname')")or die(mysqli_error());
        mysqli_query($conn,"insert into activity_log (date,username,action) values(NOW(),'$user_username','Add User $username')")or die(mysqli_error());
?>
<script>
window.location = "admin_user.php";
</script>
<?php
    }
}
}
?>