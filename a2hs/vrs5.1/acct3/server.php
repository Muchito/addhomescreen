<?php include ( "./inc/connect.inc.php" ); ?>
<?php 
session_start();
if (isset($_COOKIE['user_login'])) {
	$_SESSION['user_login'] = $_COOKIE['user_login'];
	header("location: ../naid/index.php");
	exit();
}

if (isset($_POST['login'])) {
		if (isset($_POST['user_login']) && isset($_POST['password_login'])) {
			$user_login = mysqli_real_escape_string($db,$_POST['user_login']);
			$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
			$password_login = mysqli_real_escape_string($db,$_POST['password_login']);
			$rememberme = $_POST['rememberme'];		
			$num = 0;
			$password_login_md5 = md5($password_login);
			$result = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login') AND password='$password_login_md5' AND activated='1' AND blocked_user='0'");
			$num = mysqli_num_rows($result);
			$get_user_email = mysqli_fetch_assoc($result);
				$get_user_uname_db = $get_user_email['username'];
			if ($num>0) {
				$_SESSION['user_login'] = $get_user_uname_db;
				if ($rememberme != NULL) {
					setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
				}
				header('location: index.php');
				exit();
			}
			else {
				$result1 = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login') AND password='$password_login_md5' AND activated ='0'");
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
							
							<input class="submRecov" type="submit" name="submconfrmCode" id="senddata" value="Continue Daowat">
						</form>
						</div>
						';
						//header('location: signin.php');
				}else {
					$result1 = mysqli_query($db,"SELECT * FROM users WHERE (username='$user_login' || email='$user_login') AND password='$password_login_md5' AND blocked_user='1'");
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
					//header('location: signin.php');
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
				
				header('location: index.php');
				exit();
		
	}else {
		$success_message = '
			<div class="maincontent_text" style="text-align: center;">
			<font face="bookman">Incorect varification code
			</font>
			<form action="signin.php" method="POST">
					Enter varification code:<input type="text" name="confrmCode" class="submRecov" size="30" required></br>
				
				<input class="submRecov" type="submit" name="submconfrmCode" id="senddata" value="Continue Daowat">
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

<?php

if (isset($_POST['signup'])) {
//declere veriable
$u_name = $_POST['username'];
$u_name  = trim($u_name);
$u_name  = strtolower($u_name);
$u_name  = preg_replace('/\s+/','',$u_name);
$u_email = $_POST['email'];
//triming name
$_POST['first_name'] = trim($_POST['first_name']);
$_POST['username'] = trim($_POST['username']);
$_POST['username'] = strtolower($_POST['username']);
$_POST['username'] = preg_replace('/\s+/','',$_POST['username']);
	try {
		if(empty($_POST['first_name'])) {
			throw new Exception('Fullname can not be empty');
			
		}
		if (is_numeric($_POST['first_name'][0])) {
			throw new Exception('Please write your correct name!');

		}
		if(empty($_POST['username'])) {
			throw new Exception('Username can not be empty');
			
		}
		if (is_numeric($_POST['username'][0])) {
			throw new Exception('Username first character must be a letter!');

		}
		if(empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
			
		}
		if(empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
			
		}
		if(empty($_POST['gender'])) {
			throw new Exception('Gender can not be empty');
			
		}

		if (strlen($_POST['first_name']) <7 || strlen($_POST['first_name']) >20 )  {
			throw new Exception('Full name must be 8 to 20 characters!');
		}

		//username check
		$u_check = mysqli_query($db,"SELECT username FROM users WHERE username='$u_name'");
		$check = mysqli_num_rows($u_check);
		// Check if email already exists
		$e_check = mysqli_query($db,"SELECT email FROM users WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
		if (strlen($_POST['username']) >4 && strlen($_POST['username']) <16 ) {
			if ($check == 0 ) {
				if ($email_check == 0) {
					if (strlen($_POST['password']) >4 ) {
						$d = date("Y-m-d"); //Year - Month - Day
						$_POST['first_name'] = ucwords($_POST['first_name']);
						$_POST['username'] = strtolower($_POST['username']);
						$_POST['username'] = preg_replace('/\s+/','',$_POST['username']);
						$_POST['password'] = md5($_POST['password']);
						$confirmCode   = substr( rand() * 900000 + 100000, 0, 6 );
						// send email
						$msg = "
						Assalamu Alaikum... 
						
						Your activation code: ".$confirmCode."
						Username: ".$_POST['username']."
						Signup email: ".$_POST['email']."
						
						";
						//if (@mail($_POST['email'],"Daowat Activation Code",$msg, "From:Daowat <no-reply@daowat.com>")) {
							
						$result = mysqli_query($db,"INSERT INTO users (first_name,username,email,password,gender,sign_up_date,activated) VALUES ('$_POST[first_name]','$_POST[username]','$_POST[email]','$_POST[password]','$_POST[gender]','$d','1')");
						$_SESSION['user_loginn'] = $_POST['username'];
						
						//sent follow
						//$user_from = $_POST['username'];
						//$user_to = 'nur';
						//$create_followMe = mysql_query("INSERT INTO follow VALUES ('', '$user_from', '$user_to', NOW(), 'no')");
						//$create_followFrom = mysql_query("INSERT INTO follow VALUES ('', '$user_to', '$user_from', NOW(), 'no')");
						//send message
						//$msg_body = 'Assalamu Alaikum';
						//$msgdate = date("Y-m-d");
						//$opened = "no";
						//$messages = mysql_query("INSERT INTO pvt_messages VALUES ('','$user_to','$user_from','$msg_body','$msgdate','NOW()','$opened', '')");
						
						//success message
						$success_message = '
						<h2><font face="bookman">Registration successfull!</font></h2>
						<div class="maincontent_text" style="text-align: center;">
						<font face="bookman">You can login with usename or email. <br>
							Email: '.$u_email.'<br>
							Username: '.$_POST['username'].'
						</font></div>';
						//}else {
						//	throw new Exception('Email is not valid!');
						//}
						
						
					}else {
						throw new Exception('Password must be 5 or more then 5 characters!');
					}
				}else {
					throw new Exception('Email already taken!');
				}
			}else {
				throw new Exception('Username already taken!');
			}
		}else {
			throw new Exception('Username must be 5-15 characters!');
		}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}

//getting daowat post photo
$getposts = mysqli_query($db,"SELECT * FROM daowat WHERE photos != '' ORDER BY  RAND() ");
$row = mysqli_fetch_assoc($getposts);
$photos_db = $row['photos'];
$photosrow = "./userdata/daowat_pics/".$photos_db;


?>