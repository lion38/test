<?php
session_start();
require_once('config/config.php');
require_once('config/config_boutique.php');
require_once('config/fonction.php');
require_once('config/binaryReader.php');
require_once('class/RpgApi.php');

require 'class/sql.class.php'; 
$Sql = new Sql();
$Sql->query("SET NAMES utf8");
date_default_timezone_set('Europe/Paris');
define("BASE_DS", dirname(__FILE__) . '\\');

//*** Gestion des pages ***//
$page = (!empty($_GET['page']) AND strlen($_GET['page']) > 0) ? htmlentities($_GET['page']) : 'accueil';
if(!preg_match('/^[a-z0-9-_]+$/', $page)) $page = 'erreur';
$page = ($page=='index') ? 'accueil' : $page;
if(preg_match('`\.`', $page)) $page = 'erreur';
if(!is_file('./pages/'.$page.'.php')) $page = 'erreur';

if(isset($_GET['page']) AND $_GET['page'] == "deconnection")
{
	//echo 'tamerw';
	if(!isset($_POST['logon']))
	{
		if(isset($_SESSION['Neft-Gaming_login'])) unset($_SESSION['Neft-Gaming_login']);
		if(isset($_SESSION['Neft-Gaming_level'])) unset($_SESSION['Neft-Gaming_level']);
		if(isset($_SESSION['Neft-Gaming_guid'])) unset($_SESSION['Neft-Gaming_guid']);
		if(isset($_SESSION['Neft-Gaming_connecter'])) unset($_SESSION['Neft-Gaming_connecter']);
		if(isset($_COOKIE['Neft-Gaminglogon'])){setcookie('Neft-Gaminglogon');}
		$NOTALLOWREDISCONNECTEDAUTO = true;
	}
}
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
if(isset($_COOKIE['Neft-Gaminglogon'])) echo 'COOKIE : ' .$_COOKIE['Neft-Gaminglogon'].'<br />';
*/

//**************************************************************************//
//**************************************************************************//
//**************************************************************************//
//Cette fonction génère, sauvegarde et retourne un token
//Vous pouvez lui passer en paramètre optionnel un nom pour différencier les formulaires
function generer_token_crsf($nom = '')
{
	$token = uniqid(rand(), true);
	$_SESSION[$nom.'_token'] = $token;
	$_SESSION[$nom.'_token_time'] = time();
	return $token;
}
//Cette fonction vérifie le token
//Vous passez en argument le temps de validité (en secondes)
//Le nom optionnel si vous en avez défini un lors de la création du token
function verifier_token_crsf($temps, $nom = '')
{
	if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']))
		if($_SESSION[$nom.'_token'] == $_POST['token'])
			if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
			{
				unset($_SESSION[$nom.'_token_time']);
				unset($_SESSION[$nom.'_token']);
				return true;
			}
	return false;
}
//**************************************************************************//
//**************************************************************************//
//**************************************************************************//

$token_tosave = "";
$token_time_tosave = "";
if(isset($_SESSION[$page.'_token']) AND isset($_SESSION[$page.'_token_time']))
{
	$token_tosave = $_SESSION[$page.'_token'];
	$token_time_tosave = $_SESSION[$page.'_token_time'];
}

$vote_go_tosave = "";
$out_de_rpg_tosave = "";
if(isset($_SESSION['vote_go']) AND isset($_SESSION['out_de_rpg']))
{
	$vote_go_tosave = $_SESSION['vote_go'];
	$out_de_rpg_tosave = $_SESSION['out_de_rpg'];
}

$codesecurite_tosave = "";
if(isset($_SESSION['codesecurite']))
{
	$codesecurite_tosave = $_SESSION['codesecurite'];
}


// Formulaire de connexion
if(!isset($_SESSION['Neft-Gaming_login']) AND !isset($_SESSION['Neft-Gaming_level']) AND !isset($_SESSION['Neft-Gaming_guid']) OR (!isset($_SESSION['Neft-Gaming_connecter']) OR empty($_SESSION['Neft-Gaming_connecter']) OR !$_SESSION['Neft-Gaming_connecter']))
{
	if(isset($_POST['logon']) AND isset($_POST['passlog']) AND isset($_POST['login']))
	{
			$query = $Sql->prepare("SELECT * FROM accounts WHERE Login = ?");
			$query->execute(array($_POST['login']));
			$data = $query->fetch();
			
			// Si le compte existe
			if($data)
			{
				if($data['PasswordHash'] == md5($_POST['passlog']))
				{
					setcookie("Neft-Gaminglogon",$data['Login']."|=|separator|=|".md5($data['PasswordHash']),time() + (365*24*3600));
					$_SESSION['Neft-Gaming_PRELOGIN'] = $data['Login']."|=|separator|=|".md5($data['PasswordHash']);
				}
				else $error_show['connexion_login'] = 'Mot de passe incorrect.';
			}
			else $error_show['connexion_login'] = 'Nom de compte incorrect.';
			
			$query->closeCursor();
	}
}

