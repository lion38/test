<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Voter pour Neft-Gaming"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

// Si deconnecter
if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE))
{
	?>
	<h2><span>Erreur</span></h2>
	<div class="content-padding">
		<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i>Veuillez vous <strong>connecter</strong> 1 fois si vous désirez voter pour <strong>Neft-Gaming</strong> et recevoir vos <strong>Ogrines/Jetons</strong> !</span>
	</div>
	<div class="breaking-line"></div>
	<p class="login-passes" style="width:85%;margin:auto;text-align:center;">
		Vous pouvez tout de même voter pour Neft-Gaming en cliquant &nbsp; <a href="<?php echo $CONFIG['vote']; ?>" target="_blank" style="font-weight:bold;" class="button">ICI</a> &nbsp; !
	</p>
	<?php
}
// Sinon bien connecté !
else
{
	$_SESSION['vote_go'] = -1337;
	$_SESSION['out_de_rpg'] = -1337;
	
	$messToShow = "";
	$typeButtonVote = '';
	$cssButtonVote = '';
	
	$realIP = get_real_ip();
	
	if(!empty($COMPTE->LastHardwareId))
	{
		$query = $Sql->prepare('SELECT COUNT(*) FROM accounts WHERE LastVote > ? and (last_ip_web = ? OR LastConnectedIp = ? OR LastHardwareId = ?)');
		$query->execute(array(date("Y-m-d H:i:s", (time() - (60*60*3))), $realIP, $realIP, $COMPTE->LastHardwareId));
	}
	else
	{
		$query = $Sql->prepare('SELECT COUNT(*) FROM accounts WHERE LastVote > ? and (last_ip_web = ? OR LastConnectedIp = ?)');
		$query->execute(array(date("Y-m-d H:i:s", (time() - (60*60*3))), $realIP, $realIP));
	}
	$row = $query->fetch();
	$nbvoteIP = $row['COUNT(*)'];
	$query->closeCursor();
	
	//echo $nbvoteIP;
			
	$ecartseconde = abs(time() - strtotime($COMPTE->LastVote));
	$ecartminute = $ecartseconde / 60;

	// Si le compte connecté à voter il y a + de 3h donc AUTORISE
	if ($ecartminute > 180)
	{
		// Allowed car aucun compte a son ip a voter
		if($nbvoteIP == 0)
		{
			$typeButtonVote = 'onClick="vote()"';
			$cssButtonVote = 'blue';
		}
		// Sinon il y as deja un vote avec l'ip du connecté sur un autre compte < 3h
		else
		{
			if(!empty($COMPTE->LastHardwareId))
			{
				$query = $Sql->prepare('SELECT * FROM accounts WHERE LastVote > ? and (last_ip_web = ? OR LastConnectedIp = ? OR LastHardwareId = ?) and Id != ? ORDER BY ABS(LastVote) DESC LIMIT 1');
				$query->execute(array(date("Y-m-d H:i:s", (time() - (60*60*3))), $realIP, $realIP, $COMPTE->LastHardwareId, $COMPTE->Id));
			}
			else
			{
				$query = $Sql->prepare('SELECT * FROM accounts WHERE LastVote > ? and (last_ip_web = ? OR LastConnectedIp = ?) and Id != ? ORDER BY ABS(LastVote) DESC LIMIT 1');
				$query->execute(array(date("Y-m-d H:i:s", (time() - (60*60*3))), $realIP, $realIP, $COMPTE->Id));
			}
			$row = $query->fetch();
			$ecartseconde = abs(time() - strtotime($row['LastVote']));
			$query->closeCursor();
			
			$messToShow = 'MULTIVOTEIP|'.((60*60*3) - $ecartseconde).'|'.$row['Login'];
		}
	}
	// Sinon le compte à déjà voter
	else
	{
		$restant = round(180 - $ecartminute, 0);
		$messToShow = 'NORMALWAIT|'.((60*60*3) - $ecartseconde);
	}
	?>
<h2 style="margin-bottom:0;"><span>Voter pour Neft-Gaming</span></h2>
<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;text-align:center;text-shadow:1px 1px 0 white;">
		<?php
		if($messToShow != "")
		{
			$seconde_restante = 0; 
		
			$exploded_mess = explode('|', $messToShow);
			if($exploded_mess[0] == 'NORMALWAIT')
			{
				$seconde_restante = $exploded_mess[1];
			}
			elseif($exploded_mess[0] == 'MULTIVOTEIP')
			{
				$seconde_restante = $exploded_mess[1];
				$name_multi = $exploded_mess[2];
				?>
					<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;text-shadow:0 0 0;"><i class="fa fa-warning"></i>Désolé vous avez déjà voté via le compte <b><?php echo $name_multi; ?></b> il y a <strong>moins de trois heures</strong>.</span>
					<div class="clear-float do-the-split"></div>
				<?php
			}
			$seconde_restante++; 
			?>
			<link rel="stylesheet" href="<?php echo $CONFIG['URL_SITE']; ?>wp-content/themes/iconiac/css/TimeCircles.css" />
			<script src="<?php echo $CONFIG['URL_SITE']; ?>wp-content/themes/iconiac/js/TimeCircles.js"></script>
			
				Vous pouvez de nouveau voter pour <strong>Neft-Gaming</strong> avec votre compte dans :<br />
				<div id="CountDownTimer" data-timer="<?php echo $seconde_restante+1; ?>" style="width:550px;margin:0 auto;"></div>
				
				<div class="breaking-line"></div>
				<p class="login-passes" style="width:85%;margin:auto;text-align:center;">
					La page se rechargera automatiquement une fois le délai atteint afin de voter.
				</p>
				
				<script>
			
					<?php
					$init = $seconde_restante + 1;
					$hours = floor($init / 3600);
					$minutes = floor(($init / 60) % 60);
					$seconds = $init % 60;
					?>
					var title_heures = <?php echo $hours; ?>;
					var title_minutes = <?php echo $minutes; ?>;
					var title_secondes = <?php echo $seconds; ?>;
									
					jQuery("#CountDownTimer").TimeCircles({ time: { Jours: { show: false }, Heures: { color: "#c0c8cf" }, Minutes: { color: "#c0c8cf" }, Secondes: { color: "#c0c8cf" } }});
									
					jQuery("#CountDownTimer").TimeCircles().addListener(function(unit,value,total)
					{ 
						//alert(unit + " : " + value);
						if(unit == "Heures") title_heures = value;
						if(unit == "Minutes") title_minutes = value;
						if(unit == "Secondes") title_secondes = value;
										
						jQuery(document).prop('title', 'Neft-Gaming | ' + title_heures + 'h ' + title_minutes + 'm '+ title_secondes + 's');
										
						if(total == -1)
						{
							document.location.href='<?php echo $CONFIG['URL_SITE']; ?>index.php?page=voter';
						}
					});
				</script> 
			<?php
		}
		else
		{
		?>
			<div id="voteWait" style="margin:0;padding:0;font-family:Raleway;">

				<p>Bienvenue sur la page de vote de <strong>Neft-Gaming</strong>, qui vous permet de gagnez <strong><?php echo $CONFIG['nbr_vote'];?></strong> Ogrines par vote</p>
				<a href="https://www.rpg-paradize.com/?page=vote&vote=103125" style="color:green;font-size:1.1em;margin-top:3px;display:block;" target="_blank"><strong>TUTO :</strong> Vous ne savez pas comment trouver la valeur OUT ? <strong>Cliquez-ici</strong> !</a>
				
				<div class="info-message" style="background-color: #a24026;width:90%;margin:10px auto;font-family:Verdana;">
					<p>Il est <strong>interdit de voter plusieurs fois avec différents comptes en moins de trois heures</strong>,vous n'êtes limités qu'à un compte par joueur <strong>TOUTES LES 3 HEURES</strong> lors de vos votes et <strong>en cas de triche</strong> tous les comptes liés à l'abus de vote seront <strong>supprimés</strong> sans sommation.</p>
				</div>

		<div class="breaking-line"></div>

		<?php
		if(empty($COMPTE->LastHardwareId))
		{
		?>
			
		<span class="the-error-msg" style="width:95%;margin:10px auto 15px auto;text-shadow:0 0 0;"><i class="fa fa-warning" style="position:relative;top:-2px;"></i>Vous devez au préalable vous être <strong>connecté au moins une fois en jeu</strong> avec votre compte afin de pouvoir voter.</span>
		<?php
		}
		else
		{
		?>
					
				<!--<div style="background:#fcfcfc;padding:10px 5px;border:1px solid #d8d8d8;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;">-->
				<div style="background:#fcfcfc;padding:10px 5px;border:1px solid #d8d8d8;">
						<b>1.</b> Cliquez sur le bouton ci-dessous pour être redirigé sur la page de vote. <br /> <b>Veillez à bien remplir le Captcha, puis cliquez sur voter.</b><br /><br />
						<b>2.</b> Vous devez ensuite revenir sur cette page pour la suite des instructions.
						<br />
						
						<input type="submit" id="buttonVote" value="Voter sur Rpg-paradize" class="button <?php echo $cssButtonVote; ?>" <?php echo $typeButtonVote; ?> />

						<div id="etape2" style="display:none;margin-top:5px;">
							<b>3.</b> <strong style="color:red;">En attente de votre vote !</strong><br /><em style="">(Revenez sur cette page après avoir voté)</em>
						</div>
						
						<div id="etape3" style="display:none;margin-top:10px;">
							<b>3.</b> Récupérez la valeur OUT de <b>Neft-Gaming</b> et indiquez la ci-dessous, si vous n'avez pas la valeur,<br /> c'est que votre vote n'était pas correct et vous devrez recommencer du début.
							<br />
							<input name="nbOut" id="nbOut" placeholder="Valeur OUT de Neft-Gaming" required style="width:50%;margin:15px auto;" type="text" /><br />
							<input type="submit" value="Valider mon vote" class="button" style="background-color:#519623;" onClick="valideteOut()" /><br />
										
							<span class="the-error-msg" id="error_out" style="display:none;width:95%;margin:10px auto 15px auto;text-shadow:0 0 0;"><i class="fa fa-warning" style="position:relative;top:-2px;"></i><span class="msgbox-content" style="display:inline;"></span></span>

							
						</div>
								
						<div id="etape3_down" style="display:none;margin-top:10px;">
								<b>3.</b> Le site <b>RPG-PARADIZE.com</b> semble avoir un soucis d'accès, ce vote ne nécessite donc pas<br /> d'entrer le nombre de OUT de <b>Neft-Gaming</b> pour le valider !
								<br />
								<input type="submit" value="Valider mon vote sans OUT" class="button" style="background-color: #B1221C;" onClick="valideteOutDown()" /><br />

								<span class="the-error-msg" id="error_out_down" style="display:none;width:95%;margin:10px auto 15px auto;text-shadow:0 0 0;"><i class="fa fa-warning" style="position:relative;top:-2px;"></i><span class="msgbox-content" style="display:inline;"></span></span>

								
						</div>
						
						<div id="loading_gif" style="display:none;">
							<img src="images/loadinground.gif" style="display:block;width:58px;height:58px;margin:20px auto 10px auto;" alt="Chargement ..." />
							<h3 style="color:#0b66b4;">Chargement en cours, veuillez patienter...</h3>
						</div>
						
					</div>
			<?php
			}
			?>
				</div>
				<div id="voteWin" style="display:none;">
							<div class="info-message" style="background-color: #75a226;">
								<strong>Félicitations,</strong><br />
								Votre vote a bien été <b>validé</b>, vous venez de recevoir <b><?php echo $CONFIG['nbr_vote']; ?> Ogrines</b> sur votre compte !
							</div>
							<div class="breaking-line"></div>
							<p class="login-passes" style="width:85%;margin:auto;text-align:center;">Redirection de la page dans 5 secondes...</p>
				</div>
				
<script type="text/javascript">
					function vote()
					{
							jQuery('#buttonVote').css( "background-color", "#434343" );
							jQuery('#buttonVote').attr("disabled", "disabled");
							jQuery('#etape2').fadeIn("slow");
							jQuery('#loading_gif').fadeIn("fast");
							
							var loginWindow = window.open("http://forum.Neft-Gaming.com");
							
							jQuery.get("index.php?page=vote_api", { go: "go"},
							   function(r)
							   {
									jQuery('#loading_gif').fadeOut("slow")
									//alert(r);
									if(r == "OK")
									{

										setTimeout(function(){
											jQuery('#etape2').fadeOut("slow", function() {
												jQuery('#etape3').fadeIn("slow", function() {
												});
											});
										}, 1000);
										
									}
									//else if(r == "RPG_DOWN")
									else
									{
										//alert('Veuillez screen cette erreur et la poster sur le forum s\'il vous plait !\r\n\r\nOut : ' + r + '\r\nOutDump : ' + JSON.stringify(r));
										setTimeout(function(){
											jQuery('#etape2').fadeOut("slow", function() {
												jQuery('#etape3_down').fadeIn("slow", function() {

												});
											});
										}, 1);
										
									}
							   }
							 );
					}

					function valideteOut()
					{
						
							jQuery('#loading_gif').fadeIn("fast");
							jQuery.get("index.php?page=vote_api", { out: jQuery('#nbOut').val()},
							   function(r)
							   {
									jQuery('#loading_gif').fadeOut("fast");
									// alert(r);
									if(r == "VOTE_OK")
									{
										jQuery('#voteWait').fadeOut("slow");
										jQuery('#voteWin').fadeIn("slow");
										jQuery("#ogrine_in_header").text(jQuery("#ogrine_in_header").text()-(-<?php echo $CONFIG['nbr_vote']; ?>));
										jQuery(document).ready(function()
										{
											jQuery("#ogrineMenuRight").text(jQuery("#ogrineMenuRight").text()-(-<?php echo $CONFIG['nbr_vote']; ?>));
										});
										setTimeout(function(){ document.location.href='<?php echo $CONFIG['URL_SITE']; ?>index.php?page=voter'; }, 5000);
									}
									else if(r == "ERROR_OUT")
									{
										// jQuery('#error_out .msgbox-content').html("Le nombre de <b>out</b> entré est incorrect.");
										jQuery('#error_out .msgbox-content').html("Le nombre de <b>out</b> entré est incorrect.<br /><a href=\"http://forum.Neft-Gaming.eu/index.php?/topic/379-comment-voter/\" style=\"color:#ffcece;font-family:verdana;font-size:110%;\" target=\"_blank\"><strong>TUTO :</strong> Vous ne savez pas comment trouver la valeur OUT ? <strong>Cliquez-ici</strong> !</a>");
										jQuery('#error_out').fadeIn("slow");
									}
									else
									{
										jQuery('#error_out .msgbox-content').html("Vous avez mis trop de temps.");
										jQuery('#error_out').fadeIn("slow");
									}
							   }
							 );
					}
					
					function valideteOutDown()
					{
							jQuery('#loading_gif').fadeIn("fast");
							jQuery.get("index.php?page=vote_api", { out: "0"},
							   function(r)
							   {
									jQuery('#loading_gif').fadeOut("fast");
									if(r == "VOTE_OK")
									{
										jQuery('#voteWait').fadeOut("slow");
										jQuery('#voteWin').fadeIn("slow");
										jQuery("#ogrine_in_header").text(jQuery("#ogrine_in_header").text()-(-<?php echo $CONFIG['nbr_vote']; ?>));
										jQuery(document).ready(function()
										{
											jQuery("#ogrineMenuRight").text(jQuery("#ogrineMenuRight").text()-(-<?php echo $CONFIG['nbr_vote']; ?>));
										});
										setTimeout(function(){ document.location.href='<?php echo $CONFIG['URL_SITE']; ?>index.php?page=voter'; }, 5000);
									}
									else
									{
										jQuery('#error_out_down .msgbox-content').html("Erreur..");
										jQuery('#error_out_down').fadeIn("slow");
									}
							   }
							 );
					}

</script>
						<?php
						}
						?>
	</div>
<?php
}
?>