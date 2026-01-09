<?php include('header.php'); ?>
<?php include('session.php'); ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('school_year_sidebar.php'); ?>
				<div class="span3" id="adduser">
				<?php include('add_school_year.php'); ?>		   			
				</div>
                <div class="span6" id="">
                     <div class="row-fluid">
                        <!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Semester List</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<form action="delete_sy.php" method="post">
  									<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
									<a data-toggle="modal" href="#user_delete" id="delete"  class="btn btn-danger" name=""><i class="icon-trash icon-large"></i></a>
									<?php include('modal_delete.php'); ?>
										<thead>
										  <tr>
												<th></th>
												<th>Semester</th>
												<th></th>
										   </tr>
										</thead>
										<tbody>
													<?php
													$user_query = mysqli_query($conn,"select * from school_year")or die(mysqli_error());
													while($row = mysqli_fetch_array($user_query)){
													$id = $row['school_year_id'];
													?>
									
												<tr>
												<td width="30">
												<input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
												</td>
												<td class="semester-name" style="cursor:pointer;">
													<span class="semester-text" data-id="<?php echo $id; ?>"><?php echo htmlspecialchars($row['school_year']); ?></span>
												</td>
	
												
											
												<td width="40">
												<button type="button" class="btn btn-success edit-semester-btn" data-id="<?php echo $id; ?>" title="Edit Semester Name"><i class="icon-pencil icon-large"></i></button>
												</td>
		
									
												</tr>
												<?php } ?>
										</tbody>
									</table>
									</form>
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
		<script>
		document.addEventListener('DOMContentLoaded', function() {
			function makeEditable(span, id, oldValue) {
				var input = document.createElement('input');
				input.type = 'text';
				input.value = oldValue;
				input.className = 'edit-semester-input';
				input.style.width = '80%';
				span.replaceWith(input);
				input.focus();
				input.select();
				function save() {
					var newValue = input.value.trim();
					if (newValue && newValue !== oldValue) {
						// AJAX update
						var xhr = new XMLHttpRequest();
						xhr.open('POST', 'edit_semester_name.php', true);
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						xhr.onload = function() {
							if (xhr.status === 200 && xhr.responseText === 'success') {
								var newSpan = document.createElement('span');
								newSpan.className = 'semester-text';
								newSpan.setAttribute('data-id', id);
								newSpan.textContent = newValue;
								input.replaceWith(newSpan);
							} else {
								alert('Failed to update semester name.');
								input.value = oldValue;
								input.focus();
							}
						};
						xhr.send('id=' + encodeURIComponent(id) + '&name=' + encodeURIComponent(newValue));
					} else {
						// Cancel edit
						var newSpan = document.createElement('span');
						newSpan.className = 'semester-text';
						newSpan.setAttribute('data-id', id);
						newSpan.textContent = oldValue;
						input.replaceWith(newSpan);
					}
				}
				input.addEventListener('blur', save);
				input.addEventListener('keydown', function(e) {
					if (e.key === 'Enter') {
						save();
					} else if (e.key === 'Escape') {
						var newSpan = document.createElement('span');
						newSpan.className = 'semester-text';
						newSpan.setAttribute('data-id', id);
						newSpan.textContent = oldValue;
						input.replaceWith(newSpan);
					}
				});
			}
			document.querySelectorAll('.edit-semester-btn').forEach(function(btn) {
				btn.addEventListener('click', function(e) {
					e.preventDefault();
					var id = this.getAttribute('data-id');
					// Find the semester-text span in the same row
					var row = this.closest('tr');
					var span = row ? row.querySelector('.semester-text') : null;
					if (span) {
						makeEditable(span, id, span.textContent);
					}
				});
			});
		});
		</script>
		<style>
		.edit-semester-icon { color: #357abd; cursor: pointer; }
		.edit-semester-icon:hover { color: #23527c; }
		.edit-semester-input { font-size: 1em; padding: 2px 6px; }
		</style>
    </body>

</html>