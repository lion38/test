<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
$page_title = "Administration"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
	<h2><span>Administration de Neft-Gaming</span></h2>
	<div class="content-padding">
		Accueil de l'<strong>administration de Neft-Gaming</strong>, veuillez choisir une action dans le menu de droite.					
	</div>