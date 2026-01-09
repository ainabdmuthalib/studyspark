<?php include('header.php'); ?>
<style>
	body#login::before {
    content: "";
    background: #00000036;
    position: absolute;
    top: 0;
    /* z-index: 1; */
    left: 0;
    width: 100%;
    height: 100%;
}

.index-footer {
    text-align: center;
    width: 100%;
}

.title_index {
    text-align: center;
    width: 100%;
}

.pull-right {
    float: right;
}
	b
.footer p {
		color: white;
		font-weight: bold;
		text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
	}
	
	footer p {
		color: white !important;
		font-weight: bold;
		text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
	}
</style>
<body id="login">
    <div class="container" style="position: relative">
		<div class="row-fluid">
            <div class="span12"><div class="index-footer"><?php include('link.php'); ?></div>
			<div class="span6"><div class="title_index"><?php include('title_index.php'); ?></div></div>
			<br><br><div class="span6" style="text-align: center;"><?php include('login_form.php'); ?></div>
		</div>
            
    </div>
    <br><br><br><br><br><center><footer><p>STUDY SPARK</p></footer></center>
<?php include('script.php'); ?>
<script>
function fetchUserTimeToday() {
    const today = new Date().toISOString().slice(0, 10);
    $.ajax({
        url: 'get_user_time.php?date=' + encodeURIComponent(today),
        type: 'GET',
    });
}

// On page load and every 10 seconds:
fetchUserTimeToday();
setInterval(fetchUserTimeToday, 10000);
</script>
</body>
</html>