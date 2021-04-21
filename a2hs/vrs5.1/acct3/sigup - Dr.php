<?php include ( "./inc/connect.inc.php" ); ?>
<?php 
session_start();
if (isset($_COOKIE['user_login'])) {
	$_SESSION['user_login'] = $_COOKIE['user_login'];
	header("location: index.php");
	exit();
}


?>

<?php
if(isset($_POST["name2check"]) && $_POST["name2check"] != ""){ 
$email = $_POST['email'];
    $sql_uname_check = mysqli_query($db,"SELECT id FROM users WHERE email='$email' LIMIT 1"); 
    $uname_check = mysqli_num_rows($sql_uname_check);
	
    if ($uname_check < 1) {
	    echo '<p style="color: #0B810B; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;">Success! Remember email for login</p>';
	    exit();
    } else {
	    echo '<p style="color: #C10000; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;"><strong>' . $email . '</strong> has taken! Choose another.</p>';
	    exit();
    
    }
}if(isset($_POST["tell2check"]) && $_POST["tell2check"] != ""){ 
$tell=$_POST['phone'];
	$sql_utell_check = mysqli_query($db,"SELECT id FROM users WHERE mobile='$tell' LIMIT 1"); 
    $utell_check = mysqli_num_rows($sql_uname_check);
     if ($utell_check < 1) {
	    echo '<p style="color: #0B810B; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;">Success! Remember tell for login</p>';
	    exit();
    } else {
	    echo '<p style="color: #C10000; font-size: 13px; font-weight: 600; text-align: center; margin: 3px 0;"><strong>' .$tell . '</strong> has taken! Choose another.</p>';
	    exit();
    }
}
?>

<?php

