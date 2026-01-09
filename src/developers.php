<?php include('header_dashboard.php'); ?>
    <body id="class_div">
		<?php include('navbar_about.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
								<div class="navbar navbar-inner block-header">
									<div id="" class="muted pull-left"><a href="index.php"><i class="icon-arrow-left"></i> Back</a></div>
								</div>
                            <div class="block-content collapse in">
                                <center>
                                <img id="developers" src="admin/images/ain.png">
                                <h1>Ain Binti Abd Muthalib</h1>
                                <p>I'm a passionate developer with a love for creating web applications and learning new technologies.</p>

                                <div class="buttons">
                                    <a href="https://github.com/ainabdmuthalib" class="button github" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.58 2 12.26c0 4.49 2.87 8.3 6.84 9.64.5.09.68-.22.68-.48 0-.24-.01-.87-.01-1.7-2.78.62-3.37-1.36-3.37-1.36-.45-1.18-1.1-1.5-1.1-1.5-.9-.63.07-.62.07-.62 1 .07 1.53 1.05 1.53 1.05.89 1.56 2.34 1.11 2.91.85.09-.66.35-1.11.63-1.37-2.22-.26-4.56-1.14-4.56-5.07 0-1.12.39-2.03 1.03-2.75-.1-.26-.45-1.3.1-2.7 0 0 .84-.28 2.75 1.05A9.38 9.38 0 0 1 12 6.84c.85.004 1.71.12 2.51.35 1.91-1.33 2.75-1.05 2.75-1.05.55 1.4.2 2.44.1 2.7.64.72 1.03 1.63 1.03 2.75 0 3.94-2.34 4.81-4.57 5.07.36.32.68.94.68 1.9 0 1.37-.01 2.47-.01 2.81 0 .27.18.58.69.48A10.01 10.01 0 0 0 22 12.26C22 6.58 17.52 2 12 2Z" fill="#ffffff"/></svg>
                                        GitHub
                                    </a>
                                    <a href="https://www.linkedin.com/in/ain-muthalib/" class="button linkedin" target="_blank" style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.28c-.97 0-1.75-.79-1.75-1.75s.78-1.75 1.75-1.75 1.75.79 1.75 1.75-.78 1.75-1.75 1.75zm13.5 10.28h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.89v1.23h.04c.4-.75 1.38-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.59v4.72z" fill="#ffffff"/></svg>
                                        Linkedin
                                    </a>
                                </div>
                                </center>
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
<style>
        .profile-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        p {
            color: #666;
            font-size: 16px;
            margin: 10px 0;
        }
        .buttons {
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .button.github {
            background-color: #333;
        }
        .button.linkedin {
            background-color: #0077b5;
        }
        .button:hover {
            opacity: 0.8;
        }
        /* Ensure SVG icons are visible and spaced */
        .button svg {
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            width: 20px;
            height: 20px;
            fill: currentColor;
            /* fallback for explicit color */
        }
        .button.github svg {
            color: #fff;
            fill: #fff;
        }
        .button.linkedin svg {
            color: #fff;
            fill: #fff;
        }
    </style>