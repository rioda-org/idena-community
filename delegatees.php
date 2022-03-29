<?php
require_once __DIR__ . '/_include.php';
require_once __DIR__ . '/_head.php';

$now=date('Y-m-d H:i:s');

//add delegatee to database
if(isset($_POST['add_delegatee']) AND isset($_SESSION["delegatee"])) {
$error=0;
$nickname=test_input($_POST['nickname']);
$address=test_input($_POST['address']);

if(strlen($nickname)==0) $error++;
if(isIdnaAddress($address)==0) $error++;
$address=strtolower($address);

if($error==0) {
mysqli_query($conn, "INSERT INTO delegatee (nickname, address) VALUES ('{$nickname}','{$address}')");
mysqli_query($conn, "INSERT INTO delegatee_stats (action, operator, delegatee, time) VALUES ('add','".$_SESSION["address"]."','{$address}','{$now}')");
}
else
	echo "Please check entered data";
}

//toggle activity of delegatee
if(isset($_POST['toggle_delegatee']) AND isset($_SESSION["delegatee"])) {
$is_active=$_POST['is_active'];
$address=$_POST['address'];
if($is_active=="checked"){
	$update_to="0";
	$action="disable";
}
else {
	$update_to="1";
	$action="enable";
}

mysqli_query($conn, "UPDATE delegatee SET active='{$update_to}' WHERE address='{$address}'");
mysqli_query($conn, "INSERT INTO delegatee_stats (action, operator, delegatee, time) VALUES ('{$action}','".$_SESSION["address"]."','{$address}','{$now}')");
}


//self update
if(isset($_POST['self_update']) AND $_SESSION["address"]==$_POST["self_update_address"]) {
$address_for_update=$_POST["self_update_address"];
$nickname=$_POST["self_update_nickname"];
$bio=$_POST["self_update_bio"];
$contact=$_POST["self_update_contact"];

mysqli_query($conn, "UPDATE delegatee SET nickname='{$nickname}', bio='{$bio}', contact='{$contact}' WHERE address='{$address_for_update}'");
}
?>
<body>
<!-- Place GTM -->
<div class="container">
<?php include("_nav.php");?>
<br>
<h4><?php echo "Round ".$round;?></h4><br>
<h5>Delegatees 
<?php if(isset($_SESSION["delegatee"])) echo '<a href="#" data-toggle="modal" data-target="#addDelegatee" title="Add delegatee"><i class="far fa-plus-square"></i></a>'; ?>
</h5>


<div class="table-responsive-sm">
  <table class="table table-hover">
    <thead>
	  <tr><!-- style="color:black; background-color:grey" -->
        <th></th>
        <th>Address</th>
        <th>Nickname</th>
        <th></th>
        <th></th>
        <th>Contact</th>
		<?php if(isset($_SESSION["delegatee"])) echo '<th>Active?</th>'; ?>
      </tr>
    </thead>
    <tbody>
	
<?php
//read delegatees
if(isset($_SESSION["delegatee"]))
$res=mysqli_query($conn, "SELECT * FROM delegatee");
else
$res=mysqli_query($conn, "SELECT * FROM delegatee WHERE active='1'");

while($row=mysqli_fetch_object($res)) {
	$iddelegatee=$row->iddelegatee;
	$nickname=$row->nickname;
	$address=$row->address;
	$bio=$row->bio;
	$contact=$row->contact;
	$active=$row->active;
	if($active=="1") $active="checked"; else $active="";
		
echo "<tr>
        <td><img src='https://robohash.org/{$address}' width='32px' height='32px' title='{$bio}' class='img-circle border rounded-circle'></td>
        <td><a href='https://scan.idena.io/address/{$address}' target='_blank'>{$address}</a></td>
        <td title='{$bio}'>{$nickname}</td><td>";
		
//delegatee can update his info
if(@$_SESSION["address"]==$address) {
	echo "<a href='#' data-toggle='modal' data-target='#selfEdit' title='Update your info'><i class='fas fa-pen'></i></a>";
	$self_update_nickname=$nickname;
	$self_update_bio=$bio;
	$self_update_contact=$contact;
	$self_update_address=$address;
}

echo "</td><td><a href='#' data-toggle='modal' data-target='#info{$address}' title='See info about delegatee'><i class='fas fa-info'></i></a></td>";
echo "<td><a href='{$contact}' target='_blank'>{$contact}</a></td>";
		
//delegatees can activate/deactivate one another
if(isset($_SESSION["delegatee"]))
	echo "<td>
		<form method='POST'>
		<input type='checkbox' {$active} title='Toggle status of a delegatee' onclick='this.form.submit()'>
		<input type='hidden' name='toggle_delegatee'>
		<input type='hidden' name='address' value='{$address}'>
		<input type='hidden' name='is_active' value='{$active}'>
		</form>
		</td>";
		
echo "</tr>";


echo <<<EOT
<!-- Modal delegate info stats -->
<div id="info{$address}" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	    <h4 class="modal-title">Information about delegatee:</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
EOT;
$resI=mysqli_query($conn, "SELECT * FROM delegatee_stats WHERE delegatee='{$address}'");
while($rowI=mysqli_fetch_object($resI)) {
	$action=$rowI->action;
	$operator=$rowI->operator;
	$delegatee=$rowI->delegatee;
	$time=$rowI->time;

	echo "<img src='https://robohash.org/{$operator}' width='32px' height='32px'> - $action ($time)<br>";
}
echo <<<EOT
      </div>
    </div>
  </div>
</div>
EOT;


}
?>
    </tbody>
  </table>
</div>

</div>


<!-- Modal add delegatee -->
<div id="addDelegatee" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	    <h4 class="modal-title">Add Delegatee:</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

 <form method="POST">
 <div class="form-group">
    <label for="nickname">Nickname:</label>
    <input type="text" class="form-control" pattern=".{3,}" placeholder="Nickname of a delegatee" id="nickname" name="nickname" maxlength="45" required>
  </div>
  <div class="form-group">
    <label for="address">Address:</label>
    <input type="text" class="form-control" pattern="0x([a-fA-F0-9]{40})" placeholder="Enter Idena address of a delegatee" id="address" name="address" required>
  </div>
  <button type="submit" class="btn btn-primary" name="add_delegatee">Save</button>
</form>

      </div>
    </div>
  </div>
</div>



<!-- Modal delegate info self update -->
<div id="selfEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	    <h4 class="modal-title">Update your info:</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

 <form method="POST">
 <div class="form-group">
    <label for="nickname">Nickname:</label>
    <input type="text" class="form-control" pattern=".{3,}" placeholder="Nickname of a delegatee" name="self_update_nickname" maxlength="45" required value="<?php echo $self_update_nickname; ?>">
  </div>
  <div class="form-group">
    <label for="bio">Bio:</label>
	<textarea class="form-control" rows="5" placeholder="Enter bio" id="bio" name="self_update_bio"><?php echo $self_update_bio; ?></textarea>
  </div>
    <div class="form-group">
    <label for="contact">Contact:</label>
    <input type="text" class="form-control" placeholder="Enter telegram contact link" id="contact" name="self_update_contact" maxlength="45" value="<?php echo $self_update_contact; ?>">
  </div>
  <input type="hidden" name="self_update_address" value="<?php echo $self_update_address; ?>">
  <button type="submit" class="btn btn-primary" name="self_update">Update</button>
</form>

      </div>
    </div>
  </div>
</div>


<?php include("_footer.php");?>
</body>
</html>