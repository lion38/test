<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Inscription"; // Nom de la page dans le content

if($_SESSION['Neft-Gaming_connecter']) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die();  }

$error_mess = "";
$end = FALSE;
$afficheFORMU = TRUE;

if(isset($_POST['register'], $_POST['nomdecompte'], $_POST['motdepasse'], $_POST['motdepasse_verif'], $_POST['adressemail'], $_POST['pseudonyme'], $_POST['secuquestion'], $_POST['secureponse'], $_POST['captcha_entered']))
{
	if(!empty($_POST['nomdecompte']) AND !empty($_POST['motdepasse']) AND !empty($_POST['motdepasse_verif']) AND !empty($_POST['adressemail']) AND !empty($_POST['pseudonyme']) AND !empty($_POST['secuquestion']) AND !empty($_POST['secureponse']) AND !empty($_POST['captcha_entered']))
	{
		$nomdecompte = trim($_POST['nomdecompte']);
		$motdepasse = trim($_POST['motdepasse']);
		$motdepasse_verif = trim($_POST['motdepasse_verif']);
		$adressemail = trim($_POST['adressemail']);
		$pseudonyme = trim($_POST['pseudonyme']);
		$secuquestion = trim($_POST['secuquestion']);
		$secureponse = trim($_POST['secureponse']);
		$captcha_entered = trim($_POST['captcha_entered']);
		
		// CRSF
		if(verifier_token_crsf(600, 'Neft-Gaming_'.$page))
		{
			// Test du captcha verif bot
			if(isset($_SESSION['codesecurite']) AND strtoupper($captcha_entered) == strtoupper($_SESSION['codesecurite']) AND $_SESSION['codesecurite'] != "")
			{
				// Check carracteres
				if(preg_match("#^[a-zA-Z0-9_]+$#i" , $nomdecompte))
				if(preg_match("#^[a-zA-Z0-9_]+$#i" , $pseudonyme))
				if(filter_var($adressemail, FILTER_VALIDATE_EMAIL))
				if(preg_match("#^[a-zA-Z0-9_]+$#i" , $secureponse))
				if($motdepasse == $motdepasse_verif)
				if(post_is_valid_not_chevron($secuquestion, array('<', '>', "&", ";")))
				if($nomdecompte != $pseudonyme)
				if($motdepasse != $nomdecompte)
				if($motdepasse != $pseudonyme)
				if(strlen($nomdecompte) >= 3 AND strlen($nomdecompte) <= 20)
				if(strlen($motdepasse) >= 3 AND strlen($motdepasse) <= 20)
				if(strlen($pseudonyme) >= 3 AND strlen($pseudonyme) <= 20)
				if(strlen($secuquestion) >= 3 AND strlen($secuquestion) <= 40)
				if(strlen($secureponse) >= 3 AND strlen($secureponse) <= 20)
				{
					// Test si le nom de compte / Pseudo / email existe dejà
					$query = $Sql->prepare('SELECT Login, Nickname FROM accounts WHERE Login = ? OR Nickname = ?');
					$query->execute(array($nomdecompte, $pseudonyme));
					$row = $query->fetch();
					$query->closeCursor();
					// Si tout est ok
					if(!$row)
					{
						$date = date("y/m/d H:i:s", time());
						$subscriptionEnd = date("y/m/d H:i:s", 0);
						$afficheFORMU = FALSE;
						$query = $Sql->prepare("INSERT INTO accounts(Login ,PasswordHash, Nickname, SecretQuestion, SecretAnswer, last_ip_web, CreationDate, SubscriptionEnd, Tokens, NewTokens, IsBanned, Lang, UserGroupId, Email) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 0, 0, 0, 'fr', '1', ?)");
						$query->execute(array($nomdecompte, md5($motdepasse), $pseudonyme, $secuquestion, $secureponse, get_real_ip(), $date, $subscriptionEnd, $adressemail));
						$query->closeCursor();
						$end = TRUE;
						$_SESSION['codesecurite'] == "";
					}
					else $error_mess .= 'Votre Nom de compte ou Pseudonyme est déjà utilisé par quelqu\'un.';
				}
				else $error_mess = 'Votre <strong>Réponse secrète</strong> est soit trop longue soit trop courte.<br /><em>(3 à 20 caractères)</em>';
				else $error_mess = 'Votre <strong>Question secrète</strong> est soit trop longue soit trop courte.<br /><em>(3 à 40 caractères)</em>';
				else $error_mess = 'Votre <strong>Pseudonyme</strong> est soit trop long soit trop court.<br /><em>(3 à 20 caractères)</em>';
				else $error_mess = 'Votre <strong>Mot de passe</strong> est soit trop long soit trop court.<br /><em>(3 à 20 caractères)</em>';
				else $error_mess = 'Votre <strong>Nom de compte</strong> est soit trop long soit trop court.<br /><em>(3 à 20 caractères)</em>';
				else $error_mess = 'Veuillez choisir un <strong>Mot de passe</strong> différent du <strong>Pseudonyme</strong> !';
				else $error_mess = 'Veuillez choisir un <strong>Mot de passe</strong> différent du <strong>Nom de compte</strong> !';
				else $error_mess = 'Veuillez choisir un <strong>Pseudonyme</strong> différent du <strong>Nom de compte</strong> !';
				else $error_mess = 'Caractères interdits dans votre <strong>Question secrète</strong> !';
				else $error_mess = 'Vous avez mal répétez votre <strong>Mot de passe</strong>.';
				else $error_mess = 'Caractères interdits dans votre <strong>Réponse secrète</strong> !<br /><em>(<b>a</b> à <b>z</b>, <b>A</b> à <b>Z</b>, <b>_</b> autorisées)</em>';
				else $error_mess = 'Votre <strong>Adresse Email</strong> est incorrecte.';
				else $error_mess = 'Caractères interdits dans votre <strong>Pseudo</strong> !<br /><em>(<b>a</b> à <b>z</b>, <b>A</b> à <b>Z</b>, <b>_</b> autorisées)</em>';
				else $error_mess = 'Caractères interdits dans votre <strong>Nom de compte</strong> !<br /><em>(<b>a</b> à <b>z</b>, <b>A</b> à <b>Z</b>, <b>_</b> autorisées)</em>';
			}
			else $error_mess = 'Veuillez remplir correctement le <strong>captcha de sécurité</strong>.';
		}
		else $error_mess = 'Vous avez mis trop de temps pour soumettre les informations.';
	}
	else $error_mess = 'Veuillez remplir tous les champs du formulaire d\'inscription.';
}

	if($end)
	{
		$page_is_full_width = false; // Supprime le menu de droite

		include('include/header.php');
		include('include/rightbar.php');
		?>
		
		<span class="the-success-msg" style="width:90%;margin:auto;"><i class="fa fa-check"></i><strong>Félicitations</strong>, vous êtes correctement inscrit sur Neft-Gaming !</span>
		
		<div class="breaking-line"></div>
		
		<div style="text-align:center;">
			<h2>Vous pouvez désormais vous connecter avec vos identifiants.</h2>
			<em><strong>Redirection automatique</strong> vers le formulaire de connexion dans <strong>5 secondes...</strong></em>
		</div>
		<script>
		setTimeout(function() { 
			window.location.href = "index.php?page=login"; 
		 }, 5000);
		</script>
		<?php
	}
	else
	{
		$page_is_full_width = true; // Supprime le menu de droite

		include('include/header.php');
		include('include/rightbar.php');
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
						<div class="signup-panel">

							<div class="left">
								<h2><span>Inscription</span></h2>
								
<?php
if(!empty($error_mess))
{
?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_mess; ?></span>
<?php
}
?>

								<div class="content-padding" >
								<div class="login-passes" style="padding:0;">
								
									<form action="" method="post" autocomplete="off" style="display:block;width:80%;margin:auto;position:relative;left:-10px;">
										<p>
											<label for="nomdecompte" style="display:block;margin:5px 0;">Nom de compte :</label>
											<input type="text" name="nomdecompte" id="nomdecompte" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre nom de compte" required />
										</p>
																			
										<p>
											<label for="motdepasse" style="display:block;margin:5px 0;">Mot de passe :</label>
											<input type="password" name="motdepasse" id="motdepasse" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre mot de passe" required />
										</p>
										
										<p>
											<label for="motdepasse_verif" style="display:block;margin:5px 0;">Mot de passe (répétez) :</label>
											<input type="password" name="motdepasse_verif" id="motdepasse_verif" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre mot de passe (répétez)" required />
										</p>
										
										<p>
											<label for="adressemail" style="display:block;margin:5px 0;">Adresse Email :</label>
											<input type="text" name="adressemail" id="adressemail" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre adresse email" required />
										</p>
										
										<p>
											<label for="pseudonyme" style="display:block;margin:5px 0;">Pseudo :</label>
											<input type="text" name="pseudonyme" id="pseudonyme" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre pseudonyme" required />
										</p>
										
										<input type="hidden" name="token" value="<?php echo $token; ?>" />
										<div class="clear-float do-the-split" style="margin:15px 0;"></div>
										
										<p>
											<label for="secuquestion" style="display:block;margin:5px 0;">Question secrète :</label>
											<input type="text" name="secuquestion" id="secuquestion" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre question secrète" required />
										</p>
										
										<p>
											<label for="secureponse" style="display:block;margin:5px 0;">Réponse secrète :</label>
											<input type="text" name="secureponse" id="secureponse" style="display:block;width:100%;margin:auto;" value="" placeholder="Votre réponse secrète" required />
										</p>
										
										<div class="clear-float do-the-split" style="margin:15px 0;"></div>
										
										<p style="text-align:center;">
											<label for="captcha_entered" style="display:block;margin:5px 0;">Vérification anti-robot</label>
											<img src="captcha.php" style="width:202px;height:46px;margin:0 auto 10px auto;display:block;" />
											<input type="text" name="captcha_entered" id="captcha_entered" style="display:block;width:100%;margin:auto;" value="" maxlength="6" placeholder="Captcha à remplir" required />
										</p>
										
										<div class="clear-float do-the-split" style="margin:15px 0;"></div>

										<p style="margin:15px 0;text-align:center;">
											<input type="submit" name="register" class="button big-size" style="cursor:pointer;margin-bottom:5px;background-color: #519623;" id="register" value="S'inscrire sur Neft-Gaming" />
										</p>
									</form>
								


								</div>
								</div>
								<div class="content-padding">
											<p class="clearfix doborderneph" style="margin-bottom:0;line-height:20px;background:white;">
												<span class="info-msg" style="margin-top:0;background:#dc643a;color:white;font-size:0.90em;">
													Si vous avez perdu votre mot de passe <a href="index.php?page=lostpassword" style="color:white;font-weight:bold;">Cliquez-ici</a>.
												</span>
											</p>
								</div>

							</div>

							<div class="right">
								<h2><span>L'inscription sur Neft-Gaming</span></h2>
								<div class="content-padding">
									
									<div class="form-split-about">
										<p class="p-padding"><b>Vous ne pourrez jouer sur le serveur qu'une fois votre compte crée.</b><br />Aucune validation par e-mail n'est requise, cependant veillez à mettre un <b>e-mail correct</b> en cas de <b>perte de mot de passe</b> ou de <b>vente de personnages</b> !</p>

										<ul>
											<li>
												<i class="fa fa-picture-o"></i>
												<b>Attention à vos données</b>
												<p class="p-padding">Sur Neft-Gaming, vos données sont cryptées et stockées dans des serveurs ultra-sécurisés, cependant d'autres serveurs concurrents eux ne pratiquent pas les mêmes méthodes de sécurité et laissent vos données affichées, c'est pourquoi il est <b>déconseillé</b> de mettre le même nom de compte et mot de passe que sur d'autres serveurs !</p>
											</li>
											
											<li>
												<i class="fa fa-trophy"></i>
												<b>Rejoindre le serveur Neft-Gaming</b>
												<p class="p-padding">Nombreux joueurs vous attendent, qu'attendez-vous pour nous rejoindre ? Inscrivez-vous et venez jouer dès maintenant !<br />
												<a href="http://files.Neft-Gaming.eu/Neft-Gaming.exe"><u><b>Je télécharge Neft-Gaming</b></u></a></p>
											</li>

											<li>
												<i class="fa fa-microphone"></i>
												<b>Serveur vocal à disposition !</b>
												<p class="p-padding">Un serveur <b>TeamSpeak 3</b> gratuit, accueillant et peuplé vous attends sur Neft-Gaming.<br />
												<a href="http://ts.Neft-Gaming.eu/"><u><b>Accéder au serveur vocal</b></u></a></p>
											</li>
											
											<li>
												<i class="fa fa-comments"></i>
												<b>Vous n'êtes pas seul !</b>
												<p class="p-padding">Communiquez librement avec toute la communauté de Neft-Gaming sur notre forum !<br />
												<a href="http://forum.Neft-Gaming.eu/"><u><b>Découvrir le forum en cliquant-ici</b></u></a></p>
											</li>
										</ul>
										
									</div>
									
								</div>
							</div>

							<div class="clear-float"></div>
						</div>
<?php
}
?>