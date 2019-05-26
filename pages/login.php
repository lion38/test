<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Se connecter"; // Nom de la page dans le content
$page_is_full_width = true; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

if($_SESSION['Neft-Gaming_connecter']) { header('Location: '.$CONFIG['URL_SITE'].'index.php'); die();  }
?>
						<div class="signup-panel">

							<div class="left">
								<h2><span>Se connecter</span></h2>
								<div class="content-padding">

									<div class="login-passes">

									<div class="the-form" style="margin-top:40px;">
										<form action="<?php if($page == 'deconnection') echo 'index.php'; ?>" method="post" autocomplete="off">

											<?php
											if(isset($error_show['connexion_login']))
											{
											?>
												<p>
													<span class="the-error-msg"><i class="fa fa-warning"></i><?php echo $error_show['connexion_login']; ?></span>
												</p>
											<?php
											}
											?>

											<p>
												<label for="login_username">Nom de compte :</label>
												<input type="text" name="login" id="login_username" value="" />
											</p>

											<p>
												<label for="login_password">Mot de passe :</label>
												<input type="password" name="passlog" id="login_password" value="" />
											</p>

											<p class="form-footer">
												<input type="submit" name="logon" class="button big-size" style="margin-bottom:5px;background-color: #519623;" id="login_submit" value="Se connecter" />
											</p>
										</form>
									</div>
									</div>

											<p class="clearfix doborderneph" style="margin-bottom:5px;line-height:20px;background:white;">
												<span class="info-msg" style="margin-top:0;background:#3a99dc;color:white;font-size:0.90em;">
													<a href="index.php?page=inscription" style="color:white;font-weight:bold;">Inscrivez-vous</a> sur Neft-Gaming si vous ne possédez pas de compte !<br />
												</span>
											</p>
											<p class="clearfix doborderneph" style="margin-bottom:0;line-height:20px;background:white;">
												<span class="info-msg" style="margin-top:0;background:#dc643a;color:white;font-size:0.90em;">
													<a href="index.php?page=lostpassword" style="color:white;font-weight:bold;">Cliquez-ici</a> si vous avez perdu votre mot de passe !
												</span>
											</p>

								</div>
							</div>

							<div class="right">
								<h2><span>Connexion au site</span></h2>
								<div class="content-padding">
									
									<div class="form-split-about">
										<p class="p-padding"><b>Connectez vous</b> sur le site et accédez à diverses fonctionnalités aussi utiles les unes que les autres ! <b>Achat d'Ogrines</b>, <b>Gestion de compte</b> et bien plus encore vous y attendent !</p>

										<ul>
											<li>
												<i class="fa fa-picture-o"></i>
												<b>Attention à vos identifiants</b>
												<p class="p-padding">Nous garantissons une sécurité optimale concernant vos comptes et données, cependant il est fortement déconseillé de <b>prêter</b> ses identifiants à d'autres joueurs !</p>
											</li>
											
											<li>
												<i class="fa fa-trophy"></i>
												<b>Rejoindre le serveur Neft-Gaming</b>
												<p class="p-padding">Nombreux joueurs vous attendent, qu'attendez-vous pour nous rejoindre ? Inscrivez-vous et venez jouer dès maintenant !<br />
												<a href="http://files.Neft-Gaming.com/Neft-Gaming.exe"><u><b>Je télécharge Neft-Gaming</b></u></a></p>
											</li>

											<li>
												<i class="fa fa-microphone"></i>
												<b>Serveur vocal à disposition !</b>
												<p class="p-padding">Un serveur <b>Discord</b> gratuit, accueillant et peuplé vous attends sur Neft-Gaming.<br />
												<a href="https://discord.gg/quZ9VZ3"><u><b>Accéder au serveur vocal</b></u></a></p>
											</li>
											
											<li>
												<i class="fa fa-comments"></i>
												<b>Vous n'êtes pas seul !</b>
												<p class="p-padding">Communiquez librement avec toute la communauté de Neft-Gaming sur notre forum !<br />
												<a href="http://forum.Neft-Gaming.com/"><u><b>Découvrir le forum en cliquant-ici</b></u></a></p>
											</li>
										</ul>
										
									</div>
									
								</div>
							</div>

							<div class="clear-float"></div>
						</div>
