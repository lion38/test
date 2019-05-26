<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
header("X-Frame-Options: GOFORIT");
$page_title = "Acheter des Ogrines/Jetons via Dedipass"; // Nom de la page dans le content
$icon_title = "icon-basket"; // Icone du caré bleu à gauche du titre de la page | Default : icon-pencil
include('include/breadcrum.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }

	$error_mess_toshow = '';
	$success_mess_toshow = '';
	
	if(isset($_POST['key'], $_POST['code'], $_POST['rate']) AND !empty($_POST['key']) AND !empty($_POST['code']))
	{
	/*
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	*/
		$key  = $_POST['key'];
		$code = $_POST['code'];
		$rate = $_POST['rate'];
		
		if($key == $CONFIG['dedipass_key'])
		{
			$dedipass = file_get_contents('http://api.dedipass.com/v1/pay/?key='.$key.'&rate='.$rate.'&code='.$code);
			$dedipass = json_decode($dedipass);
		/*
		echo '<pre>';
		print_r($dedipass);
		echo '</pre>';
		*/
			if($dedipass->status == 'success')
			{
				// Le code est valide
				$code = $dedipass->code;
				$rates = (isset($dedipass->rate) AND !empty($dedipass->rate)) ? $dedipass->rate : $dedipass->identifier;
				$virtual_currency = $dedipass->virtual_currency;
				
				$rates = strtolower($rates);
				$rates_explode = explode('-', $rates);

				if (strpos($rates, 'sms') !== false)
				{
					$stat_type = 'sms';
					$stat_pays = $rates_explode[1];
					$stat_paliers = $rates_explode[3];
				}
				elseif (strpos($rates, 'audiotel') !== false)
				{
					$stat_type = 'audiotel';
					$stat_pays = $rates_explode[1];
					$stat_paliers = $rates_explode[3];
				}
				elseif (strpos($rates, 'neosurf') !== false)
				{
					$stat_type = 'neosurf';
					$stat_pays = 'world';
					$stat_paliers = $rates_explode[1];
				}
				elseif (strpos($rates, 'creditcard') !== false)
				{
					$stat_type = 'cb';
					$stat_pays = 'world';
					$stat_paliers = $rates_explode[2];
				}
				elseif (strpos($rates, 'paypal') !== false)
				{
					$stat_type = 'paypal';
					$stat_pays = 'world';
					$stat_paliers = $rates_explode[1];
				}
				else
				{
					$stat_type = 'unknow';
					$stat_pays = 'unknow';
					$stat_paliers = $rates;
				}
				
				$query = $Sql->prepare("UPDATE accounts SET Tokens = Tokens + ? WHERE Id = ?");
				$query->execute(array($virtual_currency, $COMPTE->Id));
				$query->closeCursor();
				$tokenç_before = $COMPTE->Tokens;
				$tokensEntier = $tokenç_before + $virtual_currency;
				echo '<script>jQuery("#ogrine_in_header").text("'.$tokensEntier.'");</script>';
				
				//$this->site_shop_points_purchase->add($account->account, $virtual_currency, $_POST['code'], $stat_pays, $stat_paliers, "0", $stat_type, date('d/m/y H:i'));
				
				$date = date("Y-m-d H:i:s");
				$query = $Sql->prepare("INSERT INTO log_site_achat_points(accountId, ogrine_acheter, ogrine_avant, code, pays, palier, type, date, timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->execute(array($COMPTE->Id, $virtual_currency, $tokenç_before, $code, $stat_pays, $stat_paliers, $stat_type, $date, time()));
				$query->closeCursor();
				
				$success_mess_toshow = '<strong>Félicitations : </strong>Le code <strong>'.htmlspecialchars($code).'</strong> est valide, <strong>' . $virtual_currency.'</strong> Ogrines/Jetons viennent de vous être ajoutés.<br />Si vous êtes déjà connecter, il faut vous <strong>déconnecter/reconnecter</strong> pour mettre à jours vos points !';
			}
			else
			{
				// Le code est invalide
				$code = @$dedipass->code;
				if(isset($dedipass->id) AND $dedipass->id == 'rate::empty') $error_mess_toshow = 'Veuillez choisir un pallier avant de valider votre code !';
				else $error_mess_toshow = 'Le code <strong>'.htmlspecialchars(htmlentities($code)).'</strong> est invalide.';
				
			}
		}
		else $error_mess_toshow = 'Erreur de key dedipass.';
	}
?>
<blockquote style="font-style:normal;">
	<p class="no-margin" style="text-align:center;">
		Bienvenue sur l'espace de recharge des Ogrines/Jetons de <b>Neft-Gaming</b> !<br />
		Si vous avez un soucis pour comprendre où utiliser ces points <a href="index.php?page=boutique" style="color:#dc6800;font-weight:bold;">Cliquez ici.</a><br />
		Ci-dessous, entrez votre code fraîchement acheté et gagnez vos Ogrines !<br />
		
		<a class="aot-button  aot-button-blue" style="cursor:default;margin:10px auto;"><span style="position:relative;top:1px;">Vous avez actuellement : <b><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></b> Ogrines ou Jetons</span></a>
		<br />
		Si vous ne connaissez pas, ou vous posez des questions sur Néosurf , <a href="#howNeosurf"><strong>Cliquez ici</strong></a> !
	</p>
</blockquote>
<em style="text-align:center;display:block;"><strong style="color:#0e9500;">RAPPEL :</strong> Les <strong>Ogrines</strong> et les <strong>Jetons</strong> sont exactement la même monnaie</em>
<br />
<div class="separator"><div class="separator-line"></div></div>

	<?php
	if(isset($error_mess_toshow) AND !empty($error_mess_toshow))
	{
	?>
		<div class="msgbox error" style="width:100%;">
			<div class="msgbox-icon icon-na"></div>
			<div class="msgbox-content"><?php echo $error_mess_toshow; ?></div>
		</div>
	<?php
	}
	if(isset($success_mess_toshow) AND !empty($success_mess_toshow))
	{
	?>
		<div class="msgbox success" style="width:100%;">
			<div class="msgbox-icon icon-na"></div>
			<div class="msgbox-content"><?php echo $success_mess_toshow; ?></div>
		</div>
	<?php
	}
	?>

	<script src="http://api.dedipass.com/v1/pay.js"></script>
	<div data-dedipass="<?php echo $CONFIG['dedipass_key']; ?>"></div>
	<script> var dedipassInstance = new dedipass(); dedipassInstance.autoinit(); </script>
	
<div class="separator"><div class="separator-line"></div></div>

	<div class="bg-dark" id="howNeosurf" style="text-align:center;">
		<div id="aot_mailchimp_widget-3" class="clearfix widget-sidebar ui-content aot_mailchimp_widget">
			<div class="widget-header">
				<h3><span class="icon-info" ></span>Qu'est ce que Neosurf ?</h3>
			</div>
									
				Neosurf est une carte prépayée en vente chez votre buraliste qui vous permet d'acheter sur Internet<br /> de manière simple, sécurisée et anonyme.			

			<div class="widget-header">
				<h3><span class="icon-location" ></span>Ou acheter des codes Neosurf ?</h3>
			</div>
			
				<span style="">Pour trouvez un point de vente proche de chez vous veuillez vous référé à &nbsp; <a href="http://www.neosurf.info/public/fr/presentation.php?pageID=3" target="_blank" style="font-weight:bold;" class="aot-button aot-button-small aot-button-blue"><span class="icon-globe" ></span> Cette CARTE</a></span>
				<br />
				<span style="">Il est aussi possible d'acheter une carte Neosurf en ligne &nbsp; <a href="http://www.myneosurf.com/acheter/code-neosurf-en-ligne.html" target="_blank" style="font-weight:bold;" class="aot-button aot-button-medium aot-button-orange">ICI</a></span>
				<br />			
		</div>
	</div>