<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Mot de passe oublié"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

if($_SESSION['Neft-Gaming_connecter'])
{
?>
	<h2><span>Erreur</span></h2>
	<div class="content-padding">
		<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i>Vous devez être <strong>déconnecté</strong> pour faire une demande de récupération de mot de passe.</span>
	</div>
<?php
}
else
{
?>
	<h2><span>Réinitialisation de mon mot de passe</span></h2>
	
	<div class="content-padding">
<?php

	require 'config/phpmailerLIB/PHPMailerAutoload.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->isHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Host       = "mail.neft-gaming.com"; // SMTP server example
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
	$mail->Username   = "support@neft-gaming.com"; // SMTP account username example
	$mail->Password   = "10I})Yd]5cXz";        // SMTP account password example
	$mail->From = 'support@neft-gaming.com';
	$mail->FromName = 'Neft-Gaming';

$error_mess = "";
$afficheFORMU = TRUE;

// Form pour s'envoyéle mail qui confirme la possession de ce mail par le demandeur
if(isset($_GET['key']))
{
	$afficheFORMU = FALSE;
	$key = (isset($_GET['key']) AND strlen(trim($_GET['key'])) == 64) ? trim($_GET['key']) : '';
	if($key == '') $error_mess = 'Key invalide.';
	else
	{
		$saltId = substr($key, 32, 32);
		$hash = substr($key, 0, 32);
		$resultado = $Sql->prepare('SELECT * FROM motdepasse_recup WHERE hash = ? AND saltId = ? ORDER BY timestamp DESC LIMIT 1') or die ($error);
		$resultado->execute(array($hash, $saltId));
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$motdepasserecup_db_of_this_account = $resultado->fetch();
		$resultado->closeCursor();
		if($motdepasserecup_db_of_this_account)
		{
			if($motdepasserecup_db_of_this_account->timestamp + (60*60) > time())
			{
				if($motdepasserecup_db_of_this_account->used <= 0)
				{
					$resultado = $Sql->prepare('SELECT * FROM accounts WHERE Id = ?') or die ($error);
					$resultado->execute(array($motdepasserecup_db_of_this_account->idAccount));
					$resultado->setFetchMode(PDO::FETCH_OBJ);
					$compte_torecup = $resultado->fetch();
					$resultado->closeCursor();
					if($compte_torecup)
					{
						$GENERATED_NEW_PASSWORD = generer_mdp_aleatoire();
						$resulta = $Sql->prepare("UPDATE motdepasse_recup SET used = ? WHERE id = ?");
						$resulta->execute(array(time(), $motdepasserecup_db_of_this_account->id));
						$resulta->closeCursor();
						
						$resulta = $Sql->prepare("UPDATE accounts SET PasswordHash = ? WHERE Id = ?");
						$resulta->execute(array(md5($GENERATED_NEW_PASSWORD), $compte_torecup->Id));
						$resulta->closeCursor();
							
						$mail->addAddress($compte_torecup->Email);
						$mail->Subject = 'Modification de votre mot de passe';
						ob_start();	
						?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Neft-Gaming</title>
    <style type="text/css">
        #outlook a{padding:0;}
        body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
        body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body{margin:0; padding:0;}
        img{height:auto; line-height:100%; outline:none; text-decoration:none;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
       p {
           margin: 1em 0;
       }
       h1, h2, h3, h4, h5, h6 {
           color: black !important;
           line-height: 100% !important;
       }
       h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;} h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important;}h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {color: purple !important;  }
       .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}
       </style>
</head>
<body>

    <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
    <td> 

    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="300"></td>
            <td width="300"></td>
            <td width="300"></td>
        </tr>
    </table>  
	
   	<h1>Bonjour,</h1>
	<h2>Un nouveau mot de passe viens d'être généré pour votre compte sur neft-gaming.com</h2><br />
	<strong>Nom de compte :</strong> <?php echo $compte_torecup->Login; ?><br />
	<strong>Mot de passe :</strong> <?php echo $GENERATED_NEW_PASSWORD; ?><br /><br />
	<strong>Adresse email :</strong> <?php echo $compte_torecup->Email; ?><br />
	<strong>Demande effectuée depuis l'adresse ip :</strong> <?php echo get_real_ip(); ?><br />
	<br />
	<em>Pour modifier votre mot de passe, connectez-vous puis changez votre mot de passe sur la page <strong>Mon compte</strong>.</em><br /><br />
	<a href="http://neft-gaming.com">neft-gaming.com</a>
    </td>
    </tr>
    </table>  
</body>
</html>
						<?php
						$mail->Body = ob_get_contents();
						ob_end_clean();
						// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

						if(!$mail->send()) $error_mess = 'Impossible d\'envoyer le mail veuillez retenter plus tard.';
						else
						{
						?>
							<div class="info-message" style="background-color: #75a226;">
								<strong>Félicitations,</strong><br />
								Un <strong>nouveau mot de passe</strong> viens de vous être envoyé sur votre adresse email.
							</div>
							<div class="breaking-line"></div>
							<p class="login-passes" style="width:85%;margin:auto;text-align:center;">Pour vous connecter au compte il suffit d'utiliser ce nouveau mot de passe.</p>
						<?php
						}
					}
					else $error_mess = 'Erreur aucun compte est associé à cette key.';
				}
				else $error_mess = 'Cette key est déjà utilisée.';
			}
			else $error_mess = 'Veuillez refaire une demande de mot de passe celle-ci est expiré.';
		}
		else $error_mess = 'Key invalide.';
	}
}

