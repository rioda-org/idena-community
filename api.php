<?php
require_once __DIR__ . '/_include.php';
require_once __DIR__ . '/_rpc.php';

//collect input stream
$content=file_get_contents('php://input');
$data=json_decode($content,true);


//check if wallet exists when creating wallet
if(isset($data["query"])){
if($data["query"]=="does_wallet_exist"){
	$res=mysqli_query($conn, "SELECT * FROM wallet WHERE round='{$round}'");
	$numrows=mysqli_num_rows($res);
	if($numrows==0)
		echo '{"msg":"no"}';
	else
		echo '{"msg":"yes"}';
exit;
}
}


//save wallet in DB
if(isset($data["wallet"])){
	$wallet=$data["wallet"];
	//does wallet exist for current round
	$res=mysqli_query($conn, "SELECT * FROM wallet WHERE round='{$round}'");
	$numrows=mysqli_num_rows($res);
	if($numrows==0){
		//what is the author of the multisig wallet?
		$url_api="{$idena_api}/api/contract/".$data["wallet"];
		$content=file_get_contents($url_api);
		$api_data=json_decode($content,true);
		$author=strtolower($api_data["result"]["author"]);
		//is the author active delegatee
		$res=mysqli_query($conn, "SELECT * FROM delegatee WHERE address='{$author}' AND active='1'");
		$numrows=mysqli_num_rows($res);
		if($numrows==1){
			//write to db
			mysqli_query($conn, "INSERT INTO wallet (round, address, author) VALUES ('{$round}','{$wallet}','{$author}')");
			echo '{"msg":"success"}';
		}
		else echo '{"msg":"Wallet author is not active delegatee"}';
	}
	else echo '{"msg":"Wallet allready exists for current round"}';
}


//update wallet table
if(isset($data["refresh_table"])){
$res=mysqli_query($conn, "SELECT * FROM wallet");
$numrows=mysqli_num_rows($res);
if($numrows==0)	echo '<tr><td colspan="4">No wallets available.</td></tr>';

while($row=mysqli_fetch_object($res)) {
$round=$row->round;
$address=$row->address;
$author=$row->author;
$data=dna_getBalance($address);
$balance=$data["result"]["balance"];
echo <<<EOT
{"round":"{$round}","address":"{$address}","author":"{$author}","balance":"{$balance}"}
EOT;
}
}

?>