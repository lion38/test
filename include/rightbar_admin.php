<?php
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!$page_is_full_width)
{
?>
<link href='https://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
					<!-- BEGIN #sidebar -->
					<aside id="sidebar">
						
						<!-- BEGIN .panel -->
						<div class="panel">
							<h2>Navigation : <span style="color:#b10000;">Panel staff</span></h2>
							<div class="panel-content no-padding" style="width:100%;">
								<br />
										<?php
										/* Les pages pour les staff : ACCES LIMITE */
										if(isset($COMPTE->Login) AND in_array(strtolower($COMPTE->Login), $CONFIG['administration_login_allowed']) OR in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']))
										{
										?> 
										<ul class="menunephdroit">
											<li><a href="index.php?page=administration"><span style="color:initial;" class="icon-home"></span> Accueil administration</a></li>
											<li><a href="index.php?page=administration&amp;action=gerer_event"><span style="color:initial;" class="icon-pencil"></span> Gérer les events</a></li>
										</ul>
										<?php
										}
										?>
										<br />
										<?php
										/* /!\ Les pages pour les chef staff : Acces limité + poussé /!\*/
										if(isset($COMPTE->Login) AND in_array(strtolower($COMPTE->Login), $CONFIG['administration_CHEF_STAFF']))
										{
										?> 
										<ul class="menunephdroit">
											<li><a href="index.php?page=administration&amp;action=dons_ogrines"><span style="color:red;" class="icon-code"></span> Donner des Ogrines</a></li>
											<li><a href="index.php?page=administration&amp;action=rechercher"><span style="color:gray;" class="icon-search"></span> Faire une recherche</a></li>
										</ul>
										<?php
										}
										?>
										
										<?php
										/* /!\ Les pages pour les fondateurs : Acces illimité /!\*/
										if(isset($COMPTE->Login) AND in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']))
										{
										?> 
										<ul class="menunephdroit">
											<li><a href="index.php?page=administration&amp;action=gerer_news"><span style="color:blue;" class="icon-pencil"></span> Gérer les news</a></li>
											<li><a href="index.php?page=administration&amp;action=stat_achat"><span style="color:green;" class="icon-basket"></span> Voir les stats d'achat</a></li>
											<li><a href="index.php?page=administration&amp;action=dons_ogrines"><span style="color:red;" class="icon-code"></span> Donner des Ogrines</a></li>
											<li><a href="index.php?page=administration&amp;action=vote_multi"><span style="color:initial;" class="icon-spin6"></span> Voir les votes suspects</a></li>
											<li><a href="index.php?page=administration&amp;action=rechercher"><span style="color:initial;" class="icon-search"></span> Faire une recherche</a></li>
											<li><a href="index.php?page=administration&amp;action=marche_des_personnages_les_ventes"><span style="color:initial;" class="icon-chart-line"></span> Marché des personnages : Les ventes</a></li>
											<li><a href="index.php?page=administration&amp;action=marche_des_personnages_debug"><span style="color:initial;" class="icon-chart-line"></span> Marché des personnages : Debug</a></li>
										</ul>
										<br />
										<ul class="menunephdroit">
											<li><a href="index.php?page=administration&amp;action=mongologger" target="_blank"><span style="color:initial;" class="icon-search"></span> MONGO Log</a></li>
										</ul>
										<?php
										}
										?>
								<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
							</div>
						<!-- END .panel -->
						</div>
	
					<!-- END #sidebar -->
					</aside>
<?php 
}
?>
					<div id="main">