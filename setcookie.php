<?php
require __DIR__ .'/_config.php';
//get token
if(isset($_GET["token"])){
	$token=$_GET["token"];
	//set cookie to remember auth session for 2 months
	$expire = time()+60*60*24*60; //60 days
	setcookie('remember_auth', $token, $expire, '/');
	
	//delete session tokens older than 60 days
	$conn=mysqli_connect($host,$dbuser,$dbpass,$db);
	mysqli_query($conn, "DELETE FROM auth WHERE auth_time < now() - interval 60 DAY");
	header("location:/");
}
?>