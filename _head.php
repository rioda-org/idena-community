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
  <link rel="shortcut icon" href="/images/icon-32.png"/>
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
"positionClass": "toast-bottom-left",
"preventDuplicates": true,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "30000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut",
"escapeHtml": false
}
</script>


<script>
function cookieTheme(theme){
$.ajax({
type: "POST",
url: "/ajax_validation.php",
dataType: "json",
data: {theme:theme}
});
}

//start mode
<?php echo "var mode='{$theme}';";?>

function dark(){
$("body").removeClass("bg-light");
$("nav").removeClass("navbar-light");
$("body").addClass("bg-dark");
$("body").addClass("text-light");
$("nav").addClass("navbar-dark");
$(".btn-outline-dark").addClass("btn-outline-light");
$(".btn-outline-dark").removeClass("btn-outline-dark");
$(".modal-content").addClass("bg-dark");
$(".modal-content").addClass("text-light");
document.getElementById("moon_sun").innerHTML="🌞";
$(".card").addClass("bg-secondary");
$(".card-body").addClass("bg-dark");
$(".img-thumbnail").addClass("bg-secondary");
$(".dropdown-menu").addClass("bg-secondary");
$("table").addClass("table-dark");
$(".card-header a").addClass("text-light");
$(".pagination a").addClass("bg-dark");
$(".nav-tabs a").addClass("bg-dark");
$(".nav-tabs a").addClass("text-light");
$(".donate").removeClass("badge-secondary");
$(".donate").addClass("badge-light");
$("p a").css("color","#58a6ff");
$(".card a").css("color","#58a6ff");
$("td a").css("color","#58a6ff");
$(".modal a").css("color","#58a6ff");
$(".flink").css("color","rgba(255,255,255,.5)");
$(".faq").removeClass("badge-dark");
$(".faq").addClass("badge-light");
mode="dark";
}

function light(){
$("body").removeClass("bg-dark");
$("body").removeClass("text-light");
$("nav").removeClass("navbar-dark");
$("body").addClass("bg-light");
$("nav").addClass("navbar-light");
$(".btn-outline-light").addClass("btn-outline-dark");
$(".btn-outline-light").removeClass("btn-outline-light");
$(".modal-content").removeClass("bg-dark");
$(".modal-content").removeClass("text-light");
document.getElementById("moon_sun").innerHTML="🌙";
$(".card").removeClass("bg-secondary");
$(".card-body").removeClass("bg-dark");
$(".img-thumbnail").removeClass("bg-secondary");
$(".dropdown-menu").removeClass("bg-secondary");
$("table").removeClass("table-dark");
$(".card-header a").removeClass("text-light");
$(".pagination a").removeClass("bg-dark");
$(".nav-tabs a").removeClass("bg-dark");
$(".nav-tabs a").removeClass("text-light");
$(".donate").addClass("badge-secondary");
$(".donate").removeClass("badge-light");
$("p a").css("color","");
$(".card a").css("color","");
$("td a").css("color","");
$(".modal a").css("color","");
$(".card table a").css("color","");
$(".flink").css("color","rgba(0,0,0,.5)");
$(".faq").removeClass("badge-light");
$(".faq").addClass("badge-dark");
mode="light";
}

//load theme
if(mode=="dark")$(function() {dark();});
if(mode=="light")$(function() {light();});

//change theme
function toggleMode(){
if(mode=="dark"){
$(function() {light();});
$(function(){cookieTheme('light');});}
if(mode=="light"){
$(function() {dark();});
$(function(){cookieTheme('dark');});}
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
</script>

</head>