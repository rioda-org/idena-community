## Idena Community
Idena Community Platform for community wallet governance.

Proposal:
https://ubiubi2018.medium.com/proposal-for-governance-mechanism-for-idena-community-wallet-1d3f42819a50

## Setup
* LAMP stack (Ubuntu Server 20.04, Apache, Bootstrap 4, PHP 7.4, MariaDB)
* additional php modules needed
`sudo apt install -y php7.4-gmp php-bcmath php-curl php-zip`
* uncoment extension=gmp in php.ini
`nano /etc/php/7.4/cli/php.ini`
* restart apache
`sudo systemctl restart apache2.service`
* install php dependencies
`php composer.phar update`


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