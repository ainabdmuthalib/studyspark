<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body id="class_div">
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_sidebar.php'); ?>
                <div class="span6" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
					     <ul class="breadcrumb">
								<?php
								$school_year_query = mysqli_query($conn,"SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error()); 
								$school_year_query_row = mysqli_fetch_array($school_year_query);
								$school_year = $school_year_query_row['school_year'];
								?>
								<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
								<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a></li>
						</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div class="block">
								<div class="navbar navbar-inner block-header">
									<div id="count_class" class="muted pull-right"></div>
								</div>
                            <div class="block-content collapse in">
                                <div class="span12">
										<?php include('teacher_class.php'); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                    
                    <style>
                    /* Center class images */
                    #da-thumbs {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        align-items: flex-start;
                        gap: 20px;
                        padding: 0;
                        margin: 0;
                        list-style: none;
                    }
                    
                    #da-thumbs li {
                        text-align: center;
                        margin: 0;
                        padding: 0;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }
                    
                    #da-thumbs img {
                        display: block;
                        margin: 0 auto;
                    }
                    
                    #da-thumbs .class,
                    #da-thumbs .subject {
                        margin: 5px 0;
                        text-align: center;
                    }
                    </style>
                    
									<script type="text/javascript">
									$(document).ready( function() {
										// Use event delegation to handle dynamically created elements
										$(document).on('click', '.remove', function() {
										var id = $(this).attr("id");
										console.log("Attempting to delete class with id:", id); // Debug output
											
											// Hide the modal first
											$('#'+id).modal('hide');
											
											$.ajax({
											type: "POST",
											url: "delete_class.php",
											data: ({id: id}),
											cache: false,
											success: function(html){
											console.log("Delete success for id:", id); // Debug output
											$("#del"+id).fadeOut('slow', function(){ $(this).remove();}); 
											$.jGrowl("Your Class is Successfully Deleted", { header: 'Class Delete' });
												},
											error: function(xhr, status, error) {
											console.error("Failed to delete class:", error, xhr.responseText); // Debug output
											alert("Failed to delete class: " + error + "\n" + xhr.responseText);
											}
											}); 	
											return false;
										});				
									});
									</script>
                </div>
				<?php include('teacher_right_sidebar.php') ?>
            </div>
		<?php include('footer.php'); ?>
        </div>
		<?php include('script.php'); ?>
    </body>
</html>