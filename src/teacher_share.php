<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('share_sidebar_teacher.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
									<ul class="breadcrumb">
										<?php
										$school_year_query = mysqli_query($conn,"SELECT * FROM school_year ORDER BY school_year_id DESC LIMIT 1") or die(mysqli_error());
										$school_year_query_row = mysqli_fetch_array($school_year_query);
										$school_year = $school_year_query_row['school_year'];
										?>
											<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
										<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
										<li><a href="#"><b>Shared Files</b></a></li>
									</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-right"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<div class="pull-right">
												Check All <input type="checkbox"  name="selectAll" id="checkAll" />
												<script>
												$("#checkAll").click(function () {
													$('input:checkbox').not(this).prop('checked', this.checked);
												});
												</script>					
									</div>
									<form action="delete_shared.php" method="post" id="fileActionForm">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="">
								<a data-toggle="modal" href="#backup_delete" id="move"  class="btn btn-success" name=""><i class="icon-move icon-large"></i> Move</a>
									<?php include('modal_share_delete.php');  ?>
										<thead>
										        <tr>
												<th></th>
												<th>Date Upload</th>
												<th>File Name</th>
												<th>Description</th>
												<th>Shared By</th>
												<th></th>
												</tr>
										</thead>
										<tbody>
                              		<?php
										$query = mysqli_query($conn,"select * FROM teacher_shared
										LEFT JOIN teacher on teacher_shared.teacher_id = teacher.teacher_id
										where shared_teacher_id = '$session_id' 
										order by fdatein DESC")or die(mysqli_error());
										while($row = mysqli_fetch_array($query)){
										$id  = $row['teacher_shared_id'];
									?>                              
										<tr id="del<?php echo $id; ?>">
										<td width="30">
											<input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
										</td>
										 <td><?php echo date('Y-m-d h:i A', strtotime($row['fdatein'])); ?></td>
                                         <td><a href="<?php echo $row['floc']; ?>" target="_blank" style="font-weight:bold; text-decoration:underline;"><?php echo $row['fname']; ?></a></td>
                                         <td><?php echo $row['fdesc']; ?></td>                                      
                                         <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>                                      
                                         <td width="30"><a href="<?php echo $row['floc']; ?>" download="<?php echo $row['fname']; ?>"><i class="icon-download icon-large"></i></a></td>                                      
										</tr>
									<?php } ?>
										</tbody>
									</table>
									</form>
									
									<script type="text/javascript">
									$(document).ready(function(){
										// Force download functionality for shared files
										$('a[download]').click(function(e) {
											e.preventDefault();
											var link = document.createElement('a');
											link.href = $(this).attr('href');
											link.download = $(this).attr('download');
											link.target = '_blank';
											document.body.appendChild(link);
											link.click();
											document.body.removeChild(link);
										});
										
										// Prevent move button from submitting the form
										$('#move').click(function(e) {
											e.preventDefault();
											var checkedBoxes = $('input[name="selector[]"]:checked');
											if (checkedBoxes.length === 0) {
												alert('Please select at least one file to move.');
												return false;
											}
											$('#backup_delete').modal('show');
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