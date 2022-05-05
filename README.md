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
  
## To do
* Wallet page
  - Can't really remember where I'm at here. UbiUbi's proposal need to be read to understand what is needed.
  - Sign in with idena is one thing, for every user and delegatee options. For wallet, there is need for additional sign in as you would do in web app. It is needed so that app can use private key to do actions with wallet.
  - The point was, there is pool of delegatees. Funding rounds change automatically every 3 epoch. After each round new delegatees are chosen by some random thing(not figured out how), from delegatee pool on Delegatees page. After delegatees are enabled/disabled for new round, new wallet(multisig smart contract) needs to be created and fundus moved from last wallet. New delegatees must be added as wallet operators. So the history of past rounds wallets and its delegatees must be kept in DB, as well as rounds.
  - Opearators need to have option to vote for spending idna from wallet
* Proposal page
  - User that is signed in with Idena auth, can open new proposal. On that proposal, others also only signed in, can post comments in reddit style with upvote/downvotes
  - If proposal gains traction, oracle is made to decide if proposal should be funded. Delegatees vote on the wallet page to send funds if oracle is succesfull.