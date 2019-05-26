<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Vendre dans le marché des personnages"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

?>
<h2><span>test mail</span></h2>
<div class="content-padding">
<?php
									require 'config/phpmailerLIB/PHPMailerAutoload.php';
									$mail = new PHPMailer();
									$mail->IsSMTP();
									$mail->isHTML(true);
									$mail->CharSet = 'UTF-8';
									$mail->Host       = "smtp.alwaysdata.com"; // SMTP server example
									$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
									$mail->SMTPAuth   = true;                  // enable SMTP authentication
									$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
									$mail->Username   = "no-reply@Neft-Gaming.eu"; // SMTP account username example
									$mail->Password   = "Soulala775";        // SMTP account password example
									$mail->From = 'no-reply@Neft-Gaming.eu';
									$mail->FromName = 'Neft-Gaming';
									// $mail->Timeout = 5;

									$mail->addAddress('140691golberg@wanadoo.fr');
									$mail->Subject = 'Mise en vente de votre personnage test';
									ob_start();	
									?>
										<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
											"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
										<html xmlns="http://www.w3.org/1999/xhtml">
										<head>
											<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
											<title>Neft-Gaming</title>
											<style type="text/css">
												#outlook a{padding:0;}
												body{width:100% !important;} .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
												body{-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
												body{margin:0; padding:0;}
												img{height:auto; line-height:100%; outline:none; text-decoration:none;}
												#backgroundTable{height:100% !important; margin:0; padding:0; width:100% !important;}
											   p {
												   margin: 1em 0;
											   }
											   h1, h2, h3, h4, h5, h6 {
												   color: black !important;
												   line-height: 100% !important;
											   }
											   h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;} h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {color: red !important;}h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {color: purple !important;  }
											   .yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span { color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;}
											   </style>
										</head>
										<body>

											<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
											<tr>
											<td> 

											<table cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td width="300"></td>
													<td width="300"></td>
													<td width="300"></td>
												</tr>
											</table>  
											
											test
											</td>
											</tr>
											</tbody></table>  
										</body>
										</html>
									<?php
									$mail->Body = ob_get_contents();
									ob_end_clean();
									// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

									if(!$mail->send()) 
									{
										echo 'Impossible d\'envoyer l\'e-mail veuillez re-tenter plus tard.<br />';
									    echo "Mailer Error: " . $mail->ErrorInfo;
									}
									else echo 'parfait';
?>
</div>
