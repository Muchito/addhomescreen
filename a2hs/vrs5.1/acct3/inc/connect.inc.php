<?php 

$db = mysqli_connect('', '', '', '');
//time formate
function formatDate($date){
	return date('F j, Y, g:i a', strtotime($date));
}
 ?>
