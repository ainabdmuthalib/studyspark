<?php include('header.php'); ?>
  <body id="login">
    <div class="login-container">

        <div class="login-form-container">
      <form id="login_form" class="form-signin" method="post">
            <h3 class="form-signin-heading">
              <i class="icon-lock"></i> Admin Login
            </h3>
            
            <div class="form-group">
              <div class="input-wrapper">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
              </div>
            </div>
            
            <div class="form-group">
              <div class="input-wrapper">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <button type="button" id="togglePassword" class="input-icon password-toggle" tabindex="-1">
                <i class="icon-eye-open" id="eyeIcon"></i>
                </button>
              </div>
            </div>
            
            <button name="login" class="btn btn-primary btn-block" type="submit">
              <i class="icon-signin"></i> Log In
            </button>
          </form>
        </div>
      </div>

    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: 'ProximaNova-Light', Helvetica, Arial, sans-serif;
        background: #357abd;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
      }

      .login-wrapper {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        backdrop-filter: blur(10px);
      }

      .login-header {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
      }

      .logo-section i {
        font-size: 48px;
        margin-bottom: 15px;
        display: block;
        color: #ffffff;
      }

      .logo-section h1 {
        margin: 0 0 5px 0;
        font-size: 28px;
        font-weight: 300;
        color: #ffffff;
      }

      .logo-section p {
        margin: 0;
        font-size: 14px;
        opacity: 0.9;
        color: #ffffff;
      }

      .login-form-container {
        padding: 40px 30px;
      }

      .form-signin-heading {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 20px;
        font-weight: 500;
      }

      .form-signin-heading i {
        color: #4a90e2;
        margin-right: 8px;
      }

      .form-group {
        margin-bottom: 20px;
      }

      .input-wrapper {
        position: relative;
      }

      .input-icon {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #b0b8c1;
        font-size: 18px;
        pointer-events: none;
        z-index: 2;
      }

      .input-icon.left {
        left: 24px;
        right: auto;
        font-size: 18px;
        width: 22px;
        height: 22px;
        line-height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
      }

      .password-toggle {
        right: 16px;
        left: auto;
        background: none;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 0;
        pointer-events: auto;
        color: #b0b8c1;
        font-size: 18px;
        z-index: 3;
        transition: color 0.3s;
      }

      .password-toggle:hover {
        color: #4a90e2;
      }

      .form-control {
        width: 100%;
        padding: 14px 44px 14px 72px;
        border: 2px solid #e1e8ed;
        border-radius: 10px;
        font-size: 15px;
        background: #f8f9fa;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
      }

      .form-control:focus {
        border-color: #4a90e2;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.15);
      }

      ::placeholder {
        color: #a0a4ab;
        opacity: 1;
      }

      .btn-primary {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
        border: none;
        padding: 15px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 500;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
      }

      .btn-primary:hover {
        background: linear-gradient(135deg, #357abd 0%, #2c5aa0 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
      }

      .btn-primary:active {
        transform: translateY(0);
      }

      .btn-primary i {
        margin-right: 8px;
      }

      .login-footer {
        background: #f8f9fa;
        padding: 20px 30px;
        text-align: center;
        border-top: 1px solid #e1e8ed;
      }

      .login-footer p {
        margin: 0;
        color: #666;
        font-size: 12px;
      }

      /* Responsive design */
      @media (max-width: 480px) {
        .login-container {
          padding: 10px;
        }
        
        .login-wrapper {
          border-radius: 15px;
        }
        
        .login-header {
          padding: 30px 20px;
        }
        
        .login-form-container {
          padding: 30px 20px;
        }
        
        .logo-section h1 {
          font-size: 24px;
        }
      }

      /* Loading animation */
      .btn-primary.loading {
        pointer-events: none;
        opacity: 0.8;
      }

      .btn-primary.loading i {
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    </style>

				<script>
			jQuery(document).ready(function(){
			jQuery("#login_form").submit(function(e){
					e.preventDefault();
          
          // Add loading state
          var submitBtn = $(this).find('button[type="submit"]');
          submitBtn.addClass('loading').html('<i class="icon-refresh"></i> Logging In...');
          
					var formData = jQuery(this).serialize();
					$.ajax({
						type: "POST",
						url: "login.php",
						data: formData,
						success: function(html){
              if(html=='true') {
                $.jGrowl("Welcome to Study Spark", { 
                  header: 'Access Granted',
                  theme: 'success'
                });
						var delay = 2000;
                setTimeout(function(){ 
                  window.location = 'dashboard.php'  
                }, delay);  
              } else {
                $.jGrowl("Please check your username and password", { 
                  header: 'Login Failed',
                  theme: 'error'
                });
              }
            },
            error: function() {
              $.jGrowl("Connection error. Please try again.", { 
                header: 'Error',
                theme: 'error'
              });
            },
            complete: function() {
              // Remove loading state
              submitBtn.removeClass('loading').html('<i class="icon-signin"></i> Log In');
            }
					});
					return false;
				});

			// Password toggle
			$('#togglePassword').on('click', function() {
				var passwordInput = $('#password');
				var eyeIcon = $('#eyeIcon');
				var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
				passwordInput.attr('type', type);
				eyeIcon.toggleClass('icon-eye-open icon-eye-close');
			});

        // Add focus effects
        $('.form-control').on('focus', function() {
          $(this).parent().find('.input-icon').css('color', '#4a90e2');
        }).on('blur', function() {
          $(this).parent().find('.input-icon').css('color', '#999');
        });
			});
			</script>
  </body>
</html>