if (isset($_POST['signup'])) {
//declere veriable
$u_name = $_POST['first_name'];
$u_name2 = $_POST['Second_name'];
$u_email = $_POST['email'];
$Public = $_POST['Public'];
//triming name
$_POST['first_name'] = trim($_POST['first_name']);
$_POST['Second_name'] = trim($_POST['Second_name']);
$tell=$_POST['phone'];
$sex=$_POST['gender'];
	try {
		if(empty($_POST['first_name'])) {
			throw new Exception('Firstname can not be empty');
			
		}
		if (is_numeric($_POST['Second_name'][0])) {
			throw new Exception('Please write your correct name!');

		}
		if(empty($_POST['Second_name'])) {
			throw new Exception('Second name can not be empty');
			
		}
		if (is_numeric($_POST['Second_name'][0])) {
			throw new Exception('Second name first character must be a letter!');

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

		if (strlen($_POST['first_name']) <2 || strlen($_POST['first_name']) >10 )  {
			throw new Exception('first_name must be 8 to 20 characters!');
		}
		if (strlen($_POST['Second_name']) <2 || strlen($_POST['Second_name']) >10 )  {
			throw new Exception('first_name must be 8 to 20 characters!');
		}

		//username check
		$u_check = mysqli_query($db,"SELECT username FROM users WHERE First_name='$u_name' || username='$u_name2' ");
		$check = mysqli_num_rows($u_check);
		//phone check
		$m_check = mysqli_query($db,"SELECT username FROM users WHERE mobile='$tell'");
		$mobile_check = mysqli_num_rows($u_check);
		// Check if email already exists
		$e_check = mysqli_query($db,"SELECT email FROM users WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
			if ($check == 0 ) {
				if ($email_check == 0) {
					if ($mobile_check == 0) {
					if (strlen($_POST['password']) >4 ) {
						$d = date("Y-m-d"); //Year - Month - Day
						$_POST['password'] = md5($_POST['password']);
						$confirmCode   = substr( rand() * 900000 + 100000, 0, 6 );
						// send email
						$msg = "
						Welcome To The Fantastic World Of Online Medicines... 
						
						Your activation code: ".$confirmCode."
						Username: ".$_POST['first_name']." ".$_POST['Second_name']."
						Signup email: ".$_POST['email']."
						tell: ".$_POST['phone']."
						
						";
						//if (@mail($_POST['email'],"Naid Activation Code",$msg, "From:Daowat <no-reply@daowat.com>")) {
							
						$result = mysqli_query($db,"INSERT INTO users (first_name,username,email,password,gender,sign_up_date,activated,Category,speciality) VALUES ('$_POST[first_name]','$_POST[Second_name]','$_POST[email]','$_POST[password]','$_POST[gender]','$d','0','$_POST[cat]','$_POST[Public]')");
						$_SESSION['user_loginn'] = $_POST['first_name'];
						
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
						<div class="maincontent_text" style="text-align: left;">
						<font face="bookman">You can login with phone number or email. <br>
							Email: '.$u_email.'<br>
							Username: '.$_POST['first_name'].'
						</font></div>';
				
						
						
					}else {
						throw new Exception('Password must be 5 or more then 5 characters!');
					}
				}else {
					throw new Exception('Phone number already taken!');
					}}
					else {
					throw new Exception('Email already taken!');
				}
			}else {
				throw new Exception('User already Exist!');
			}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}



?>



<!doctype html>
<html>
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<link rel="stylesheet" href="build/css/intlTelInput.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>aid</title><link rel="icon"  href="title.png" type="image/x-icon">
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	    <script type="text/javascript">
		  <!--
		  
		  //-->
		</script>
		<script src="js/modernizr.custom.js"></script>
		<script src="js/hideShowPassword.js"></script>	
		<script>
			$(window).ready(function(){
				$('#password-1').hideShowPassword({
				  // Creates a wrapper and toggle element with minimal styles.
				  innerToggle: true,
				  // Makes the toggle functional in touch browsers without
				  // the element losing focus.
				  touchSupport: Modernizr.touch
				});
			});
		</script>
		
	    <script src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
		<script type="text/javascript">
			$(function() {
			  $('body').on('keydown', '#first_name', function(e) {
			    console.log(this.value);
			    if (e.which === 32 &&  e.target.selectionStart === 0) {
			      return false;
			    }  
			  });
			});
		</script>
		<script type="text/javascript" language="javascript">
		
		function checkemail(){
			var status = document.getElementById("emailstatus");
			var u = document.getElementById("email").value;
			if(u != ""){
				status.innerHTML = 'checking email...';
				var hr = new XMLHttpRequest();
				hr.open("POST", "signin.php", true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						status.innerHTML = hr.responseText;
					}
				}
		        var v = "name2check="+u;
		        hr.send(v);
			}
		}function checktell(){
			var status = document.getElementById("tellstatus");
			var u = document.getElementById("tell").value;
			if(u != ""){
				status.innerHTML = 'checking number...';
				var hr = new XMLHttpRequest();
				hr.open("POST", "signin.php", true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						status.innerHTML = hr.responseText;
					}
				}
		        var v = "tell2check="+u;
		        hr.send(v);
			}
		}
		</script>
		<script type="text/javascript">
			function clean (username) {
				var textfield = document.getElementById(username);
				var regex = /[^a-z0-9]/g;
				textfield.value = textfield.value.replace(regex, "");
			    }
		</script>
		
	</head>
	<body style="background-color: #f8f8f8">

	
<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container"><ul class="nav pull-right">

						<li><a href="passRecover.php">
							Forgot password
						</a></li>

						

						<li><a href="other-login.php">
						Sign in
						</a></li>
					</ul>
				

			  	<a class="brand" href="index.html">
			  		<img src="Untitled-1.png" height="1%">aid
			  	</a>

				<div class="nav-collapse collapse navbar-inverse-collapse">
				
					
				</div><!-- /.nav-collapse -->
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar-inner -->
	

			<div class="wrapper" style=" background-color:#f8f8f8;">
							<br><br><br>
								<div class="container" style="width:100%; background-color:#f8f8f8;">	     <div class="row"  style=" background-color:#f8f8f8;">
                    <div  class="span3">
                        <div class="sidebar"><ul style="position:relative; background-color:#f8f8f8;left:20px" class="widget widget-menu unstyled">
                         <div >
				<div>
					<div >
						<div>
							<div>
							   <?php
								if (isset($success_message)) {
									echo $success_message;
								}else {
									echo '<br>
									   <h2><font face="bookman">Enjoy <b style="color:red">O</b>nline Medicines  !</font></h2>
										<div class="maincontent_text">
										<font face="bookman">Join Naid now ! <br>
											<li>Connect with your family And Freinds.</li>
											<li>Get Medic Assistance 100% Assured in seconds.</li>
											<li>Get Medi-update all-over the world.</li>
										</font>
										</div>
									';
								}
							   ?>
								
							</div> <div style="color:red;" class="signup_error_msg"><h2>Form Validation</h2>
									<?php 
										if (isset($error_message)) {echo $error_message;}
										else{ echo'<div><div style=" background-color:  rgba(8, 220, 195, 0.5); border:1px solid rgba(8, 220, 195, 0.5); color:white; top:10%;width:102%"  class="alert alert-info">Enter your username or email address below., We will then send a special link to your email. After you click on that link, you will be asked to enter a new password.
										while we verify your documents
										<br ><h1 style="color:black">NB: any false document is againts article A100 of the doctors terms and conditions</h1></div>';}
									?>
									</div>


								</div>
							</div>
						</div>
					</div>
				</div>
		   
                        </div>
                        <!--/.sidebar-->
                    </div>
				
				<div class="module12 module-login span4 offset4" >
									<form style="background-color:#f8f8f8"action=""class="form-vertical" method="POST" class="registration">
									<div>
							<h3>Sign Up AS :pls select category</h3>
						</div>
										<div class="module-body">
											<div>
												<label class=""><b style="position:relative; top:22px">Doctor</b><b style="background-color:white; border: 1.3px solid #05edfc;color:#31708f"class="  label green pull-left"><input onclick="check()" type="checkbox" value="Dr."   name="cat" ><img src="follow3.png" width="80%"></b></b></label>
				  <label class=""><b style="position:relative; float:right;top:22px">PATIENT</b><b style="background-color:white; border: 1.3px solid #f0f;border-bottom: solid #f8f8f8 ;color:#31708f"class="  label green pull-right"><a href="sigup.php"><img src="pt.png"  width="40%" ><img src="follow3s.png" width="80%"></a></b></b>
				  </label><br><br>
				  
			
		<hr style="border: 1.3px solid #f0f">
		
		<div class="control-group" data-validate="Name is required">
						<div class="controls row-fluid">
									
												     <input name="first_name"  style="background-color: #ffffff;
border: 1.3px solid #08e1ea;color:#31708f;"class="span12" id="username" placeholder="First name" required="required" onBlur="checkusername()" onkeyup="clean('username')" onkeydown="clean('username')" class="user_name signupbox signupbox_wihei" type="text" size="30" value="" >
		
												<td style=" margin: 10px; padding: 2px; background-color: white;">
												<p id="usernamestatus"></p>

												</td>
												<input name="Second_name"  class="span12" style="background-color: #ffffff;
border: 1.3px solid #08e1ea"id="Second_name" placeholder="Second name" required="required" class="first_name signupbox_wihei signupbox" type="text" size="30" value="" >
									
											</div>
					</div>
		<hr>			
<div class="control-group" data-validate="Name is required">
						<div class="controls row-fluid">
													<input name="email" class="span12"  onBlur="checkemail()" id="email" style="background-color: white;
border: 1.3px solid #08e1ea"  placeholder="email..@gmail.com" required="required" class="email signupbox signupbox_wihei" type="email" size="30" value="">
                                                												<td style=" margin: 10px; padding: 2px; background-color: white;">
												<p id="emailstatus"></p>

												</td>
												</div>
					
<div class="controls row-fluid">
												
					
												
													<input style="background-color: #ffffff;
border: 1.3px solid #08e1ea;border-bottom:1.3px solid white"name="password"  class="span12" id="password-1" required="required" style="overflow: hidden; padding-right: 7px;" placeholder="Enter New Password" class="password signupbox passbox_wihei" type="password" size="30" value="">
											
											</div>

						<div class="controls row-fluid">
												
													<input  style="background-color: #ffffff; color:white;
border: 1.3px solid #08e1ea;border-top:1.3px solid white" name="password"  class="span12" id="password-1" required="required" style="overflow: hidden; padding-right: 7px;" placeholder="cofirm New Password" class="password signupbox passbox_wihei" type="password" size="30" value="">
											
											</div></div><hr>
<select name="Public" style="border-color:#08e1ea" >
            <option style="font-size:12px;height:20px">Select speciality
           </option>
      <option  value="Alldoc" ><div style="">Generalist</div></option>
      <option   value="Herbalist" >Herbalist</option>
        <option  value="Nurse"  >Nurse assisted</option>
        <option   value="Pediatric Surgery" >Child/Delivery</option>

    <option >------------------------------</option>

           <option   >Optician </option>
              <option  name="Dentist" value="Dentist" >Dentist</option>
              <option  name=" Cardiologist" value="Cardiologist" >Cardiologist </option><option   value="Covid_19" style="color: red" >Covid 19</option>
              <option  value="Seogeon" >Seogeon </option>
              <option value="Gynaecologist" >Gynaecologist </option>
              <option  value="Urologist">Urologist </option>
              <option value="Medical Oncologist" >Medical Oncologist</option>
              <option  value="Neurologist" >Neurologist </option>
              <option  value="Gastronomist" >Gastronomist </option>
              <option  value="Nephrologist" >Nephrologist </option>
              <option value="Pneumologist" >Pneumologist </option>
              <option  value="Anathesian/Resuscitatist" >Anathesian/Resuscitatist </option>
              <option  value="Clinical biologist" >Clinical biologist </option>
              <option  value="Radiologist" >Radiologist </option>
              <option  value="Microbiologist" >Microbiologist </option>
              <option  value="Chemical Pathologist" >Chemical Pathologist</option>
              <option  value="Anatomy/Pathologist" >Anatomy/Pathologist </option>
              <option  value="Neurosurgery" >Neurosurgery </option>
              <option  value="General Surgery" >General Surgery</option>
              <option  value="Pediatric Surgery" >Pediatric Surgery</option>
              <option  value="Orthopedic Surgery" >Orthopedic Surgery</option>
              <option  value="Internal Medicine" >Internal Medicine</option>
           
        </select><br><input id="phone" name="phone" style="height:5%;border-color: #08e1ea" type="tel" placeholder="(+237)******" >										
				      <div style="width:15%;margin:0 0 0 10px"class="btn btn-mdb-color btn-rounded float-Right">
        <input type="file">
      </div>
    </div>
									
									
		sex :
<label class="checkbox">
	<input  type="checkbox" name="gender" value="1" >male
	</label>
	<label class="checkbox">
	<input  type="checkbox" name="gender" value="2" />female
</label>



		<button  class="button button1">>>verify</button> <input name="signup" class="button button3" type="submit" value="Sign Me Up!"><button type="reset"  class="button button5" style="float:right">reset</button>
										</div>
									</form>
						
</div><style>
.input2 {background-color: #05edfc17;
border: 1.3px solid #ff00ff;}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    cursor: pointer;
}

.button1 {
    background-color:#088bff ; 
    color: #ffffff ; 
  
}

.button1:hover {
    background-color:#f8f8f8;
    color: #088bff;
}



.button3 {
    background-color: #f44336; 
    color: #f8f8f8; 
   
}

.button3:hover {
    background-color: #f8f8f8;
    color: #f44336;
}

.button4 {
    background-color:#f8f8f8;
    color: black;

}

.button4:hover {background-color: #e7e7e7;}

.button5 {
    background-color: #f8f8f8;
    color: black;
   
}

.button5:hover {
    background-color: #555555;
    color: white;
}
.intl-tel-input {
  display: table-cell;
}
.intl-tel-input .selected-flag {
  z-index: 4;
}
.intl-tel-input .country-list {
  z-index: 5;
}
.input-group .intl-tel-input .form-control {
  border-top-left-radius: 4px;
  border-top-right-radius: 0;
  border-bottom-left-radius: 4px;
  border-bottom-right-radius: 0;
}
</style>
<div style="overflow:hidden;">
    <div class="form-group">
        <div class="row">
            <div class="col-md-8">
                <div id="datetimepicker12"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true
            });
        });
    </script>
