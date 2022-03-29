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


//start theme mode
if(!localStorage.getItem("theme"))
var mode='dark';
else
var mode=localStorage.getItem("theme");

//load theme
if(mode=="dark")$(function() {dark();});
if(mode=="light")$(function() {light();});

//change theme
function toggleMode(){
if(mode=="dark"){
$(function() {light();});
$(function(){localStorage.setItem("theme","light");});}
if(mode=="light"){
$(function() {dark();});
$(function(){localStorage.setItem("theme","dark");});}
}