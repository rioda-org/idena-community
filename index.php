<?php
require_once __DIR__ . '/_include.php';
require_once __DIR__ . '/_head.php';
?>
<body>
<!-- Place GTM -->
<div class="container">
<?php include("_nav.php");?>


<script>






async function action(){

let confirmed="no";
let i=1;
while(confirmed=="no"){
document.write("i:"+i+"<br>");
i++;
await new Promise(resolve => setTimeout(resolve, 2000));

if(i>10)
	confirmed="yes";

}

}




</script>
<button onclick="action()">LFG !!</button>
<script src="./js/axios.min.js"></script>


</div>

<?php include("_footer.php");?>
</body>
</html>