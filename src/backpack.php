<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('backpack_sidebar.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->	
									<ul class="breadcrumb">
										<?php
										$school_year_query = mysqli_query($conn,"select * from school_year order by school_year_id DESC LIMIT 1")or die(mysqli_error());
										$school_year_query_row = mysqli_fetch_array($school_year_query);
										$school_year = $school_year_query_row['school_year'];
										?>
											<li><a href="#"><b>My Class</b></a><span class="divider">/</span></li>
										<li><a href="#">Semester <?php echo $school_year_query_row['school_year']; ?></a><span class="divider">/</span></li>
										<li><a href="#"><b>Backpack</b></a></li>
									</ul>
						 <!-- end breadcrumb -->
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div id="" class="muted pull-right"></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <!-- Display success/error messages -->
                                    <?php if(isset($_SESSION['copy_message'])): ?>
                                        <div class="alert alert-success">
                                            <i class="icon-ok-sign"></i> <?php echo $_SESSION['copy_message']; ?>
                                        </div>
                                        <?php unset($_SESSION['copy_message']); ?>
                                    <?php endif; ?>
                                    
                                    <?php if(isset($_SESSION['copy_error'])): ?>
                                        <div class="alert alert-warning">
                                            <i class="icon-warning-sign"></i> <?php echo $_SESSION['copy_error']; ?>
                                        </div>
                                        <?php unset($_SESSION['copy_error']); ?>
                                    <?php endif; ?>
                                    
							<div class="pull-right">
								Check All <input type="checkbox"  name="selectAll" id="checkAll" />
								<script>
								$("#checkAll").click(function () {
									$('input:checkbox').not(this).prop('checked', this.checked);
								});
								</script>					
							</div>
								<?php
								$query_backpack = mysqli_query($conn,"select * FROM student_backpack where student_id = '$session_id'  order by fdatein DESC ")or die(mysqli_error());
								$num_row = mysqli_num_rows($query_backpack);
								if ($num_row > 0){
								?>
									<form action="delete_backpack.php" method="post">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="">
									<a data-toggle="modal" href="#backup_delete" id="delete"  class="btn btn-danger" name=""><i class="icon-trash icon-large"></i></a>
									<?php include('modal_backpack_delete.php'); ?>
										<thead>
										        <tr>
												<th></th>
												<th>Date Upload</th>
												<th>File Name</th>
												<th>Description</th>
												<th></th>
												</tr>
										</thead>
										<tbody>
                              		<?php
										$query = mysqli_query($conn,"select * FROM student_backpack where student_id = '$session_id'  order by fdatein DESC ")or die(mysqli_error());
										while($row = mysqli_fetch_array($query)){
										$id  = $row['file_id'];
									?>                              
										<tr id="del<?php echo $id; ?>">
										<td width="30">
											<input id="" class="" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
										</td>
										 <td><?php echo $row['fdatein']; ?></td>
                                         <td><a href="<?php echo $row['floc']; ?>" target="_blank"><?php  echo $row['fname']; ?></a></td>
                                         <td><?php echo $row['fdesc']; ?></td>                                      
                                         <td width="30">
                                            <a class="btn btn-success" href="<?php echo $row['floc']; ?>" target="_blank" download>
                                                <i class="icon-download"></i>
                                            </a>
                                         </td>                                      
										</tr>
									<?php } ?>
										</tbody>
									</table>
									</form>
									<?php }else{ ?>
									<div class="alert alert-info"><i class="icon-info-sign"></i> No Files Inside Your Backpack.</div>
									<?php } ?>
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