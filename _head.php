<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Idena Community Platform</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <link rel="shortcut icon" href="<?php echo $url; ?>/images/icon-32.png"/>
  <noscript><meta http-equiv="refresh" content="0;url=jscript-disabled.php"></noscript>
    <style>
	html {
	position: relative;
	min-height: 100%;}
	body {background-color: #f5f5f5;}
	.footer {
	position: absolute;
	bottom: 0;
	width: 100%;}
  </style>
  
  <!-- toastr -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
toastr.options = {
"closeButton": true,
"debug": false,
"newestOnTop": false,
"progressBar": true,
"positionClass": "toast-bottom-right",
"preventDuplicates": true,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut",
"escapeHtml": false
}

//allow only number characters
function onlyNum(evt)
{var cc = (evt.which) ? evt.which : event.keyCode;
if (cc==48||cc==49||cc==50||cc==51||cc==52||cc==53||cc==54||cc==55||cc==56||cc==57||cc==46||cc==8) return true; return false;}
//0 1 2 3 4 5 6 7 8 9 delete backspace

//popover
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});

<?php
echo <<<EOT
const idena_api = "{$idena_api}";
const rpc_url = "{$rpc_url}";
const rpc_key = "{$rpc_key}";
EOT;
?>
</script>
<script src="./js/theme.js"></script>
</head>