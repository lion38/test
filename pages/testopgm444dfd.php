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

	$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.characters_shortcuts_items WHERE OwnerId = ?');
	$query->execute(array('77659'));

	$nb_de_ligne_bdd = 0;
	while($row = $query->fetch())
	{
		$nb_de_ligne_bdd++;
	}
	$query->closeCursor();
	
	echo '<hr /> NOMBRE TOTAL LIGNE : '.$nb_de_ligne_bdd;


?>
</div>