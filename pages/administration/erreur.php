<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
$page_title = "Administration - Erreur"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
						<div class="big-message">
							<div>
								<h4>Page non trouvée</h4>
							</div>
							<p>Désolé mais cette page n'existe pas dans l'<strong>administration</strong>.</p>
							<div class="msg-menu">
								<a href="index.php?page=administration">Retourner à l'accueil de l'administration</a>
							</div>
						</div>
