<?php
if(!isset($_SESSION['Neft-Gaming_connecter']) OR !$_SESSION['Neft-Gaming_connecter']) die();

$url_api_json = 'http://api.dedipass.com/v1/pay/rates?key='.$CONFIG['dedipass_key'];

$cache_to_read = $CONFIG['cache_folder'].'dedipass_rate.cache';
$DEDIPASS_ARRAY = ''; // array des Neft-Gaming
$expire = time() - (60 * 60 * 3); // TEMP CACHE CLASSEMENT

if(file_exists($cache_to_read) && filemtime($cache_to_read) > $expire)
{
	$DEDIPASS_ARRAY = file_get_contents($cache_to_read);
}
else
{
	ob_start();
	echo file_get_contents($url_api_json);
	// Fin cache
	$DEDIPASS_ARRAY = ob_get_contents();
	ob_end_clean();
	file_put_contents($cache_to_read, $DEDIPASS_ARRAY);
}
$DEDIPASS_ARRAY = json_decode($DEDIPASS_ARRAY);

/*/
echo count($DEDIPASS_ARRAY);
echo '<pre>';
print_r($DEDIPASS_ARRAY);
echo '</pre>';
/**/

$ARRAY_METHODE_PAIEMENT_ALLOWED = array('audiotelsms' => array('audiotel', 'sms'), 'paypal' => array('paypal'), 'neosurf' => array('neosurf'), 'cartebancaire' => array('carte bancaire'), 'internetplus' => array('internet plus mobile'), 'paysafecard' => array('paysafecard'));
$ARRAY_PAYS_ALLOWED = array('fr', 'be', 'at', 'ca', 'cz', 'de', 'it', 'lu', 'ma', 'pl', 'es', 'ch', 'gb', 'anre');

