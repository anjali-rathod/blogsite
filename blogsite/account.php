<?php
  session_start();
  if (isset($_COOKIE["uid"]))
    {
      $_SESSION["logged_in"]="pass";
    }
 ?>
<?php require_once('includes/head_section.php') ?>
	<title>Your Blog | Account </title>
</head>
<body>
	<?php
    $h=$_SESSION["logged_in"];
        if($h=='pass')
        {

      ?>
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
				<?php
				 if($_SESSION["admin"]=="yes")
				 {
				 	echo '<a href="userinfo.php"><br>Update Users Information<br></a>';
				 }
				 ?>
				<a href="logout.php">LOGOUT</a>
			</div>
		</div>

		<!-- Page content -->
		<div class="content">
			<h2 class="content-title"> Your Recent Blogs</h2>

			<hr>
			<?php
				 include('db.php') ;		
				 disp_account_blog($_SESSION["uid"]);
			?>
		</div>
		<!-- // Page content -->

		<!-- footer -->
<?php include('includes/footer.php') ?>
<?php
       }
      else {
        header("LOCATION: index.php ");
      }
  ?>