// Connexion persistance
if(isset($_COOKIE['Neft-Gaminglogon']) AND !empty($_COOKIE['Neft-Gaminglogon']) OR (isset($_SESSION['Neft-Gaming_PRELOGIN']) AND !empty($_SESSION['Neft-Gaming_PRELOGIN'])))
{
	if(!isset($NOTALLOWREDISCONNECTEDAUTO))
	{
		if(isset($_SESSION['Neft-Gaming_PRELOGIN']) AND !empty($_SESSION['Neft-Gaming_PRELOGIN'])) $info = explode('|=|separator|=|', $_SESSION['Neft-Gaming_PRELOGIN']);
		else $info = explode('|=|separator|=|', $_COOKIE['Neft-Gaminglogon']);
		$login=$info[0];
		$password=$info[1];
		if(isset($_SESSION['Neft-Gaming_PRELOGIN'])) { unset($_SESSION['Neft-Gaming_PRELOGIN']); }
		
		$query = $Sql->prepare("SELECT * FROM accounts WHERE Login = ?");
		$query->execute(array($login));
		$data = $query->fetch();
		/*
		echo 'MOT DE PASSE = '.$password.'<hr />';
		echo 'data["PasswordHash"] = '.$data['PasswordHash'].'<hr />';
		echo 'md5(data["PasswordHash"]) = '.md5($data['PasswordHash']).'<hr />';
		*/
		if($data['Login'] != $login OR md5($data['PasswordHash']) != $password)
		{
			//$_SESSION = array();
			//session_destroy();
			//if(isset($_COOKIE['Neft-Gaminglogon'])){setcookie('Neft-Gaminglogon');}
			$_SESSION['Neft-Gaming_connecter'] = false;
		}
		else
		{
			$_SESSION['Neft-Gaming_login'] = $data['Login'];
			$_SESSION['Neft-Gaming_level'] = $data['UserGroupId'];
			$_SESSION['Neft-Gaming_guid'] = $data['Id'];
			$_SESSION['Neft-Gaming_connecter'] = true;
			
			$resultado = $Sql->prepare('SELECT * FROM accounts WHERE Login=:login') or die ($error);
			$resultado->bindvalue(':login', $data['Login'], PDO::PARAM_STR);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$COMPTE = $resultado->fetch();
			$resultado->closeCursor();
		}
		
		$query->closeCursor();
	}
	else { $_SESSION = array(); $_SESSION['Neft-Gaming_connecter'] = false; }
}
else { $_SESSION['Neft-Gaming_connecter'] = false; }


if($token_tosave != "" AND $token_time_tosave != "")
{
	$_SESSION[$page.'_token'] = $token_tosave;
	$_SESSION[$page.'_token_time'] = $token_time_tosave;
}

if($vote_go_tosave != "" AND $out_de_rpg_tosave != "")
{
	$_SESSION['vote_go'] = $vote_go_tosave;
	$_SESSION['out_de_rpg'] = $out_de_rpg_tosave;
}

if($codesecurite_tosave != "")
{
	$_SESSION['codesecurite'] = $codesecurite_tosave;
}

	if($page == 'administration')
	{
		if(!isset($COMPTE->Login)) $page = 'erreur';
		else
		{
			if(!in_array(strtolower($COMPTE->Login), $CONFIG['administration_login_allowed']) AND !in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) $page = 'erreur';
		}
	}
	
	ob_start();
	if($page == 'vote_api' OR $page == 'achat_api' OR $page == 'api_logger' OR ($page == 'vendre_personnages' AND isset($_GET['confirm_makefiche']))) include('pages/'.$page.'.php');
	elseif($page == 'administration' AND isset($_GET['action']) AND !empty($_GET['action']) AND $_GET['action'] == 'mongologger') include('pages/administration.php');
	else
	{
		include('include/doctype.php');
		// Inclusion de la bonne page
		include('pages/'.$page.'.php');
		include('include/footer.php');
	}

	ob_end_flush();

$Sql = null;
?>