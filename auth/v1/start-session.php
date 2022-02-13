<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../_config.php';

$error=0;

//collect input stream
$content=file_get_contents('php://input');
$data=json_decode($content,true);

//do token and address exist?
if(!isset($data['token']) OR !isset($data['address'])) $error++;

//do they have correct format?
if(isIdnaAddress($data['address'])==0) $error++;
if(isToken($data['token'])==0) $error++;

//if there is no error
if($error==0){
	//lowercase them just in case
	$token=strtolower($data['token']);
	$address=strtolower($data['address']);
	$nonce="signin-".guid();
	$ip_address=getUserIpAddr();
	$start_auth=date('Y-m-d H:i:s');
	//start session by entering token in auth table
	//agent, if idena=DesktopApp, if axios=WebApp
	mysqli_query($conn, "INSERT INTO auth (token,address,nonce,ip_address,start_auth,agent)
VALUES ('{$token}','{$address}','{$nonce}','{$ip_address}','{$start_auth}','{$agent}')");

echo '{"success":true,"data":{"nonce":"'.$nonce.'"}}';
}
else
	echo '{"success":false,"error":"Ser? What are you trying?"}';
?>