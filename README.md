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
* import database structure from
`import.sql`

### You need to add `_config.php` file
```php
<?php
$url="https://community.idena.site";
$idena_api="https://api.idena.org";
$rpc_url="https://test.idena.site";
$rpc_key="test";

//MySQL database parameters
$host="localhost";
$dbuser="";
$dbpass="";
$db="community";
?>
```

## Functionalities
* Anyone is able to authenticate his Idena account (Sign in with Idena). By default authentication is remembered for 60 days.
* Delegatees page
  - Everyone: Can view active delegatees and their information, Idena address, nickname, bio, contact info and historical changes for their delegatee status.
  - Active delegatee: Additionaly can add new delegatees, change other delegatees status (active or not). Each delegatee can edit it's info (bio, contact, nickname)
* Wallet page
  - Everyone: Can view wallets history.
  - Active delegatee: Can use Sign in option to manage community wallet.