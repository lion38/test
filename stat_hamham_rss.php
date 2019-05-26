<?php
require 'class/sql.class.php'; 
require_once('config/config.php');
require_once('config/fonction.php');
date_default_timezone_set('Europe/Paris');
$Sql = new Sql();
$Sql->query("SET NAMES utf8");
header ("Content-Type:text/xml");

$content = 0;
$label = '';

if(isset($_GET['tunezz']))
{
	$nbDiviserPrixOgrine = 100;
	$dateToUse = $today = date('d-m-Y', time());
	$explodedDate = explode('-', $dateToUse);
	$jours = $explodedDate[0];
	$mois = $explodedDate[1];
	$annee = $explodedDate[2];
	$start_date = mktime(0,0,0, $mois, $jours, $annee);
	$end_date = mktime(0,0,0, $mois, $jours+1, $annee);
	
	$totalApproxEuros = 0;
	$prixApproxActuel = 0;
	$query = $Sql->prepare('SELECT * FROM '.$CONFIG['db_auth'].'.log_site_achat_points WHERE timestamp >= '.$start_date.' AND timestamp < '.$end_date.' ORDER BY timestamp DESC');
	$query->execute();
	while($data = $query->fetch())
	{
		$prixApproxActuel = $data['ogrine_acheter'] / $nbDiviserPrixOgrine;
		if($data['type'] != 'paypal' AND $data['timestamp'] >= 1450744061 AND $data['timestamp'] <= 1451899298) $prixApproxActuel = $prixApproxActuel / 2;
		if($data['timestamp'] >= 1440761473 AND $data['timestamp'] <= 1441058371) { $prixApproxActuel = $prixApproxActuel / 2; }
		if($data['timestamp'] >= 1446145615 AND $data['timestamp'] <= 1446467026) { $prixApproxActuel = $prixApproxActuel / 2; } // A edit (a degager a la fin de l'offre cette ligne)
		if($data['timestamp'] >= 1455210000 AND $data['timestamp'] <= 1455534000) { $prixApproxActuel = $prixApproxActuel / 2; } // A edit (a degager a la fin de l'offre cette ligne)
		if($data['type'] == 'paypal')
		{
			if($data['timestamp'] > 1450484620) { $prixApproxActuel = WithoutaddTenPercent($data['palier']) / $nbDiviserPrixOgrine; $totalApproxEuros += $prixApproxActuel; } // Plus grand que la date ou on a mis HMA
			else{ $totalApproxEuros += $prixApproxActuel; } // Sinon normal
		}
		else $totalApproxEuros += $prixApproxActuel;
	}
	$query->closeCursor();
	$content =  $totalApproxEuros.' €';
	$label = 'N | Cash';
	
	if(isset($_GET['one_part']))
	{
		if($totalApproxEuros > 0) $totalApproxEuros = round($totalApproxEuros / 4, 2);
		$content =  $totalApproxEuros.' €';
		$label = 'N² | Cash';
	}
}
else
{
	$content = -1;
	$QUERYBOT = $Sql->prepare("SELECT CharsCount FROM worlds");
	$QUERYBOT->execute();
	$row = $QUERYBOT->fetch();
	$QUERYBOT->closeCursor();
	if($row) $content =  $row['CharsCount'];
	$label = 'N | Online';
}
$Sql = null;
?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
 <title><?php echo $content; ?></title>
 <description>This is an example of an RSS feed</description>
 <link>http://Neft-Gaming.eu/</link>
 <lastBuildDate>Mon, 06 Sep 2009 16:45:00 +0000 </lastBuildDate>
 
 <item>
  <title><?php echo $label; ?></title>
  <description>Here is some text containing an interesting description.</description>
  <link>http://Neft-Gaming.eu/</link>
  <pubDate>Mon, 06 Sep 2009 16:45:00 +0000 </pubDate>
 </item>
 
</channel>
</rss>