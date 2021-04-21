<?php

// initializing variables

$email    = "";
$password="";
$errors = array();
$rememberme="";
include ( "./inc/connect.inc.php" ); ?>
<?php 
session_start();
if (isset($_COOKIE['user_login'])) {
	$_SESSION['user_login'] = $_COOKIE['user_login'];
	header("location:../Html/index.php");
	exit();
}
// LOGIN USER
if (isset($_POST['login'])) {
		if (isset($_POST['user_login']) && isset($_POST['password_login'])) {
			$user_login = mysqli_real_escape_string($db,$_POST['user_login']);
			$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
			$password_login = mysqli_real_escape_string($db,$_POST['password_login']);
			$rememberme = $_POST['rememberme'];		
			$num = 0;
			$password_login_md5 = md5($password_login);
			$result = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login')  AND activated='1' AND blocked_user='0'");
			$num = mysqli_num_rows($result);
			$get_user_email = mysqli_fetch_assoc($result);
				$get_user_uname_db = $get_user_email['username'];
			if ($num>0) {
				$_SESSION['user_login'] = $get_user_uname_db;
				if ($rememberme != NULL) {
					setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
				}
				header('location:../Html/index.php');
				exit();
			}
			else {
				$result1 = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login') AND activated ='0'");
				$num1 = mysqli_num_rows($result1);
				$get_user_email = mysqli_fetch_assoc($result1);
				$get_user_name_db = $get_user_email['username'];
				$get_user_email_db = $get_user_email['email'];
				$get_user_confrmCode_db = $get_user_email['confirmCode'];
				if ($num1>0) {
					$_SESSION['user_loginn'] = $get_user_name_db ;
					$_SESSION['user_confrmCode'] = $get_user_confrmCode_db;
					$success_message = '
						<div class="maincontent_text" style="text-align: center;">
						<font face="bookman">Account activation code send to you. <br>
							Please check your mail: '.$get_user_email_db.'
						</font>
						<form action="signin.php" method="POST">
								Enter varification code:<input type="text" name="confrmCode" class="submRecov" size="30" required></br>
							
							<input class="submRecov" type="submit" name="submconfrmCode" id="senddata" value="Continue..">
						</form>
						</div>
						';
						//header('location: signin.php');
				}else {
					$result1 = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login')  AND blocked_user='1'");
					$num1 = mysqli_num_rows($result1);
					if ($num1>=1) {
						$success_message = '
						<h2><font face="bookman">Opps!!!</font></h2>
							<div class="maincontent_text" style="text-align: center;">
							<font face="bookman">This account has been blocked.<br>
							</font></div>';
					}else {
						$success_message = '
						<h2><font face="bookman">Sorry!!!</font></h2>
							<div class="maincontent_text" style="text-align: center;">
							<font face="bookman">Username or Password incorrect.<br>
							</font></div>';
					}
					//header('location: other-login.php');
				}
				
			}
		}

	}

if (isset($_POST['submconfrmCode'])) {
	$user_confrmCode_db = mysqli_real_escape_string($db,$_POST['confrmCode']);
	$user_loginnn = $_SESSION['user_loginn'];
	$result2 = mysqli_query($db,"SELECT * FROM users WHERE username='$user_loginnn' AND confirmCode='$user_confrmCode_db' AND activated='0'");
	$num2 = mysqlp_num_rows($result2);
	$get_user_info_f = mysqlp_fetch_assoc($result2);
	if ($num2>=1) {
		$password_update_query = mysqli_query($db,"UPDATE users SET activated='1', confirmCode='0' WHERE username='$user_loginnn'");
		
		//creating session
		$_SESSION['user_login'] = $user_loginnn;
				
				setcookie('user_login', $user_loginnn, time() + (365 * 24 * 60 * 60), "/");
				
				header('location:../Html/index.php');
				exit();
		
	}else {
		$success_message = '
			<div class="maincontent_text" style="text-align: center;">
			<font face="bookman">Incorect varification code
			</font>
			<form action="other-loginh.php" method="POST">
					Enter varification code:<input type="text" name="confrmCode" class="submRecov" size="30" required></br>
				
				<input class="submRecov" type="submit" name="submconfrmCode" id="senddata" value="Continue to naid">
			</form>
			</div>';
	}
}

?>

<?php
if(isset($_POST["name2check"]) && $_POST["name2check"] != ""){
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST['name2check']); 
    $sql_uname_check = mysqli_query($db,"SELECT id FROM users WHERE username='$username' LIMIT 1"); 
    $uname_check = mysqli_num_rows($sql_uname_check);
    if (strlen($username) < 5 || strlen($username) > 15 ) {
	    echo '<p style="color: #C10000; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;">5 - 15 characters please</p>';
	    exit();
    }
	if (is_numeric($username[0])) {
	    echo '<p style="color: #C10000; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;">First character must be a letter</p>';
	    exit();
    }
    if ($uname_check < 1) {
	    echo '<p style="color: #0B810B; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;">Success! Remember username for login</p>';
	    exit();
    } else {
	    echo '<p style="color: #C10000; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;"><strong>' . $username . '</strong> has taken! Choose another.</p>';
	    exit();
    }
}
?>