<?php
session_start();
 require_once('includes/head_section.php'); ?>
	<title>Your Blog | Blogs </title>
</head>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include('includes/navbar.php'); ?>

		<!-- banner -->
		<div class="banner">
			<div class="welcome_msg">
				<h1>Today's Inspiration</h1>
				<p> 
				   “Blogging is good for your career. <br>
				   A well-executed blog sets you apart as an expert in your field.” <br>
					<span>― Penelope Trunk</span>
				</p>
				<a href="register.php" class="btn">Join us!</a>
			</div>
		</div>

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">All Blogs</h2>
			<hr>
			<?php
				 include('db.php') ;		
				 disp_all_blog();
			?>
		</div>
		<!-- footer -->
<?php include('includes/footer.php'); ?>