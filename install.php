<?php
include 'libs/config.php';

$mysqli->query("CREATE TABLE IF NOT EXISTS `address_blocked` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;"); 

$mysqli->query("CREATE TABLE IF NOT EXISTS `address_list` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `bitcoin_address` varchar(75) NOT NULL,
  `total_claimed` varchar(100) NOT NULL,
  `ref` varchar(75) NOT NULL,
  `last` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;"); 

$mysqli->query("CREATE TABLE IF NOT EXISTS `ip_blocked` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;"); 

$mysqli->query("CREATE TABLE IF NOT EXISTS `ip_list` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(50) NOT NULL,
  `last` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;"); 

$mysqli->query("CREATE TABLE IF NOT EXISTS `link` (
  `bitcoin_address` varchar(75) NOT NULL,
  `sec_key` varchar(75) NOT NULL,
  `ip` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");

$mysqli->query("CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
");

$mysqli->query("INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'Name', 'microzeny faucet サンプル'),
(2, 'Description', 'Free BitZeny by microzeny'),
(3, 'Url', 'http://example.com/'),
(4, 'Theme', 'default'),
(5, 'Currency', 'ZNY'),
(6, 'Microzeny Faucet api', ''),
(7, 'Timer', '60'),
(8, 'Reward', '0.01'),
(9, 'Referral Commision', '5'),
(10, 'Short Link Status', 'off'),
(11, 'Short Link Reward', '10'),
(12, 'Force Short Link', 'off'),
(13, 'Captcha System', 'recaptcha'),
(14, 'Recaptcha Public Key', ''),
(15, 'Recaptcha Secret Key', ''),
(16, 'Bitcaptcha Id', ''),
(17, 'Bitcaptcha Key', ''),
(18, 'Bitcaptcha Id For WWW Verson', ''),
(19, 'Bitcaptcha Key For WWW Verson', ''),
(20, 'SolveMedia Challenge Key', ''),
(21, 'SolveMedia Private Key', ''),
(22, 'SolveMedia Hash Key', ''),
(23, 'Top Ad Slot', 'Top Ad Slot test'),
(24, 'Left Ad Slot', 'Left Ad Slot'),
(25, 'Right Ad Slot', 'Right Ad Slot'),
(26, 'Above Form Ad Slot', 'Above Form Ad Slot'),
(27, 'Bottom Ad Slot', 'Bottom Ad Slot'),
(28, 'Modal Ad Slot', 'Modal Ad Slot'),
(29, 'IpHub Api', ''),
(30, 'Faucet Balance', 'Make a claim to update it');");
?>
<center><h1>Remove this file after running it successful !</h1>
<h2>For more instructions, go here: <a href="https://github.com/microzeny/faucet-script">Microzeny Faucet Script</a></h2></center>
