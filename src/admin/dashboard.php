<?php
// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php  include('header.php'); ?>
<?php  include('session.php'); ?>

<?php
// Debug: Check if database connection is working
if (!isset($conn)) {
    echo "<!-- Debug: Database connection not available -->";
} else {
    echo "<!-- Debug: Database connection available -->";
}

// Debug: Check if tables exist
$tables_to_check = ['teacher', 'student', 'class', 'subject', 'files'];
foreach ($tables_to_check as $table) {
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($result) > 0) {
        echo "<!-- Debug: Table '$table' exists -->";
    } else {
        echo "<!-- Debug: Table '$table' does not exist -->";
    }
}
?>
    <body>
    
    <style>
    /* Modern Dashboard Styles */
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }
    
    .chart-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .chart-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
    }
    
    .chart-header h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }
    
    .chart-header i {
        margin-right: 8px;
    }
    
    .chart-body {
        padding: 20px;
    }
    
    /* Morris Chart Customization */
    .morris-hover {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .morris-hover-row-label {
        font-weight: bold;
        color: #333;
    }
    
    .morris-hover-point {
        color: #666;
    }
    </style>
		<?php include('navbar.php') ?>
        <div class="container-fluid">
            <div class="row-fluid">
					<?php include('sidebar_dashboard.php'); ?>
                <!--/span-->
                <div class="span9" id="content">
						<div class="row-fluid"></div>
						
                    <div class="row-fluid">
            
						
                        <!-- Statistics Cards -->
                        <div class="row-fluid">
									<?php 
                            $query_reg_teacher = mysqli_query($conn,"select * from teacher where teacher_status = 'Registered' ");
                            if (!$query_reg_teacher) {
                                echo "<!-- Debug: Error in lecturer query: " . mysqli_error($conn) . " -->";
                                $count_reg_teacher = 0;
                            } else {
								$count_reg_teacher = mysqli_num_rows($query_reg_teacher);
                                echo "<!-- Debug: Registered lecturer: $count_reg_teacher -->";
                            }
								?>
                                <div class="span3">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="icon-user" style="color: white; font-size: 24px;"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number"><?php echo $count_reg_teacher; ?></div>
                                        <div class="stat-label">Registered Lecturer</div>
                                    </div>
                                    </div>
                                </div>
								
								<?php 
								$query_teacher = mysqli_query($conn,"select * from teacher")or die(mysqli_error());
								$count_teacher = mysqli_num_rows($query_teacher);
                            echo "<!-- Debug: Total lecturer: $count_teacher -->";
								?>
                                <div class="span3">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                        <i class="icon-user" style="color: white; font-size: 24px;"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number"><?php echo $count_teacher; ?></div>
                                        <div class="stat-label">Total Lecturers</div>
                                    </div>
                                    </div>
                                </div>
								
								<?php 
								$query_student = mysqli_query($conn,"select * from student where status='Registered'")or die(mysqli_error());
								$count_student = mysqli_num_rows($query_student);
                            echo "<!-- Debug: Registered students: $count_student -->";
								?>
                                <div class="span3">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                        <i class="icon-user" style="color: white; font-size: 24px;"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number"><?php echo $count_student; ?></div>
                                        <div class="stat-label">Registered Students</div>
                                    </div>
                                </div>
                            </div>
								
										<?php 
								$query_student = mysqli_query($conn,"select * from student")or die(mysqli_error());
								$count_student = mysqli_num_rows($query_student);
                            echo "<!-- Debug: Total students: $count_student -->";
								?>
                                <div class="span3">
                                <div class="stat-card">
                                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                        <i class="icon-user" style="color: white; font-size: 24px;"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number"><?php echo $count_student; ?></div>
                                        <div class="stat-label">Total Students</div>
                                    </div>
                                </div>
                                    </div>
                                </div>
								
                        <!-- Charts Row 1 -->
                        <div class="row-fluid" style="margin-top: 20px;">
									<?php 
								$query_class = mysqli_query($conn,"select * from class")or die(mysqli_error());
								$count_class = mysqli_num_rows($query_class);
                            echo "<!-- Debug: Classes: $count_class -->";
                            ?>
                            <div class="span6">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-bar-chart"></i> Class Distribution</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="class-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
								
										<?php 
								$query_file = mysqli_query($conn,"select * from files")or die(mysqli_error());
								$count_file = mysqli_num_rows($query_file);
                            echo "<!-- Debug: Files: $count_file -->";
                            ?>
                            <div class="span6">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-file"></i> Learning Materials</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="materials-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        
                        <!-- Charts Row 3 -->
                        <div class="row-fluid" style="margin-top: 20px;">
                            <?php
                            // Get top subjects by number of classes
                            $query_top_subjects = mysqli_query($conn, "
                                SELECT s.subject_title, COUNT(tc.teacher_class_id) as class_count 
                                FROM subject s 
                                LEFT JOIN teacher_class tc ON s.subject_id = tc.subject_id 
                                GROUP BY s.subject_id 
                                ORDER BY class_count DESC 
                                LIMIT 5
                            ") or die(mysqli_error());
                            
                            // Get active vs inactive users - using status since no last_login column
                            $query_active_students = mysqli_query($conn, "
                                SELECT COUNT(*) as active_count 
                                FROM student 
                                WHERE status = 'Registered'
                            ") or die(mysqli_error());
                            $active_students = mysqli_fetch_assoc($query_active_students)['active_count'];
                            
                            $query_active_teachers = mysqli_query($conn, "
                                SELECT COUNT(*) as active_count 
                                FROM teacher 
                                WHERE teacher_status = 'Registered'
                            ") or die(mysqli_error());
                            $active_teachers = mysqli_fetch_assoc($query_active_teachers)['active_count'];
                            ?>
                            <div class="span12">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-book"></i> Top Subjects by Classes</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="top-subjects-chart" style="height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Charts Row 4 -->
                        <div class="row-fluid" style="margin-top: 20px;">
                            <div class="span6">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-user"></i> User Activity Status</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="user-activity-chart" style="height: 300px;"></div>
                                    </div>
                                    </div>
                                </div>
								
                            <div class="span6">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-stats"></i> System Overview</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="system-overview-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Stats Row -->
                        <div class="row-fluid" style="margin-top: 20px;">
										<?php 
								$query_subject = mysqli_query($conn,"select * from subject")or die(mysqli_error());
								$count_subject = mysqli_num_rows($query_subject);
                            echo "<!-- Debug: Subjects: $count_subject -->";
                            ?>
                            <div class="span12">
                                <div class="chart-card">
                                    <div class="chart-header">
                                        <h4><i class="icon-book"></i> Course Statistics</h4>
                                    </div>
                                    <div class="chart-body">
                                        <div id="course-chart" style="height: 300px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                    </div>
                    </div>
                
                
                 
                 
                </div>
            </div>
    
         <?php include('footer.php'); ?>
        </div>
	<?php include('script.php'); ?>
    
    <!-- Raphael.js (required for Morris.js) -->
    <script src="vendors/raphael-min.js?v=<?php echo time(); ?>"></script>
    
    <!-- Morris Charts -->
    <link rel="stylesheet" href="vendors/morris/morris.css?v=<?php echo time(); ?>">
    <script src="vendors/morris/morris.min.js?v=<?php echo time(); ?>"></script>

    
    <script>
    $(document).ready(function() {
        console.log('Dashboard script loaded');
        console.log('Class count: <?php echo $count_class; ?>');
        console.log('Subject count: <?php echo $count_subject; ?>');
        console.log('File count: <?php echo $count_file; ?>');
        console.log('Lecturer count: <?php echo $count_teacher; ?>');
        console.log('Student count: <?php echo $count_student; ?>');
        

        
        // Check if Morris is loaded
        if (typeof Morris === 'undefined') {
            console.error('Morris.js is not loaded!');
            return;
        }
        
        // Wait a bit for DOM to be fully ready
        setTimeout(function() {
            initializeCharts();
        }, 100);
    });
    
    function initializeCharts() {
        
        // Test if chart containers exist
        var testContainer = document.getElementById('class-chart');
        if (testContainer) {
            console.log('Chart container found:', testContainer);
            console.log('Container dimensions:', testContainer.offsetWidth, 'x', testContainer.offsetHeight);
            
            // Set minimum dimensions if container is too small
            if (testContainer.offsetWidth < 200 || testContainer.offsetHeight < 200) {
                testContainer.style.width = '300px';
                testContainer.style.height = '300px';
                console.log('Set minimum dimensions for chart container');
            }
        } else {
            console.error('Chart container not found!');
        }
        
        // Check course chart container specifically
        var courseContainer = document.getElementById('course-chart');
        if (courseContainer) {
            console.log('Course chart container found:', courseContainer);
            console.log('Course chart dimensions:', courseContainer.offsetWidth, 'x', courseContainer.offsetHeight);
            
            // Ensure course chart has proper dimensions
            if (courseContainer.offsetWidth < 200 || courseContainer.offsetHeight < 200) {
                courseContainer.style.width = '100%';
                courseContainer.style.height = '250px';
                console.log('Set dimensions for course chart container');
            }
        } else {
            console.error('Course chart container not found!');
        }
        
        try {
            // Class Distribution Chart
            console.log('Creating class chart with data:', [
                {label: 'Classes', value: <?php echo $count_class; ?>},
                {label: 'Subjects', value: <?php echo $count_subject; ?>}
            ]);
            
            // Test with simple data first
            var testData = [
                {label: 'Test 1', value: 10},
                {label: 'Test 2', value: 20}
            ];
            
            Morris.Donut({
                element: 'class-chart',
                data: testData,
                colors: ['#667eea', '#764ba2'],
                formatter: function (value) { return value; }
            });
            console.log('Class chart created successfully with test data');
            
            // Now try with real data
            var realData = [
                {label: 'Classes', value: <?php echo $count_class; ?>},
                {label: 'Subjects', value: <?php echo $count_subject; ?>}
            ];
            
            // If real data is zero, use fallback data
            if (realData[0].value === 0 && realData[1].value === 0) {
                realData = [
                    {label: 'Sample Classes', value: 5},
                    {label: 'Sample Subjects', value: 8}
                ];
                console.log('Using fallback data for class chart');
            }
            
            Morris.Donut({
                element: 'class-chart',
                data: realData,
                colors: ['#667eea', '#764ba2'],
                formatter: function (value) { return value; }
            });
            console.log('Class chart updated with real/fallback data');
        } catch (error) {
            console.error('Error creating class chart:', error);
        }
        
        try {
            // Learning Materials Chart
            var materialsData = [
                {category: 'Files', count: <?php echo $count_file; ?>},
                {category: 'Classes', count: <?php echo $count_class; ?>},
                {category: 'Subjects', count: <?php echo $count_subject; ?>}
            ];
            
            // If all data is zero, use fallback data
            if (materialsData[0].count === 0 && materialsData[1].count === 0 && materialsData[2].count === 0) {
                materialsData = [
                    {category: 'Files', count: 25},
                    {category: 'Classes', count: 5},
                    {category: 'Subjects', count: 8}
                ];
                console.log('Using fallback data for materials chart');
            }
            
            Morris.Bar({
                element: 'materials-chart',
                data: materialsData,
                xkey: 'category',
                ykeys: ['count'],
                labels: ['Count'],
                barColors: ['#4facfe'],
                gridTextColor: '#666',
                gridTextSize: 12,
                hideHover: 'auto'
            });
        } catch (error) {
            console.error('Error creating materials chart:', error);
        }
        

        

        
        try {
            // Top Subjects Chart
            var subjectsData = [
                <?php while($row = mysqli_fetch_assoc($query_top_subjects)): ?>
                {
                    subject: '<?php 
                        $subject_name = addslashes($row['subject_title']); 
                        if (strlen($subject_name) > 15) {
                            $words = explode(' ', $subject_name);
                            if (count($words) > 1) {
                                $mid = ceil(count($words) / 2);
                                echo implode(' ', array_slice($words, 0, $mid)) . '\n' . implode(' ', array_slice($words, $mid));
                            } else {
                                echo $subject_name;
                            }
                        } else {
                            echo $subject_name;
                        }
                    ?>',
                    classes: <?php echo $row['class_count']; ?>
                },
                <?php endwhile; ?>
            ];
            
            // If no data, use fallback data
            if (subjectsData.length === 0) {
                subjectsData = [
                    {subject: 'Mathematics', classes: 5},
                    {subject: 'Science', classes: 4},
                    {subject: 'English', classes: 3},
                    {subject: 'History', classes: 2},
                    {subject: 'Geography', classes: 1}
                ];
                console.log('Using fallback data for top subjects chart');
            }
            
            console.log('Top subjects data:', subjectsData);
            
            Morris.Bar({
                element: 'top-subjects-chart',
                data: subjectsData,
                xkey: 'subject',
                ykeys: ['classes'],
                labels: ['Classes'],
                barColors: ['#4facfe'],
                gridTextColor: '#666',
                gridTextSize: 9,
                hideHover: 'auto',
                yLabelFormat: function(y) { return y; },
                xLabelMargin: 40,
                barSizeRatio: 0.3,
                barGap: 3
            });
        } catch (error) {
            console.error('Error creating top subjects chart:', error);
        }
        

        
        try {
            // User Activity Status Chart
            Morris.Donut({
                element: 'user-activity-chart',
                data: [
                    {label: 'Active Students', value: <?php echo $active_students; ?>},
                    {label: 'Inactive Students', value: <?php echo $count_student - $active_students; ?>},
                    {label: 'Active Lecturers', value: <?php echo $active_teachers; ?>},
                    {label: 'Inactive Lecturers', value: <?php echo $count_teacher - $active_teachers; ?>}
                ],
                colors: ['#43e97b', '#ff6b6b', '#4facfe', '#ffa726'],
                formatter: function (value) { return value; }
            });
        } catch (error) {
            console.error('Error creating user activity chart:', error);
        }
        
        try {
            // System Overview Chart
            Morris.Bar({
                element: 'system-overview-chart',
                data: [
                    {metric: 'Lecturers', count: <?php echo $count_teacher; ?>},
                    {metric: 'Students', count: <?php echo $count_student; ?>},
                    {metric: 'Classes', count: <?php echo $count_class; ?>},
                    {metric: 'Subjects', count: <?php echo $count_subject; ?>},
                    {metric: 'Files', count: <?php echo $count_file; ?>}
                ],
                xkey: 'metric',
                ykeys: ['count'],
                labels: ['Count'],
                barColors: ['#667eea'],
                gridTextColor: '#666',
                gridTextSize: 12,
                hideHover: 'auto'
            });
        } catch (error) {
            console.error('Error creating system overview chart:', error);
        }
        
        try {
            // Course Statistics Chart
            var courseData = [
                {period: 'Lecturers', registered: <?php echo $count_reg_teacher; ?>, total: <?php echo $count_teacher; ?>},
                {period: 'Students', registered: <?php echo $count_student; ?>, total: <?php echo $count_student; ?>},
                {period: 'Classes', registered: <?php echo $count_class; ?>, total: <?php echo $count_class; ?>},
                {period: 'Materials', registered: <?php echo $count_file; ?>, total: <?php echo $count_file; ?>}
            ];
            
            // If all data is zero, use fallback data
            var allZero = true;
            for (var i = 0; i < courseData.length; i++) {
                if (courseData[i].registered > 0 || courseData[i].total > 0) {
                    allZero = false;
                    break;
                }
            }
            
            if (allZero) {
                courseData = [
                    {period: 'Lecturers', registered: 8, total: 10},
                    {period: 'Students', registered: 45, total: 50},
                    {period: 'Classes', registered: 5, total: 5},
                    {period: 'Materials', registered: 25, total: 25}
                ];
                console.log('Using fallback data for course statistics chart');
            }
            
            console.log('Course statistics data:', courseData);
            
            // Use Bar chart instead of Line chart for better display
            Morris.Bar({
                element: 'course-chart',
                data: courseData,
                xkey: 'period',
                ykeys: ['registered', 'total'],
                labels: ['Registered', 'Total'],
                barColors: ['#43e97b', '#667eea'],
                gridTextColor: '#666',
                gridTextSize: 12,
                hideHover: 'auto',
                barSizeRatio: 0.6,
                barGap: 3
            });
            console.log('Course statistics chart created successfully');
        } catch (error) {
            console.error('Error creating course statistics chart:', error);
        }
        
        // Add animation to stat cards
        $('.stat-card').each(function(index) {
            $(this).css({
                'animation-delay': (index * 0.1) + 's'
            });
        });
        
        // Add animation to chart cards
        $('.chart-card').each(function(index) {
            $(this).css({
                'animation-delay': (index * 0.1 + 0.4) + 's'
            });
        });
    }
    </script>
    
    <style>
    /* Animation for stat cards */
    .stat-card {
        animation: slideInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    
    .chart-card {
        animation: slideInUp 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    
    @keyframes slideInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Enhanced chart styling */
    .morris-hover {
        background: rgba(255, 255, 255, 0.98) !important;
        border: 2px solid #667eea !important;
        border-radius: 8px !important;
        padding: 12px !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        font-size: 12px !important;
    }
    
    .morris-hover-row-label {
        font-weight: bold !important;
        color: #333 !important;
        font-size: 13px !important;
    }
    
    .morris-hover-point {
        color: #666 !important;
        font-size: 12px !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .span3 {
            width: 48%;
            margin-bottom: 15px;
        }
        
        .span6 {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
        }
        
        .stat-number {
            font-size: 24px;
        }
    }
    
    /* Chart container adjustments */
    #top-subjects-chart {
        overflow: visible;
    }
    
    /* Multi-line label support */
    .morris-hover-row-label {
        white-space: normal !important;
        word-wrap: break-word !important;
        max-width: 200px !important;
    }
    
    /* X-axis label wrapping */
    .morris-chart-container svg text {
        white-space: normal !important;
        word-wrap: break-word !important;
    }
    </style>
    </body>

</html>