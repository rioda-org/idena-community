async function checkLogin() {
  if(document.getElementById('encrypted_private_key').value.length == 120 && document.getElementById('password').value.length != 0) {
    Window.decryptAndAddress();
	if(auth_address==sessionStorage.getItem("address")){
		$("#signInLink").addClass("d-none");
		$("#createWalletLink").removeClass("d-none");
		$('#signInWallet').modal('toggle');
		toastr.success('Sign in was successfull.');
	}
	else
		toastr.error('Sign in was not successfull.');
   }
   else {toastr.error('Sign in was not successfull, data missing.');}
}


async function createWallet() {
//check if wallet allready exists
let exists = await axios.post('/api.php', {"query":"does_wallet_exist"}).then(response => response.data.msg);
	if (exists == "no"){
		sessionStorage.nonce = await getNonce(sessionStorage.getItem("address"));
		sessionStorage.nonce++;
		sessionStorage.epoch = await getEpoch();
		encodeAndSignRawTxDeplMltsg();
		if (sessionStorage.getItem("signedRawTx") == "") {
		toastr.error("Error creating wallet. Signed Tx is not found.");
		} else {
			var tx = await sendRawTx(sessionStorage.getItem("signedRawTx"));
			toastr.success('Transaction was sent');
			document.getElementById('resultTx').innerHTML = '<div class="spinner-border" role="status"><span class="sr-only"> Please wait for a transaction result.</span></div> Please wait for a transaction result.';
			let confirmed="no";
			while(confirmed=="no"){
					//wait 5 sec
					await new Promise(resolve => setTimeout(resolve, 5000));
					//check if tx is confirmed and contract deployed successfully
					try {var txResult = await txReceiptSuccess(tx);} catch (e){var txResult = "not ready";}
					if(txResult==true){
						confirmed="yes"
						//multisig wallet address
						let wallet = await txReceiptContract(tx);
						//save wallet in DB
						let saveWl2DB = await axios.post('/api.php', {"wallet":wallet}).then(response => response.data.msg);
						if(saveWl2DB=="success"){
							toastr.success('Wallet has been created');
							//refresh wallets table
							refreshWalTB();
							document.getElementById('resultTx').innerHTML = '';
						}
						else 
							toastr.error('Error creating wallet');
					}
			}
		}
	} 
	else {toastr.error("Wallet allready exists for this round.");}
}


function getNonce(address) {
    return axios.post(rpc_url, {"method":"dna_getBalance","params":[address],"id":1,"key":rpc_key}).then(response => response.data["result"].mempoolNonce);
}

function getEpoch() {
    return axios.post(rpc_url, {"method":"dna_epoch","params":[],"id":1,"key":rpc_key}).then(response => response.data["result"].epoch);
}

function encodeAndSignRawTxDeplMltsg() {
	//encode it
	Window.encodeRawTxDeployMultisig();
	//sign it
	Window.signRawTx();
}

function sendRawTx(signedRawTx) {
    return axios.post(rpc_url, {"method":"bcn_sendRawTx","params":[signedRawTx],"id":1,"key":rpc_key}).then(response=>response.data.result);
}


function txReceiptSuccess(tx) {
	return axios.post(rpc_url, {"method":"bcn_txReceipt","params":[tx],"id":1,"key":rpc_key}).then(response => response.data.result.success);
}

function txReceiptContract(tx) {
    return axios.post(rpc_url, {"method":"bcn_txReceipt","params":[tx],"id":1,"key":rpc_key}).then(response => response.data.result.contract);
}


async function refreshWalTB() {
	await axios.post('/api.php', {"refresh_table":"yes"}).then(function (response) {
		round=response.data.round;
		address=response.data.address;
		author=response.data.author;
		balance=response.data.balance;
	});
	
	document.getElementById('walletsTable').innerHTML = `<tr>
	<td>${round}</td>
	<td><img src='https://robohash.org/${author}' width='32px' height='32px' class='img-circle border rounded-circle'></td>
	<td><a href="https://scan.idena.io/contract/${address}" target="_blank">${address}</a></td>
	<td>${balance} iDNA</td>
	<td>0</td>
	</tr>`;
}