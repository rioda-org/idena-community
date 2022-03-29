<?php
require_once __DIR__ . '/_include.php';
require_once __DIR__ . '/_head.php';
$now=date('Y-m-d H:i:s');
?>
<body>
<!-- Place GTM -->
<div class="container">
<?php include("_nav.php");?>
<br>
<h4><?php echo "Round ".$round;?></h4><br>
<h5>Wallets
<?php 
if(isset($_SESSION["delegatee"])) {
	echo '<a href="#" data-toggle="modal" data-target="#signInWallet" class="ml-3" title="Sign in" id="signInLink">
	<i class="fas fa-sign-in-alt"></i> Sign in</a>';
	
	//do we have wallet for current round?
	$res=mysqli_query($conn, "SELECT * FROM wallet WHERE round='{$round}'");
	$numrows=mysqli_num_rows($res);
	if($numrows==0)
	echo '<a href="#" class="ml-3 d-none" title="Create wallet" onclick="createWallet()" id="createWalletLink">
	<i class="fas fa-wallet"></i> Create wallet</a>';
}
//After sign in, address is checked, if he's not active delegatee, can't do nothing with multisig wallet thingy
?>
</h5>

<div class="table-responsive-sm">
  <table class="table table-hover">
    <thead>
	  <tr>
        <th>Round</th>
		<th>Author</th>
        <th>Address</th>
        <th>Balance</th>
		<th>Voters</th>
      </tr>
    </thead>
    <tbody id="walletsTable"></tbody>
  </table>
</div>

<hr>

<div id="resultTx"></div>


<!-- Modal sign in for wallet -->
<div id="signInWallet" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	    <h5 class="modal-title">Sign in like you would do in <a href="https://app.idena.io/" target="_blank">Idena Web App</a>:</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<div id="login">
		<form>
		<div class="form-group">
		<input type="text" class="form-control" id="encrypted_private_key" placeholder="Encrypted private key" value="">
		</div>
		<div class="form-group">
		<input type="password" class="form-control" id="password" placeholder="Password" value="">
		</div>
		</form>
		<button class="btn btn-secondary btn-block" onclick="checkLogin()">Sign in</button>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- END modal sign in for wallet -->

</div><!-- end container  -->

<?php include("_footer.php");?>

<script>
<?php
if(isset($_SESSION["delegatee"]))
echo <<<EOT
const auth_address="{$_SESSION["address"]}";
sessionStorage.round = {$round};
EOT;
?>

//check if delegatee is allready signed in
let address=sessionStorage.getItem("address");
if(address==auth_address){
	$("#signInLink").addClass("d-none");
	$("#createWalletLink").removeClass("d-none");
}

//initialisation
$(document).ready(function(){
refreshWalTB();
});
</script>

<script src="./js/script.js"></script>
<script src="./js/axios.min.js"></script>
<script src="./js/bundle.js"></script>
</body>
</html>