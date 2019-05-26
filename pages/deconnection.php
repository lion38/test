<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Déconnection"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite
include('include/header.php');
include('include/rightbar.php');
header('Refresh: 5; URL='.$CONFIG['URL_SITE']);
?>
						<div class="big-message">
							<div>
								<h4><strong>Déconnection</strong>...</h4>
							</div>
							<p class="login-passes" style="width:45%;margin:auto;text-align:center;">Vous allez être rédirigé vers l'accueil dans <strong>5 secondes</strong>.</p>
							<br /><div class="breaking-line"></div>
							<div class="msg-menu">
								<a href="index.php">Retourner à l'accueil du site</a>
							</div>
						</div>
