toastr.options = {
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-right",
  "preventDuplicates": false,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

async function checkLogin() {
  if (document.getElementById('block2-pk').value.length == 120 && document.getElementById('block2-pass').value.length != 0) {
    Window.Wblock2();
	let pKey = document.getElementById('unencryptedPK').value;
	let addy = document.getElementById('addy').value;
	if(pKey.length==64 && addy.length==42)
	if(auth_address==addy){
		$("#signInLink").addClass("d-none");
		$("#createWalletLink").removeClass("d-none");
		$('#signInWallet').modal('toggle');
		toastr.success('Sign in was successfull.');
		let nonce = await getNonce(addy);
		let epoch = await getEpoch();
		nonce++;
		document.getElementById('nonce').value = nonce;
		document.getElementById('epoch').value = epoch;
	}
	else
		toastr.error('Incorrect sign in.');
	} else {
    toastr.error('Sign in was not successfull, data missing.');
	}
}

function getNonce(addy) {
    return axios.post('https://test.idena.site', {"method":"dna_getBalance","params":[addy],"id":1,"key":"test"}).then(response => response.data["result"].mempoolNonce)
}

function getEpoch() {
    return axios.get('https://api.idena.org/api/epoch/last').then(response => response.data["result"].epoch)
}

function sendRawTx(signedRawTx) {
    return axios.post('https://test.idena.site', {"method":"bcn_sendRawTx","params":[signedRawTx],"id":1,"key":"test"}).then(response => response.data.result);
}

function encodeAndSignRawTxDeplMltsg() {
	if (document.getElementById('nonce').value == "") {
	toastr.error("Error encoding rawTx.");
	} else {
		//encode it
		Window.encodeRawTxDeployMultisig();
		//sign it
		Window.signRawTx();
  }
}


async function createWallet() {
	encodeAndSignRawTxDeplMltsg();
	if (document.getElementById('signedRawTx').value == "") {
	toastr.error("Error creating wallet.");
	} else {
		let signedRawTx = document.getElementById('signedRawTx').value;
		let tx = await sendRawTx(signedRawTx);
		var fwdTx = tx;
		toastr.success('Transaction was sent');
		document.getElementById('resultTx').innerHTML = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div> Please wait...';
		setTimeout(function(){
			document.getElementById('resultTx').innerHTML = 'Check your transaction on Idena explorer:<br><a href="https://scan.idena.io/transaction/'+fwdTx+'" target="_blank">'+fwdTx+'</a>';
		}, 20000);
	}
}
