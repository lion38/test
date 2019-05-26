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

$ogrineWasGivenOrNot = false;

if(isset($_REQUEST['custom'], $_REQUEST['clientemail'], $_REQUEST['item'], $_REQUEST['amount']))
{
	$get_idCompte = intval($_REQUEST['custom']);
	$get_email = urldecode($_REQUEST['clientemail']);
	$get_item = urldecode($_REQUEST['item']);
	$get_amount = $_REQUEST['amount'];
	$get_fee = 0;
	if(isset($_REQUEST['fee'])) $get_fee = $_REQUEST['fee'];
	
	$ogrine_a_donner = addTenPercent($get_amount);
	if($CONFIG['boutique_offre_ogrine_double'] == TRUE) $ogrine_a_donner = $ogrine_a_donner * 2;
	
	if($get_amount < 0) die();
	if($ogrine_a_donner < 0) die();
	
	$transactionIdPaypal = get_real_ip();
	$transactionIdPaypal = @$_REQUEST['txn'];
	
	$query = $Sql->prepare("UPDATE accounts SET Tokens = Tokens + ? WHERE Id = ?");
	$query->execute(array($ogrine_a_donner, $get_idCompte));
	$query->closeCursor();
	
	$ogrineWasGivenOrNot = true;
	
	$resultado = $Sql->prepare('SELECT * FROM accounts WHERE Id = ?') or die ($error);
	$resultado->execute(array($get_idCompte));
	$resultado->setFetchMode(PDO::FETCH_OBJ);
	$COMPTE_find = $resultado->fetch();
	$resultado->closeCursor();
	
	$token_before = 0;
	if($COMPTE_find) $token_before = $COMPTE_find->Tokens;
	
	$date = date("Y-m-d H:i:s");
	$query = $Sql->prepare("INSERT INTO log_site_achat_points(accountId, ogrine_acheter, ogrine_avant, code, pays, palier, type, date, timestamp, fee) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$query->execute(array($get_idCompte, $ogrine_a_donner, $token_before, $transactionIdPaypal, $get_email, $get_amount, 'paypal', $date, time(), $get_fee));
	$query->closeCursor();
}

	$ogrineWasGivenOrNot = ($ogrineWasGivenOrNot) ? 'OK' : 'ERROR';

	$varOf_GET = var_export($_GET, true);
	$varOf_POST = var_export($_POST, true);
	$returnToInTXT = '['.date("Y-m-d H:i:s").'] IP : '.get_real_ip().' ETAT : '.$ogrineWasGivenOrNot;
	$returnToInTXT .= "\r\n";
	if(strlen($varOf_GET) > 9) $returnToInTXT .= "GET : ".$varOf_GET."\r\n";
	if(strlen($varOf_POST) > 9) $returnToInTXT .= 'POST : '.$varOf_POST;
	$fp = fopen('Z_shophmalogppa8d9g4f4.txt','a+');
	fseek($fp,SEEK_END);
	fputs($fp, $returnToInTXT . "\r\n---------------------------------------------------------------\r\n");
	fclose($fp);

$Sql = null;
?>