<?php
require_once __DIR__ . '/_config.php';
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
	echo '<a href="#" data-toggle="modal" data-target="#signInWallet" class="ml-3" title="Sign in" id="signInLink"><i class="fas fa-sign-in-alt"></i> Sign in</a>';
	
	//do we have wallet for current round?
	$res=mysqli_query($conn, "SELECT * FROM wallet WHERE round='{$round}'");
	$numrows=mysqli_num_rows($res);
	if($numrows==0)
	echo '<a href="#" data-toggle="modal" data-target="#createWallet" class="ml-3 d-none" title="Create wallet" id="createWalletLink"><i class="fas fa-wallet"></i> Create wallet</a>';
	
echo <<<EOT
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
		<form action="">
		<div class="form-group">
		<input type="text" class="form-control" id="block2-pk" placeholder="Encrypted private key" value="">
		</div>
		<div class="form-group">
		<input type="password" class="form-control" id="block2-pass" placeholder="Password" value="">
		</div>
		<a type="button" class="btn btn-large btn-secondary btn-block" onclick="checkLogin()">Sign in</a>
		</form>
		</div>
      </div>
    </div>
  </div>
</div>
<!-- END modal sign in for wallet -->
EOT;
}
//After sign in, address is checked, if he's not active delegatee, can't do nothing with multisig wallet thingy
?>
</h5>

<div class="table-responsive-sm">
  <table class="table table-hover">
    <thead>
	  <tr><!-- style="color:black; background-color:grey" -->
        <th>Address</th>
        <th>Amount</th>
		<?php //if(isset($_SESSION["delegatee"])) echo '<th>Active?</th>'; ?>
      </tr>
    </thead>
    <tbody>


<?php
$res=mysqli_query($conn, "SELECT * FROM wallet");
$numrows=mysqli_num_rows($res);

if($numrows==0)
	echo '<tr><td colspan="2">No wallets available.</td></tr>';

while($row=mysqli_fetch_object($res)) {
$ime=$row->ime;
$prezime=$row->prezime;
}
?>

    </tbody>
  </table>
</div>

<hr>


<?php
if(isset($_SESSION["delegatee"]))
echo <<<EOT
<script>
const auth_address="{$_SESSION["address"]}";
</script>
EOT;
?>


<input type="hidden" id="unencryptedPK" value="">
<input type="hidden" id="addy" value="">
<input type="hidden" id="epoch" value="">
<input type="hidden" id="nonce" value="">
<input type="hidden" id="rawTx" value="">
<input type="hidden" id="signedRawTx" value="">

<div id="resultTx"></div>

</div><!-- end container  -->

<?php include("_footer.php");?>

<script src="./js/axios.min.js"></script>
<script src="./js/script.js"></script>
<script src="./js/bundle.js"></script>
</body>
</html>