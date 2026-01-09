<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('teacher_sidebar.php'); ?>
                <div class="span6" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->
				
									
					     <ul class="breadcrumb">
						<?php
						$school_year_query = mysqli_query($conn,"select * from school_year order by school_year DESC")or die(mysqli_error());
						$school_year_query_row = mysqli_fetch_array($school_year_query);
						$school_year = $school_year_query_row['school_year'];
						?>
							<li><a href="#">Teachers</a><span class="divider">/</span></li>
							<li><a href="#"><b>Profile</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
					 
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-left"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
										<div class="alert alert-info"><i class="icon-info-sign"></i> About Me</div>
								<?php $query= mysqli_query($conn,"select * from teacher where teacher_id = '$session_id'")or die(mysqli_error());
								$row = mysqli_fetch_array($query);
								$about = $row['about'];
						?>

<div id="aboutMeDisplay" style="display: <?php echo ($about ? 'block' : 'none'); ?>;">
  <div id="aboutMeText"><?php echo nl2br(htmlspecialchars($about)); ?></div>
  <button id="editAboutBtn" class="btn btn-primary" style="margin-top:10px;">Edit</button>
</div>
<div id="aboutMeEdit" style="display: <?php echo ($about ? 'none' : 'block'); ?>;">
  <form id="aboutMeForm">
    <textarea name="about" id="aboutTextarea" class="span12" rows="5"><?php echo htmlspecialchars($about); ?></textarea>
    <button type="submit" class="btn btn-success" style="margin-top:10px;">Save</button>
    <button type="button" id="cancelEditBtn" class="btn btn-default" style="margin-top:10px;">Cancel</button>
  </form>
</div>
<script>
$(function() {
  $('#editAboutBtn').click(function() {
    $('#aboutMeDisplay').hide();
    $('#aboutMeEdit').show();
  });
  $('#cancelEditBtn').click(function() {
    $('#aboutMeEdit').hide();
    $('#aboutMeDisplay').show();
  });
  $('#aboutMeForm').submit(function(e) {
    e.preventDefault();
    var about = $('#aboutTextarea').val();
    $.ajax({
      url: 'update_teacher_about.php',
      type: 'POST',
      data: { about: about },
      success: function(response) {
        $('#aboutMeText').html(about.replace(/\n/g, '<br>'));
        $('#aboutMeEdit').hide();
        $('#aboutMeDisplay').show();
        $.jGrowl('Profile updated!', { header: 'Success' });
      },
      error: function(xhr, status, error) {
        alert('Failed to update: ' + error);
      }
    });
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