<?php 
ini_set('display_errors', 1);
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

	$query = $Sql->prepare('SELECT *, COUNT(id_perso) as nb FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = '.$CONFIG['marcheperso_array_etat']['vendu'].' AND buyByAccountId != 3 AND timestampAchat >= ? GROUP BY id_perso ORDER BY timestampAchat DESC');
	$query->execute(array(1449702000));
	$nb_de_ligne_bdd = 0;
	while($row = $query->fetch())
	{
		// if($row['nb'] > 1) continue; // pr le moment
		if($row['nb'] <= 1) continue; // pr le moment
		

			$query2 = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.worlds_characters WHERE CharacterId = ?');
			$query2->execute(array($row['id_perso']));
			$row2 = $query2->fetch();
			$query2->closeCursor();
			
			
		if($row['id_perso'] == 117810) continue;
		if($row['id_perso'] == 110737) continue;
		if($row['id_perso'] == 92079) continue;
		$nb_de_ligne_bdd++;
		
		
			// Passer le marche en cancel
			// Rembourser l'acheteur
			echo 'UPDATE '. $CONFIG['db_auth'] .'.marche_des_personnages SET etat = -1 WHERE id = '.$row['id'].' LIMIT 1; ';
			/*
			$query3 = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.marche_des_personnages SET etat = ?, ipAchatFin = ?, timestampAchat = ?, buyByAccountId = ? WHERE id = ? LIMIT 1');
			$query3->execute(array('-1', '-1', '-1', '-1', $row['id']));
			$query3->closeCursor();
			*/
			echo "UPDATE accounts SET Tokens = Tokens + ".$row['prix']." WHERE Account = ".$row['buyByAccountId'].";<br />";
			/*
			$query3 = $Sql->prepare("UPDATE accounts SET Tokens = Tokens + ? WHERE Id = ?");
			$query3->execute(array($row['prix'], $row['buyByAccountId']));
			$query3->closeCursor();
			*/
			
			
		
		if($row['nb'] >1) echo '<strong>';
		echo 'ID PERSO : '.$row['id_perso'].' nb : '.$row['nb'].' buyByAccountId : '.$row['buyByAccountId'].' AccountIdWorldCaract : '.$row2['AccountId'].' ';
		if($row['buyByAccountId'] != $row2['AccountId']) echo '<strong style="color:red;">DIFFERENT !</strong>';
		echo '<br />';
		if($row['nb'] >1) echo '</strong>';
	}
	$query->closeCursor();
	
	echo '<hr /> NOMBRE TOTAL LIGNE : '.$nb_de_ligne_bdd;

?>
</div>