<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_message_sidebar.php'); ?>
                <div class="span6" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
					     <ul class="breadcrumb">
								<?php
								$school_year_query = mysqli_query($conn,"SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>
								<li><a href="#">Message</a><span class="divider">/</span></li>
								<li><a href="#"><b>Inbox</b></a><span class="divider">/</span></li>
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
                                <?php if($count_my_message > 0) { ?>
                                <div class="alert alert-info" id="unread-notification">
                                    <i class="icon-info-sign"></i> You have <strong><?php echo $count_my_message; ?></strong> unread message(s) in your inbox.
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                                <?php } ?>
								<form action="read_message_teacher.php" method="post">
  								
										<ul class="nav nav-pills">
										<li class="active">
										<a href="teacher_message.php"><i class="icon-envelope-alt"></i>inbox</a>
										</li>
										<li class="">
										<a href="sent_message.php"><i class="icon-envelope-alt"></i>Sent messages</a>
										</li>
										</ul>
										
									<?php
								 function getUserName($conn, $user_id) {
									// Try to find in teacher table
									$res = mysqli_query($conn, "SELECT firstname, lastname FROM teacher WHERE teacher_id = '$user_id'");
									if ($res && mysqli_num_rows($res) > 0) {
										$row = mysqli_fetch_assoc($res);
										return htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
									}
									// Try to find in student table
									$res = mysqli_query($conn, "SELECT firstname, lastname FROM student WHERE student_id = '$user_id'");
									if ($res && mysqli_num_rows($res) > 0) {
										$row = mysqli_fetch_assoc($res);
										return htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
									}
									return "Unknown";
								}
							 $query_announcement = mysqli_query($conn,"select * from message
																	LEFT JOIN teacher ON teacher.teacher_id = message.sender_id
																	where  message.reciever_id = '$session_id' order by date_sended DESC
																	")or die(mysqli_error());
								$count_my_message = mysqli_num_rows($query_announcement);	
								if ($count_my_message != '0'){
								 while($row = mysqli_fetch_array($query_announcement)){
								 $id = $row['message_id'];
								 $status = $row['message_status'];
								 $send_by = getUserName($conn, $row['sender_id']);
								 // Set variables for reply modal
								 $sender_id = $row['sender_id'];
								 $reciever_name = getUserName($conn, $session_id); // current user
								 $sender_name = getUserName($conn, $row['sender_id']); // original sender
								 ?>
											<div class="post <?php echo ($status != 'read') ? 'unread-message' : ''; ?>" id="del<?php echo $id; ?>" data-message-id="<?php echo $id; ?>">
										
											<div class="message_content">
											<?php echo $row['content']; ?>
											</div>
											
											<?php if ($status != 'read') { ?>
											<div class="unread-indicator">
												<span class="badge badge-important">New</span>
											</div>
											<?php } ?>
											
													<hr>
											Send by: <strong><?php echo $send_by; ?></strong>
											<i class="icon-calendar"></i> <?php echo date('M d, Y h:i A', strtotime($row['date_sended'])); ?>
													<div class="pull-right">
														<a class="btn btn-link"  href="#reply<?php echo $id; ?>" data-toggle="modal" ><i class="icon-reply"></i> Reply </a>
													</div>
													<div class="pull-right">
													<a class="btn btn-link"  href="#<?php echo $id; ?>" data-toggle="modal" ><i class="icon-remove"></i> Remove </a>
													<?php include("remove_inbox_message_modal.php"); ?>
													<?php include("reply_inbox_message_modal.php"); ?>
													</div>
											</div>
											
								<?php }}else{ ?>
								<div class="alert alert-info"><i class="icon-info-sign"></i> No Inbox  Messages</div>
								<?php } ?>	
								</form>		
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
<style>
.unread-message {
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    padding-left: 15px;
    margin-bottom: 10px;
    position: relative;
}

.unread-message:hover {
    background-color: #e9ecef;
    cursor: pointer;
}

.unread-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
}

.message_content {
    margin-bottom: 10px;
}

.post {
    transition: all 0.3s ease;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
}

.post:hover {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
</style>

<script type="text/javascript">
	$(document).ready( function() {
		// Auto-read functionality when clicking on unread messages
		$('.unread-message').click(function() {
			var messageId = $(this).data('message-id');
			var messageElement = $(this);
			
			// Mark message as read via AJAX
			$.ajax({
				type: "POST",
				url: "mark_message_read.php",
				data: {message_id: messageId},
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						// Remove unread styling
						messageElement.removeClass('unread-message');
						messageElement.find('.unread-indicator').fadeOut();
						
						// Update message count in sidebar
						updateMessageCount();
						
						// Update notification alert
						updateNotificationAlert();
						
						// Show success notification
						$.jGrowl("Message marked as read", { header: 'Success' });
					} else {
						$.jGrowl("Failed to mark message as read", { header: 'Error' });
					}
				},
				error: function() {
					$.jGrowl("Error marking message as read", { header: 'Error' });
				}
			});
		});
		
		// Remove message functionality
		$('.remove').click( function() {
		var id = $(this).attr("id");
			$.ajax({
			type: "POST",
			url: "remove_inbox_message.php",
			data: ({id: id}),
			cache: false,
			success: function(html){
			$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
			$('#'+id).modal('hide');
			$.jGrowl("Your Sent message is Successfully Deleted", { header: 'Data Delete' });	
			updateMessageCount();
			}
			}); 		
			return false;
		});
		
		// Function to update message count in sidebar
		function updateMessageCount() {
			$.ajax({
				type: "POST",
				url: "get_unread_message_count.php",
				data: {user_id: '<?php echo $session_id; ?>'},
				dataType: 'json',
				success: function(response) {
					if (response.count > 0) {
						$('.message-badge').text(response.count);
						$('.message-badge').show();
					} else {
						$('.message-badge').hide();
					}
				}
			});
		}
		
		// Function to update notification alert
		function updateNotificationAlert() {
			$.ajax({
				type: "POST",
				url: "get_unread_message_count.php",
				data: {user_id: '<?php echo $session_id; ?>'},
				dataType: 'json',
				success: function(response) {
					var alertElement = $('#unread-notification');
					if (response.count > 0) {
						if (alertElement.length === 0) {
							// Create new alert if it doesn't exist
							var newAlert = '<div class="alert alert-info" id="unread-notification"><i class="icon-info-sign"></i> You have <strong>' + response.count + '</strong> unread message(s) in your inbox.<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
							$('.span12').prepend(newAlert);
						} else {
							// Update existing alert
							alertElement.find('strong').text(response.count);
						}
					} else {
						// Remove alert if no unread messages
						alertElement.fadeOut();
					}
				}
			});
		}
		
		// Check for new messages every 30 seconds
		setInterval(function() {
			updateMessageCount();
		}, 30000);
		
		// Request notification permission
		if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
			Notification.requestPermission();
		}
		
		// Function to show desktop notification
		function showNotification(title, body) {
			if (Notification.permission === 'granted') {
				var notification = new Notification(title, {
					body: body,
					icon: '/admin/images/ain.PNG',
					badge: '/admin/images/ain.PNG'
				});
				
				// Auto close notification after 5 seconds
				setTimeout(function() {
					notification.close();
				}, 5000);
				
				// Play notification sound if available
				var audio = new Audio('/notification.mp3');
				audio.play().catch(function(error) {
					console.log('Audio play failed:', error);
				});
			}
		}
		
		// Check for new messages and show notification
		var lastMessageCount = <?php echo $count_message; ?>;
		function checkNewMessages() {
			$.ajax({
				type: "POST",
				url: "get_unread_message_count.php",
				data: {user_id: '<?php echo $session_id; ?>'},
				dataType: 'json',
				success: function(response) {
					if (response.count > lastMessageCount) {
						var newMessages = response.count - lastMessageCount;
						showNotification('New Messages', 'You have ' + newMessages + ' new message(s) in your inbox!');
						lastMessageCount = response.count;
					}
				}
			});
		}
		
		// Check for new messages every 60 seconds
		setInterval(checkNewMessages, 60000);
	});
</script>
			<script>
/* 			jQuery(document).ready(function(){
			jQuery("#reply").submit(function(e){
					e.preventDefault();
					var id = $('.reply').attr("id");
					var _this = $(e.target);
					var formData = jQuery(this).serialize();
					$.ajax({
						type: "POST",
						url: "reply.php",
						data: formData,
						success: function(html){
						$.jGrowl("Message Successfully Sent", { header: 'Message Sent' });
						$('#reply'+id).modal('hide');
						}
						
					});
					return false;
				});
			}); */
			</script>

                </div>
				<?php include('create_message.php') ?>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>