<?php
// ?custom=1&clientemail=abc@def.fr&item=1100 Ogrines/Jetons&amount=10.00
session_start();
require_once('config/config.php');
require_once('config/fonction.php');
require 'class/sql.class.php'; 
$Sql = new Sql();
$Sql->query("SET NAMES utf8");
date_default_timezone_set('Europe/Paris');
define("BASE_DS", dirname(__FILE__) . '\\');
/*

	$varOf_GET = var_export($_GET, true);
	$varOf_POST = var_export($_POST, true);
	$returnToInTXT = '['.date("Y-m-d H:i:s").'] IP : '.get_real_ip();
	$returnToInTXT .= "\r\n";
	if(strlen($varOf_GET) > 9) $returnToInTXT .= "GET : ".$varOf_GET."\r\n";
	if(strlen($varOf_POST) > 9) $returnToInTXT .= 'POST : '.$varOf_POST;
	$fp = fopen('Z_shophmalogppa8d9g4f4.txt','a+');
	fseek($fp,SEEK_END);
	fputs($fp, $returnToInTXT . "\r\n---------------------------------------------------------------\r\n");
	fclose($fp);
*/
$Sql = null;
?>
OK