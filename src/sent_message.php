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
								<li><a href="#"><b>Sent Messages</b></a><span class="divider">/</span></li>
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
  								
										<ul class="nav nav-pills">
										<li class="">
										<a href="teacher_message.php"><i class="icon-envelope-alt"></i>inbox</a>
										</li>
										<li class="active">
										<a href="sent_message.php"><i class="icon-envelope-alt"></i>Sent messages</a>
										</li>
										</ul>
									
								<?php
								 $query_announcement = mysqli_query($conn,"select * from message
																	where  sender_id = '$session_id'  order by date_sended DESC
																	")or die(mysqli_error());					
								 $count_my_message = mysqli_num_rows($query_announcement);
								 if ($count_my_message != '0'){								 
								 while($row = mysqli_fetch_array($query_announcement)){
								 $id = $row['message_id'];
								 // Always try to fetch teacher name for recipient
								 $sent_to = '';
								 $res = mysqli_query($conn, "SELECT firstname, lastname FROM teacher WHERE teacher_id = '{$row['reciever_id']}'");
								 if ($res && mysqli_num_rows($res) > 0) {
									 $teacher = mysqli_fetch_assoc($res);
									 $sent_to = htmlspecialchars($teacher['firstname'] . ' ' . $teacher['lastname']);
								 } else {
									 $sent_to = htmlspecialchars($row['reciever_name']);
								 }
								 ?>
											<div class="post"  id="del<?php echo $id; ?>">
											<?php echo $row['content']; ?>
													<hr>
											Sent to: <strong><?php echo $sent_to; ?></strong>
											<i class="icon-calendar"></i> <?php echo date('M d, Y h:i A', strtotime($row['date_sended'])); ?>
													<div class="pull-right">
													<a class="btn btn-link"  href="#<?php echo $id; ?>" data-toggle="modal" ><i class="icon-remove"></i> Remove </a>
													<?php include("remove_sent_message_modal.php"); ?>
													</div>
											</div>
								<?php }}else{ ?>
								<div class="alert alert-info"><i class="icon-info-sign"></i> No Message in your Sent Items</div>
								<?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
					
<script type="text/javascript">
	$(document).ready( function() {

		
		$('.remove').click( function() {
		
		var id = $(this).attr("id");
			$.ajax({
			type: "POST",
			url: "remove_sent_message.php",
			data: ({id: id}),
			cache: false,
			success: function(html){
			$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
			$('#'+id).modal('hide');
			$.jGrowl("Your Sent message is Successfully Deleted", { header: 'Data Delete' });
		
			}
			}); 
			
			return false;
		});				
	});

</script>
	

                </div>
				<?php include('create_message.php') ?>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>