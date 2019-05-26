<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Erreur"; // Nom de la page dans le content
$page_is_full_width = true; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');
?>
<h2><span>test</span></h2>
<div class="content-padding">
<?php

	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = '.$CONFIG['marcheperso_array_etat']['en_vente'].'');
	$query->execute(array());
	$nb_de_ligne_bdd = 0;
	while($row = $query->fetch())
	{
		$query2 = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.worlds_characters WHERE CharacterId = ?');
		$query2->execute(array($row['id_perso']));
		$row2 = $query2->fetch();
		$query2->closeCursor();
		
		if($CONFIG['marcheperso_idaccount_stackpersotosell'] == $row2['AccountId'] OR empty($row2['AccountId'])) continue;
		/*
									$query3 = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.worlds_characters SET AccountId = ? WHERE Id = ? LIMIT 1');
									$query3->execute(array($CONFIG['marcheperso_idaccount_stackpersotosell'], $row2['Id']));
									$query3->closeCursor();
		*/
		$nb_de_ligne_bdd++;
		echo 'ID PERSO : '.$row['id_perso'].' ACCOUNT ID : '.$row2['AccountId'].'<br />';
	}
	$query->closeCursor();
	
	echo '<hr /> NOMBRE TOTAL LIGNE : '.$nb_de_ligne_bdd;
	
	die();
	// $query->execute(array('1337991337'));
	$query->execute(array($CONFIG['marcheperso_idaccount_stackpersotosell']));
	if($CONFIG['marcheperso_idaccount_stackpersotosell'] != 1337991337) die('ERREUR a verifier Avant de lancer !! marcheperso_idaccount_stackpersotosell = '.$CONFIG['marcheperso_idaccount_stackpersotosell'].' EST DIFFERENT DE 1337991337');

	$nb_de_ligne_bdd = 0;
	while($row = $query->fetch())
	{
		// echo 'Account '.$row['AccountId'].' ';
	// $date_to_use = ($row['timestampAchat'] > $row['timetampStartVente']) ? $row['timestampAchat'] : $row['timetampStartVente'];

	
		$query2 = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE id_perso = ? AND (etat = '.$CONFIG['marcheperso_array_etat']['annule'].' OR etat = '.$CONFIG['marcheperso_array_etat']['vendu'].' OR etat = '.$CONFIG['marcheperso_array_etat']['en_vente'].') ORDER BY timetampStartVente DESC LIMIT 1');
		$query2->execute(array($row['CharacterId']));
		$row2 = $query2->fetch();
		$query2->closeCursor();
		if($row2['etat'] != '')
		{
			if($CONFIG['marcheperso_array_etat']['en_vente'] == $row2['etat']) continue;
			$nb_de_ligne_bdd++;
			$compte_qui_recup = '-1';
			echo 'CharacterId = '.$row['CharacterId'].' ';
			echo 'Etat = '.$row2['etat'].' ';
			if($row2['etat'] == $CONFIG['marcheperso_array_etat']['vendu']) $compte_qui_recup = $row2['buyByAccountId'];
			elseif($row2['etat'] == $CONFIG['marcheperso_array_etat']['annule']) $compte_qui_recup = $row2['sellByAccountId'];
			// echo 'AccountQuiRecup = '.$row2['sellByAccountId'].' ';
			// echo 'AccountQuiRecup = '.$row2['buyByAccountId'].' ';
			echo 'AccountQuiRecupGOOD = '.$compte_qui_recup.' ';
			/*
									$query3 = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.worlds_characters SET AccountId = ? WHERE CharacterId = ? AND AccountId = ? LIMIT 1');
									$query3->execute(array($compte_qui_recup, $row['CharacterId'], $CONFIG['marcheperso_idaccount_stackpersotosell']));
									$query3->closeCursor();
			*/
			echo '<br />';
		}
	}
	$query->closeCursor();
	
	echo '<hr /> NOMBRE TOTAL LIGNE : '.$nb_de_ligne_bdd;
/*
	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? AND sellByAccountId = ? ORDER BY timestampAchat DESC, timetampStartVente DESC');
	$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente'], $COMPTE->Id));
	$nb_de_ligne_bdd = 0;
	while($row = $query->fetch())
	{
	$nb_de_ligne_bdd++;
	$date_to_use = ($row['timestampAchat'] > $row['timetampStartVente']) ? $row['timestampAchat'] : $row['timetampStartVente'];
	?>

	<?php
	}
	$query->closeCursor();
*/

?>
</div>