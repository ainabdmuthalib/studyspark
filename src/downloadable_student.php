<?php include('header_dashboard.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>
    <body>
		<?php include('navbar_student.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('downloadable_link_student.php'); ?>
                <div class="span8" id="content">
                     <div class="row-fluid">
					    <!-- breadcrumb -->
						<?php $class_query = mysqli_query($conn,"select * from teacher_class
						LEFT JOIN class ON class.class_id = teacher_class.class_id
						LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
						where teacher_class_id = '$get_id'")or die(mysqli_error());
						$class_row = mysqli_fetch_array($class_query);
						$class_id = $class_row['class_id'];
						$school_year = $class_row['school_year'];
						?>
						<ul class="breadcrumb">
							<li><a href="#"><?php echo $class_row['class_name']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><?php echo $class_row['subject_code']; ?></a> <span class="divider">/</span></li>
							<li><a href="#">Semester <?php echo $class_row['school_year']; ?></a> <span class="divider">/</span></li>
							<li><a href="#"><b>Learning Materials</b></a></li>
						</ul>
						<!-- end breadcrumb -->
						<!-- block -->
                        <div id="block_bg" class="block">
                            <div class="navbar navbar-inner block-header">
							<?php  $query = mysqli_query($conn,"select * FROM files where class_id = '$get_id' order by fdatein DESC ")or die(mysqli_error());
							$count = mysqli_num_rows($query);
							?>
                                <div id="" class="muted pull-right"><span class="badge badge-info"><?php echo $count; ?></span></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
							<?php
							$query = mysqli_query($conn,"select * FROM files where class_id = '$get_id' order by fdatein DESC ")or die(mysqli_error());
							$count = mysqli_num_rows($query);
							if ($count == '0'){ ?>
							<div class="alert alert-info"><i class="icon-info-sign"></i> No downloadable material currently uploaded.</div>
							<?php } else { ?>
							<div class="materials-grid">
							<?php
							while($row = mysqli_fetch_array($query)){
							$id  = $row['file_id'];
							$fname = $row['fname'];
							$fdesc = $row['fdesc'];
							$floc = $row['floc'];
							$fdatein = $row['fdatein'];
							$uploaded_by = $row['uploaded_by'];
							$ext = strtolower(trim(pathinfo($fname, PATHINFO_EXTENSION)));
							$icon = 'icon-file-alt';
							if (in_array($ext, ['pdf'])) $icon = 'icon-file-text';
							elseif (in_array($ext, ['doc','docx'])) $icon = 'icon-file-text';
							elseif (in_array($ext, ['jpg','jpeg','png','gif'])) $icon = 'icon-picture';
							elseif (in_array($ext, ['mp4','avi','mov'])) $icon = 'icon-facetime-video';
							elseif (in_array($ext, ['ppt','pptx'])) $icon = 'icon-file-text';
							elseif (in_array($ext, ['xls','xlsx'])) $icon = 'icon-file-text';
							elseif (in_array($ext, ['txt'])) $icon = 'icon-file-text';
							elseif (in_array($ext, ['zip','rar','7z'])) $icon = 'icon-download-alt';
							// Highlight new files (last 7 days)
							$is_new = (strtotime($fdatein) > strtotime('-7 days'));
							$preview_url = "track_material_access.php?file_id=$id&class_id=$get_id";
							?>
							<div class="material-card<?php if($is_new) echo ' new-material'; ?>" data-file-id="<?php echo $id; ?>" data-class-id="<?php echo $get_id; ?>">
								<div class="material-icon">
								<?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
								    <img src="<?php echo $preview_url; ?>" alt="Preview" class="material-thumb">
								<?php else: ?>
								    <a href="<?php echo htmlspecialchars($floc); ?>" target="_blank"><i class="<?php echo $icon; ?> icon-3x"></i></a>
								<?php endif; ?>
								</div>
								<div class="material-info">
									<div class="material-desc"><?php echo htmlspecialchars($fdesc); ?></div>
									<div class="material-meta">Uploaded: <?php echo date('M d, Y', strtotime($fdatein)); ?> | By: <?php echo htmlspecialchars($uploaded_by); ?></div>
								</div>
								<div class="material-actions">
									<?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
										<a class="btn btn-primary preview-btn" title="Preview" href="<?php echo $preview_url; ?>" target="_blank"><i class="icon-eye-open"></i> Preview</a>
									<?php else: ?>
										<a class="btn btn-primary preview-btn" title="Preview" href="<?php echo htmlspecialchars($floc); ?>" target="_blank"><i class="icon-eye-open"></i> Preview</a>
									<?php endif; ?>
									<a class="btn btn-success" title="Download" href="track_material_access.php?file_id=<?php echo $id; ?>&class_id=<?php echo $get_id; ?>" target="_blank"><i class="icon-download"></i> Download</a>
									<form action="copy_file_student.php" method="post" style="display:inline;">
										<input type="hidden" name="selector[]" value="<?php echo $id; ?>">
										<button type="submit" class="btn btn-info"><i class="icon-copy"></i> Copy to Backpack</button>
									</form>
								</div>
							</div>
							<?php } ?>
							</div>
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
    .materials-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .material-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        padding: 18px 20px 16px 20px;
        width: 320px;
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        margin-bottom: 10px;
        position: relative;
        transition: box-shadow 0.2s;
    }
    .material-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.13);
    }
    .material-icon {
        margin-right: 18px;
        font-size: 2.5em;
        color: #00796b;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        overflow: hidden;
        background: #f5f5f5;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
    }
    .material-icon i {
        font-size: 2em;
        color: #00796b;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    .material-icon a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
    }
    .material-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid #e0e0e0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07);
        transition: box-shadow 0.2s;
    }
    .material-thumb:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.18);
    }
    .material-info {
        flex: 1;
    }
    .material-title {
        font-weight: bold;
        font-size: 1.1em;
        margin-bottom: 4px;
    }
    .material-desc {
        color: #555;
        font-size: 0.97em;
        margin-bottom: 6px;
    }
    .material-meta {
        font-size: 0.88em;
        color: #888;
        margin-bottom: 8px;
    }
    .material-actions {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-left: 12px;
    }
    .material-actions .btn {
        min-width: 140px;
        width: 140px;
        text-align: center;
        white-space: nowrap;
        padding: 8px 12px;
        font-size: 12px;
    }
    .material-actions form {
        display: inline;
    }
    .material-actions form button {
        min-width: 140px;
        width: 140px;
        text-align: center;
        white-space: nowrap;
        padding: 8px 12px;
        font-size: 12px;
    }
    .material-card.new-material {
        border: 2px solid #4caf50;
        background: #f6fff6;
    }
    @media (max-width: 900px) {
        .materials-grid { flex-direction: column; align-items: center; }
        .material-card { width: 95%; }
    }
    /* Modal styles */
    .modal-preview-bg {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0; top: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.7);
        align-items: center;
        justify-content: center;
    }
    .modal-preview-bg.active { display: flex; }
    .modal-preview-content {
        background: #fff;
        border-radius: 8px;
        padding: 18px 18px 10px 18px;
        max-width: 90vw;
        max-height: 90vh;
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .modal-preview-close {
        position: absolute;
        top: 8px; right: 12px;
        font-size: 2em;
        color: #888;
        cursor: pointer;
        background: none;
        border: none;
    }
    .modal-preview-img, .modal-preview-pdf {
        max-width: 80vw;
        max-height: 70vh;
        margin-top: 18px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.13);
    }
    </style>
    <script>
    // Track material card visibility (scroll progress)
    document.addEventListener('DOMContentLoaded', function() {
        var tracked = {};
        var cards = document.querySelectorAll('.material-card');
        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries, obs) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var card = entry.target;
                        var fileId = card.getAttribute('data-file-id');
                        var classId = card.getAttribute('data-class-id');
                        if (!tracked[fileId]) {
                            tracked[fileId] = true;
                            // Send AJAX POST to track_material_access.php
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'track_material_access.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.send('file_id=' + encodeURIComponent(fileId) + '&class_id=' + encodeURIComponent(classId) + '&scroll_view=1');
                        }
                        obs.unobserve(card); // Only track once
                    }
                });
            }, { threshold: 0.3 }); // 30% visible
            cards.forEach(function(card) { observer.observe(card); });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.material-icon-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var fileId = this.getAttribute('data-file-id');
                var classId = this.getAttribute('data-class-id');
                // Track the view
                fetch('track_material_access.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'file_id=' + encodeURIComponent(fileId) + '&class_id=' + encodeURIComponent(classId) + '&scroll_view=0'
                }).then(function() {
                    // Trigger leaderboard refresh in all tabs
                    localStorage.setItem('refreshLeaderboard', Date.now());
                });
            });
        });
    });
    </script>
    </body>
</html>