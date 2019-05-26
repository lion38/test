<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Mon compte"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }

$email_show = (!empty($COMPTE->Email)) ? $COMPTE->Email : 'Non renseignée';
$banni_show = ($COMPTE->IsBanned == 1) ? 'Oui' : 'Non';
$vip_show = 'Non';
$vote_show = ($COMPTE->Votes > 0) ? $COMPTE->Votes : 0;
?>
<h2><span>Mon compte</span></h2>
<div style="font-family:Raleway;">

	  <script>
	  $(function() {
		$( "#tabsCompte" ).tabs();
	  });
	  </script>
	  
	<div id="tabsCompte" style="width:95%;margin:auto;">
		<ul class="content-padding" style="text-align:center;list-style:none;">
			<li style="display:inline;"><a href="#tabs-mesinfos" class="button big-size" style="margin-bottom:5px;">Mes informations</a></li> &nbsp;
			<li style="display:inline;"><a href="#tabs-changerpass" class="button big-size" style="margin-bottom:5px;background-color: #B1221C;">Changer mon mot de passe</a></li>
		</ul>
		
		<div class="breaking-line"></div>
		
		<div class="content-padding">
		
			<div id="tabs-mesinfos">
				<h2 style="text-align:center;text-shadow:1px 1px 0 white;">Mes informations</h2>
				<div class="do-the-split" style="margin:0 auto 5px auto;"></div>
				
				
				<div class="table_neph" style="text-align:center;">
					<div class="row_neph header_neph" style="font-family:'Open Sans';">
						<div class="cell_neph">Nom de compte</div>
						<div class="cell_neph">Pseudonyme</div>
						<div class="cell_neph">Email</div>
					</div>
					<div class="row_neph" style="background:white;">
						<div class="cell_neph"><?php echo htmlspecialchars(ucfirst($COMPTE->Login)); ?></div>
						<div class="cell_neph"><?php echo htmlspecialchars(ucfirst($COMPTE->Nickname)); ?></div>
						<div class="cell_neph"><?php echo $email_show; ?></div>
					</div>
				</div>
				<br />
				<div class="table_neph" style="text-align:center;">
					<div class="row_neph header_neph" style="font-family:'Open Sans';background-color:#95001c;">
						<div class="cell_neph">Dernière IP</div>
						<div class="cell_neph">Banni</div>
						<div class="cell_neph">V.I.P</div>
					</div>
					<div class="row_neph" style="background:white;">
						<div class="cell_neph"><?php echo $COMPTE->LastConnectedIp; ?></div>
						<div class="cell_neph"><strong><?php echo $banni_show; ?></strong></div>
						<div class="cell_neph"><strong><?php echo $vip_show; ?></strong></div>
					</div>
				</div>
				<br />
				<div class="table_neph" style="text-align:center;">
					<div class="row_neph header_neph" style="font-family:'Open Sans';background-color:#199500;">
						<div class="cell_neph">Nombres de votes</div>
						<div class="cell_neph">Nombres d'Ogrines</div>
					</div>
					<div class="row_neph" style="background:white;">
						<div class="cell_neph"><strong style="font-size:1.5em;"><?php echo $vote_show; ?></strong></div>
						<div class="cell_neph"><strong style="font-size:1.5em;"><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></strong><em style="font-size:1.2em;position:relative;top:4px;left:4px;">(<a href="index.php?page=achat" style="color:#4074d3;">En acheter</a>)</em></div>
					</div>
				</div>
				
			</div>
			
			<div id="tabs-changerpass">
				<h2 style="text-align:center;text-shadow:1px 1px 0 white;">Changer mon mot de passe</h2>
				<div class="do-the-split" style="margin:0 auto 5px auto;"></div>
				
				<div class="table_neph" style="text-align:center;">
					<div class="row_neph header_neph" style="font-family:'Open Sans';background-color:#199500;">
						<div class="cell_neph" style="background-color:#737373;"></div>
					</div>
					<div class="row_neph" style="background:white;">
						<div class="cell_neph">
						
				<?php
				$afficherFORMeditmdp = TRUE;
				$editmdp_SUCCESS = FALSE;
				$editmdp_ERROR = "";
				
				if(isset($_POST['editmdp'], $_POST['mdp_actual'], $_POST['mdp_new'], $_POST['mdp_new_confirm']))
				{
					if(!empty($_POST['mdp_actual']) AND !empty($_POST['mdp_new']) AND !empty($_POST['mdp_new_confirm']))
					{
						$mdp_actual = trim($_POST['mdp_actual']);
						$mdp_new = trim($_POST['mdp_new']);
						$mdp_new_confirm = trim($_POST['mdp_new_confirm']);
						// CRSF
						if(verifier_token_crsf(600, 'Neft-Gaming_'.$page))
						{
							if($mdp_new == $mdp_new_confirm)
							if(strlen($mdp_new) >= 3 AND strlen($mdp_new) <= 20)
							if($mdp_new != $COMPTE->Login)
							if($mdp_new != $COMPTE->Nickname)
							if(md5($mdp_new) != $COMPTE->PasswordHash)
							if(md5($mdp_actual) == $COMPTE->PasswordHash)
							{
								$editmdp_SUCCESS = TRUE;
								$afficherFORMeditmdp = FALSE;
										
								// Update le mdp
								$query = $Sql->prepare("UPDATE accounts SET PasswordHash = ? WHERE Id = ?");
								$query->execute(array(md5($mdp_new), $COMPTE->Id));
								$query->closeCursor();
										
								setcookie('Neft-Gaminglogon');
								setcookie("Neft-Gaminglogon",$COMPTE->Login.'|=|separator|=|'.md5(md5($mdp_new)),time() + (365*24*3600));
								
							}
							else $editmdp_ERROR = 'Votre <strong>mot de passe actuel</strong> est incorrect.';
							else $editmdp_ERROR = 'Veuillez choisir un <strong>nouveau mot de passe</strong> différent de <strong>l\'actuel</strong>.';
							else $editmdp_ERROR = 'Veuillez choisir un <strong>Mot de passe</strong> différent du <strong>Pseudonyme</strong> !';
							else $editmdp_ERROR = 'Veuillez choisir un <strong>Mot de passe</strong> différent du <strong>Nom de compte</strong> !';
							else $editmdp_ERROR = 'Votre <strong>nouveau Mot de passe</strong> est soit trop long soit trop court. (3 à 20 caractères)';
							else $editmdp_ERROR = 'Vous avez mal confirmé votre nouveau <strong>mot de passe</strong>.';
						}
						else $editmdp_ERROR = 'Vous avez mis trop de temps pour soumettre les informations.';
					}
					else $editmdp_ERROR = 'Veuillez remplir tout les champs du formulaire.';
				}
				
				if($editmdp_SUCCESS)
				{
					?>
					<span class="the-success-msg" style="width:95%;margin:auto;"><i class="fa fa-check"></i>Mot de passe changé avec succés.</span>
					<?php
				}
				else
				{
					if($editmdp_ERROR != "")
					{
					?>
					<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $editmdp_ERROR; ?></span>
					<?php
					}
					if($afficherFORMeditmdp)
					{
					$token = generer_token_crsf('Neft-Gaming_'.$page);
					?>
									<form action="index.php?page=mon_compte#tabs-changerpass" method="post" autocomplete="off" style="display:block;width:80%;margin:auto;position:relative;left:-10px;">
										<p>
											<label for="mdp_actual" style="display:block;margin:5px 0;">Mot de passe actuel :</label>
											<input type="text" name="mdp_actual" id="mdp_actual" style="display:block;width:100%;margin:auto;" value="" placeholder="Mot de passe actuel" required />
										</p>
										
										<p>
											<label for="mdp_new" style="display:block;margin:5px 0;">Nouveau mot de passe :</label>
											<input type="text" name="mdp_new" id="mdp_new" style="display:block;width:100%;margin:auto;" value="" placeholder="Nouveau mot de passe" required />
										</p>
										
										<p>
											<label for="mdp_new_confirm" style="display:block;margin:5px 0;">Confirmer le nouveau mot de passe :</label>
											<input type="text" name="mdp_new_confirm" id="mdp_new_confirm" style="display:block;width:100%;margin:auto;" value="" placeholder="Confirmer le nouveau mot de passe" required />
										</p>
										
										<input type="hidden" name="token" value="<?php echo $token; ?>" />
										
										<div class="clear-float do-the-split" style="margin:15px 0;"></div>

										<p style="margin:15px 0;text-align:center;">
											<input type="submit" name="editmdp" class="button big-size" style="cursor:pointer;margin-bottom:5px;background-color: #519623;" id="editmdp" value="Modifier mon mot de passe" />
										</p>
									</form>	
					<?php
					}
				}
				?>
							
						</div>
					</div>
				</div>
			</div>
			
		</div>

	</div>
</div>