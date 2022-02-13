<?php
session_start();
require __DIR__ .'_config.php';

$conn=mysqli_connect($host,$dbuser,$dbpass,$db);
if (mysqli_connect_errno())  { echo "Failed to connect to MySQL: ".mysqli_connect_error(); }
mysqli_set_charset($conn,"utf8");

//check login
if(isset($_GET["token"])){
	$token=$_GET["token"];
	$res=mysqli_query($conn, "SELECT address FROM auth WHERE token='{$token}' AND auth_success='1'");
	$numrows=mysqli_num_rows($res); $res or die ("Unable to execute query.");

	if($numrows==1){
		while($row=mysqli_fetch_object($res)) {
		$_SESSION["address"]=$address=$row->address;
		
		//check if it's active delegatee
		$resD=mysqli_query($conn, "SELECT * FROM delegatee WHERE address='{$address}' AND active='1'");
		$numrowsD=mysqli_num_rows($resD);
		if($numrowsD==1){
		$_SESSION["delegatee"]="yes";
			while($rowD=mysqli_fetch_object($resD)) {
			$_SESSION["nickname"]=$rowD->nickname;
			}
		}
		header("location:{$url}");
		}
	}
}

//read data
$res=mysqli_query($conn, "SELECT * FROM round ORDER BY idround ASC LIMIT 1");
while($row=mysqli_fetch_object($res)) {
	$round=$row->idround;
}


//read theme light/dark
if(isset($_COOKIE["theme"])){
if($_COOKIE['theme']=="dark")$theme="dark";
elseif($_COOKIE['theme']=="light")$theme="light";
else $theme="dark";}
else $theme="dark";

ini_set('display_errors', "On");
ini_set('display_startup_errors', "On");
error_reporting(E_ALL);


function guid(){
if(function_exists('com_create_guid') === true)
return trim(com_create_guid(), '{}');
$data = openssl_random_pseudo_bytes(16);
$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
$data[8] = chr(ord($data[8]) & 0x3f | 0x80);
return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

//checks idena address format
function isIdnaAddress($address) {
return preg_match('/^0x[0-9a-f]{40}$/i', $address);
}

//checks guid token format
function isToken($token) {
return preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/', $token);
}

//checks nonce format
function isSignature($signature) {
return preg_match('/^0x[0-9a-f]{130}$/i', $signature);
}

//agent/device/browser
@$agent=$_SERVER['HTTP_USER_AGENT'];
//GET VISITOR IP
function getUserIpAddr(){
if(!empty($_SERVER['HTTP_CLIENT_IP'])){
//ip from share internet
$ip = $_SERVER['HTTP_CLIENT_IP'];
}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
//ip pass from proxy
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}else{$ip = $_SERVER['REMOTE_ADDR'];}
return $ip;}

function test_input($data) {
$data=trim($data);
$data=stripslashes($data);
$data=htmlspecialchars($data);
return $data;
}

//format date for echo
function date_echo($arg)
{$arg=substr($arg, 8, 2).'.'.substr($arg, 5, 2).'.'.substr($arg, 0, 4).'.'; //22.3.2012.
if($arg=="00.00.0000." || $arg=="...")
$arg="";
return $arg;
}

//format date for db
function date_db($arg)
{$arg=substr($arg, 6, 4).'-'.substr($arg, 3, 2).'-'.substr($arg, 0, 2); //2012-09-02
return $arg;}

//(hh:mm:ss) to (sec)
function timeToSeconds($time)
{  $timeExploded = explode(':', $time);
     if (isset($timeExploded[2])) {
         return $timeExploded[0] * 3600 + $timeExploded[1] * 60 + $timeExploded[2];
     }
     return $timeExploded[0] * 3600 + $timeExploded[1] * 60;
}

//(sec) to (hh:mm:ss)
function secondsToTime($t,$f=':') // t = seconds, f = separator 
{return sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);}


?>