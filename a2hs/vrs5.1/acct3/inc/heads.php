
	<?php include ( "header.inc.php" ); ?>
	<?php if ($user != '') {echo ' 
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
                        <i class="icon-reorder shaded"></i></a><a class="brand" href="index.php"><img src="Untitled-1.png" height=".1%"><img src="giphy.gif" style="height:4%"> </a>
                    <div class="nav-collapse collapse navbar-inverse-collapse">
                        <ul class="nav nav-icons">
                            <li class="active"><a href="#"><i class="icon-envelope"></i></a></li>
                            <li><a href="#"><i class="icon-eye-open"></i></a></li>
                            <li><a href="#"><i class="icon-bar-chart"></i></a></li>
                        </ul>
                        <form action="search.php" method="get" class="navbar-search pull-left input-append" action="#">
                        <input style="background-color:#ffffff;border:1px solid #ffffff" type="text" id="search" name="keywords" placeholder="Search Here..." class="sport" class="span3"></input>
						<select name="topic" style="background-color:#ffffff" class="span1" style="height:20px">
							<option>User</option>
							<option>Post</option>
						</select>
                        <button class="btn" type="submit" name="search" >
                            <i style="color:#0ff; font-variant: small-caps;font-weight: 900;text-shadow:  3px 1px 1px #404040"class="icon-search"></i>
                        </button>
                        </form>
                        <ul class="nav pull-right">';
if ($noti_num == "") {
							echo '<li>
							<form method="POST" action="">
							<button type="submit"  name="gotonoti" style="background: none; cursor: pointer; border: none;">
							<img src="./img/preview.png" style="margin: 15px 0px 17px 2px;" height="122" width="42">
							</button>
							</form>
							</li>';
						}else {
							echo '<li>
							<form method="POST" action="">
							<button type="submit"  name="gotonoti" style="background: none; cursor: pointer; border: none;">
							<a href="notifications.php" title="View Notification" style="color: red;">
							<img src="./img/preview.gif" style="margin: 1px -27px 0px 2px;" height="122" width="112"><b style="position:absolute; top:15%;left:14%; color:red; font-variant: small-caps;font-weight: 900;text-shadow:  3px 1px 1px 0ff"  >'.$noti_num.'</b></a>
							</button>
							</form>
							</li>';
}
						if ($unread_numrows == "") {
							echo '<li>
							<form method="POST" action="">
							<button type="submit"  name="gotoinbox" style="background: none; cursor: pointer; border: none;">
							<img src="./img/lg.png" style="margin: 13px 0px 0px 36px;" height="39" width="42">
							</button>
							</form>
							</li>';
						}else {
							echo '
							<li>
							<form method="POST" action="">
							<button type="submit"  name="gotoinbox" style="background: none; cursor: pointer; border: none;">
							<a href="messages.php"  title="View Messages" style="color: red;">
							<img src="./img/lg.-text-entering-comment-loader.gif" style="margin: 13px 0px 0px 36px;" height="39" width="42"><b style="color:red;position:absolute; top:16%;left:27%;  font-variant: small-caps;font-weight: 900;text-shadow:  3px 1px 1px 0ff">'.$unread_msg_numrows.'</b></a>
							</button>
							</form>
							</li>';
						}
						
						if ($follow_numrows == "") {
							echo '<li>
							<form method="POST" action="">
							<button type="submit"  name="gotofollow" style="background: none; cursor: pointer; border: none;">
							<img src="./img/iconfollowing.png" style="margin: 0px 0px 13px 0px;" height="42" width="92">
							</button>
							</form>
							</li>';
						}else {
							echo '
							<li>
							<form method="POST" action="">
							<button type="submit"  name="gotofollow" style="background: none; cursor: pointer; border: none;">
							<a href="followRequest.php"  title="View Follow" style="color: red; margin: 14px;">
							<img src="./img/iconfollowing.gif" style="margin: 0px 0px 13px 0px;" height="42" width="92"><b style="color:red;position:absolute; top:12%;left:45%; font-variant: small-caps;font-weight: 900;text-shadow:  3px 1px 1px 0ff">'.$unread_follow_numrows.'</b></a>
							</button>
							</form>
							</li>';
						}
					 
					
					echo '<li><a href="profile.php?u='.$user.'" title="Go to profile"><img src="'.$profile_pic.'" class="h_propic"  height="222" width="52"></a></li>
					<a href="newsfeed.php"  title="Go to newsfeed"><img  src="./img/AgonizingQuestionableBorer-small.gif" style="margin: 11px 2px 11px 11px; padding: 0 5px;" height="322" width="82"></a>
				</div>';
			}else {
				echo '<li class="logo"><a href="index.php" title="Go to Daowat Home" >daowat</a></li>
				<div style="float: right; margin-top: 10px;">
					<a href="signin.php" class="uiloginbutton" title="Log In" >Log In / Sign Up</a>
				</div>';
			}'
                            <li> <a href="#">Support </a></li><li>
    	</li><li>
    	<a href="index.php" style="color: red;">logout</a> 
    <?php endif ?></li>
                            <li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <img src="<?php echo $profile_pic; ?>" height="70" width="70" style="border-radius: 40px; margin: 20px 0 0 10px;border: 2px solid #fff;" /> 
                                <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="profile.php?u=<?php echo $user; ?>">Your Profile</a></li>
                                    <li><a  href="profile_update.php">Edit Profile</a></li>
                                    <li><a href="#">Account Settings</a></li>
                                    <li class="divider"></li>
                                    <li><button type="submit" name="logout" style=" margin-top: 11px; border-radius: 10px; border:none;
"><a href="logout.php" title="Log me out" style="font-weight: bold; margin: 3px 8px; font-size: 14px; color: #0B810B;">Logout</a>
</button></form></li>';
						
			?></a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
            </div>
            <!-- /navbar-inner -->
        </div>