// Form pour s'envoyéle mail qui confirme la possession de ce mail par le demandeur
if(isset($_POST['nomdecompte'], $_POST['adressemail'], $_POST['token'], $_POST['captcha_entered']))
{
	$nomdecomptee = (isset($_POST['nomdecompte']) AND strlen($_POST['nomdecompte']) > 0) ? trim($_POST['nomdecompte']) : '';
	$adressemail = (isset($_POST['adressemail']) AND strlen($_POST['adressemail']) > 0) ? trim($_POST['adressemail']) : '';
	$token = (isset($_POST['token']) AND strlen($_POST['token']) > 0) ? trim($_POST['token']) : '';
	$captcha_entered = (isset($_POST['captcha_entered']) AND strlen($_POST['captcha_entered']) > 0) ? trim($_POST['captcha_entered']) : '';
	
	if($nomdecomptee == '') $error_mess = 'Veuillez remplir le champ <strong>Nom de compte</strong>.';
	if($adressemail == '') $error_mess = 'Veuillez remplir le champ <strong>Adresse email</strong>.';
	if($captcha_entered == '') $captcha_entered = 'Veuillez remplir le champ <strong>Captcha de sécurité</strong>.';
	if($token == '') $error_mess = 'Token invalide.';
	// Si pas d'erreur
	if($error_mess == '')
	{
		// Test du captcha verif bot
		if(strtoupper($captcha_entered) == strtoupper($_SESSION['codesecurite']) AND $_SESSION['codesecurite'] != "")
		// if(true)
		{
			$resultado = $Sql->prepare('SELECT * FROM accounts WHERE Login = ? AND Email = ?') or die ($error);
			$resultado->execute(array($nomdecomptee, $adressemail));
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$compte_torecup = $resultado->fetch();
			$resultado->closeCursor();
			// Si le compte existe
			if($compte_torecup)
			{
				$resultado = $Sql->prepare('SELECT * FROM motdepasse_recup WHERE idAccount = ? ORDER BY timestamp DESC LIMIT 1') or die ($error);
				$resultado->execute(array($compte_torecup->Id));
				$resultado->setFetchMode(PDO::FETCH_OBJ);
				$motdepasserecup_db_of_this_account = $resultado->fetch();
				$resultado->closeCursor();
				
				// Si son mdprecup est pas vide et contient le separateur
				if($motdepasserecup_db_of_this_account)
				{
					if($motdepasserecup_db_of_this_account->timestamp + (60*60) > time()) $error_mess = 'Vous vous êtes déjà envoyé un Email de récupération de compte il y as moins d\'une heure.</strong>.'; // A REMETTRE
				}
				// Si pas d'erreur
				if($error_mess == '')
				{
					// Send email
					$GENERATE_HASH = generer_hash_md5();
					$saltId = md5($compte_torecup->Id);
					$_SESSION['codesecurite'] == "";
					$afficheFORMU = FALSE;
					
					$resulta = $Sql->prepare("INSERT INTO motdepasse_recup (idAccount, hash, saltId, ip, timestamp, used) VALUES (?, ?, ?, ?, ?, 0)");
					$resulta->execute(array($compte_torecup->Id, $GENERATE_HASH, $saltId, get_real_ip(), time()));
					$resulta->closeCursor();
					
					$GENERATE_HASH = $GENERATE_HASH . $saltId;
					
					$mail->addAddress($adressemail);
					$mail->Subject = 'Confirmation de changement de mot de passe';
					ob_start();	
					?>
	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Neft-Gaming</title>
    <style type="text/css">
        #outlook a{padding:0;}
        body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
        body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body{margin:0; padding:0;}
        img{height:auto; line-height:100%; outline:none; text-decoration:none;}
        #backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
       p {
           margin: 1em 0;
       }
       h1, h2, h3, h4, h5, h6 {
           color: black !important;
           line-height: 100% !important;
       }
       h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;} h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important;}h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {color: purple !important;  }
       .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}
       </style>
</head>
<body>

    <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr>
    <td> 

    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="300"></td>
            <td width="300"></td>
            <td width="300"></td>
        </tr>
    </table>  
	
   	<h1>Bonjour,</h1>
	<h2>Vous avez demandé la réinitialisation de votre mot de passe sur neft-gaming.com</h2><br />
	<strong>Nom de compte :</strong> <?php echo $compte_torecup->Login; ?><br />
	<strong>Demande effectuée depuis l'adresse ip :</strong> <?php echo get_real_ip(); ?><br /><br />
	Pour poursuivre votre demande :
    <a href="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=lostpassword&amp;key=<?php echo $GENERATE_HASH; ?>" style="color:red; text-decoration:none;" target ="_blank"><span style="color:blue;">Cliquez ici</span></a>
    </td>
    </tr>
    </table>  
</body>
</html>
					<?php
					$mail->Body = ob_get_contents();
					ob_end_clean();
					// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					if(!$mail->send()) $error_mess = 'Impossible d\'envoyer le mail veuillez retenter plus tard.';
					else
					{
					?>
						<div class="info-message">
								Pour changer votre mot de passe commencez par confirmer votre identitée.<br />
								Un email vient de vous êtes envoyé sur l'adresse <strong><?php echo htmlspecialchars($adressemail); ?></strong>.<br />
						</div>
						<div class="breaking-line"></div>
						<p class="login-passes" style="width:85%;margin:auto;text-align:center;">Pour continuer la procédure, veuillez suivre les instructions dans ce mail.</p>
					<?php
					}
				}
			}
			else $error_mess = 'Aucun compte ne possèdent cette combinaison de <strong>Nom de compte / Adresse email</strong>.';
		}
		else $error_mess = 'Veuillez remplir correctement le <strong>Captcha de sécurité</strong>.';
	}
}


