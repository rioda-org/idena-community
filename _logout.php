<?php
require_once __DIR__ . '/_include.php';
$token_for_deletion=$_COOKIE['remember_auth'];
mysqli_query($conn, "DELETE FROM auth WHERE token='{$token_for_deletion}'");
session_destroy();
header("location:/");
?>