<?php
session_start();
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../_include.php';
use Elliptic\EC;
use kornrunner\Keccak;


$error=0;
//collect input stream
$content=file_get_contents('php://input');
$data=json_decode($content,true);

//do token and signature exist?
if(!isset($data['token']) OR !isset($data['signature'])) $error++;
else {
	//let's check token and signature format
	if(isToken($data['token'])==0) $error++;
	if(isSignature($data['signature'])==0) $error++;
	
if($error==0){
	//do we have that token in db?
	$token=$data['token'];
	$res=mysqli_query($conn, "SELECT address, nonce FROM auth WHERE token='{$token}'");
	$numrows=mysqli_num_rows($res); $res or die ("Unable to execute query.");

	if($numrows==1){
		while($row=mysqli_fetch_object($res)) {
		$address=$row->address;
		$nonce=$row->nonce;
		}
	}
	else
		$error++;
	
	if($error==0){
	//nonce and adress are available, lets decrypt signature and check if they match

	function pubKeyToAddress($pubkey){
		return "0x".substr(Keccak::hash(substr(hex2bin($pubkey->encode("hex")),1),256),24);
	}
	
	$signature=$data['signature'];
	
	function verifySignature($nonce, $signature, $address){
		$hash = Keccak::hash(pack("H*", Keccak::hash(pack("H*", bin2hex($nonce)) , 256)) , 256);
		$sign = ["r" => substr($signature, 2, 64) , "s" => substr($signature, 66, 64) ];
		$recid = ord(hex2bin(substr($signature, 130, 2)));
		if ($recid != ($recid & 1)) return false;
		$ec = new EC('secp256k1');
		$pubkey = $ec->recoverPubKey($hash, $sign, $recid);
		return $address == pubKeyToAddress($pubkey);
	}
	
	//if signature is verified, success
	if(verifySignature($nonce, $signature, $address)) {
        //write to db time of successfull auth
		$auth_time=date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE auth SET auth_time='{$auth_time}', auth_success='1' WHERE token='{$token}'");
        echo '{"success":true,"data":{"authenticated":true}}';
    }
	else {
		//write unsuccessfull authentication
		$auth_time=date('Y-m-d H:i:s');
		mysqli_query($conn, "UPDATE auth SET auth_time='{$auth_time}', auth_success='0' WHERE token='{$token}'");
		header('Content-Type: application/json');
		echo '{"success":true,"data":{"authenticated":false}}';
	}

}

}

}

if($error>0){
	echo '{"success":true,"data":{"authenticated":false}}';
}
?>