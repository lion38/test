<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
header("X-Frame-Options: GOFORIT");
$page_title = "Acheter des Ogrines/Jetons via Paypal"; // Nom de la page dans le content
$icon_title = "icon-basket"; // Icone du caré bleu à gauche du titre de la page | Default : icon-pencil
include('include/breadcrum.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }

?>
<blockquote style="font-style:normal;">
	<p class="no-margin" style="text-align:center;">
		Bienvenue sur l'espace de recharge des Ogrines/Jetons de <b>Neft-Gaming</b> !<br />
		Si vous avez un soucis pour comprendre où utiliser ces points <a href="index.php?page=boutique" style="color:#dc6800;font-weight:bold;">Cliquez ici.</a><br />
		
		<a class="aot-button  aot-button-blue" style="cursor:default;margin:10px auto;"><span style="position:relative;top:1px;">Vous avez actuellement : <b><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></b> Ogrines ou Jetons</span></a>
		<br />
		
		<a class="aot-button  aot-button-blue-alt" href="index.php?page=achat_dedipass" style="margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-phone"></span> Acheter via <strong>Dedipass</strong></span></a>
	</p>
</blockquote>
<em style="text-align:center;display:block;"><strong style="color:#0e9500;">RAPPEL :</strong> Les <strong>Ogrines</strong> et les <strong>Jetons</strong> sont exactement la même monnaie</em>
<br />
<div class="separator"><div class="separator-line"></div></div>

<?php
if(isset($_GET['transaction_valide']))
{
?>
	<div class="msgbox success" style="width:100%;">
		<div class="msgbox-icon icon-na"></div>
		<div class="msgbox-content"><strong>Félicitations</strong>, votre achat s'est déroulé correctement et vos Ogrines seront crédités sous 5 minutes.</div>
	</div>
	<div class="separator" style="margin-bottom:10px;"><div class="separator-line"></div></div>
	<div style="text-align:center;">
	<a class="aot-button  aot-button-black" href="index.php?page=achat" style="margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-left-open"></span> Retour à la page d'achat</span></a>
	</div>
<?php
}
elseif(isset($_GET['transaction_erreur']))
{
?>
	<div class="msgbox error" style="width:100%;">
		<div class="msgbox-icon icon-na"></div>
		<div class="msgbox-content">Nous sommes sincèrement désolé mais vous avez annulé la procédure de paiement.</div>
	</div>
	<div class="separator" style="margin-bottom:10px;"><div class="separator-line"></div></div>
	<div style="text-align:center;">
	<a class="aot-button  aot-button-black" href="index.php?page=achat" style="margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-left-open"></span> Retour à la page d'achat</span></a>
	</div>
<?php
}
else
{
?>

<div class="msgbox info" style="margin:auto;width:500px;float:none;font-family:Verdana;">
	<div class="msgbox-icon icon-na"></div>
	<div class="msgbox-content" style="text-shadow:1px 1px 0 white;">Le prix actuel est de <strong>1 € pour 75 Ogrines/Jetons</strong>.</div>
</div>

<br />
<div class="bg-dark" id="howNeosurf" style="text-align:center;">
	<div id="aot_mailchimp_widget-3" class="clearfix widget-sidebar ui-content aot_mailchimp_widget">
		<div class="widget-header">
			<h3><span class="icon-info" ></span>Veuillez choisir la somme désirée :</h3>
		</div>							

			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="form_pp" class="contact-form clearfix" style="width:80%;margin:auto;">
				<input name="currency_code" type="hidden" value="EUR" />
				<input name="shipping" type="hidden" value="0.00" />
				<input name="tax" type="hidden" value="0.00" />
				<input name="return" type="hidden" value="http://Neft-Gaming.eu/index.php?page=achat_paypal&amp;transaction_valide" />
				<input name="cancel_return" type="hidden" value="http://Neft-Gaming.eu/index.php?page=achat_paypal&amp;transaction_erreur" />
				<input name="cmd" type="hidden" value="_xclick" />
				<input name="business" type="hidden" value="payformygamed@gmail.com" />
				<input name="item_name" id="item_name" type="hidden" value="" />
				<input name="lc" type="hidden" value="FR" />
				<input name="bn" type="hidden" value="PP-BuyNowBF" />
				<input name="custom" type="hidden" value="<?php echo $COMPTE->Id; ?>" />
				<p>
					<select name="amount" id="amount" style="font-family:verdana;">
					  <option value="">Veuillez choisir un produit dans la liste</option> 
					  <option value="1.00">1 € pour <?php echo addTenPercent(1); ?> Ogrines</option> 
					  <option value="2.00">2 € pour <?php echo addTenPercent(2); ?> Ogrines</option> 
					  <option value="3.00">3 € pour <?php echo addTenPercent(3); ?> Ogrines</option> 
					  <option value="4.00">4 € pour <?php echo addTenPercent(4); ?> Ogrines</option> 
					  <option value="5.00">5 € pour <?php echo addTenPercent(5); ?> Ogrines</option> 
					  <option value="10.00">10 € pour <?php echo addTenPercent(10); ?> Ogrines</option> 
					  <option value="15.00">15 € pour <?php echo addTenPercent(15); ?> Ogrines</option> 
					  <option value="20.00">20 € pour <?php echo addTenPercent(20); ?> Ogrines</option> 
					  <option value="30.00">30 € pour <?php echo addTenPercent(30); ?> Ogrines</option> 
					  <option value="50.00">50 € pour <?php echo addTenPercent(50); ?> Ogrines</option> 
					  <option value="60.00">60 € pour <?php echo addTenPercent(60); ?> Ogrines</option> 
					  <option value="75.00">75 € pour <?php echo addTenPercent(75); ?> Ogrines</option> 
					  <option value="100.00">100 € pour <?php echo addTenPercent(100); ?> Ogrines</option> 
					  <option value="150.00">150 € pour <?php echo addTenPercent(150); ?> Ogrines</option> 
					</select>
				</p>
				<p>
					<input class="aot-button aot-button-big" name="submit" id="submit_pp" type="submit" value="Payer via paypal" style="display:block;margin:auto;" />
				</p>
			</form>
		
	</div>
</div>
<script type="text/javascript">
	var canSubmit = false;
	
	jQuery('#amount').on('change', function()
	{
		if(isNaN(this.value) || this.value == "" || this.value == null)
		{
			canSubmit = false;
			jQuery('#item_name').val("");
		}
		else
		{
			var myarr = jQuery(this).find("option:selected").text().split("pour ");
			if(myarr[1] != "")
			{
				jQuery('#item_name').val(myarr[1]);
				canSubmit = true;
			}
			else
			{
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
</script>
<?php
}
?>