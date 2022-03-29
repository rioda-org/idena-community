<?php
//runs rpc's to the Idena node
function rpc($method){
	global $rpc_url;
	$postdata=json_encode($method);
	$ch=curl_init($rpc_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$result=curl_exec($ch);
	curl_close($ch);
	$data=json_decode($result,true);
	return $data;
}

//gets all identites and sorts them in a array that has idena addresses as keys
function dna_identities(){
	global $rpc_key;
	$method=array("method"=>"dna_identities","params"=>[],"id"=>1,"key"=>"{$rpc_key}");
	$data=rpc($method);

	$dna_identities=array();
	foreach($data["result"] as $value){
		$dna_identities[$value["address"]]=array(
		"state"=>$value["state"], 
		"totalShortFlipPoints"=>$value["totalShortFlipPoints"], 
		"totalQualifiedFlips"=>$value["totalQualifiedFlips"], 
		"age"=>$value["age"]
		);
	}
	return $dna_identities;
//$dna_identities["0xabc123ef45678"]["state"];
}

//gets balance for Idena address
function dna_getBalance($address){
	global $rpc_key;
	$method=array("method"=>"dna_getBalance","params"=>["{$address}"],"id"=>1,"key"=>"{$rpc_key}");
	$data=rpc($method);
	return $data;
//$data["result"]["balance"];
}

//gets info about Idena identity
function dna_identity($address){
	global $rpc_key;
	$method=array("method"=>"dna_identity","params"=>["{$address}"],"id"=>1,"key"=>"{$rpc_key}");
	$data=rpc($method);
	return $data;
}



?>