## Idena Community
Idena Community Platform for community wallet governance.

Proposal:
https://ubiubi2018.medium.com/proposal-for-governance-mechanism-for-idena-community-wallet-1d3f42819a50

## Setup
* LAMP stack on Ubuntu server 20.04
* additional php modules needed
`sudo apt install -y php7.4-gmp php-bcmath php-curl php-zip`

### You need to add `_config.php` file
```php
<?php
$url="https://community.idena.site";
$idena_domain="idena.org";

//MySQL database parameters
$host="localhost";
$dbuser="";
$dbpass="";
$db="community";
?>
```