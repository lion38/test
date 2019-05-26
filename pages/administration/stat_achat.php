<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Statistiques d'achat"; // Nom de la page dans le content
$page_is_full_width = true; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
<h2 style="margin-bottom:10px;"><span>Administration - Statistiques d'achat</span></h2>
<div class="content-padding">
<?php

$nb_de_ligne_tableau_a_use = 10;
// Config
$nbDiviserPrixOgrine = 100;

function checkIsAValidDate($myDateString){
    return (bool)strtotime($myDateString);
}

$today = date('d-m-Y', time());
if(isset($_GET['date']) AND !empty($_GET['date']) AND checkIsAValidDate($_GET['date'])) $dateToUse = $_GET['date'];
else $dateToUse = $today;
$explodedDate = explode('-', $dateToUse);
$jours = $explodedDate[0];
$mois = $explodedDate[1];
$annee = $explodedDate[2];
$start_date = mktime(0,0,0, $mois, $jours, $annee);
$end_date = mktime(0,0,0, $mois, $jours+1, $annee);
/*
echo 'dateToUse : '.$dateToUse.'<br />';
echo 'Start : '.$start_date.'<br />';
echo 'End : '.$end_date.'<br />';
*/

$showGet = (isset($_GET['show']) AND !empty($_GET['show'])) ? $_GET['show'] : '';

for($aa=7; $aa >= 1; $aa--)
{
	$day_before = date( 'd-m-Y', strtotime( $today . ' -'.$aa.' day' ) );
	if($day_before == $dateToUse)
		echo '<a href="index.php?page=administration&action=stat_achat&amp;date='.$day_before.'" style="color:green;font-weight:bold;font-family:Verdana;">'.$day_before.'</a>';
	else
		echo '<a href="index.php?page=administration&action=stat_achat&amp;date='.$day_before.'" style="color:red;font-weight:bold;font-family:Verdana;">'.$day_before.'</a>';
		
	if($aa > 1) echo ' - ';
}
	if($today == $dateToUse)
		echo '<a href="index.php?page=administration&action=stat_achat" class="right" style="color:green;font-weight:bold;">Aujourd\'hui ('.$today.')</a><br />';
	else
		echo '<a href="index.php?page=administration&action=stat_achat" class="right" style="color:blue;font-weight:bold;">Aujourd\'hui ('.$today.')</a><br />';
?>
<div style="text-align:center;margin:0 auto 10px auto;">
  <h4><span style="position:relative;top:8px;left:-5px;">Date actuellement utilisée (Ou choisir) :</span> <input type="text" id="datepicker" value="<?php echo $dateToUse; ?>"></h4>
  <script>
  $(function() {
	$( "#datepicker" ).datepicker({
	altField: "#datepicker",
	closeText: 'Fermer',
	prevText: 'Précédent',
	nextText: 'Suivant',
	currentText: 'Aujourd\'hui',
	monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
	monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
	dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
	dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
	dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
	weekHeader: 'Sem.',
	dateFormat: 'dd-mm-yy',
        onSelect: function () {
           window.location.href = '<?php echo $CONFIG['URL_SITE']; ?>index.php?page=administration&action=stat_achat&date=' + this.value;
        }
	});
  });
  </script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<a class="button  aot-button-red" href="index.php?page=administration&action=stat_achat&amp;show=statistiques" style="background-color:#dc0016;margin:10px 0 10px 0;font-family:verdana;float:left;"><span style="position:relative;top:1px;"><span class="icon-cloud"></span> Statistiques</span></a>
	<div style="float:right;">
	<a class="button " href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=month" style="background-color:#8a10a1;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-cloud"></span> Du mois</span></a>
	<a class="button  aot-button-black" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=all" style="background-color:#4c4c4c;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-globe"></span> Tout</span></a>
	<a class="button  aot-button-blue-alt" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=paypal" style="background-color:#2875b5;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-paypal"></span> Paypal</span></a>
	<a class="button  aot-button-pink" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=cb" style="background-color:#dd2050;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><i class="fa fa-credit-card"></i> Carte bancaire</span></a>
	<a class="button  aot-button-blued" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=internetplus" style="background-color:#098acd;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><i class="fa fa-info"></i> Internet +</span></a>
	<a class="button  aot-button-orange" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=smsaudio" style="background-color:#e05e0d;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><span class="icon-phone"></span> Sms/Audiotel</span></a>
	<a class="button  aot-button-green-alt" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=neosurf" style="background-color:#29b765;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><i class="fa fa-ticket"></i> Neosurf</span></a>
	<a class="button  aot-button-green-alt" href="index.php?page=administration&action=stat_achat&amp;date=<?php echo $dateToUse; ?>&amp;show=paysafecard" style="background-color:#294ab7;margin:10px auto 0 auto;font-family:verdana;"><span style="position:relative;top:1px;"><i class="fa fa-globe"></i> PaySafe</span></a>
	</div>
