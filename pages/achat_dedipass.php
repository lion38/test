<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Acheter des Ogrines/Jetons"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE))
{ 
?>
	<h2><span>Acheter des ogrines</span></h2>
	<div class="content-padding">
		<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i>Veuillez vous <strong>connecter</strong> si vous désirez acheter des <strong>Ogrines</strong> !</span>
	</div>
	<div class="breaking-line"></div>
	<p class="login-passes" style="width:85%;margin:auto;text-align:center;">
		Pour accéder à la page de connexion &nbsp; <a href="index.php?page=login" target="_blank" style="font-weight:bold;" class="button">CLIQUEZ-ICI</a>
	</p>
<?php
}
else
{
?>
<div class="content-padding">

<blockquote class="clearfix doborderneph" style="margin-bottom:0;line-height:20px;background:white;font-style:normal;">
	<p class="no-margin" style="text-align:center;">
		Bienvenue sur l'espace de recharge des Ogrines/Jetons de <b>Neft-Gaming</b> !<br />
		Si vous avez un soucis pour comprendre où utiliser ces points <a href="index.php?page=boutique" style="color:#5b70dd;font-weight:bold;">Cliquez ici.</a><br />
		<a class="button" style="cursor:default;margin:10px auto;background-color: #005590;"><span style="position:relative;top:1px;">Vous avez actuellement : <strong id="ogrineInPageToUpdate" style="font-weight:bold;"><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></strong> Ogrines ou Jetons</span></a>
	</p>
</blockquote>
</div>
<div class="clear-float do-the-split" style="margin-top:20px;margin-bottom:20px;"></div>
<em style="text-align:center;display:block;"><strong style="color:#0e9500;">RAPPEL :</strong> Les <strong>Ogrines</strong> et les <strong>Jetons</strong> sont exactement la même monnaie</em>
<?php
if($CONFIG['boutique_offre_ogrine_double'] == true)
{
?>
	<br />
	<div class="content-padding">
		<a href="index.php?page=achat_dedipass" class="top-alert-message">
			<span><span class="pod-live">Offre en cours</span>Les Ogrines achetées sont doublées à chaque achat ! <em style="color:#ededed;text-shadow:1px 1px 0 #9b1818;font-weight:bold;">Fin de l'offre : <strong>Lundi 23 Mai 2016 à 12h00</strong>.</em></span>
		</a>
	</div>
<?php
}
?>
<div class="breaking-line"></div>

<div class="content-padding" style="background:white;<?php if(!isset($_GET['transaction_paypal_valide']) AND !isset($_GET['transaction_paypal_erreur'])) echo 'padding-top:20px;padding-bottom:20px;'; ?>border:1px solid #e0e0e0;border-width:1px 0;">

<?php
if(isset($_GET['transaction_paypal_valide']))
{
?>
	<span class="the-success-msg" style="font-family:verdana;margin-top:20px;"><i class="fa fa-check"></i><strong>Félicitations</strong>, votre achat via paypal s'est déroulé correctement et vos Ogrines seront crédités sous 5 minutes.</span>

	<div class="clear-float do-the-split" style="margin:0;"></div>

	<div style="text-align:center;">
		<a class="button" href="index.php?page=achat" style="margin:15px auto 20px auto;font-family:verdana;background:#202020;"><span style="position:relative;top:1px;"><span class="icon-left-open"></span> Retour à la page d'achat</span></a>
	</div>
<?php
}
elseif(isset($_GET['transaction_paypal_erreur']))
{
?>
	<span class="the-error-msg" style="font-family:verdana;margin-top:20px;"><i class="fa fa-check"></i>Nous sommes sincèrement désolé mais vous avez annulé la procédure de paiement <strong>Paypal</strong>.</span>

	<div class="clear-float do-the-split" style="margin:0;"></div>

	<div style="text-align:center;">
		<a class="button" href="index.php?page=achat" style="margin:15px auto 20px auto;font-family:verdana;background:#202020;"><span style="position:relative;top:1px;"><span class="icon-left-open"></span> Retour à la page d'achat</span></a>
	</div>
<?php
}
else
{
?>
		

		<span class="the-error-msg" id="alert_mess_error" style="display:none;font-family:verdana;"><i class="fa fa-warning"></i><span class="msgbox-content" style="position:relative;top:2px;"></span></span>
		<span class="the-success-msg" id="alert_mess_success" style="display:none;font-family:verdana;"><i class="fa fa-check"></i><span class="msgbox-content" style="position:relative;top:1px;"></span></span>
		
			<div action="" method="post" class="contact-form clearfix" style="width:90%;margin:auto;">
				<label for="methode_paiement"><h3>Veuillez choisir une méthode de paiement :</h3></label>
				<select name="methode_paiement" id="methode_paiement" style="font-family:verdana;margin-top:3px;">
					<option value="">Veuillez choisir une méthode de paiement parmi la liste</option> 
					<option value="paysafecard">Paysafecard</option>    
					<option value="audiotelsms">Audiotel / SMS</option>  
					<option value="cartebancaire">Carte Bancaire</option>  
					<option value="neosurf">Neosurf</option>    
					<option value="internetplus">Internet Plus Mobile</option>  
					<option value="paypalOff" style="color:red;" disabled="disabled">Paypal (bientôt)</option>  
				</select>
				
				<div id="methode_paiement_callback"></div>
				
				<div id="methode_paiement_paypal" style="display:none;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="form_pp" style="margin:0;">
						<input name="currency_code" type="hidden" value="EUR" />
						<input name="shipping" type="hidden" value="0.00" />
						<input name="tax" type="hidden" value="0.00" />
						<input name="return" type="hidden" value="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=achat_dedipass&transaction_paypal_valide" />
						<input name="cancel_return" type="hidden" value="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=achat_dedipass&transaction_paypal_erreur" />
						<input name="cmd" type="hidden" value="_xclick" />
						<input name="business" type="hidden" value="payformygamed@gmail.com" />
						<input name="item_name" id="item_name" type="hidden" value="" />
						<input name="lc" type="hidden" value="FR" />
						<input name="cpp_header_image" type="hidden" value="http://Neft-Gaming.eu/images/pp_banniere.png" />
						<input name="bn" type="hidden" value="PP-BuyNowBF" />
						<input name="custom" type="hidden" value="<?php echo $COMPTE->Id; ?>" />
						<label for="choix_palier" style="margin-top:20px;display:block;"><h3>Veuillez choisir un palier :</h3></label>
						<?php
						?>
							<select name="amount" id="amount" style="font-family:verdana;margin-top:3px;">
							  <option value="">Veuillez choisir un palier parmi la liste</option> 
							  <?php
							  foreach($CONFIG['paypal_array_ammont_allowed'] as $ammountPayPalSorted)
							  {
								if($CONFIG['boutique_offre_ogrine_double'] == true)
									echo '<option value="'.$ammountPayPalSorted.'.00">Paypal - '.(addTenPercent($ammountPayPalSorted) * 2).' Ogrines ('.$ammountPayPalSorted.'.00 €) au lieu de '.addTenPercent($ammountPayPalSorted).' Ogrines</option>';
								else
									echo '<option value="'.$ammountPayPalSorted.'.00">Paypal - '.addTenPercent($ammountPayPalSorted).' Ogrines ('.$ammountPayPalSorted.'.00 €)</option>';
							  }
							  ?>
							</select>
						<br /><br />
						<p>
							<input class="button big-size" name="submit" id="submit_pp" type="submit" value="Payer via paypal" style="display:block;margin:auto;background-color:#202020;" />
						</p>
					</form>
					
				</div>
				
				<div id="loading_gif" style="display:none;text-align:center;">
					<img src="images/loadinground.gif" style="display:block;width:58px;height:58px;margin:20px auto 10px auto;" alt="Chargement ..." />
					<h3 style="color:#0b66b4;">Chargement en cours, veuillez patienter...</h3>
				</div>
				
			</div>
			
	<script type="text/javascript">
	jQuery(document).ready(function()
	{
		jQuery('#methode_paiement').on('change', function()
		{
			jQuery('#alert_mess_error').hide();
			jQuery('#alert_mess_success').hide();
			jQuery('#methode_paiement_callback').html('');
			jQuery('#methode_paiement_paypal').hide();
			jQuery('#loading_gif').show();
			
			var methode_value = this.value;
			if(methode_value != "")
			{
				if(methode_value == "paypal")
				{
					jQuery('#loading_gif').hide();
					jQuery('#methode_paiement_paypal').show();
				}
				else
				{
					jQuery.ajax({
						type: "POST",
						url: "index.php?page=achat_api",
						data: "etape=chose_methode&methode_paiement="+methode_value,
						success: function(r)
						{
							jQuery('#loading_gif').hide();
							jQuery('#methode_paiement_callback').html(r);
						}
					});
				}
			}
			else
			{
				jQuery('#loading_gif').hide();
				jQuery('#methode_paiement_callback').html('');
				jQuery('#alert_mess_error .msgbox-content').html('Veuillez choisir une méthode de paiement.');
				jQuery('#alert_mess_error').show();
				jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast');
			}
		});
		
		var canSubmit = false;
		
		jQuery('#amount').on('change', function()
		{
			jQuery('#alert_mess_error').hide();
			jQuery('#alert_mess_success').hide();
			
			if(isNaN(this.value) || this.value == "" || this.value == null)
			{
				canSubmit = false;
				jQuery('#item_name').val("");
				jQuery('#alert_mess_error .msgbox-content').html('Veuillez choisir un palier pour paypal.');
				jQuery('#alert_mess_error').show();
				jQuery('#submit_pp').css("background-color","#202020");
			}
			else
			{
				var myarr = jQuery(this).find("option:selected").text().split("Paypal - ");
				if(myarr[1] != "")
				{
					jQuery('#submit_pp').css("background-color","#2e9700");
					var myarr2 = myarr[1].split(" ");
					jQuery('#item_name').val(myarr2[0] + " Ogrines");
					canSubmit = true;
				}
				else
				{
					jQuery('#submit_pp').css("background-color","#202020");
					jQuery('#item_name').val("");
					canSubmit = false;
				}
			}
		});
		
		jQuery('#form_pp').on('submit', function()
		{
			if(canSubmit && jQuery('#item_name').val() != "") return true;
			else return false;
		});

	});
	</script>
<?php
}
?>
</div>
<?php
}
?>