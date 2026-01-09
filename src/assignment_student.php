<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('assignment_link_student.php'); ?>
                <div class="span9" id="content">
                     <div class="row-fluid">
					   
					   <!-- breadcrumb -->
				
										<?php $class_query = mysqli_query($conn,"select * from teacher_class
										LEFT JOIN class ON class.class_id = teacher_class.class_id
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										where teacher_class_id = '$get_id'")or die(mysqli_error());
										$class_row = mysqli_fetch_array($class_query);
										?>
				
					     <ul class="breadcrumb">
							<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
							<li><a href="#">Semester <?php echo $class_row['school_year']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><b>Uploaded Assignments</b></a></li>
						</ul>
						 <!-- end breadcrumb -->
						
						
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
								<?php $query = mysqli_query($conn,"select * FROM assignment where class_id = '$get_id'  order by fdatein DESC")or die(mysqli_error()); 
									  $count  = mysqli_num_rows($query);
								?>
                                <div id="" class="muted pull-right"><span class="badge badge-info"><?php echo $count; ?></span></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<?php
									$query = mysqli_query($conn,"select * FROM assignment where class_id = '$get_id'  order by fdatein DESC")or die(mysqli_error());
									$count = mysqli_num_rows($query);
									if ($count == '0'){?>
									<div class="alert alert-info">No Assignment Currently Uploaded</div>
									<?php
									}else{
								?>
  											<table cellpadding="0" cellspacing="0" border="0" class="table" id="">
						
										<thead>
										        <tr>
												<th>Date Upload</th>
												<th>File Name</th>
												<th>Description</th>
												<th></th>
												</tr>
												
										</thead>
										<tbody>
											
                              		<?php
										$query = mysqli_query($conn,"select * FROM assignment where class_id = '$get_id'  order by fdatein DESC")or die(mysqli_error());
										while($row = mysqli_fetch_array($query)){
										$id  = $row['assignment_id'];
										$floc = $row['floc'];
									?>                              
										<tr>
										 <td><?php 
                                            $fdatein = $row['fdatein'];
                                            echo date('Y-m-d H:i', strtotime($fdatein)); 
                                         ?></td>
                                         <td><?php  echo $row['fname']; ?></td>
                                         <td><?php echo $row['fdesc']; ?></td>                                      
                                         <td width="220">
										 <form id="assign" method="post" action="submit_assignment.php<?php echo '?id='.$get_id ?>&<?php echo 'post_id='.$id ?>">
										 <input type="hidden" name="id" value="<?php echo $id; ?>">
										 <?php
											if ($floc == ""){
											}else{
										 ?>
										  <a data-placement="bottom" title="Preview" id="<?php echo $id; ?>preview" class="btn btn-primary" href="<?php echo $row['floc']; ?>" target="_blank"><i class="icon-eye-open icon-large"></i> Preview</a>
										  <a data-placement="bottom" title="Download" id="<?php echo $id; ?>download" class="btn btn-info" href="<?php echo $row['floc']; ?>" download><i class="icon-download icon-large"></i> Download</a>
										<?php } ?>
										 <button  data-placement="bottom" title="Submit Assignment" id="<?php echo $id; ?>submit" class="btn btn-success" name="btn_assign"><i class="icon-upload icon-large"></i> Submit Assignment</button>
										 </form>
										 </td>                                      
                               
                                </tr>
                         
						 <?php } ?>
						   
                              
										</tbody>
									</table>
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
        
        <style>
        .btn {
            display: inline-block;
            margin: 2px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }
        
        .btn:hover {
            opacity: 1;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-info {
            color: #fff;
            background-color: #5bc0de;
            border-color: #46b8da;
        }
        
        .btn-info:hover {
            color: #fff;
            background-color: #31b0d5;
            border-color: #269abc;
        }
        
        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        
        .btn-success:hover {
            color: #fff;
            background-color: #449d44;
            border-color: #398439;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        
        .btn-primary:hover {
            color: #fff;
            background-color: #286090;
            border-color: #204d74;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        /* Make buttons display side by side */
        form#assign {
            display: flex;
            flex-direction: row;
            gap: 5px;
            align-items: center;
        }
        
        form#assign .btn {
            margin: 0;
            flex-shrink: 0;
        }
        </style>
    </body>
</html>