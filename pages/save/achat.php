<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Acheter des Ogrines/Jetons"; // Nom de la page dans le content
$icon_title = "icon-basket"; // Icone du caré bleu à gauche du titre de la page | Default : icon-pencil
include('include/breadcrum.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }
?>
<blockquote style="font-style:normal;">
	<p class="no-margin" style="text-align:center;">
		Bienvenue sur l'espace de recharge des Ogrines/Jetons de <b>Neft-Gaming</b> !<br />
		Si vous avez un soucis pour comprendre où utiliser ces points <a href="index.php?page=boutique" style="color:#dc6800;font-weight:bold;">Cliquez ici.</a><br />
		<a class="aot-button  aot-button-blue" style="cursor:default;margin:10px auto;"><span style="position:relative;top:1px;">Vous avez actuellement : <b><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></b> Ogrines ou Jetons</span></a>
	</p>
</blockquote>
<em style="text-align:center;display:block;"><strong style="color:#0e9500;">RAPPEL :</strong> Les <strong>Ogrines</strong> et les <strong>Jetons</strong> sont exactement la même monnaie</em>
<br />
<div class="separator" style="margin-bottom:15px;"><div class="separator-line"></div></div>

<h3>Veuillez choisir une méthode de paiement :</h3>

<div style="text-align:center;">
	<a href="index.php?page=achat_dedipass"><img src="images/bouton_dedipass.png" alt="Achat via dedipass" style="width:339px;height:159px;margin-right:15px;" /></a>
	<a href="index.php?page=achat_paypal"><img src="images/bouton_paypal.png" alt="Achat via paypal" style="width:339px;height:159px;" /></a>
</div>