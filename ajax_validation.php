<?php
include("_include.php");

//Theme settup light/dark
if(isset($_POST["theme"])){
$expire=time()+31536000; //365 days
setcookie('theme', $_POST["theme"], $expire, '/');
exit;
}
?>