if(!empty($error_mess))
{
?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_mess; ?></span>
<?php
}
?>

<?php
if($afficheFORMU)
{
$token = generer_token_crsf('Neft-Gaming_'.$page);
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
*/
?>

	<form action="" method="post" autocomplete="off" style="display:block;width:95%;margin:auto;">
		<p>
			<label for="nomdecompte" style="display:block;margin:5px 0;">Nom de compte :</label>
			<input type="text" name="nomdecompte" id="nomdecompte" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre nom de compte" required />
		</p>	
										
		<p>
			<label for="adressemail" style="display:block;margin:5px 0;">Adresse Email :</label>
			<input type="text" name="adressemail" id="adressemail" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre adresse email" required />
		</p>											
								
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		
		<div class="clear-float do-the-split" style="margin:15px 0;"></div>
										
		<p style="text-align:center;">
			<label for="captcha_entered" style="display:block;margin:5px 0;font-weight:bold;">Vérification anti-robot</label>
			<img src="captcha.php" style="width:202px;height:46px;margin:0 auto 10px auto;display:block;" />
			<input type="text" name="captcha_entered" id="captcha_entered" style="display:block;width:100%;margin:auto;" value="" maxlength="6" placeholder="Captcha à remplir" required />
		</p>
										
		<div class="clear-float do-the-split" style="margin:15px 0;"></div>

		<p style="margin:15px 0;text-align:center;">
			<input type="submit" name="register" class="button big-size" style="cursor:pointer;margin-bottom:5px;background-color: #519623;" id="register" value="Réinitialiser mon mot de passe" />
		</p>
	</form>
	
<?php
}
?>
	</div>
<?php
}
?>