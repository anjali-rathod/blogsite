<?php
  session_start();
  if (isset($_SESSION["admin"]))
    {
 ?>
<?php require_once('includes/head_section.php') ?>
	<title>Your Blog | Account </title>
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
				<h2>Hi <?php echo $_SESSION["uid"] ?> </h2>
				<a href="createblog.php">Create a blog</a>
				<a href="logout.php">LOGOUT</a>
			</div>
		</div>
		<div class="content">
			<h2 class="content-title"> ALL CREDENTIALS</h2>

			<hr>
			<?php
			ini_set("display_errors", 1);
error_reporting(E_ALL);
				 include('db.php') ;		
				 user_info();
			?>
		</div>
		<!-- footer -->
<?php include('includes/footer.php') ?>
<?php
       }
      else {
        header("LOCATION: account.php ");
      }
  ?>