</div>
<table id="table_achat" class="bordered bordered-orange" style="margin-top:10px;width:100%;border:1px solid #b4b4b4;background:white;">
<?php
if($showGet != 'statistiques')
{
?>
	<thead>
		<tr>
			<th style="text-align:center;width:25px;">#</th>
			<th style="width:160px;">Date</th>
			<th>Type</th>
			<th>Pays</th>
			<th style="width:50px;">Ogrines</th>
			<th style="text-align:center;">Prix</th>
		</tr>
	</thead>
<?php
}
?>
	<tbody>
<?php
$id=0;
$totalApproxEuros = 0;
$totalPaypal = 0;
$totalSmsaudio = 0;
$totalNeosurf = 0;
$totalPaysafecard = 0;
$totalCb = 0;
$totalInternetPlus = 0;

if($showGet == 'month')
{
	$start_date = mktime(0, 0, 0, $mois, 1, $annee);
	$end_date = mktime(23, 59, 0, $mois, date("t"), $annee);
}
elseif($showGet == 'statistiques')
{
	$start_date = 0;
	$end_date = time() + 99999;
}


if($showGet == 'paypal')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND type = "paypal" ORDER BY timestamp DESC');
elseif($showGet == 'smsaudio')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND (type = "audiotel" OR type = "sms") ORDER BY timestamp DESC');
elseif($showGet == 'neosurf')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND type = "neosurf" ORDER BY timestamp DESC');
elseif($showGet == 'cb')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND type = "cb" ORDER BY timestamp DESC');
elseif($showGet == 'internetplus')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND type = "internetplus" ORDER BY timestamp DESC');
elseif($showGet == 'paysafecard')
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' AND type = "paysafecard" ORDER BY timestamp DESC');
else
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' ORDER BY timestamp DESC');
	
