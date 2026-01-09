<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_teacher.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('calendar_sidebar.php'); ?>
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
										<li><a href="#"><b>My Class Calendar</b></a></li>
									</ul>
									<!-- end breadcrumb -->
                        <!-- block -->
                        <div id="block_bg" class="block">
                
								<div class="block-content collapse in">
										<div class="span8">
							<!-- block -->
										<div class="navbar navbar-inner block-header">
											<div class="muted pull-left">Calendar</div>
										</div>
															<div id='calendar'></div>		
										</div>
										
										<div class="span4">
												<?php include('add_class_event.php'); ?>
										</div>	
							<!-- block -->
						
										</div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
		<?php include('footer.php'); ?>
        </div>

<!-- Delete Event Confirmation Modal -->
<div id="deleteEventModal" class="delete-modal" style="display: none;">
    <div class="delete-modal-content">
        <div class="delete-modal-header">
            <h4>Confirm Event Deletion</h4>
        </div>
        <div class="delete-modal-body">
            <p id="deleteEventMessage">Are you sure you want to delete this event?</p>
            <p class="delete-warning">This action cannot be undone.</p>
        </div>
        <div class="delete-modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hideDeleteEventModal()">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteEventBtn">Delete Event</button>
        </div>
    </div>
</div>

		<?php include('script.php'); ?>
		<?php include('class_calendar_script.php'); ?>

<style>
/* Delete Confirmation Modal */
.delete-modal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-modal-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    max-width: 400px;
    width: 90%;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.delete-modal-header {
    padding: 20px 20px 0 20px;
    border-bottom: 1px solid #e1e8ed;
}

.delete-modal-header h4 {
    margin: 0;
    color: #14171a;
    font-size: 18px;
    font-weight: 700;
}

.delete-modal-body {
    padding: 20px;
}

.delete-modal-body p {
    margin: 0 0 10px 0;
    color: #14171a;
    font-size: 14px;
    line-height: 1.4;
}

.delete-warning {
    color: #e0245e !important;
    font-weight: 500;
    font-size: 13px !important;
}

.delete-modal-footer {
    padding: 0 20px 20px 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.delete-modal-footer .btn {
    padding: 8px 16px;
    border-radius: 4px;
    font-weight: 500;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.delete-modal-footer .btn-secondary {
    background-color: #6c757d;
    color: white;
}

.delete-modal-footer .btn-secondary:hover {
    background-color: #5a6268;
}

.delete-modal-footer .btn-danger {
    background-color: #dc3545;
    color: white;
}

.delete-modal-footer .btn-danger:hover {
    background-color: #c82333;
}
</style>

<script>
// Delete event confirmation functions
function showDeleteEventConfirmation(eventId, eventTitle, classId) {
    const modal = document.getElementById('deleteEventModal');
    const message = document.getElementById('deleteEventMessage');
    const confirmBtn = document.getElementById('confirmDeleteEventBtn');
    
    message.textContent = `Are you sure you want to delete the event "${eventTitle}"?`;
    
    confirmBtn.onclick = function() {
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'delete_class_event.php';
        
        const get_id_input = document.createElement('input');
        get_id_input.type = 'hidden';
        get_id_input.name = 'get_id';
        get_id_input.value = classId;
        
        const id_input = document.createElement('input');
        id_input.type = 'hidden';
        id_input.name = 'id';
        id_input.value = eventId;
        
        const delete_event_input = document.createElement('input');
        delete_event_input.type = 'hidden';
        delete_event_input.name = 'delete_event';
        delete_event_input.value = '1';
        
        form.appendChild(get_id_input);
        form.appendChild(id_input);
        form.appendChild(delete_event_input);
        
        document.body.appendChild(form);
        form.submit();
    };
    
    modal.style.display = 'flex';
    return false;
}

function hideDeleteEventModal() {
    const modal = document.getElementById('deleteEventModal');
    modal.style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('deleteEventModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteEventModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteEventModal();
    }
});
</script>

    </body>
</html>