// Etape 1 : Affiche la form par defaut après avoir choisis une méthode de paiement
if(isset($_POST['etape']) AND $_POST['etape'] == 'chose_methode')
{
	$methode_paiement = (isset($_POST['methode_paiement']) AND array_key_exists($_POST['methode_paiement'], $ARRAY_METHODE_PAIEMENT_ALLOWED) ) ? $_POST['methode_paiement'] : '';
	$pays_actuel = ($methode_paiement == 'audiotelsms' OR $methode_paiement == 'internetplus') ? 'fr' : 'all';
	
	if($methode_paiement != '')
	{
		if($methode_paiement == 'audiotelsms' OR $methode_paiement == 'internetplus')
		{
?>
				<label for="from_pays" style="margin-top:20px;display:block;"><h3>Choix du pays :</h3></label>
				<select name="from_pays" id="from_pays" style="font-family:verdana;margin-top:3px;">
					<option value="fr">France</option> 
					<?php
					if($methode_paiement == 'audiotelsms')
					{
					?>
					<option value="be">Belgique</option> 
					<option value="at">Autriche</option> 
					<option value="ca">Canada</option> 
					<option value="cz">République tchèque</option> 
					<option value="de">Allemagne</option> 
					<option value="it">Italie</option> 
					<option value="lu">Luxembourg</option> 
					<option value="ma">Maroc</option> 
					<option value="pl">Pologne</option> 
					<option value="es">Espagne</option> 
					<option value="ch">Suisse</option> 
					<option value="gb">Royaume-Uni</option> 
					<option value="anre">Antilles-Réunion</option> 
					<?php
					}
					?>
				</select>
<?php
		}
?>
	<div id="palierBoxShow">
				<label for="choix_palier" style="margin-top:20px;display:block;"><h3>Veuillez choisir un palier :</h3></label>
				<select name="choix_palier" id="choix_palier" style="font-family:verdana;margin-top:3px;">
				<option value="">Veuillez choisir un palier parmi la liste</option>
<?php

	foreach($DEDIPASS_ARRAY as $onePalier)
	{
		
		if(!in_array(strtolower($onePalier->solution), $ARRAY_METHODE_PAIEMENT_ALLOWED[$methode_paiement])) continue;
		if($onePalier->country->iso != $pays_actuel) continue;
		// echo $onePalier->solution.' '.$onePalier->country->iso.'<br />';
		
		if($CONFIG['boutique_offre_ogrine_double'] == TRUE)
			echo '<option value="'.$onePalier->rate.'">'.$onePalier->solution.' - '.($onePalier->user_earns * 2).' Ogrines ('.$onePalier->user_price.' '.$onePalier->user_currency.') au lieu de '.$onePalier->user_earns.' Ogrines</option> ';
		else
			echo '<option value="'.$onePalier->rate.'">'.$onePalier->solution.' - '.$onePalier->user_earns.' Ogrines ('.$onePalier->user_price.' '.$onePalier->user_currency.')</option> ';
	}
?>
				</select>
	</div>
				<div id="finFormulaireShowByCallback" style="display:none;">
					<div style="text-align:center;margin-top:20px;">
						<div class="clearfix doborderneph" style="margin-bottom:0;line-height:20px;background:#f7f7f7;text-shadow:2px 2px 1px white;">
							<h2 style="margin-bottom:0;color:#4f8e0c;"><i class="fa fa-info"></i> Informations :</h2>
							<div class="clear-float do-the-split" style="margin-top:5px;margin-bottom:15px;"></div>
							<p style="font-family:Verdana;color:#676767;" id="instructions_string"></p>
						</div>
					</div>	
				<div class="clearfix doborderneph" style="margin-bottom:0;line-height:20px;text-align:center;margin-top:20px;background:#f7f7f7;text-shadow:2px 2px 1px #f7f7f7;">
					<label for="code_acces"><h2 style="margin-bottom:0;color:#de606f;"><i class="fa fa-info"></i> Code d'accés :</h2></label>
					<div class="input-icon-wrap clearfix" style="width:90%;margin:auto;position:relative;left:-18px;margin-top:10px;"><span class="icon-key"></span>
						<input class="input-icon required" style="font-size:17px;font-weight:bold;" type="text" name="code_acces" id="code_acces" value="" placeholder="Votre code d'accés" />
					</div><input class="button" name="submit" id="submit_dedipass_pay" type="submit" value="Valider mon code" style="display:block;margin:20px auto 0 auto;" />
				</div>
						

				</div>
				
	<script type="text/javascript">
	jQuery('#from_pays').on('change', function()
	{
		jQuery('#alert_mess_error').hide();
		jQuery('#alert_mess_success').hide();
		jQuery('#palierBoxShow').hide();
		jQuery('#finFormulaireShowByCallback').hide();
		jQuery('#loading_gif').show();
		
		var pays_value = this.value;
		
		if(pays_value != "")
		{
			jQuery.ajax({
				type: "POST",
				url: "index.php?page=achat_api",
				data: "etape=chose_pays&pays_value="+pays_value,
				success: function(r)
				{
					jQuery('#loading_gif').hide();
					jQuery('#choix_palier').html(r);
					jQuery('#palierBoxShow').show();
				}
			});
		}
		else
		{
			jQuery('#loading_gif').hide();
			jQuery('#alert_mess_error .msgbox-content').html('Veuillez choisir un pays.');
			jQuery('#alert_mess_error').show();
			jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast');
		}
	});
	
	jQuery('#choix_palier').on('change', function()
	{
		jQuery('#alert_mess_error').hide();
		jQuery('#alert_mess_success').hide();
		jQuery('#finFormulaireShowByCallback').hide();
		jQuery('#loading_gif').show();
		
		var palier_value = this.value;
		
		if(palier_value != "")
		{
			jQuery.ajax({
				type: "POST",
				url: "index.php?page=achat_api",
				data: "etape=chose_palier&palier_value="+palier_value,
				success: function(r)
				{
					jQuery('#loading_gif').hide();
					jQuery('#instructions_string').html(r);
					jQuery('#finFormulaireShowByCallback').show();
				}
			});
		}
		else
		{
			jQuery('#loading_gif').hide();
			jQuery('#alert_mess_error .msgbox-content').html('Veuillez choisir un palier.');
			jQuery('#alert_mess_error').show();
			jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast');
		}
	});
	
	jQuery("#submit_dedipass_pay").click(function()
	{
		jQuery('#alert_mess_error').hide();
		jQuery('#alert_mess_success').hide();
		var palier_value = jQuery("#choix_palier").val();
		var code_value = jQuery("#code_acces").val();
		
		if(code_value == "") { jQuery('#alert_mess_error .msgbox-content').html('Veuillez entrer un code d\'accés.'); jQuery('#alert_mess_error').show(); jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast'); }
		else
		{
			jQuery('#loading_gif').show();
			jQuery('#submit_dedipass_pay').hide();
			jQuery("#code_acces").prop('disabled', true);
			jQuery("#choix_palier").prop('disabled', true);
			jQuery("#methode_paiement").prop('disabled', true);
			jQuery("#from_pays").prop('disabled', true);
			
			jQuery.ajax({
				type: "POST",
				url: "index.php?page=achat_api",
				data: "etape=checkpaiement&palier_value="+palier_value+"&code_value="+code_value,
				success: function(r)
				{
					var exploded = r.split("|==|");
					if(exploded[0] == 'ERROR')
					{
						jQuery('#alert_mess_error .msgbox-content').html(exploded[1]); jQuery('#alert_mess_error').show();
						jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast');
					}
					else if(exploded[0] == 'SUCCESS')
					{
						jQuery("#ogrine_in_header").text(exploded[1]);
						jQuery("#ogrineMenuRight").text(exploded[1]);
						jQuery("#ogrineInPageToUpdate").text(exploded[1]);
						jQuery('#alert_mess_success .msgbox-content').html(exploded[2]); jQuery('#alert_mess_success').show();
						jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_success").offset().top - 100}, 'fast');
					}
					else
					{
						jQuery('#alert_mess_error .msgbox-content').html("Une erreur est survenue, veuillez actualiser la page et rentrer à nouveau votre code s'il vous plaît."); jQuery('#alert_mess_error').show();
						jQuery('html,body').animate({scrollTop: jQuery("#alert_mess_error").offset().top - 100}, 'fast');
					}
					jQuery("#code_acces").val('');
					jQuery('#loading_gif').hide();
					jQuery('#submit_dedipass_pay').show();
					jQuery("#code_acces").prop('disabled', false);
					jQuery("#choix_palier").prop('disabled', false);
					jQuery("#methode_paiement").prop('disabled', false);
					jQuery("#from_pays").prop('disabled', false);
				}
			});
		}
	});
	</script>
<?php
	}
}

// Etape 2 : Retourne les options du select PALIER par PAYS (audiotelsms only)
if(isset($_POST['etape']) AND $_POST['etape'] == 'chose_pays')
{
	$pays_actuel = (isset($_POST['pays_value']) AND in_array($_POST['pays_value'], $ARRAY_PAYS_ALLOWED) ) ? $_POST['pays_value'] : '';
	if($pays_actuel != '')
	{
		echo '<option value="">Veuillez choisir un palier parmi la liste</option>';
		foreach($DEDIPASS_ARRAY as $onePalier)
		{
			
			if(!in_array(strtolower($onePalier->solution), $ARRAY_METHODE_PAIEMENT_ALLOWED['audiotelsms'])) continue;
			if($onePalier->country->iso != $pays_actuel) continue;
			// echo $onePalier->solution.' '.$onePalier->country->iso.'<br />';
			if($CONFIG['boutique_offre_ogrine_double'] == TRUE)
				echo '<option value="'.$onePalier->rate.'">'.$onePalier->solution.' - '.($onePalier->user_earns * 2).' '.$onePalier->virtual_currency_name.' ('.$onePalier->user_price.' '.$onePalier->user_currency.') au lieu de '.$onePalier->user_earns.' Ogrines</option> ';
			else
				echo '<option value="'.$onePalier->rate.'">'.$onePalier->solution.' - '.$onePalier->user_earns.' Ogrines ('.$onePalier->user_price.' '.$onePalier->user_currency.')</option> ';
		}
	}
}

// Etape 3 : Retourne les informations du pallier
if(isset($_POST['etape']) AND $_POST['etape'] == 'chose_palier')
{
	$palier_actuel = (isset($_POST['palier_value']) AND !empty($_POST['palier_value']) ) ? $_POST['palier_value'] : '';
	if($palier_actuel != '')
	{
		foreach($DEDIPASS_ARRAY as $onePalier)
		{
			if($onePalier->rate == $palier_actuel)
			{
				if($onePalier->solution == 'Audiotel')
				{
					?>
						Pour obtenir un code d'accès, <strong>appeler</strong> le :<br />
						<?php
						if($onePalier->country->iso == 'fr')
						{
						?>
						<div class="audiotel-france">
						  <?php echo $onePalier->phone; ?>
						  <small>Service <?php echo $onePalier->user_price; ?> &euro; / appel<br>+ prix appel</small>
						</div>
						<style>
						.audiotel-france {
						  background: url(//pay.dedipass.com/images/audiotel.png);
						  width: 393px;
						  height: 45px;
						  color: #9c1881;
						  font-family: arial;
						  font-size: 28px;
						  text-align: left;
						  position: relative;
						  margin: 0 auto;
						  -webkit-box-sizing : border-box;‌​
						  -moz-box-sizing : border-box;
						  box-sizing : border-box;
						  padding-top: 3px;
						  padding-left: 20px;
						  margin-top: 10px;
						  font-weight: bold;
						  overflow:hidden;
						  line-height:40px;
						  text-shadow:0 0 0 !important;
						}
						.audiotel-france small {
						  display: block;
						  font-size: 13px;
						  color: #fff;
						  position: absolute;
						  right: 22px;
						  top: 4px;
						  font-weight: bold;
						  line-height:20px;
						  text-shadow:0 0 0 !important;
						}
						</style>
						<?php
						}
						else
						{
						?>
						<h3><?php echo $onePalier->phone; ?></h3>
						<?php echo $onePalier->mention; ?>
					<?php
						}
				}
				elseif($onePalier->solution == 'SMS')
				{
					?>
						Pour obtenir votre code d'accès, envoyez par <strong>SMS</strong> :<br />
						<h2><?php echo $onePalier->keyword; ?> <span style="font-size:80%;">au</span> <?php echo $onePalier->shortcode; ?></h2>
						<?php echo $onePalier->mention; ?>
						<?php if($onePalier->country->iso != "fr" AND isset($onePalier->legal_graphic->footer) AND !empty($onePalier->legal_graphic->footer)) echo '<br /><br />'.$onePalier->legal_graphic->footer; ?>
					<?php
				}
				elseif($onePalier->solution == 'Paypal')
				{
					?>
					Pour obtenir votre code d'accés il faut procéder au paiement.<br />Ensuite complétez le formulaire avec le code reçus.<br /><br />
					<a target="_blank" href="https://buy.dedipass.com/v1/paypal?key=<?php echo $CONFIG['dedipass_key']; ?>&amp;rate=<?php echo $onePalier->rate; ?>" class="button">Acheter un code avec <strong>Paypal</strong> de <strong><?php echo $onePalier->user_price; ?> €</strong></a>
					<?php
				}
				elseif($onePalier->solution == 'Carte bancaire')
				{
					?>
					Pour obtenir votre code d'accés il faut procéder au paiement.<br />Ensuite complétez le formulaire avec le code reçus.<br /><br />
					<a target="_blank" href="<?php echo $onePalier->link; ?>&amp;rate=<?php echo $onePalier->rate; ?>" class="button">Acheter un code avec une <strong>Carte Bancaire</strong> de <strong><?php echo $onePalier->user_price; ?> €</strong></a>
					<?php
				}
				elseif($onePalier->solution == 'Neosurf')
				{
					?>			
					Neosurf est une carte prépayée en vente chez votre buraliste qui vous permet<br /> d'acheter sur Internet de manière simple, sécurisée et anonyme.			
					<br /><br />
					<h2 style="margin-bottom:0;color:#db6200;"><i class="fa fa-location-arrow"></i> Ou acheter des codes Neosurf ?</h2>
					<div class="clear-float do-the-split" style="margin-top:5px;margin-bottom:15px;"></div>
				
					<span style="">Pour trouvez un point de vente proche de chez vous veuillez vous référé à &nbsp; <a href="http://www.neosurf.info/public/fr/presentation.php?pageID=3" target="_blank" style="margin-bottom:5px;background-color: #519623;font-weight:bold;" class="button">Cette CARTE</a></span>
					<br /><br />
					<span style="">Il est aussi possible d'acheter une carte Neosurf en ligne &nbsp; <a href="http://www.myneosurf.com/acheter/code-neosurf-en-ligne.html" target="_blank" style="margin-bottom:5px;background-color: #DB6D1D;font-weight:bold;" class="button">ICI</a></span>
					<br />	
					
					<div class="breaking-line"></div>
					Pour obtenir votre code d'accés il faut utiliser un <strong>code Neosurf</strong> pour procéder au paiement.<br />Ensuite complétez le formulaire avec le code reçus.<br /><br />
					<a target="_blank" href="<?php echo $onePalier->link; ?>&amp;rate=<?php echo $onePalier->rate; ?>" class="button">Payer un code avec <strong>Neosurf</strong> de <strong><?php echo $onePalier->user_price; ?> €</strong></a>
					<?php
				}
				elseif($onePalier->solution == 'Internet Plus Mobile')
				{
					?>
					Pour obtenir votre code d'accés il faut procéder au paiement.<br />Ensuite complétez le formulaire avec le code reçus.<br /><br />
					<a target="_blank" href="http://buy.dedipass.com/v1/pay/internetplus?rate=<?php echo $onePalier->rate; ?>" class="button">Acheter un code avec une <strong>Internet Plus</strong> de <strong><?php echo $onePalier->user_price; ?> €</strong></a>
					<?php
				}
				elseif($onePalier->solution == 'Paysafecard')
				{
					?>			
					Pour obtenir votre code d'accés il faut utiliser une <strong>carte Paysafecard</strong> pour procéder au paiement.<br />Ensuite complétez le formulaire avec le code reçus.<br /><br />
					<a target="_blank" href="https://buy.buycode.eu/v1/paysafecard?rate=<?php echo $onePalier->rate; ?>" class="button">Payer un code avec <strong>Paysafecard</strong> de <strong><?php echo $onePalier->user_price; ?> €</strong></a>
					<?php
				}
				/*
				echo '<pre>';
				print_r($onePalier);
				echo '</pre>';
				*/
				break;
			}
		}
	}
}

// Etape 4 : Verif le paiement et donne les gains
if(isset($_POST['etape']) AND $_POST['etape'] == 'checkpaiement')
{
	$palier_actuel = (isset($_POST['palier_value']) AND !empty($_POST['palier_value']) ) ? $_POST['palier_value'] : '';
	$code_value = (isset($_POST['code_value']) AND !empty($_POST['code_value']) ) ? $_POST['code_value'] : '';
	if($palier_actuel != '' AND $code_value != '')
	{

			$dedipass = file_get_contents('http://api.dedipass.com/v1/pay/?key='.$CONFIG['dedipass_key'].'&rate='.$palier_actuel.'&code='.$code_value);
			$dedipass = json_decode($dedipass);
			
			if($dedipass->status == 'success')
			{
				// Le code est valide
				$code = $dedipass->code;
				$rates = (isset($dedipass->rate) AND !empty($dedipass->rate)) ? $dedipass->rate : $dedipass->identifier;
				$virtual_currency = $dedipass->virtual_currency;
				
				if($CONFIG['boutique_offre_ogrine_double'] == TRUE) $virtual_currency = $virtual_currency * 2;
				
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
				elseif (strpos($rates, 'internetplus') !== false)
				{
					$stat_type = 'internetplus';
					$stat_pays = $rates_explode[1];
					$stat_paliers = $rates_explode[3];
				}
				elseif (strpos($rates, 'paysafecard') !== false)
				{
					$stat_type = 'paysafecard';
					$stat_pays = 'world';
					$stat_paliers = $rates_explode[1];
				}
				else
				{
					$stat_type = 'unknow';
					$stat_pays = 'unknow';
					$stat_paliers = $rates;
				}
				
				$tokens_before = $COMPTE->Tokens + $COMPTE->NewTokens;
				$query = $Sql->prepare("UPDATE accounts SET Tokens = Tokens + ? WHERE Id = ?");
				$query->execute(array($virtual_currency, $COMPTE->Id));
				$query->closeCursor();
				$tokensEntier = $tokens_before + $virtual_currency;
				//$this->site_shop_points_purchase->add($account->account, $virtual_currency, $_POST['code'], $stat_pays, $stat_paliers, "0", $stat_type, date('d/m/y H:i'));
				
				$date = date("Y-m-d H:i:s");
				$query = $Sql->prepare("INSERT INTO log_site_achat_points(accountId, ogrine_acheter, ogrine_avant, code, pays, palier, type, date, timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$query->execute(array($COMPTE->Id, $virtual_currency, $tokens_before, $code, $stat_pays, $stat_paliers, $stat_type, $date, time()));
				$query->closeCursor();
				
				echo 'SUCCESS|==|'. ($COMPTE->Tokens + $COMPTE->NewTokens + $virtual_currency).'|==|<strong>Félicitations : </strong>Le code <strong>'.htmlspecialchars($code).'</strong> est valide, <strong>' . $virtual_currency.'</strong> Ogrines/Jetons viennent de vous être ajoutés.<br />Si vous êtes déjà connecter, il faut vous <strong>déconnecter/reconnecter</strong> pour mettre à jours vos Ogrines !';
			}
			else
			{
				// Le code est invalide
				$code = @$dedipass->code;
				if(isset($dedipass->id) AND $dedipass->id == 'rate::empty') echo 'ERROR|==|Veuillez choisir un pallier avant de valider votre code !';
				else echo 'ERROR|==|Le code <strong>'.htmlspecialchars(htmlentities($code)).'</strong> est invalide.';
				
			}
			
			$date = date("d-m-Y");
			$heure = date("H:i:s");
			$finalStatus = ($dedipass->status == 'success') ? 'OK' : 'ERROR';
			$monfichier = fopen($CONFIG['cache_folder'].'appachat.txt', 'a+');
			rewind($monfichier);
			fputs($monfichier, "$date $heure |--| STATUS : $finalStatus |--| CODE : $code_value |--| RATE : ".$dedipass->rate." |--| COMPTElogin : ".$COMPTE->Login."\r\n");
			fclose($monfichier);
		
	}
	else
	{
		echo 'ERROR|==|Veuillez entrer un code correct.';
	}
}
?>