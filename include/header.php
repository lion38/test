<?php if(!defined("BASE_DS")) die(); ?>
		<!-- BEGIN #top-layer -->
		<div id="header-top-fixeddd">
			<div id="header-top">
				<div class="wrapper">
					<ul class="right">
						<?php
						if($_SESSION['Neft-Gaming_connecter'])
						{
						?>
						<li><a href="#drop-the-bass" style="font-weight:bold;padding-top:0;padding-bottom:0;line-height:41px;padding-left:0;"><img src="images/avatar_menu_top.png" style="width:33px;height:40px;margin-right:8px;" /> MON COMPTE : <span style="color:white;"><?php echo htmlspecialchars($COMPTE->Login); ?></span></a>
							<div class="drop">
								<ol class="notify-list"><li><a href="index.php?page=mon_compte" class="notify-content">Gérer mon compte</a></li></ol>
								<ol class="notify-list"><li><a href="index.php?page=achat" class="notify-content">Acheter des Ogrines <div class="ogrine_in_header adsdfdsfd" style="display:inline;text-shadow:0 0 0;"><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></div></a></li></ol>
								<ol class="notify-list"><li><a href="index.php?page=voter" class="notify-content">Voter pour Neft-Gaming</a></li></ol>
								
							<div class="notify-footer" style="border-top:2px solid #e5e5e5;"><a href="index.php?page=deconnection">Se déconnecter</a></div>
							</div>
						</li>
						<?php
						}
						else
						{
						?>
							<li><a href="index.php?page=login" style="color:white;font-weight:bold;"><i class="fa fa-user"></i> &nbsp; Se connecter</a></li>
						<?php
						}
						?>
						
						<li class="tohideVerySmallResponsive"><a href="https://www.facebook.com/Neft-Gamingdofus" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li class="tohideVerySmallResponsive"><a href="https://twitter.com/Neft-Gamingfr" target="_blank"><i class="fa fa-twitter"></i></a></li>
					</ul>
					<ul class="load-responsive" rel="Navigation">
						<li style="margin-left:1px;"><a href="index.php" style="color:white;background:rgba(0,0,0,0.2);"><i class="fa fa-home"></i> Accueil</a></li>
						<?php
						if($_SESSION['Neft-Gaming_connecter'])
						{
						?>
							<li><a href="index.php?page=achat" style="color:white;">Acheter des <strong>Ogrines/Jetons</strong> <small class="ogrine_in_header"><?php echo $COMPTE->Tokens + $COMPTE->NewTokens; ?></small></a></li>
							<li><a href="index.php?page=voter" style="color:white;">Voter pour <strong>Neft-Gaming</strong></a></li>
						<?php
							if(isset($COMPTE->Login) AND in_array(strtolower($COMPTE->Login), $CONFIG['administration_login_allowed']) OR in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']))
							{
							?>
								<li style="background: rgba(204,29,29,0.45);"><a href="index.php?page=administration" style="color:#ff8888;text-shadow:2px 4px 2px #690c0c;font-family:'Open Sans';font-size:15px;"><i class="fa fa-plug" style="color:#ffdcdc;"></i>&nbsp;<strong>Administration</strong></a></li>
							<?php
							}
						}
						else
						{
						?>
							<li><a href="index.php?page=inscription" style="color:white;font-weight:bold;">Inscription</a></li>
						<?php
						}
						?> 
					</ul>
				</div>
			</div>
		</div>
		<div id="top-layer">
			<section id="content">
				<header id="header" <?php if($page != 'accueil') echo 'class="needsmallpadding"'; ?>>
					<div id="menu-bottom">
						<!-- <nav id="menu" class="main-menu width-fluid"> -->
						<nav id="menu" class="main-menu">
							<div class="blur-before"></div>
							<a href="index.php" class="header-logo left" style="padding-right:0;"><span class="logoInHeader"></span></a>
							<a href="#dat-menu" class="datmenu-prompt"><i class="fa fa-bars"></i>Afficher le menu</a>
							<ul class="load-responsive" rel="Menu">
								<li><a href="<?php echo $CONFIG['forum']; ?>" target="_blank"><i class="fa fa-comments"></i><strong style="font-weight:bold;font-family:Verdana;">FORUM</strong></a></li>
								<li><a href="index.php?page=nous_rejoindre"><i class="fa fa-users"></i><strong style="font-weight:bold;">Nous rejoindre</strong></a></li>
						<?php
						if(!$_SESSION['Neft-Gaming_connecter'])
						{
						?>
								<li><a href="index.php?page=inscription"><i class="fa fa-user"></i><strong style="font-weight:bold;">Inscription</strong></a></li>
						<?php
						}
						?>
								<li><a href="index.php?page=voter"><i class="fa fa-circle-o-notch"></i><strong style="font-weight:bold;">VOTER</strong></a></li>
								<li><a href="index.php?page=boutique"><span><i class="fa fa-shopping-cart"></i><strong style="font-weight:bold;">Boutique</strong></span></a>
									<ul class="sub-menu">
										<li><a href="index.php?page=boutique" style="color:white;">Informations sur la boutique</a></li>
										<li><a href="index.php?page=achat" style="color:white;">Acheter des Ogrines</a></li>
									</ul>
								</li>
						<?php
						if($_SESSION['Neft-Gaming_connecter'])
						{
						?>
								<li><a href="index.php?page=achat"><i class="fa fa-gift"></i><strong style="font-weight:bold;">Acheter des Ogrines</strong></a></li>
						<?php
						}
						?>
								<li><a href="index.php?page=classement"><span><i class="fa fa-trophy"></i><strong style="font-weight:bold;">Classement</strong></span></a>
									<ul class="sub-menu">
										<li><a href="index.php?page=classement#tabs-pvm" style="color:white;"><div style="display:inline;color:#bbbbbb;">Classement</div> PVM</a></li>
										<li><a href="index.php?page=classement#tabs-pvp" style="color:white;"><div style="display:inline;color:#bbbbbb;">Classement</div> PVP</a></li>
										<li><a href="index.php?page=classement#tabs-kolizeum" style="color:white;"><div style="display:inline;color:#bbbbbb;">Classement</div> Kolizeum</a></li>
										<li><a href="#tabs-guildes" style="color:white;"><div style="display:inline;color:#bbbbbb;">Classement</div> Guildes</a></li>
									</ul>
								</li>
								
						<?php
						$afficherButtonAdmininistrationInHeader=false;
						if($_SESSION['Neft-Gaming_connecter'])
						{
							if(isset($COMPTE->Login) AND in_array(strtolower($COMPTE->Login), $CONFIG['administration_login_allowed']) OR in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']))
							{
								$afficherButtonAdmininistrationInHeader=true;
							}
						}
						if($afficherButtonAdmininistrationInHeader)
						{
						?>
						<li style="float:right;"><a href="index.php?page=administration"><i class="fa fa-plug"></i><strong style="font-family:'Open Sans';font-size:15px;font-weight:bold;">Administration</strong></a></li>
						<?php
						}
						else
						{
						?>
						<li style="float:right;"><a target="_blank" href="https://discord.gg/quZ9VZ3"><i class="fa fa-microphone"></i><strong style="font-family:'Open Sans';font-size:15px;font-weight:bold;">Discord</strong></a></li>
						<?php
						}
						?> 
							</ul>
						</nav>
					</div>
					<?php 
					if($page == 'accueil') 
					{
					?>
					<div id="slider">
						<div id="slider-info">
							<div class="padding-box">
								<ul>
									<li>
										<h2><a href="post.html">Neft-Gaming, le serveur d'excellence</a></h2>
										<p>Bienvenue sur un serveur équilibré, modéré avec une équipe prête à tout pour vous assister et hébergé sur une infrastructure stable et protégée !</p>
										<a href="http://Neft-Gaming.eu/index.php?page=nous_rejoindre" class="read-more-r">Je rejoins Neft-Gaming !</a>
									</li>
									<li class="dis">
										<h2><a href="post.html">Une boutique non Pay2Win</a></h2>
										<p>Notre boutique ne dénaturalise pas le jeu et n'avantage en aucun cas les joueurs ayant effectué des donations, cependant vous pouvez toujours acheter des Ogrines !</p>
										<a href="http://Neft-Gaming.eu/index.php?page=achat" class="read-more-r">J'achète des Ogrines !</a>
									</li>
									<li class="dis">
										<h2><a href="post.html">Un forum communautaire actif</a></h2>
										<p>La communauté de Neft-Gaming est extrèmement active sur le forum, venez participer à la vie du serveur et débattre avec l'équipe et les joueurs !</p>
										<a href="http://forum.Neft-Gaming.eu/" class="read-more-r">J'accède au forum !</a>
									</li>
									<li class="dis">
										<h2><a href="post.html">Voter et gagner des Ogrines !</a></h2>
										<p>Vous pouvez gagner des Ogrines en votant pour le serveur, avec les Ogrines achetez des objets et faites vous plaisir en jeu !</p>
										<a href="http://Neft-Gaming.eu/index.php?page=voter" class="read-more-r">Je vote !</a>
									</li>
								</ul>
							</div>
							<a href="javascript: featSelect(1);" id="featSelect-1" class="featured-select this-active">
								<span class="w-bar" id="feat-countdown-bar-1">.</span>
								<span class="w-coin" id="feat-countdown-1">0</span>
								<img src="images/photos/image-1.jpg" alt="" title="" />
							</a>
							<a href="javascript: featSelect(2);" id="featSelect-2" class="featured-select">
								<span class="w-bar" id="feat-countdown-bar-2">.</span>
								<span class="w-coin" id="feat-countdown-2">0</span>
								<img src="images/photos/image-4.jpg" alt="" title="" />
							</a>
							<a href="javascript: featSelect(3);" id="featSelect-3" class="featured-select">
								<span class="w-bar" id="feat-countdown-bar-3">.</span>
								<span class="w-coin" id="feat-countdown-3">0</span>
								<img src="images/photos/image-3.jpg" alt="" title="" />
							</a>
							<a href="javascript: featSelect(4);" id="featSelect-4" class="featured-select">
								<span class="w-bar" id="feat-countdown-bar-4">.</span>
								<span class="w-coin" id="feat-countdown-4">0</span>
								<img src="images/photos/image-2.jpg" alt="" title="" />
							</a>
						</div>
					</div>
					<?php 
					}
					else
					{
					?>
					<div class="wrapper" style="width:100%;border:0;">
						<div class="header-breadcrumbs" style="">
							<div class="container hidden-whenphone" style="margin-top:40px;padding:0;text-align:center;border:0;">

								
								<a id="marcheHeaderTitle" href="index.php?page=achat_personnages"><h2>Marché des personnages :</h2></a>
								<div class="marchePersoBoxedHeader">
									<div class="marchePersoBoxedHeaderInner">
													<?php
													$cache_to_read = $CONFIG['cache_folder'].'marche_des_personnages_slider.cache';
													$MARCHE_PERSO_SLIDER = ''; // array des perso en slider
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
													$nb_picture_haut = 0;
													foreach($unserializedSlider as $row)
													{
														$nb_picture_haut++;
														$classToUse = '';
														if($nb_picture_haut <= 1) $classToUse = 'visible-phone visible-tablet visible-desktop';
														elseif($nb_picture_haut <= 3) $classToUse = 'visible-tablet visible-desktop';
														elseif($nb_picture_haut <= 6) $classToUse = 'visible-desktop';
													?>
														<div>
														<a href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>" title="<?php echo str_replace('"', "", str_replace("'", "", $row['nomPerso'])); ?>">
															<div class="mini_perso_details">
																<div class="mini_perso_classe"><strong><?php echo $classe[$row['classe']]; ?></strong></div>
																<div class="mini_perso_level">Niveau <strong><?php echo $row['level']; ?></strong></div>
															</div>
															<img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="<?php echo str_replace('"', "", str_replace("'", "", $row['nomPerso'])); ?>" />
														</a>
														</div>
													<?php
													}
													
													if($nb_picture_haut == 0)
													{
													?>
														<a href="index.php?page=vendre_personnages" class="aucun_perso_en_vente_menudroite">Aucun personnage en vente</a>
													<?php
													}
													?>
									</div>
								</div>
							</div>
							<?php
							if($nb_picture_haut > 1)
							{
							?>
							<script>
								(function($) {
									$(function() {
										$(".marchePersoBoxedHeaderInner").simplyScroll({
											customClass: 'custom',
											direction: 'forwards',
											orientation: 'horizontal',
											frameRate: 24,
											speed: 1,
											auto: true,
											autoMode: 'bounce'
										});
									});
								})(jQuery);
							</script>
							<?php
							}
							?>
							<br />
							<div id="breadcrumnephh">
								<h2 class="right"><?php echo $page_title; ?></h2>
								<ul>
									<li class="hidden-whenphone"><a href="index.php">Accueil</a></li>
									<li><a href="index.php?page=<?php echo $page; ?>"><?php echo $page_title; ?></a></li>
								</ul>
							</div>
						</div>
					</div>
					<?php 
					}
					?>
					
				</header>
				<div id="main-box" <?php if($page_is_full_width) echo 'class="full-width"'; ?>>
				
					<?php if(!$page_is_full_width) echo '<div id="sidebarBottomAfficherAll">&nbsp;</div>'; ?>