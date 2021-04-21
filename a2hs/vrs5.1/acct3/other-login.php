<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>aid</title><link rel="icon"  href="title.png" type="image/x-icon">
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<?php 
            include 'server1.php';
     
         
    ?>
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
					<ul class="nav pull-right">

						<li><a href="sigup.php">
							Sign Up
						</a></li>

						

						<li><a href="passRecover.php">
							Forgot your password?
						</a></li>
					</ul>
				

			  	<a class="brand" href="index.html">
			  		<img src="Untitled-1.png" height="1%">aid
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->


<P>
	<div class="wrapper"> <br><br><br><span class="login100-form-title p-b-59">
						<div class="holecontainer">
				<div class="container">
					<div>
						<div>
							<div class="maincontent">
							   <?php
								if (isset($success_message)) {
									echo $success_message;
								}else {
									echo '
									   <h2><font face="bookman">Welcome to Naid Afrika!</font></h2>
										<div class="maincontent_text">
										<font face="bookman">Join the naid family <br>
											<li>Manage your  Health.</li>
											<li>Chat with sick brothers and sister.</li>
											<li>Get medic update over the world.</li>
										</font>
										</div>
									';
								}
							   ?>
					</span>
</div>
</div>
</div>		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical"method="post" autocomplete="off">
						<div class="module-head">
							<h3>Sign In</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" name="user_login" type="email" name="email" placeholder="email or username">
								</div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" name="password_login"  type="password" name="pass" placeholder="Password">
								</div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									<button type="submit" name="login" value="Log In"   class="btn btn-primary pull-right">Login</button>
									<label class="checkbox">
										<input type="checkbox" name="rememberme" checked> Remember me
									</label>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
					
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">

			<b class="copyright"><img src="Untitled-1.png" height="5px"> -naid.com </b> all rights reserved.
		</div>
	</div>
	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>