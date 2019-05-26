<?php
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Votes suspects"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
$showCat = (isset($_GET['show']) AND !empty($_GET['show']) AND $_GET['show'] == 'keyIsNull') ? 'keyIsNull' : 'keyNotNull';
?>
<h2><span>Administration - Votes suspects</span></h2>
<div class="content-padding">

<a href="index.php?page=administration&amp;action=vote_multi&amp;show=keyNotNull" style="color:<?php echo $showCat == 'keyNotNull' ? 'green' : 'red'; ?>;"><h2>Les comptes  avec > 1 vote, et > 1 ip sur 24h qui fraudent PAR LastHardwareId</h2></a>
<a href="index.php?page=administration&amp;action=vote_multi&amp;show=keyIsNull" style="color:<?php echo $showCat == 'keyIsNull' ? 'green' : 'red'; ?>;"><h2>Les comptes  avec > 1 vote qui se sont jamais connecté (LastHardwareId = null)</h2></a>
<div class="clear-float do-the-split" style="margin-top:10px;margin-bottom:10px;"></div>
<?php
/*/*/
	if($showCat == 'keyIsNull')
	{
	// Permet de faire des requetes sur les clientkey null
	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.accounts WHERE Votes > ? AND isnull(LastHardwareId) AND not isnull(LastVote)');
	$query->execute(array(1));
	$nbtotal = 0;
	$htmlToShow_temp = '';
	while($data = $query->fetch())
	{
			$htmlToShow_temp .= ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ';
			//echo "\t";
			$htmlToShow_temp .= 'Login : <a style="font-family:verdana;color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=login&amp;value='.urlencode($data['Login']).'">'.$data['Login'].'</a> | ';
			$htmlToShow_temp .= 'LastVote : <b>'.$data['LastVote'].'</b> | ';
			$htmlToShow_temp .= 'Votes : '.$data['Votes'].' | ';
			$htmlToShow_temp .= 'Ogrines : <b>'. ($data['Tokens'] + $data['Tokens']).'</b> | ';
			$htmlToShow_temp .= 'last_ip_web : <a style="font-family:verdana;color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=ip&amp;value='.urlencode($data['last_ip_web']).'">'.$data['last_ip_web'].'</a>';
			$htmlToShow_temp .= '<br />';
		$nbtotal++;
	}
	$query->closeCursor();
	
	echo $htmlToShow_temp;
	echo $nbtotal;
	
	}
/**/
?>
<?php
/*/*/

	/*
			LastHardwareId : iaH4zTlSfIXz4mPOkTbQ6 | Nb de compte : 12 | nbIp : 12
          Login : nightmare1209 | LastVote : 2015-07-22 01:46:45 | Votes : 31 | Ogrines : 70
	*/
	// echo 'LastHardwareId : iaH4zTlSfIXz4mPOkTbQ6 | Nb de compte : 12 | nbIp : 12<br />';
	// echo 'Login : nightmare1209 | LastVote : 2015-07-22 01:46:45 | Votes : 31 | Ogrines : 70<br />';
	
	// return;
	
	if($showCat == 'keyNotNull')
	{
	// compte suspect avec > 1 vote , et > 1 ip sur 24h
	$query = $Sql->prepare('SELECT count(LastHardwareId) as nbCompteByKey, LastHardwareId, count(DISTINCT last_ip_web) as nbIp FROM '. $CONFIG['db_auth'] .'.accounts WHERE LastVote > ? GROUP BY LastHardwareId HAVING count(LastHardwareId) > ? and nbIp > ? ORDER BY count(LastHardwareId) DESC');
	$query->execute(array(date("Y-m-d H:i:s", (time() - (3600*24))), 1 , 1));
	$nbtotalSuspect = 0;
	$nbtotalReelCheater = 0;
	$htmlToShow = '';
	while($data = $query->fetch())
	{
		$htmlToShow_temp = '';
		$htmlToShow_temp .= '<b>LastHardwareId : <a style="font-family:verdana;color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=LastHardwareId&amp;value='.urlencode($data['LastHardwareId']).'">'.$data['LastHardwareId'].'</a> | Nb de compte : '.$data['nbCompteByKey'].' | nbIp : '.$data['nbIp'].'</b><br />';
		
		$query2 = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.accounts WHERE LastHardwareId = ? ORDER BY LastVote ASC');
		$query2->execute(array($data['LastHardwareId']));
		$datePrecedenteSec = 0;
		$isCheater = false;
		while($data2 = $query2->fetch())
		{
			$htmlToShow_temp .= ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ';
			//echo "\t";
			$htmlToShow_temp .= 'Login : <a style="font-family:verdana;color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=login&amp;value='.urlencode($data2['Login']).'">'.$data2['Login'].'</a> | ';
			$htmlToShow_temp .= 'LastVote : <b>'.$data2['LastVote'].'</b> | ';
			$htmlToShow_temp .= 'Votes : '.$data2['Votes'].' | ';
			$htmlToShow_temp .= 'Ogrines : <b>'. ($data2['Tokens'] + $data2['Tokens']).'</b> | ';
			$htmlToShow_temp .= 'last_ip_web : <a style="font-family:verdana;color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=ip&amp;value='.urlencode($data2['last_ip_web']).'">'.$data2['last_ip_web'].'</a>';
			$htmlToShow_temp .= '<br />';
			
			if($datePrecedenteSec == 0) { $datePrecedenteSec = strtotime($data2['LastVote']); continue;}
			$diffDate  = strtotime($data2['LastVote']) - $datePrecedenteSec;
			$datePrecedenteSec = strtotime($data2['LastVote']);
			if($diffDate < (60*60*3 - 60)) { $isCheater = TRUE; }
		}
		$query2->closeCursor();
		
		if($isCheater) { $nbtotalReelCheater++; $htmlToShow .= $htmlToShow_temp; }
		$nbtotalSuspect++;
	}
	$query->closeCursor();
	
	echo $htmlToShow;
	
	echo '<hr />nbtotalSuspect : '.$nbtotalSuspect;
	echo '<br />nbtotalReelCheater : '.$nbtotalReelCheater;
	}
/**/
?>
</div>