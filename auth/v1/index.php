<?php
require_once __DIR__ . '/../../_include.php';

$session_token=guid();

$link="https://app.idena.io/dna/signin?token={$session_token}&callback_url={$url}/setcookie.php?token={$session_token}&nonce_endpoint={$url}/auth/v1/start-session.php&authentication_endpoint={$url}/auth/v1/authenticate.php&favicon_url={$url}/images/favicon-idena.ico";

header("location:{$link}");
?>