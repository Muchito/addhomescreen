<?php 

//check for noti
$check_for_post_noti = mysqli_query($db,"SELECT * FROM post_comments WHERE posted_to='$user' && posted_by != '$user' && opened='no' ORDER BY id DESC");
	$post_noti_num = mysqli_num_rows($check_for_post_noti);
	$noti_num=$post_noti_num;

//get msg row
$get_unread_query = mysqli_query($db,"SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no'");
$get_unread = mysqli_fetch_assoc($get_unread_query);
$unread_numrows = mysqli_num_rows($get_unread_query);
$unread_msg_numrows = $unread_numrows;

//get follow row
$get_follow_query = mysqli_query($db,"SELECT opened FROM follow WHERE user_to='$user' && opened='no'");
$get_follow = mysqli_fetch_assoc($get_follow_query );
$follow_numrows = mysqli_num_rows($get_follow_query );
$unread_follow_numrows = $follow_numrows;

//profile pic upload
$check_pic = mysqli_query($db,"SELECT profile_pic FROM users WHERE username='$user'");
$get_pic_row = mysqli_fetch_assoc($check_pic);
$profile_pic_db = $get_pic_row['profile_pic'];
						//check for propic delete
						$pro_changed = mysqli_query($db,"SELECT * FROM posts WHERE added_by='$user' AND (discription='changed his profile picture.' OR discription='changed her profile picture.') ORDER BY id DESC LIMIT 1");
						$get_pro_changed = mysqli_fetch_assoc($pro_changed);
		$pro_num = mysqli_num_rows($pro_changed);
		if ($pro_num == 0) {
			$profile_pic = "img/default_propic.png";
		}else {
			$pro_changed_db = $get_pro_changed['photos'];
		if ($pro_changed_db != $profile_pic_db) {
			$profile_pic = "img/default_propic.png";
		}else {
			$profile_pic = "userdata/profile_pics/".$profile_pic_db;
		}
		}

//getting user first message
$get_first_message = mysqli_query($db,"SELECT * FROM pvt_messages WHERE user_to='$user' ORDER BY id DESC LIMIT 1");
$first_message_row = mysqli_fetch_assoc($get_first_message);
$first_message_id = $first_message_row['id'];
$first_message_uname = $first_message_row['user_from'];
if (isset($_POST['gotoinbox'])) {
	$setopened_query = mysqli_query($db,"UPDATE pvt_messages SET opened='yes' WHERE user_to='$user'");
	header("location: messages.php?u=$first_message_uname");
}

//notification 
if (isset($_POST['gotonoti'])) {
	if ($post_noti_num > $daowat_noti_num) {
	     header("location: notification.php");
	}else {
	     header("location: notifications.php");
	     }
	$pstopened_query = mysqli_query($db,"UPDATE post_comments SET opened='yes' WHERE posted_to='$user'");
	$dwtopened_query = mysqli_query($db,"UPDATE daowat_comments SET opened='yes' WHERE daowat_to='$user'");
	
}

//followers
if (isset($_POST['gotofollow'])) {
	$pstopened_query = mysqli_query($db,"UPDATE follow SET opened='yes' WHERE user_to='$user'");
	header("location: followRequest.php");
}

//logout
if (isset($_POST['logout'])) {
	header("location: logout.php");
}
//signup
if (isset($_POST['signup'])) {
	header("location: signin.php");
}

?>


<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	$(function() {
	  $('body').on('keydown', '#search', function(e) {
	    console.log(this.value);
	    if (e.which === 32 &&  e.target.selectionStart === 0) {
	      return false;
	    }  
	  });
	});
</script>
<script type="text/javascript">
	$(function() {
	  $('body').on('keydown', '#comment', function(e) {
	    console.log(this.value);
	    if (e.which === 32 &&  e.target.selectionStart === 0) {
	      return false;
	    }  
	  });
	});
</script>