$query->execute();
$to_show_tabledata = '';
ob_start();	
while($data = $query->fetch())
{
	$id++;
	$stroke_show = '';
	
	/*if($data['type'] == 'paypal' AND $data['timestamp'] > 1439851202) $nbDiviserPrixOgrine = 75;
	else*/ 
	$nbDiviserPrixOgrine = 100;
	
	$prixApproxActuel = $data['ogrine_acheter'] / $nbDiviserPrixOgrine;
	if($data['timestamp'] >= 1463686973 AND $data['timestamp'] <= 1464003653) $prixApproxActuel = $prixApproxActuel / 2;
	if($data['type'] == 'paypal')
	{
		/*
		$stroke_show = $prixApproxActuel = intval($data['palier']);
		if($data['fee'] != null AND $data['fee'] > 0) $prixApproxActuel = $prixApproxActuel - $data['fee'];
		$prixApproxActuel = $prixApproxActuel - ($prixApproxActuel * 0.25);
		*/
		if($data['timestamp'] > 1450484620) { $prixApproxActuel = WithoutaddTenPercent($data['palier']) / $nbDiviserPrixOgrine; $totalPaypal += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; } // Plus grand que la date ou on a mis HMA
		else{ $totalPaypal += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; } // Sinon normal
	}
	elseif($data['type'] == 'sms' OR $data['type'] == 'audiotel') { $totalSmsaudio += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; }
	elseif($data['type'] == 'neosurf') { $totalNeosurf += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; }
	elseif($data['type'] == 'cb') { $totalCb += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; }
	elseif($data['type'] == 'internetplus') { $totalInternetPlus += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; }
	elseif($data['type'] == 'paysafecard') { $totalPaysafecard += $prixApproxActuel; $totalApproxEuros += $prixApproxActuel; }
	else { $totalApproxEuros += $prixApproxActuel; }
?>
	<tr style="font-family:verdana;">
		<td style="text-align:center;"><strong><?php echo $id; ?></strong></td>
		<td style=""><?php echo $data['date']; ?></td>
		<td style="font-weight:bold;"><?php echo ucfirst($data['type']); ?></td>
		<td style="font-weight:bold;"><?php echo ($data['pays']); ?></td>
		<td style=""><?php echo $data['ogrine_acheter']; ?></td>
		<td style="font-weight:bold;font-size:110%;text-align:center;"><?php if($stroke_show != '') echo '<s style="color:red;">'.$stroke_show.'</s> '; ?><?php echo $prixApproxActuel; ?> €</td>
	</tr>
<?php
}
$query->closeCursor();
$to_show_tabledata = ob_get_contents();
ob_end_clean();
?>
<?php
if($showGet != 'statistiques')
{
?>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL</strong></td>
		<td style="font-weight:bold;color:red;text-align:center;font-family:Arial;font-size:110%;"><?php echo $totalApproxEuros; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#2875b5;text-shadow:1px 1px 0 #cce8ff;">PAYPAL</span></strong></td>
		<td style="font-weight:bold;color:#2875b5;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #cce8ff;"><?php echo $totalPaypal; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#dd2050;text-shadow:1px 1px 0 #ffccd9;">CARTE BANCAIRE</span></strong></td>
		<td style="font-weight:bold;color:#dd2050;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ffccd9;"><?php echo $totalCb; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#098acd;text-shadow:1px 1px 0 #ccedff;">INTERNET PLUS</span></strong></td>
		<td style="font-weight:bold;color:#098acd;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ccedff;"><?php echo $totalInternetPlus; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#e05e0d;text-shadow:1px 1px 0 #ffe0cc;">AUDIOTEL / SMS</span></strong></td>
		<td style="font-weight:bold;color:#e05e0d;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ffe0cc;"><?php echo $totalSmsaudio; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#29b765;text-shadow:1px 1px 0 #ccffe1;">NEOSURF</span></strong></td>
		<td style="font-weight:bold;color:#29b765;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ccffe1;"><?php echo $totalNeosurf; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#294ab7;text-shadow:1px 1px 0 #d0d8f2;">PAYSAFECARD</span></strong></td>
		<td style="font-weight:bold;color:#294ab7;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #d0d8f2;"><?php echo $totalPaysafecard; ?> €</td>
	</tr>
<?php 
echo $to_show_tabledata; 
}?>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL</strong></td>
		<td style="font-weight:bold;color:red;text-align:center;font-family:Arial;font-size:110%;"><?php echo $totalApproxEuros; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#2875b5;text-shadow:1px 1px 0 #cce8ff;">PAYPAL</span></strong></td>
		<td style="font-weight:bold;color:#2875b5;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #cce8ff;"><?php echo $totalPaypal; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#dd2050;text-shadow:1px 1px 0 #ffccd9;">CARTE BANCAIRE</span></strong></td>
		<td style="font-weight:bold;color:#dd2050;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ffccd9;"><?php echo $totalCb; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#098acd;text-shadow:1px 1px 0 #ccedff;">INTERNET PLUS</span></strong></td>
		<td style="font-weight:bold;color:#098acd;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ccedff;"><?php echo $totalInternetPlus; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#e05e0d;text-shadow:1px 1px 0 #ffe0cc;">AUDIOTEL / SMS</span></strong></td>
		<td style="font-weight:bold;color:#e05e0d;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ffe0cc;"><?php echo $totalSmsaudio; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#29b765;text-shadow:1px 1px 0 #ccffe1;">NEOSURF</span></strong></td>
		<td style="font-weight:bold;color:#29b765;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #ccffe1;"><?php echo $totalNeosurf; ?> €</td>
	</tr>
	<tr style="font-family:verdana;">
		<td style="text-align:center;" colspan="5"><strong>TOTAL - <span style="color:#294ab7;text-shadow:1px 1px 0 #d0d8f2;">PAYSAFECARD</span></strong></td>
		<td style="font-weight:bold;color:#294ab7;text-align:center;font-family:Arial;font-size:110%;text-shadow:1px 1px 0 #d0d8f2;"><?php echo $totalPaysafecard; ?> €</td>
	</tr>
	</tbody>
</table>
<?php
if($showGet == 'statistiques')
{

}
?>

</div>