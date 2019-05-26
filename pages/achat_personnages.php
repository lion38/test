<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Le marché des personnages"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite


include('include/header.php');
include('include/rightbar.php');

// echo get_contents("http://10.10.1.5:8080/deltokens/2/10&token=7MBWJNC3CF4L6QUE8HCWEMXB8B4XEBRC");
// echo get_contents("http://localhost:13379/&0_Neft-Gaming_php/fakeapiadalete.php?deltokens/2/10&token=7MBWJNC3CF4L6QUE8HCWEMXB8B4XEBRC");

// Voir la fiche d'un perso + possibilite de l'acheter
if(isset($_GET['show_id']) AND !empty($_GET['show_id']) AND is_numeric($_GET['show_id']))
{	
?>
<h2 style="margin-bottom:0;"><span>Le marché des personnages</span></h2>
<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">
<?php
	$error_mess = '';
	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE id = ? LIMIT 1');
	$query->execute(array($_GET['show_id']));
	$row = $query->fetch();
	$query->closeCursor();
	
	
	
	if($row)
	{
		if($row['etat'] == $CONFIG['marcheperso_array_etat']['annule']) $error_mess = 'Désolé, cette vente est annulée.';
		elseif($row['etat'] == $CONFIG['marcheperso_array_etat']['wait_confirmation']) $error_mess = 'Désolé, cette vente n\'est pas encore confirmée.';
		elseif($row['etat'] == $CONFIG['marcheperso_array_etat']['vendu']) $error_mess = 'Désolé, cette vente est terminée.';
		else
		{
			$endBuyAction = false;
			
			// Formulaire achat PHP
			if(isset($_POST['buyAChar'], $_POST['captcha_entered']) AND !empty($_POST['captcha_entered']))
			{
				if($_SESSION['Neft-Gaming_connecter'] AND isset($COMPTE)) 
				{
					if($COMPTE->Id != $row['sellByAccountId'])
					{
						if(strtoupper(trim($_POST['captcha_entered'])) == strtoupper($_SESSION['codesecurite']) AND $_SESSION['codesecurite'] != "")
						{
							if(($COMPTE->Tokens + $COMPTE->NewTokens) >= $row['prix'])
							{
								//$callApiBuyCharRemoveTokens = @get_contents("http://localhost:13379/&0_Neft-Gaming_php/fakeapiadalete.php?deltokens/".$COMPTE->Id."/".$row['prix']."&token=7MBWJNC3CF4L6QUE8HCWEMXB8B4XEBRC");
								$callApiBuyCharRemoveTokens = @get_contents("http://10.10.3.5:8080/deltokens/".$COMPTE->Id."/".$row['prix']."&token=7MBWJNC3CF4L6QUE8HCWEMXB8B4XEBRC");
								
								if(strtolower($callApiBuyCharRemoveTokens) == 'ok')
								{
									$endBuyAction = TRUE;
									$_SESSION['codesecurite'] == "";
									?>
									<div class="info-message" style="background-color: #75a226;">
										<p><strong>Félicitations</strong>, vous venez d'acheter correctement ce personnage <strong><em style="color:#e0ffd6;">(<?php echo $classe[$row['classe']]; ?> <?php echo $row['level']; ?>)</em></strong>.<br />Pour accéder à votre historique d'achat dans le marché <a href="index.php?page=historique_marche_personnage#tabs-historiqueachatvente" style="font-weight:bold;color:#2c6200;">cliquez-ici</a>.</p>
									</div>
									
									<div class="breaking-line" style=""></div>
									
									<h3 style="text-align:center;">Pour utiliser votre nouveau personnage il vous suffit de vous <span style="color:#086ead;">reconnecter</span> en jeu !</h3>
									<script>
										jQuery("#ogrine_in_header").text(jQuery("#ogrine_in_header").text()-(<?php echo $row['prix']; ?>));
										jQuery(document).ready(function()
										{
											jQuery("#ogrineMenuRight").text(jQuery("#ogrineMenuRight").text()-(<?php echo $row['prix']; ?>));
										});
									</script>
									<?php
									
									// Payer le vendeur
									$query = $Sql->prepare('UPDATE accounts SET Tokens = Tokens + ? WHERE Id = ?');
									$query->execute(array($row['prix'], $row['sellByAccountId']));
									$query->closeCursor();
									
									// Change etat marché
									$query = $Sql->prepare("UPDATE marche_des_personnages SET  etat = ?,buyByAccountId = ?, timestampAchat = ?, ipAchatFin = ? WHERE id = ?");
									$query->execute(array($CONFIG['marcheperso_array_etat']['vendu'], $COMPTE->Id, time(), get_real_ip(), $row['id']));
									$query->closeCursor();
									
									// Donne le perso a l'acheteur
									$query = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.worlds_characters SET AccountId = ? WHERE CharacterId = ? AND AccountId = ? LIMIT 1');
									$query->execute(array($COMPTE->Id, $row['id_perso'], $CONFIG['marcheperso_idaccount_stackpersotosell']));
									$query->closeCursor();
								}
								else
								{
									if($callApiBuyCharRemoveTokens == 'Ko - Account not connected') $error_mess  = 'Erreur, vous devez vous <strong>connecter</strong> sur un <strong>personnage</strong> de votre compte (<strong>'.htmlspecialchars($COMPTE->Login).'</strong>) sur le client Dofus !';
									elseif($callApiBuyCharRemoveTokens == 'Ko - Character doesn\'t have enough tokens' OR $callApiBuyCharRemoveTokens == 'Ko - Character doesn\'t have any tokens') $error_mess = 'Vous n\'avez pas assez d\'<strong>Ogrines</strong> pour acheter ce personnage. <a href="index.php?page=achat" style="font-weight:bold;color:#a80606;">Cliquez-ici pour en acheter</a>';
									else $error_mess = 'Erreur <strong>API</strong> veuillez réessayer dans un instant... '.$callApiBuyCharRemoveTokens;
								}
							}
							else $error_mess = 'Vous n\'avez pas assez d\'<strong>Ogrines</strong> pour acheter ce personnage. <a href="index.php?page=achat" style="font-weight:bold;color:#a80606;">Cliquez-ici pour en acheter</a>';
						}
						else $error_mess  = 'Erreur le captcha est incorrect.';
					}
					else $error_mess  = 'Vous êtes le vendeur du personnage il est impossible d\'acheter votre personnage.';
				}
				else $error_mess  = 'Veuillez vous connecter pour poursuivre l\'achat de ce personnage.';
			}
			
		if(!$endBuyAction)
		{
			if($_SESSION['Neft-Gaming_connecter'] AND isset($COMPTE))
			{
				if(in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']))
				{
					?>
						<a class="button" style="position:absolute;top:15px;right:15px;font-weight:bold;padding-left:5px;background-color:#a21616;" href="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=vendre_personnages&amp;confirm_hash=<?php echo $row['hash']; ?>&amp;confirm_id=<?php echo md5(md5($row['id_perso']) . 'Ae9d6fsd41f'); ?>&amp;admin_refresh_fiche"><span class="icon-cog" style="margin-left:0;"></span> ADMIN: Refresh la fiche du personnage</a>
					<?php
				}
			}
			
			$cache_to_read = $CONFIG['cache_folder'] .'marche_des_personnages/'.$row['id_perso'].'.cache';
			if(file_exists($cache_to_read))
			{
				$preview_of_this_perso = file_get_contents($cache_to_read);
				// echo $preview_of_this_perso;
				$API_RETURN_ARRAY_OF_A_PERSO = unserialize($preview_of_this_perso);
				// $b64_image_mini = $row['previewMini'];
				// $b64_image_big = $row['previewBig'];
				
				if($_SESSION['Neft-Gaming_connecter'] AND isset($COMPTE))
				{
				?>
				<div class="split" style="text-align:center;">
					<div class="size6">
						<h4 style="text-indent:15px;color:#0c0c0c;">Le prix de ce personnage est de <strong style="color:#2e7acf;font-size:22px;position:relative;top:-7px;"><?php echo $row['prix']; ?></strong> Ogrines.</h4>
						<h4 style="text-indent:15px;color:#0c0c0c;">Vous avez actuellement <strong style="color:#bd0707;font-size:22px;position:relative;top:-7px;"><?php echo ($COMPTE->Tokens + $COMPTE->NewTokens); ?></strong> Ogrines.</h4>
					</div>
					<div class="size6">
						<a class="button big-size" href="#Gobuyperso_label">Acheter ce personnage</a>
					</div>
				</div>
				<?php
				}
				
				include('include/view_marche_des_personnages.php');
				
				if($_SESSION['Neft-Gaming_connecter'] AND isset($COMPTE))
				{
				?>
					<h2 id="Gobuyperso_label" style="padding-top:0px;clear:both;margin-bottom:5px;margin-top:0;">ACHETER CE PERSONNAGE :</h2>
					
					<h4 style="text-indent:15px;color:#0c0c0c;">Le prix de ce personnage est de <strong style="color:#2e7acf;font-size:22px;position:relative;top:-7px;"><?php echo $row['prix']; ?></strong> Ogrines.</h4>
					<h4 style="text-indent:15px;color:#0c0c0c;">Vous avez actuellement <strong style="color:#bd0707;font-size:22px;position:relative;top:-7px;"><?php echo ($COMPTE->Tokens + $COMPTE->NewTokens); ?></strong> Ogrines.</h4>
				<?php
					// Si c'est le vendeur qui va sur cette page il peut annuler mais pas acheter
					if($COMPTE->Id == $row['sellByAccountId'])
					{
					?>
					<div class="clear-float do-the-split" style="margin-top:0px;margin-bottom:10px;display:block;"></div>
					
					<div class="info-message">
						<p>Vous êtes le vendeur de ce personnage, si vous voulez gérer cette vente <a href="index.php?page=historique_marche_personnage" style="font-weight:bold;color:#a4daff;">cliquez-ici</a> !<br /> Sinon patientez le temps qu'un potentiel acheteur visite votre annonce.</p>
					</div>
					<?php
					}
					// Si c'est un acheteur potentiel et qu'il a les ogrines on lui affiche le formulaire d'achat
					// FORMULAIRE D'ACHAT
					elseif(($COMPTE->Tokens + $COMPTE->NewTokens) >= $row['prix'])
					{
					?>
						<h4 style="text-indent:15px;color:#0c0c0c;">Votre montant d'Ogrines après achat : <strong style="color:#208513;font-size:22px;position:relative;top:-7px;"><?php echo ($COMPTE->Tokens + $COMPTE->NewTokens) - $row['prix']; ?></strong></h4>
						
						<div class="clear-float do-the-split" style="margin-top:0px;margin-bottom:10px;display:block;"></div>

						<div class="bg-dark" style="text-align:center;margin-bottom:15px;padding-bottom:10px;">
								<h2 style="padding-top:5px;color:#ededed;"><span class="icon-info" ></span>Informations avant l'achat du personnage :</h2>
								<div class="clear-float do-the-split" style="width:50%;margin:auto;opacity:0.5;margin-top:0px;margin-bottom:10px;display:block;"></div>

								<p style="color:white;">
									Veuillez être <strong>connecté</strong> sur un <strong>personnage</strong> de votre compte Dofus (<strong><?php echo htmlspecialchars($COMPTE->Login); ?></strong>) pour la finalisation de votre achat.
								</p>
						</div>
						
						
						
						<form method="post" action="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>#Gobuyperso" style="background:white;padding-bottom:15px;border-bottom:3px solid #e5e5e5;">
						<div class="clear-float do-the-split" style="margin-top:0px;margin-bottom:10px;display:block;"></div>
						
						<div style="text-align:center;margin:auto;width:410px;overflow:hidden;">
							<label for="captcha_entered" class="left">Vérification anti-robot : </label>
							<div style="clear:left;">
								<img class="left" src="captcha.php" />
								<div class="span4">
									<input name="captcha_entered" id="captcha_entered" type="text" maxlength="6" style="position:relative;top:4px;" placeholder="Captcha à remplir" required />
								</div>
							</div>
						</div>
							<input  class="button clearfix" style="margin:10px auto 0 auto;width:350px;display:block;padding:14px;" name="buyAChar" type="submit" value="Acheter ce personnage contre <?php echo $row['prix']; ?> Ogrines" />
						</form>
						<br />
					<?php
					}
					// SINON Acheteur potentiel mais manque d'ogrines / HESS
					else
					{
						?>
							<h4 style="text-indent:15px;color:#0c0c0c;">Il vous manque <strong style="color:#ae0000;font-size:22px;position:relative;top:-7px;"><?php echo abs(($COMPTE->Tokens + $COMPTE->NewTokens) - $row['prix']); ?></strong> Ogrines.</h4>
						<?php
						$error_mess = 'Vous n\'avez pas assez d\'<strong style="position:relative;top:2px;">Ogrines</strong> pour acheter ce personnage. <a href="index.php?page=achat" style="font-weight:bold;color:#ffd7d7;">Cliquez-ici pour en acheter</a>';
					}
				}
				else $error_mess = 'Vous devez être connecté pour acheter un personnage.';
			}
			else $error_mess = 'Désolé, la fiche de ce personnage est introuvable !';
		}
		}
	}
	else $error_mess = 'Aucune vente trouvée.';
	
	if(!empty($error_mess))
	{
	?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_mess; ?></span>
	<?php
	}
	
	?>
	</div>
	<?php
}
else
{
	$nb_de_ligne_tableau_a_use = $CONFIG['marcheperso_classement_nbdeligne_partableau'];
	?>
	<h2><span>Le marché des personnages</span></h2>
	<div class="content-padding">
	
	
		<table class="bordered" id="demoTable" style="width:100%;border:1px solid #b4b4b4;">
			<thead>
				<tr style="text-shadow:1px 1px 0 white;">
					<th sort="" style="font-weight:normal;padding-bottom:5px;">Nom du personnage</th>
					<th sort="" style="text-align:center;width:10%;font-weight:normal;padding-bottom:5px;">Niveau</th>
					<th sort="" style="text-align:center;width:15%;font-weight:normal;padding-bottom:5px;">Classe</th>
					<th sort="" style="text-align:center;width:20%;font-weight:normal;padding-bottom:5px;">Prix (Ogrines)</th>
					<th style="text-align:center;width:20%;font-weight:normal;padding-bottom:5px;">Acheter</th>
				</tr>
			</thead>
			<tbody>
	<?php
		$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? ORDER BY timetampStartVente DESC');
		$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente']));
		$nb_de_ligne_bdd = 0;
		while($row = $query->fetch())
		{
		$nb_de_ligne_bdd++;
		?>
			<tr style="background:white;">
				<td style="line-height:33px;font-weight:bold;padding-top:5px;" class="new_a_link"><a href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>" title="Mis en vente le :  <?php echo date('d/m/Y H\hi', $row['timetampStartVente']); ?>"><img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;float:left;" />&nbsp; &nbsp;<?php echo htmlentities($row['nomPerso']); ?></a></td>
				<td style="line-height:35px;text-align:center;"><strong style="position:relative;top:6px;"><?php echo $row['level']; ?><span style="display:none;">0</span></strong></td>
				<td style="line-height:33px;text-align:center;font-family:verdana;"><span style="position:relative;top:6px;"><?php echo $classe[$row['classe']]; ?></span></td>
				<td style="line-height:33px;text-align:center;font-size:16px;"><strong style="position:relative;top:6px;"><?php echo $row['prix']; ?><span style="display:none;">0</span></strong></td>
				<td style="line-height:33px;text-align:center;"><a class="button" style="padding:0px 8px;background-color: #1c7eb1;position:relative;top:6px;" href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>" title="Mis en vente le :  <?php echo date('d/m/Y H\hi', $row['timetampStartVente']); ?>"><span style="position:relative;top:1px;">VOIR PLUS</span></a></td>
			</tr>
		<?php
		}
		$query->closeCursor();
		if($nb_de_ligne_tableau_a_use > $nb_de_ligne_bdd)
		{
			if($nb_de_ligne_bdd == 0) $nb_de_ligne_tableau_a_use = 1;
			else $nb_de_ligne_tableau_a_use = $nb_de_ligne_bdd;
		}
		if($nb_de_ligne_bdd == 0)
		{
		?>
		<tr>
			<td colspan="5" style="text-align:center;padding:5px;font-size:14px;color:red;">Aucun personnage dans le marché actuellement.</td>
		</tr>
		<?php
		}
	?>
			</tbody>
			<tfoot class="nav">
				<tr>
					<td colspan="5">
						<div class="pagination"></div>
						<div class="paginationTitle">Page</div>
						<div class="selectPerPage"></div>
						<div class="status"></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<script>
			jQuery(function () { 
				jQuery('#demoTable').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
			});
		</script>
		
	</div>
<?php
}
?>
