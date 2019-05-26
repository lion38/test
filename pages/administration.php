<?php 
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
define("ADMIN_DS", "secure");
if(!isset($COMPTE->Login)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
else
{
	if(!in_array(strtolower($COMPTE->Login), $CONFIG['administration_login_allowed']) AND !in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
}

//*** Gestion des pages ***//
$action_page = (!empty($_GET['action'])) ? htmlentities($_GET['action']) : 'accueil';
$action_page = ($action_page=='index') ? 'accueil' : $action_page;
if(preg_match('`\.`', $action_page)) $action_page = 'erreur';
if(!is_file('./pages/administration/'.$action_page.'.php')) $action_page = 'erreur';

include('./pages/administration/'.$action_page.'.php');
?>