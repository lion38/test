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
						<div class="big-message">
							<h3>404</h3>
							<div>
								<h4>Page non trouvée</h4>
							</div>
							<p>Désolé mais cette page n'existe pas.</p>
							<div class="msg-menu">
								<a href="index.php">Retourner à l'accueil</a>
							</div>
						</div>
