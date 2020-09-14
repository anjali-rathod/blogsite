<?php
	session_start();
	if (isset($_COOKIE["uid"]))
		{
			$_SESSION["logged_in"]="pass";
		}
	if((isset($_SESSION["logged_in"]))&&($_SESSION["logged_in"]=='pass'))
	{
				header("LOCATION: account.php");

	}	
	else
	{
?>
<?php require_once('includes/head_section.php') ?>
	<title>Your Blog | Home </title>
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
				   “Have the courage to follow your heart and intuition. <br>
				   They somehow already know what you truly want to become.<br>
				    Everything else is secondary.” <br>
					<span>― Steve Jobs</span>
				</p>
				<a href="register.php" class="btn">Join us!</a>
			</div>
			<div class="login_div">
				<form action="index.php" method="post" >
					<h2>Login</h2>
					<br>
					<?php

						if(isset($_SESSION["error"]))
						{
							echo('<p id="e">'.$_SESSION["error"]."</p>\n");
							unset($_SESSION["error"]);
						}
						if(isset($_SESSION["success"]))
						{
							echo('<p id="g">'.$_SESSION["success"]."</p>\n");
							unset($_SESSION["success"]);
						}
					?>
					<input type="text" name="uid" placeholder="Username" required><br>
					<input type="password" name="upd"  placeholder="Password" required><br> 
					<b>Remember me </b><input type="checkbox" name="remember" id="remember"/>
					<button class="btn" type="submit" name="login_btn">Sign in</button>
				</form>
				<?php
					ini_set("display_errors", 1);
					error_reporting(E_ALL);
					include "db.php";

					if (isset($_POST['uid']) && isset($_POST['upd']))

					{
						$row=login($_POST['uid'],$_POST['upd']);
						if ($row === false)
						{
							$_SESSION["error"]="Incorrect password.";
							header("LOCATION: index.php");
						}
						else
						{
							if (!empty($_POST['remember']))
							{
								setcookie ("uid", $_POST['uid'], time()+ (10 * 365 * 24 * 60 * 60));
							}
							
							$_SESSION["uid"]=$_POST['uid'];
							$_SESSION["admin"]=admin($_SESSION["uid"]);
							$_SESSION["success"]="Login success";
							$_SESSION["logged_in"]="pass";
							header("LOCATION: account.php");
						}
					}

				 ?>

			</div>
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

<?php
	}

?>