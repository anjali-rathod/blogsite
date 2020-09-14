<?php 
session_start();
require_once('includes/head_section.php') ?>
	<title>Your Blog | Read More </title>
</head>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include('includes/navbar.php') ?>

		<!-- banner -->
		<div class="banner">
			<div class="welcome_msg">
				<h1>Today's Inspiration</h1>
				<p> 
				   “We have to dare to be ourselves, <br>
				   however frightening or strange that self may prove to be.”<br>
					<span>― May Sarton</span>
				</p>
			</div>
			<div class="account">
				
			</div>
		</div>

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Blog</h2>

			<hr>
			<?php
				 include('db.php') ;
				 if (isset($_SESSION["admin"])&& isset($_SESSION["logged_in"]))
				 {
				 	view_post($_GET['id'],$_SESSION["admin"],$_SESSION["logged_in"],$_SESSION["uid"]);
				 }
				 else
				 {
				 	view_post($_GET['id'],"no","fail","none");
				 }
			?>
		</div>
		<!-- // Page content -->

		<!-- footer -->
<?php include('includes/footer.php') ?>