</div>
	
	

		<script type="text/javascript">
		// Material Select Initialization
$(document).ready(function() {
$('.mdb-select').materialSelect();
});
		$("input").intlTelInput({
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
});
			function check(){
Swal.fire({
  title: '<strong><u>Wait !</u></strong>',
  type: 'info',
  html:
    'You must Read <b>Doctors</b>, ' +
    '<a href="//sweetalert2.github.io"> terms and conditions</a> ' +
    'and not forgetting required attestation',
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Now!',
  confirmButtonAriaLabel: 'Thumbs up, Read!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>Later !',
  cancelButtonAriaLabel: 'Thumbs down',
  background: '#fff ',
 backdrop: `
    rgba(0, 255, 225, 0.09)
  `
})
Swal.fire({
    title: '<strong><u>Wait !</u></strong>',
  type: 'info',
  html:
    'You must read <b>Doctors</b>, ' +
    '<a href="//sweetalert2.github.io">terms and conditions</a> ' +
    'and other  tags',
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Now!',
  confirmButtonAriaLabel: 'Thumbs up, Read!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>Later!',
  cancelButtonAriaLabel: 'Thumbs down',
  background: '#fff ',
  backdrop: `
    rgba(0, 255, 225, 0.09)
  `
			})}function check1(){
Swal.fire({
  title: '<strong><u> Wait</u></strong>',
  type: 'error',
  html:
    '<b> (includes an obligatory upload during signup !)</b>, ' +
    '<a href="//sweetalert2.github.io"> pls u most be in possesion of any attestation of workmanship thnks click for details:</a> ' +
    'searious.'
	,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> <a style="color:white" href="sigup - Dr.php"> continue...</a>',
  confirmButtonAriaLabel: 'Thumbs up, Read!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>Cancel!',
  cancelButtonAriaLabel: 'Thumbs down',
  background: '#fff ',
 backdrop: `
    rgba(0, 255, 255, 0.09)
  `
})

Swal.fire({
     title: '<strong><u> Wait ! </u></strong>',
  type: 'error',
  html:
    '<b>Doctor (includes an obligatory upload during signup !)</b>, ' +
    '<a href="//sweetalert2.github.io"> pls u most be in possesion of any attestation of workmanship thanks <ul>click for details:</ul></a> ' +
    'and other tags',
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i>  <a style="color:white"  href="sigup - Dr.php">continue...</a>',
  confirmButtonAriaLabel: 'Thumbs up, Read!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>Cancel!',
  cancelButtonAriaLabel: 'Thumbs down',
  background: '#fff ',
  backdrop: `
    rgba(0, 255, 225, 0.09)
   
  `
			})}</script>
			<script src="build/js/intlTelInput.js"></script>
  <script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
      // preferredCountries: ['cn', 'jp'],
      // separateDialCode: true,
      utilsScript: "build/js/utils.js",
    });
  </script></div></body>						
