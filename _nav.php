<nav class="navbar navbar-expand-sm">
<!-- Brand -->
<?php include("_logo.php");?>

<!-- Toggler/collapsibe Button -->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
<span class="navbar-toggler-icon"></span>
</button>

<!-- Links -->
<div class="collapse navbar-collapse" id="collapsibleNavbar">
<ul class="navbar-nav align-items-center">

<!-- Dropdown 
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Item 1 <span class="caret"></span></a>
  <div class="dropdown-menu">
	<a href="#" class="dropdown-item" target="_blank"><i class="fas fa-calculator"></i> Subitem</a>
  </div>
</li>
-->

<li class="nav-item"><a href="delegatees.php" class="nav-link">Delegatees</a></li>
<li class="nav-item"><a href="wallet.php" class="nav-link">Wallet</a></li>
<li class="nav-item"><a href="https://ubiubi2018.medium.com/proposal-for-governance-mechanism-for-idena-community-wallet-1d3f42819a50" target="_blank" class="nav-link">Governance proposal</a></li>



</ul>

<ul class="navbar-nav align-items-center ml-auto">
<?php if(isset($_SESSION["address"])) { 
echo <<<EOT
<li class="nav-item dropdown dropleft">
<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
<img src="https://robohash.idena.io/{$_SESSION['address']}" width="55" height="55" title="{$_SESSION['address']}" alt="{$_SESSION['address']}" class="img-circle border rounded-circle" id="avatar" style="background-color:white;">
 <span class="caret"></span>
</a>
<div class="dropdown-menu">
	<a class="dropdown-item" href="_logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
</li>
EOT;
}
else
echo "<li class='nav-item'><a href='auth/v1/' class='nav-link' title='You need Idena account to sign in'>Sign in with Idena</a></li>";
 ?>
</ul>

  </div>
</nav>