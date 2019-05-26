<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Vendre dans le marché des personnages"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

if(!isset($_GET['confirm_makefiche']))
{
include('include/header.php');
include('include/rightbar.php');
}

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }

	$cache_to_read = $CONFIG['cache_folder'].'classement_xprate.cache';
	$XP_TABLE = '';
	if(file_exists($cache_to_read))
	{
		$XP_TABLE = file_get_contents($cache_to_read);
	}
	else
	{
		ob_start();	
		$resultado = $result = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.experiences') or die ($error);
		$resultado->execute();
		$rowofxp = $resultado->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
		$resultado->closeCursor();
		echo serialize($rowofxp);
		$XP_TABLE = ob_get_contents();
		ob_end_clean();

		file_put_contents($cache_to_read, $XP_TABLE);
	}
	$XP_TABLE = unserialize($XP_TABLE);
?>
<?php
$error_mess = "";
$hide_base_form = false;
$show_button_page_refresh = false;

if(isset($_GET['confirm_makefiche']))
{
	if(isset($_GET['confirm_hash'], $_GET['confirm_id']) AND !empty($_GET['confirm_hash']) AND !empty($_GET['confirm_id']))
	{
		$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE hash = ? and (etat = ? OR etat = ?) ORDER BY timetampStartVente DESC LIMIT 1');
		$query->execute(array($_GET['confirm_hash'], $CONFIG['marcheperso_array_etat']['wait_confirmation'], $CONFIG['marcheperso_array_etat']['en_vente']));
		$row = $query->fetch();
		$query->closeCursor();
		
		$bypassAdminEdit = (isset($_GET['admin_refresh_fiche']) AND in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) ? true : false;
		
		if($row)
		{
			if($row['etat'] == $CONFIG['marcheperso_array_etat']['wait_confirmation'] OR $bypassAdminEdit)
			{
				if($_GET['confirm_id'] == md5(md5($row['id_perso']) . 'Ae9d6fsd41f'))
				{
					if($COMPTE->Id == $row['sellByAccountId'] OR $bypassAdminEdit)
					{
						$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.accounts WHERE Id = ? LIMIT 1');
						$query->execute(array($COMPTE->Id));
						$rowWorld = $query->fetch();
						$query->closeCursor();
								
						$connected_on_other_perso_ok = (isset($rowWorld) AND !empty($rowWorld) AND ($rowWorld['ConnectedCharacter'] == NULL OR $rowWorld['ConnectedCharacter'] == $row['id_perso'])) ? FALSE : TRUE ;
						// Verif si le compte est pas connecté sur le world
						if($connected_on_other_perso_ok OR $bypassAdminEdit)
						{
						
							// Trade le perso avec un compte bot
							if(!$bypassAdminEdit)
							{
							$query = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.worlds_characters SET AccountId = ? WHERE CharacterId = ? AND AccountId = ? LIMIT 1');
							$query->execute(array($CONFIG['marcheperso_idaccount_stackpersotosell'], $row['id_perso'], $row['sellByAccountId']));
							$query->closeCursor();
							
							// Met le perso en vente
							$query = $Sql->prepare("UPDATE marche_des_personnages SET etat = ? WHERE id = ?");
							$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente'], $row['id']));
							$query->closeCursor();
							}
						
							$cache_perso_preview = ''; 
							ob_start();	
							// Debut cache
								
								$API_ID_PERSO_PARSING = $row['id_perso'];
								include('include/api_marche_des_personnages.php');
								
							// Fin cache
							$base64mini_image = (isset($b64_image_mini)) ? $b64_image_mini : '';
							$base64big_image = (isset($b64_image_big)) ? $b64_image_big : '';
							$cache_perso_preview = ob_get_contents();
							ob_end_clean();
							$cache_to_read = $CONFIG['cache_folder'] .'marche_des_personnages/'.$row['id_perso'].'.cache';
							file_put_contents($cache_to_read, $cache_perso_preview);

							$previewBigInject = base64_decode(str_replace(' ', '+', $b64_image_big));
							if(strlen($previewBigInject) > 100)
								file_put_contents('pages/marche_des_personnages_images/big/'.$row['id_perso'].'.png', $previewBigInject);
							
							$previewMiniInject = base64_decode(str_replace(' ', '+', $b64_image_mini));
							if(strlen($previewMiniInject) > 100)
								file_put_contents('pages/marche_des_personnages_images/mini/'.$row['id_perso'].'.png', $previewMiniInject);
								
							echo "OK_VALIDATE";
							
						}
						else
						{
							$show_button_page_refresh = true;
							if($rowWorld['ConnectedCharacter'] == NULL)
								$error_mess = "Erreur, pour continuer vous devez vous <strong>connecter sur le client Dofus</strong> avec votre compte.<br /><strong style='color:#af0a0a;'>Il est obligatoire de vous connecter sur un personnage autre que ".$row['nomPerso']." !</strong><br /><em>Si vous n'avez pas d'autre personnage, il suffit d'en créer un nouveau !</em>";
							elseif($rowWorld['ConnectedCharacter'] == $row['id_perso'])
								$error_mess = "Erreur, vous êtes actuellement connecté sur le personnage <strong>".$row['nomPerso']."</strong>.<br /><strong style='color:#af0a0a;'>Pour continuer vous devez vous connecter sur un autre personnage !</strong><br /><em>Se déconnecter du compte ne suffit pas.</em>";
						}
					}
					else $error_mess = 'Erreur ce personnage ne vous appartient pas.';
				}
				else $error_mess = 'Erreur ce hash n\'existe pas dans le marché des personnages.';
			}
			else $error_mess = 'Erreur ce personnage est déjà en vente !';
		}
		else $error_mess = 'Erreur ce hash n\'existe pas dans le marché des personnages.';
	}
	
	if(!empty($error_mess)) echo $error_mess;
}
elseif(isset($_GET['confirm_hash'], $_GET['confirm_id']) AND !empty($_GET['confirm_hash']) AND !empty($_GET['confirm_id']))
{
	?>
	<h2 style="margin-bottom:0;"><span>Vendre dans le marché des personnages</span></h2>
	<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">
	<?php
	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE hash = ? and (etat = ? OR etat = ?) ORDER BY timetampStartVente DESC LIMIT 1');
	$query->execute(array($_GET['confirm_hash'], $CONFIG['marcheperso_array_etat']['wait_confirmation'], $CONFIG['marcheperso_array_etat']['en_vente']));
	$row = $query->fetch();
	$query->closeCursor();
	
	$bypassAdminEdit = (isset($_GET['admin_refresh_fiche']) AND in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) ? true : false;
	
	if($row)
	{
		if($row['etat'] == $CONFIG['marcheperso_array_etat']['wait_confirmation'] OR $bypassAdminEdit)
		{
			if($_GET['confirm_id'] == md5(md5($row['id_perso']) . 'Ae9d6fsd41f'))
			{
				if($COMPTE->Id == $row['sellByAccountId'] OR $bypassAdminEdit)
				{
				?>
				<span style="text-align:center;" id="etapeOneNotEnd">
					<h3>Vous êtes sur le point de <?php if($bypassAdminEdit) echo 'rafraichir la fiche du personnage'; else echo 'finaliser la vente de votre personnage'; ?> <strong style="color:#007ac0;"><?php echo $row['nomPerso']; ?></strong>.</h3>
					
					<input onClick="vote()" id="buttonSellConfirm" type="submit" value="<?php if($bypassAdminEdit) echo 'Actualiser la fiche du personnage'; else echo 'Mettre en vente mon personnage'; ?>" style="margin:5px auto;width:auto;display:block;" class="button big-size" /><br />
					
					<div class="breaking-line" style="margin-top:0;"></div>
					
					<div id="loading_gif" style="display:none;">
						<img src="images/loadinground.gif" style="display:block;width:58px;height:58px;margin:20px auto 10px auto;" alt="Chargement ..." />
						<h3 style="color:#0b66b4;"><?php if($bypassAdminEdit) echo 'Actualisation du personnage'; else echo 'Mise en vente de votre personnage'; ?>, veuillez patienter...</h3>
					</div>
					
					
					<span class="the-error-msg" id="error_to_show" style="width:95%;margin:0 auto 15px auto;display:none;"><i class="fa fa-warning"></i><div class="msgbox-content" style="display:inline;"></div></span>
				</span>
				<div id="successToShow" style="display:none;">
					<span class="the-success-msg" style=""><i class="fa fa-check"></i>Félicitations, <strong><?php echo htmlentities($row['nomPerso']); ?></strong> <em>(<?php echo $classe[$row['classe']]; ?> de niveau <?php echo $row['level']; ?>)</em> est désormais en vente pour <strong><?php echo $row['prix']; ?> Ogrines </strong> !</span>

					<div class="breaking-line" style=""></div>

					<p style="text-align:center;"><a href="index.php?page=historique_marche_personnage" style="margin:0px auto 0 auto;" class="button"><strong>Cliquez-ici</strong> pour voir vos personnages en vente.</a></p>
				</div>
				
				<script type="text/javascript">

					function vote()
					{
							jQuery('#buttonSellConfirm').hide();
							jQuery('#loading_gif').fadeIn("fast");
							jQuery('#error_to_show').hide();
							
							jQuery.get("index.php?page=vendre_personnages", { confirm_makefiche: "yes", confirm_hash: "<?php echo $_GET['confirm_hash']; ?>", confirm_id: "<?php echo $_GET['confirm_id']; ?>"<?php if($bypassAdminEdit) echo ', admin_refresh_fiche: "yes"'; ?>},
							   function(r)
							   {
									jQuery('#loading_gif').fadeOut("slow")

									if(r == "OK_VALIDATE")
									{
										jQuery('#etapeOneNotEnd').hide();
										<?php
										if($bypassAdminEdit)
										{
										?>
										document.location="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=achat_personnages&show_id=<?php echo intval($row['id']); ?>";
										<?php
										}
										else
										{
										?>
										jQuery('#successToShow').fadeIn("slow");
										<?php
										}
										?>
									}
									else
									{
										jQuery('#buttonSellConfirm').show();
										if(r == "") r = 'Erreur inconnue.';
										jQuery('#error_to_show').show();
										jQuery('#error_to_show .msgbox-content').html(r);
									}
							   }
							 );
					}
</script>
				<?php
				}
				else $error_mess = 'Erreur ce personnage ne vous appartient pas.';
			}
			else $error_mess = 'Erreur ce hash n\'existe pas dans le marché des personnages.';
		}
		else $error_mess = 'Erreur ce personnage est déjà en vente !';
	}
	else $error_mess = 'Erreur ce hash n\'existe pas dans le marché des personnages.';
	
	
	if(!empty($error_mess))
	{
	?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><div class="msgbox-content" style="display:inline;"><?php echo $error_mess; ?></div></span>
	<?php
	}
	if($show_button_page_refresh)
	{
	?>
		<div style="text-align:center;">
			<a class="button" style="background-color: #B1221C;" href="" id="reload_page"><strong>Cliquez-ici</strong> pour rafraîchir la page quand vous êtes connecté sur <strong>un autre personnage</strong> !</a>
		</div>
		<script>
		jQuery('#reload_page').click(function() {
			location.reload();
			return false;
		});
		</script>
	<?php
	}
	?>
	</div>
	<?php
}
else
{
	?>
<h2 style="margin-bottom:0;"><span>Vendre dans le marché des personnages</span></h2>
<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">

	<?php
	if(isset($_POST['sellAChar'], $_POST['id_persopick'], $_POST['prix_ogrines']))
	{
		if(!empty($_POST['id_persopick']) AND !empty($_POST['prix_ogrines']))
		{
			$_POST['id_persopick'] = trim($_POST['id_persopick']);
			// Si le prix est plus haut que le minimum
			if(is_numeric($_POST['prix_ogrines']) AND $_POST['prix_ogrines'] >= $CONFIG['marcheperso_prixvente_mini'] AND $_POST['prix_ogrines'] <= 999998)
			{
				$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.worlds_characters WHERE CharacterId = ? AND AccountId = ? AND WorldId = 1 LIMIT 1');
				$query->execute(array($_POST['id_persopick'], $COMPTE->Id));
				$row = $query->fetch();
				$query->closeCursor();
				
				// Si le personnage appartient bien au compte connecté OK
				if($row)
				{
					$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE id_perso = ? and (etat = ? OR etat = ?) ORDER BY timetampStartVente DESC LIMIT 1');
					$query->execute(array($_POST['id_persopick'], $CONFIG['marcheperso_array_etat']['wait_confirmation'], $CONFIG['marcheperso_array_etat']['en_vente']));
					$row2 = $query->fetch();
					$query->closeCursor();
					$canContinue = true;
					if($row2) { if(time() < $row2['timetampStartVente'] + 60 * 60 OR $row2['etat'] == $CONFIG['marcheperso_array_etat']['en_vente']) $canContinue = false; }
					// Si le perso est pas deja en vente, ou mis il y as plus d'une heure
					if($canContinue)
					{
						$GENERATE_HASH = generer_hash_md5();
						
						$QUERYBOT2 = $Sql->prepare('SELECT Id,Experience,Breed,Name FROM '.$CONFIG['db_world'].'.characters WHERE Id = ?');
						$QUERYBOT2->execute(array($_POST['id_persopick']));
						$rowOfCharactersForSell = $QUERYBOT2->fetch();
						$QUERYBOT2->closeCursor();
						
						if($rowOfCharactersForSell)
						{
							$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.accounts WHERE Id = ? LIMIT 1');
							$query->execute(array($COMPTE->Id));
							$rowWorld = $query->fetch();
							$query->closeCursor();
						
							
							if(getLevelByExperience($XP_TABLE, 'CharacterExp', $rowOfCharactersForSell['Experience']) >= 60)
							{
								
								$connected_on_other_perso_ok = (isset($rowWorld) AND !empty($rowWorld) AND ($rowWorld['ConnectedCharacter'] == NULL OR $rowWorld['ConnectedCharacter'] == $_POST['id_persopick'])) ? FALSE : TRUE ;
								// Verif si le compte est pas connecté sur le world
								if($connected_on_other_perso_ok)
								{
									require 'config/phpmailerLIB/PHPMailerAutoload.php';
									$mail = new PHPMailer();
									$mail->IsSMTP();
									$mail->isHTML(true);
									$mail->CharSet = 'UTF-8';
									$mail->Host       = "mail.neft-gaming.com"; // SMTP server example
									$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
									$mail->SMTPAuth   = true;                  // enable SMTP authentication
									$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
									$mail->Username   = "support@neft-gaming.com"; // SMTP account username example
									$mail->Password   = "10I})Yd]5cXz";        // SMTP account password example
									$mail->From = 'support@neft-gaming.com';
									$mail->FromName = 'Domanya';

									$mail->addAddress($COMPTE->Email);
									$mail->Subject = 'Mise en vente de votre personnage '.htmlentities($rowOfCharactersForSell['Name']);
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
											<h2>Vous avez fait une demande de vente de votre personnage <?php echo htmlentities($rowOfCharactersForSell['Name']); ?> sur <a href="<?php echo $CONFIG['URL_SITE']; ?>" target="_blank">neft-gaming.com</a></h2>
											<strong>Nom de compte :</strong> <?php echo htmlentities($COMPTE->Login); ?><br />
											<strong>Adresse email :</strong> <?php echo ($COMPTE->Email); ?><br />
											<strong>Demande effectuée depuis l'adresse ip :</strong> <?php echo get_real_ip(); ?><br /><br />
											<br>
											<a target="_blank" href="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=vendre_personnages&amp;confirm_hash=<?php echo $GENERATE_HASH; ?>&amp;confirm_id=<?php echo md5(md5($_POST['id_persopick']) . 'Ae9d6fsd41f'); ?>" style="font-weight:bold;font-family:Verdana;font-size:15px;background:#e8e8e8;padding:10px;color:#585858;text-shadow:1px 1px 0 white;border:1px solid #b7b7b7;">Cliquez-ici pour confirmer la vente du personnage <?php echo htmlentities($rowOfCharactersForSell['Name']); ?> pour <?php echo intval($_POST['prix_ogrines']); ?> Ogrines.</a><br /><br />
											
											<br /><em>Si cette demande n'as pas été effectuée par vous veuillez changer vos identifiants.</em><br><br>
											<a href="<?php echo $CONFIG['URL_SITE']; ?>" target="_blank">Neft-gaming.com</a>
											</td>
											</tr>
											</tbody></table>  
										</body>
										</html>
									<?php
									$mail->Body = ob_get_contents();
									ob_end_clean();
									// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

									if(!$mail->send()) $error_mess = 'Impossible d\'envoyer l\'e-mail veuillez re-tenter plus tard.';
									else
									{
										if($row2)
										{
											$query = $Sql->prepare("UPDATE marche_des_personnages SET timetampStartVente = ?, ipStartVente = ?, prix = ?, hash = ?, sellByAccountId = ?, level = ?, classe = ?, nomPerso = ?, etat = ? WHERE id = ?");
											$query->execute(array(time(), get_real_ip(), $_POST['prix_ogrines'], $GENERATE_HASH, $COMPTE->Id, getLevelByExperience($XP_TABLE, 'CharacterExp', $rowOfCharactersForSell['Experience']), $rowOfCharactersForSell['Breed'], $rowOfCharactersForSell['Name'], $CONFIG['marcheperso_array_etat']['wait_confirmation'], $row2['id']));
											$query->closeCursor();
										}
										else
										{
											$query = $Sql->prepare("INSERT INTO marche_des_personnages(id_perso,sellByAccountId,level,classe,nomPerso,prix,buyByAccountId,timetampStartVente,ipStartVente,hash,etat,timestampAchat,ipAchatFin) VALUES(?, ?, ?, ?, ?, ?, -1, ?, ?, ?, ?, -1, -1)");
											$query->execute(array(intval($_POST['id_persopick']), $COMPTE->Id, getLevelByExperience($XP_TABLE, 'CharacterExp', $rowOfCharactersForSell['Experience']), $rowOfCharactersForSell['Breed'], $rowOfCharactersForSell['Name'], $_POST['prix_ogrines'], time(), get_real_ip(), $GENERATE_HASH, $CONFIG['marcheperso_array_etat']['wait_confirmation']));
											$query->closeCursor();
										}
										$hide_base_form = true;
										?>
										<span class="the-success-msg" style="margin-top:10px;"><i class="fa fa-check"></i>Félicitations, vous allez reçevoir un <strong>e-mail</strong> sous peu pour <strong>confirmer la vente</strong> de votre personnage <?php htmlentities($rowOfCharactersForSell['Name']); ?>.</span>
										<?php
									}
								}
								else
								{
									if($rowWorld['ConnectedCharacter'] == NULL)
										$error_mess = "Erreur, pour continuer vous devez vous <strong>connecter sur le client Dofus</strong> avec votre compte.<br /><strong style='color:#af0a0a;'>Il est obligatoire de vous connecter sur un personnage autre que ".$rowOfCharactersForSell['Name']." !</strong><br /><em>Si vous n'avez pas d'autre personnage, il suffit d'en créer un nouveau !</em>";
									elseif($rowWorld['ConnectedCharacter'] == $_POST['id_persopick'])
										$error_mess = "Erreur, vous êtes actuellement connecté sur le personnage <strong>".$rowOfCharactersForSell['Name']."</strong>.<br /><strong style='color:#af0a0a;'>Pour continuer vous devez vous connecter sur un autre personnage !</strong><br /><em>Se déconnecter du compte ne suffit pas.</em>";
								}
							}
							else $error_mess = "Le personnage dois être minimum niveau 60 pour le vendre !";
						}
						else $error_mess = "Ce personnage n'existe pas.";
					}
					else $error_mess = "Vous avez déjà fait une demande il y as moins d'une heure sur ce personnage.";
				}
				else $error_mess = "Ce personnage n'est pas lié à votre compte.";
			}
			else $error_mess = 'Le prix doit être au <strong>minimum de '.$CONFIG['marcheperso_prixvente_mini'].' Ogrines</strong>.';
		}
		else $error_mess = 'Veuillez remplir le formulaire.';
	}
	?>

	<?php
	if(!$hide_base_form)
	{
	?>
		<div class="info-message bg-dark" style="text-align:center;">
				<h3><span class="icon-info" ></span>Informations avant la vente d'un personnage :</h3>
				<p style="margin:8px 0;">
					Veuillez vous <strong>connecter en jeu sur un autre personnage</strong> que celui que vous allez vendre puis validez votre vente.<br />
					Vous allez reçevoir un <strong>e-mail pour confirmer</strong> la vente de votre personnage.<br />
					Veuillez <strong>cliquer sur le lien</strong> qui sera dans cet e-mail pour <strong>valider la vente</strong> de votre personnage.
				</p>
		</div>

		<div class="info-message">
			<p>Lorsque la vente de votre personnage sera <strong>validée</strong>, vous ne pourrez <strong>plus vous connecter dessus</strong>.</p>
		</div>
		
		<div class="clear-float do-the-split" style="margin-top:20px;margin-bottom:20px;"></div>
		
		<?php
		if(!empty($error_mess))
		{
		?>
		<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_mess; ?></span>
		<?php
		}
		?>
		
		<form method="post" action="index.php?page=vendre_personnages">
			
			<label for="id_persopick" style="font-family:verdana;margin-top:20px;display:block;"><h3>Veuillez choisir un de vos personnages pour le vendre dans le marché :</h3></label>
			<select name="id_persopick" id="id_persopick" style="font-size:16px;width:100%;margin-top:5px;" class="form-control">
				<option value="" style="color:red;">Veuillez choisir un de vos personnages.</option>
					<?php
					
					$query = $Sql->prepare('SELECT DISTINCT p.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE a.AccountId = ? AND p.Id = a.CharacterId AND a.AccountId = r.Id AND a.WorldId = 1 ORDER BY p.Experience DESC');
					$query->execute(array($COMPTE->Id));
					$id=0;					
					while ($row = $query->fetch())
					{
						$id++;
						?>
						<option value="<?php echo $row['Id']; ?>"><?php echo $row['Name']; ?> (<?php echo $classe[$row['Breed']]; ?> - Niveau <?php echo getLevelByExperience($XP_TABLE, 'CharacterExp', $row['Experience']); ?>)</option>
						<?php
					}
					$query->closeCursor();
					if($id == 0)
					{
					?>
					<option value="" style="color:red;">Aucun personnage sur ce compte.</option>
					<?php
					}
					
					$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE sellByAccountId = ? and etat = ? ORDER BY timetampStartVente DESC');
					$query->execute(array($COMPTE->Id, $CONFIG['marcheperso_array_etat']['en_vente']));
					while ($row = $query->fetch())
					{
						?>
						<option value="" style="color:darkred;">EN COURS DE VENTE : <?php echo $row['nomPerso']; ?> (<?php echo $classe[$row['classe']]; ?> - Niveau <?php echo $row['level']; ?>)</option>
						<?php
					}
					$query->closeCursor();
					?>
			</select>
			<br />
			<div id="askPrixToSell" style="display:none;">
				<br />
				<label for="prix_ogrines"><h3>Prix en Ogrines (Chiffre rond) :</h3></label>
				<input class="form-control" type="text" name="prix_ogrines" id="prix_ogrines" style="width:100%;text-align:left;color:black;display:inline;margin-top:5px;" value="" placeholder="Prix en Ogrines" />
				<span class="the-alert-msg" style="margin-top:10px;"><i class="fa fa-warning"></i>Le montant minimum est de <strong><?php echo $CONFIG['marcheperso_prixvente_mini']; ?></strong> Ogrines.</span>
				
				<input class="button big-size" style="margin:20px auto 0 auto;display:block;background-color: #14a837;" name="sellAChar" type="submit" value="Vendre ce personnage" />
			</div>
		</form>
		
		<script>
		jQuery('#id_persopick').change(function()
		{
			var idChar = jQuery(this).attr('value');
			if(idChar != "") jQuery('#askPrixToSell').show();
			else jQuery('#askPrixToSell').hide();
		});
		</script>	
	<?php
	}
	?>
	</div>
	<?php
}
?>