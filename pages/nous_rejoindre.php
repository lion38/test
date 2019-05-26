<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Nous rejoindre"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');
?>
	<?php
	if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE))
	{
	?>
	<h2 style="margin-bottom:0;"><span>Pas encore inscrit ?</span></h2>
	<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;text-align:center;text-shadow:1px 1px 0 white;">
				Bienvenue à toi visiteur, si tu n'est pas encore inscrit sur Neft-Gaming c'est une étape obligatoire pour nous rejoindre.<br />
				<br /><p><a href="index.php?page=inscription" class="button" style="margin-bottom:5px;background-color: #519623;"><span class="icon-right-open"></span> Cliquez ici pour rejoindre la page d'<b>inscription</b> !</a></p>		
	</div>
	<?php
	}
	?>
	<h2 style="margin-bottom:0;"><span>Téléchargement / Installation du Uplauncher</span></h2>
	<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;text-align:center;text-shadow:1px 1px 0 white;">
				Pour rejoindre l'aventure parmi nous il vous suffit simplement de télécharger l'UpLauncher.<br /><b>Exécutez le en tant qu'Administrateur</b> pour pouvoir vous en servir convenablement.
				<br /><br />
				<a class="button big-size" href="<?php echo $CONFIG['archive_install_uplauncher']; ?>" target="_blank">Télécharger l'<strong>UpLauncher de Neft-Gaming</strong> <em style="font-family:Verdana;"></em></a>
				<br /><br />
				Une fois L'uplauncher installé, il faut le lancer et le laisser télécharger les fichiers necessaires pour le jeu.		
	</div>
	
	<h2 style="border-bottom: 5px solid #dedede;"><span>Je rencontre des problèmes au lancement de mon jeu</span></h2>
	<div class="content-padding" style="text-align:center;">
	


		<div class="accordion" id="howNeosurf">
			<div class="accordion-tab active" style="background:white;">
				<a href="#"><h3>Mon UpLauncher ne veut pas s'éxécuter</h3></a>
				<div class="accordion-block"><div class="breaking-line" style="margin:0;position:relative;top:-15px;"></div>
					Avez-vous installé et mis à jour <a href="http://www.microsoft.com/fr-be/download/details.aspx?id=30653"><u><b>.NET Framework</b></u></a> ? Il est fort probable que celui-ci ne soit pas à jour et que le lancement du programme soit impossible s'il ne l'est pas.<br /><br />
					Après l'installation et la mise à jour du <a href="http://www.microsoft.com/fr-be/download/details.aspx?id=30653"><u><b>.NET Framework</b></u></a>, l'UpLauncher ne souhaite toujours pas s'exécuter, vérifiez que celui-ci est exécuté en tant qu'Administrateur.<br /><br />
					Sinon, veuillez vérifier que votre Antivirus ou Pare-Feu ne bloque pas l'application Neft-Gaming.
					<br /><br />
				</div>
			</div>
			
			<div class="accordion-tab" style="background:white;">
				<a href="#"><h3>Le chargement de mon jeu est bloqué à 50%/63%</h3></a>
				<div class="accordion-block"><div class="breaking-line" style="margin:0;position:relative;top:-15px;"></div>
					Veuillez vider complètement le cache du jeu, le menu pour vider le cache est accessible via l'engrenage présent en haut à droite de votre client <b>DOFUS</b>.</br>
					<i>Si vous n'avez pas accès à ce menu, passez directement à l'installation de <a href="http://download.piriform.com/ccsetup507.exe"><u><b>CCLEANER</b></u></a></i><br />
					L'option se trouve ici !<img src="http://i.imgur.com/FIEEGpW.png"></img><br />
					Si après avoir vidé le cache, vous êtes toujours bloqués à <b>50% ou 63%</b>, nous vous invitons à faire l'option <img src="http://i.imgur.com/S5dz8Xx.png"></img> sur l'<b>UpLauncher Neft-Gaming</b><br /><br />
					Veuillez installer si ce n'est pas déjà fait le programme <a href="http://download.piriform.com/ccsetup507.exe"><u><b>CCLEANER</b></u></a><br />
					Ensuite, allez désinstaller <a href="https://get.adobe.com/air/?loc=fr"><b><u>Adobe AIR</u></b></a> de vos programmes sur votre ordinateur<br />
					Puis, exécutez CCleaner, allez dans le menu Registre, puis cochez tout de cette façon <img src="http://i.imgur.com/tQZhEsZ.png"></img><br /><br />
					Une fois tout coché, pressez le bouton <img src="http://i.imgur.com/wLgolql.png"></img>, cela peut prendre un peu de temps...<br /><br />
					Une fois l'analyse terminée, cliquez sur le bouton <img src="http://i.imgur.com/da6ivmu.png"></img><br /><br />
					Pressez le bouton "Non" à la première pop-up, et à la deuxième <img src="http://i.imgur.com/DrwJuAy.png"></img>, attendez un peu...<br /><br />
					Une fois toutes les erreurs corrigées, réinstallez <a href="https://get.adobe.com/air/?loc=fr"><b><u>Adobe AIR</u></b></a> en le téléchargeant <a href="https://get.adobe.com/air/?loc=fr"><b><u>sur ce lien (cliquez-ici)</u></b></a><br /><br />
					Si après tout ça ça ne fonctionne pas, veuillez faire la touche <b>WINDOWS</b> ainsi que la touche <b>R</b> enfoncés simultanément sur votre clavier<br /><br />
					Une fenêtre s'ouvre, écrivez dedans <b>%appdata%</b>, votre Explorateur de Fichiers s'ouvre, supprimez tous les dossiers nommés Neft-Gaming ou Dofus, puis relancez votre jeu, ça devrait fonctionner maintenant !
					<br /><br />
				</div>
			</div>
		</div>
					
	</div>
	
	
	
