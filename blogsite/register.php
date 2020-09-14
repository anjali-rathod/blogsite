<?php 
session_start();
require_once('includes/head_section.php') ;
if (isset($_SESSION['uid']))
{
	header("LOCATION: account.php");
}
?>
	<title>Your Blog | Sign Up </title>
</head>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include('includes/navbar.php') ?>

		<div class="banner">
			<div class="welcome_msg">
				<h1>Today's Inspiration</h1>
				<p> 
				   “Take the first step in faith. <br>
				   You don’t have to see the whole staircase,<br>
				    just take the first step.”<br>
					<span> – Martin Luther King Jr.</span>
				</p>
				<a href="register.php" class="btn">Join us!</a>
			</div>
			<div class="login_div">
				<form method="post" >
					<h2>Sign Up</h2>
					<input type="text" name="name" placeholder="Full Name" required><br>
					<input type="text" name="email" placeholder="Email" required><br>
					<input type="text" name="uid" placeholder="Username" required><br>
					<input type="password" name="upd"  placeholder="Password" required><br> 
					<button class="btn" type="submit" name="login_btn">Sign up</button>
				</form>
				<?php
							ini_set("display_errors", 1);
							error_reporting(E_ALL);
							include "db.php";
							if (isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["uid"])&&isset($_POST["upd"]))
							{
								sign_up($_POST["name"],$_POST["email"],$_POST["uid"],$_POST["upd"]);
							}
				?>
				
			</div>
			<br>
		</div>
		<!-- Page content -->
		<div class="content">
			<h2 class="content-title">Recent Articles</h2>
			<hr>
			<?php	
				 disp_recent_blog();
			?>
		</div>
		<!-- // Page content -->

		<!-- footer -->
<?php include('includes/footer.php') ?>