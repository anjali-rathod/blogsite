<?php 
	session_start();
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
	$h=$_SESSION["logged_in"];
    if($h=='pass')
    {
	require_once('includes/head_section.php'); ?>
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
				<h2 class ="acc">Hi <?php echo $_SESSION["uid"] ?> </h2>
				<a class="acc" href="logout.php">LOGOUT</a>
			</div>
		</div>

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Blog</h2>

			<hr>
			<?php
				 include('db.php') ;
				 delete_post($_GET['id'],$_SESSION["uid"],$_SESSION["uno"]);
			?>
		</div>
		<!-- // Page content -->

		<!-- footer -->
<?php 
	include('includes/footer.php') ;
	}
	else
	{
		header("LOCATION: index.php");
	}
?>