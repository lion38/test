<?php if(!defined("BASE_DS")) die(); ?>

<?php 
if(!$page_is_full_width)
{
?>
					<!-- BEGIN #sidebar -->
					<aside id="sidebar">
						
						<!-- BEGIN .panel -->
						<div class="panel">
							<h2>Personnages du marché</h2>
							<div class="panel-content" style="width:100%;">
								
								<div style="width:100%;margin:auto;">
								<?php
								
								$cache_to_read = $CONFIG['cache_folder'].'marche_des_personnages_slider.cache';
								if(!isset($MARCHE_PERSO_SLIDER)) $MARCHE_PERSO_SLIDER = ''; // array des perso en slider
								$expire = time() - $CONFIG['cache_news_seconde']; // TEMP CACHE CLASSEMENT
														
								if(file_exists($cache_to_read) && filemtime($cache_to_read) > $expire)
								{
									$MARCHE_PERSO_SLIDER = file_get_contents($cache_to_read);
								}
								else
								{
									ob_start();	
									$query = $Sql->prepare('SELECT id,nomPerso,classe,level,timetampStartVente,id_perso FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? ORDER BY timetampStartVente DESC LIMIT 20');
									$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente']));
									$rowSlider = $query->fetchAll();
									$query->closeCursor();
									echo serialize($rowSlider);
									$MARCHE_PERSO_SLIDER = ob_get_contents();
									ob_end_clean();
									file_put_contents($cache_to_read, $MARCHE_PERSO_SLIDER);
								}
								
								$unserializedSlider = unserialize($MARCHE_PERSO_SLIDER);
								$nb_picture_droite = 0;
								foreach($unserializedSlider as $row)
								{
									$nb_picture_droite++;
									if($nb_picture_droite > 6) break;
								?>
									<a href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>" class="mini_perso_menu mini_perso_menu_clair" title="<?php echo str_replace('"', "", str_replace("'", "", $row['nomPerso'])); ?>">
										<div class="mini_perso_details">
											<div class="mini_perso_classe"><strong><?php echo $classe[$row['classe']]; ?></strong></div>
												<div class="mini_perso_level">Niveau <strong><?php echo $row['level']; ?></strong></div>
											</div>
											<img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="<?php echo str_replace('"', "", str_replace("'", "", $row['nomPerso'])); ?>" />
									</a>
								<?php
								}

								?>
								</div>
								<?php
								if($nb_picture_droite == 0)
								{
								?>
									<a href="index.php?page=vendre_personnages" style="clear:left;position:relative;left:-10px;margin-bottom:0;" class="aucun_perso_en_vente_menudroite" title="">Aucun personnage en vente</a>
								<?php
								}
								else
								{
								?>
								<a href="index.php?page=achat_personnages" class="voirplusdepersonnages_menu" style="clear:left;position:relative;left:-10px;">Voir plus de personnages</a>
								<?php
								}
								if($_SESSION['Neft-Gaming_connecter'])
								{
								?>
										<a href="index.php?page=vendre_personnages" class="vendrelundesmiens_menu" style="clear:left;position:relative;left:-10px;">Je veux vendre l'un des miens</a>
										<a href="index.php?page=historique_marche_personnage" class="vente_en_cours_achat_precedent" style="clear:left;position:relative;left:-10px;">Vente en cours / Achat précédent</a>
								<?php
								}
								?>
							</div>
						<!-- END .panel -->
						</div>
						
						<!-- BEGIN .panel -->
						<div class="panel">
							<h2>Nous suivre</h2>
							<div class="panel-content" style="100%">
							
								<div class="fb-page" data-href="https://www.facebook.com/Neft-Gaming" data-width="360" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/Neft-Gamingdofus"><a href="https://www.facebook.com/Neft-Gamingdofus">Neft-Gaming</a></blockquote></div></div>
								<br /><br />
								<a class="twitter-timeline"  href="https://twitter.com/L1onTV" data-widget-id="1118567046994890753">Tweets de @Neft-Gamingfr</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
											
							</div>
						<!-- END .panel -->
						</div>
	
					<!-- END #sidebar -->
					<br /><br /><br /><br /><br />
					</aside>
<?php 
}
?>
					<div id="main">