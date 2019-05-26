<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']) AND !in_array(strtolower($COMPTE->Login), $CONFIG['administration_CHEF_STAFF'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Recherche"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');

$SHOW_FORM_SEARCH = TRUE;
$table_object_character = false;
$table_object_account = false;
$error_to_show = '';
$TOFIND_from = ''; // accounts character
$TOFIND_type = ''; // Id Login etc
$TOFIND_value = ''; // azerty 127.0.0.1 etc

$CONFIG_FIND_ARRAY = array(
	'account' => array(
		'login',
		'LastHardwareId',
		'email',
		'ip',
		'id'
	),
	'character' => array(
		'name',
		'id'
	)
);

if(isset($_GET['from'], $_GET['value'], $_GET['type']) AND !empty($_GET['from']) AND !empty($_GET['value']) AND !empty($_GET['type']))
{
	$TOFIND_from = (array_key_exists(strtolower($_GET['from']), $CONFIG_FIND_ARRAY)) ? strtolower($_GET['from']) : '';
	if($TOFIND_from != '')
	{
		$TOFIND_type = (in_array(strtolower($_GET['type']), $CONFIG_FIND_ARRAY[$TOFIND_from])) ? strtolower($_GET['type']) : '';
		$TOFIND_value = trim(urldecode($_GET['value']));
	}
}

if(isset($_POST['account_submit']))
{
	$TOFIND_from = 'account';
	$TOFIND_type = (isset($_POST['account_type']) AND in_array(strtolower($_POST['account_type']), $CONFIG_FIND_ARRAY['account'])) ? strtolower($_POST['account_type']) : '';
	$TOFIND_value = (isset($_POST['account_value']) AND !empty($_POST['account_value'])) ? trim($_POST['account_value']) : '';
}
elseif(isset($_POST['character_submit']))
{
	$TOFIND_from = 'character';
	$TOFIND_type = (isset($_POST['character_type']) AND in_array(strtolower($_POST['character_type']), $CONFIG_FIND_ARRAY['character'])) ? strtolower($_POST['character_type']) : '';
	$TOFIND_value = (isset($_POST['character_value']) AND !empty($_POST['character_value'])) ? trim($_POST['character_value']) : '';
}


if($TOFIND_type != '' AND $TOFIND_value != '')
{
	// SI ON FAIT UNE DEMANDE SUR LA TABLE PERSONNAGES
	if($TOFIND_from == 'character')
	{
		$champToSeek = '';
		$champToSeek = ($TOFIND_type == 'name') ? 'Name' : $champToSeek;
		$champToSeek = ($TOFIND_type == 'id') ? 'Id' : $champToSeek;

		$resultado = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.characters WHERE '.$champToSeek.' = ?') or die ($error);
		$resultado->execute(array($TOFIND_value));
		$resultado->setFetchMode(PDO::FETCH_OBJ);
		$table_object_character = $resultado->fetchAll();
		$resultado->closeCursor();
		// Si il y as des perso
		if($table_object_character)
		{
			$query = $Sql->prepare('SELECT DISTINCT r.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE p.'.$champToSeek.' = ? AND p.Id = a.CharacterId AND a.AccountId = r.Id AND a.WorldId = 1');
			$query->execute(array($TOFIND_value));
			$query->setFetchMode(PDO::FETCH_OBJ);
			$table_object_account = $query->fetchAll();
			$query->closeCursor();
		}
		else $error_to_show = 'Le personnage avec comme valeur <strong>'.htmlspecialchars($TOFIND_value).'</strong> en <strong>'.$champToSeek.'</strong> n\'existe pas.';
	}
	// SI ON FAIT UNE DEMANDE SUR LA TABLE COMPTES
	elseif($TOFIND_from == 'account')
	{
		$champToSeek = '';
		$champToSeek = ($TOFIND_type == 'login') ? 'Login' : $champToSeek;
		$champToSeek = ($TOFIND_type == 'LastHardwareId') ? 'LastHardwareId' : $champToSeek;
		$champToSeek = ($TOFIND_type == 'email') ? 'Email' : $champToSeek;
		$champToSeek = ($TOFIND_type == 'id') ? 'Id' : $champToSeek;
		$champToSeek = ($TOFIND_type == 'ip') ? 'ip' : $champToSeek;
		if($champToSeek == 'ip')
		{
			$resultado = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.accounts WHERE last_ip_web = ? OR LastConnectedIp = ?') or die ($error);
			$resultado->execute(array($TOFIND_value, $TOFIND_value));
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$table_object_account = $resultado->fetchAll();
			$resultado->closeCursor();
		}
		else
		{
			$resultado = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.accounts WHERE '.$champToSeek.' = ?') or die ($error);
			$resultado->execute(array($TOFIND_value));
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$table_object_account = $resultado->fetchAll();
			$resultado->closeCursor();
		}
		// Si il y as des comptes
		if($table_object_account)
		{
			// Si il n'y as qu'un compte
			if(count($table_object_account) == 1)
			{
				$query = $Sql->prepare('SELECT DISTINCT p.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE a.AccountId = ? AND p.Id = a.CharacterId AND a.AccountId = r.Id AND a.WorldId = 1');
				$query->execute(array($table_object_account[0]->Id));
				$query->setFetchMode(PDO::FETCH_OBJ);
				$table_object_character = $query->fetchAll();
				$query->closeCursor();
			}
		}
		else $error_to_show = 'Le compte avec comme valeur <strong>'.htmlspecialchars($TOFIND_value).'</strong> en <strong>'.$champToSeek.'</strong> n\'existe pas.';
	}
}

if($TOFIND_from != '' AND $TOFIND_type != '' AND $TOFIND_value != '')
{
?>
<div class="content-padding" style="background:white;padding-top:10px;padding-bottom:10px;border:1px solid #e0e0e0;border-width:1px 0;">
	<h3 style="text-align:center;margin:0px auto;">Recherche sur <span style="color:gray;"><?php echo ucfirst($TOFIND_from); ?></span> de type <span style="color:blue;"><?php echo ucfirst($TOFIND_type); ?>'</span> pour la valeur <span style="color:green;"><?php echo htmlspecialchars(ucfirst($TOFIND_value)); ?></span></h3>
</div>
<div class="breaking-line"></div>
<?php
}

if($error_to_show != '')
{
?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_to_show; ?></span>
<?php
}

if($table_object_account)
{
?>
	<h2 style="margin-bottom:0;"><span>Informations Comptes (<?php echo count($table_object_account); ?>):</span></h2>
	<div class="content-padding" style="background:white;padding-top:10px;padding-bottom:10px;border:1px solid #e0e0e0;border-width:1px 0;">
	<table class="bordered bordered-purple">
		<thead>
			<tr>
				<th style="text-align:center;width:50px;">Id</th>
				<th>NDC</th>
				<th style="text-align:center;">LastHardwareId</th>
				<th>Email</th>
				<th style="text-align:center;width:10%;">IP</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($table_object_account as $comptee)
		{
			if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']) AND $comptee->UserGroupId > 3)
			{
				$comptee->last_ip_web = $comptee->LastConnectedIp = '127.0.0.1';
				$comptee->Email = '';
			}
		?>
			<tr style="font-family:Verdana;">
				<td style="text-align:center;line-height:33px;"><strong><a style="color:black;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=id&amp;value=<?php echo urlencode($comptee->Id); ?>"><?php echo $comptee->Id; ?></a></strong></td>
				<td style="line-height:33px;"><a style="color:black;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=login&amp;value=<?php echo urlencode($comptee->Login); ?>"><?php echo htmlspecialchars($comptee->Login); ?></a></td>
				<td style="text-align:center;line-height:33px;"><a style="color:green;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=LastHardwareId&amp;value=<?php echo urlencode($comptee->LastHardwareId); ?>"><?php echo $comptee->LastHardwareId; ?></a></td>
				<td style="text-align:center;line-height:33px;"><a href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=email&amp;value=<?php echo urlencode($comptee->Email); ?>"><?php echo htmlspecialchars($comptee->Email); ?></a></td>
				<td style="text-align:left;font-family:verdana;">wb:<a style="color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=ip&amp;value=<?php echo urlencode($comptee->last_ip_web); ?>"><?php echo $comptee->last_ip_web; ?></a><br />ig:<a style="color:blue;" href="index.php?page=administration&amp;action=rechercher&amp;from=account&amp;type=ip&amp;value=<?php echo urlencode($comptee->LastConnectedIp); ?>"><?php echo $comptee->LastConnectedIp; ?></a></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
</div>
<?php
	if(count($table_object_account) == 1)
	{
	?>
	<div class="split" style="margin:15px 0 5px 0;background:white;border:1px solid #e0e0e0;border-width:1px 0;">
					<!-- left -->
					<div class="size6" style="font-family:verdana;">
							<div class="clearfix widget-sidebar ui-content aot_listing_widget">
								<div class="widget-category-listing">
									<div class="widget-category-item" style="overflow:hidden;" >
										<a class="category-1" style="padding:5px;">
										<span style="line-height:28px;">Pseudonyme :</span> <span class="category-count right bg" style="padding:7px 20px;width: 250px;text-indent: 0;"><?php echo htmlspecialchars(ucfirst($table_object_account[0]->Nickname)); ?></span>
										</a>
									</div>
									<div class="widget-category-item" style="overflow:hidden;">
										<a class="category-1" style="padding:5px;">
										<span style="line-height:28px;">Rang :</span> <span class="category-count right bg" style="padding:7px 20px;width: 250px;text-indent: 0;"><?php echo intval($table_object_account[0]->UserGroupId); ?></span>
										</a>
									</div>
									<div class="widget-category-item" style="overflow:hidden;">
										<a class="category-1" style="padding:5px;">
										<span style="line-height:28px;">CreationDate :</span> <span class="category-count right bg" style="padding:7px 20px;width: 250px;text-indent: 0;"><?php echo htmlspecialchars(ucfirst($table_object_account[0]->CreationDate)); ?></span>
										</a>
									</div>
								
									<div class="widget-category-item" style="overflow:hidden;">
										<a class="category-1" style="padding:5px;">
										<?php
										$lastconectx = (!empty($table_object_account[0]->LastConnection)) ? $table_object_account[0]->LastConnection : 'Jamais connecté';
										?>
										<span style="line-height:28px;">LastConnection :</span> <span class="category-count right bg" style="padding:7px 20px;width: 250px;text-indent: 0;"><?php echo $lastconectx; ?></span>
										</a>
									</div>
								</div>
							</div>
					</div>
					<!-- right -->
					<div class="size6" style="font-family:verdana;">
							<div class="clearfix widget-sidebar ui-content aot_listing_widget">
								<div class="widget-category-listing">
									<div class="widget-category-item" style="overflow:hidden;">
										<?php
										$banni_show = ($table_object_account[0]->IsBanned == 1) ? 'Oui' : 'Non';
										$banni_color_show = ($banni_show == 'Oui') ? 'red' : 'green';
										?>
										<a class="category-1" style="padding:5px;">
										<span style="line-height:28px;">Banni :</span> <span class="category-count right bg-<?php echo $banni_color_show; ?>" style="padding:7px 20px;text-indent: 0;text-align:center;font-weight:bold;"><?php echo $banni_show; ?></span>
										</a>
									</div>
									<div class="widget-category-item" style="overflow:hidden;">
										<a class="category-1" style="padding:5px;">
										<?php
										$last_vote_show = (isset($table_object_account[0]->LastVote)) ? htmlspecialchars(ucfirst($table_object_account[0]->LastVote)) : 'Aucun';
										?>
										<span style="line-height:28px;">LastVote :</span> <span class="category-count right bg" style="padding:7px 20px;text-indent: 0;text-align:center;"><?php echo $last_vote_show; ?></span>
										</a>
									</div>
									<div class="widget-category-item" style="overflow:hidden;">
									<?php
									$vote_show = ($table_object_account[0]->Votes > 0) ? $table_object_account[0]->Votes : 0;
									?>
										<a class="category-2" style="padding:5px;">
										<span style="line-height:28px;">Nombres de votes :</span> <span class="category-count right bg" style="padding:7px 20px;text-indent: 0;text-align:center;font-weight:bold;"><?php echo $vote_show; ?></span>
										</a>
									</div>
									<div class="widget-category-item" style="overflow:hidden;">
										<a class="category-23" style="padding:5px;">
										<span style="line-height:28px;">Nombres d'Ogrines :</span> <span class="category-count right bg" style="padding:7px 20px;text-indent: 0;text-align:center;font-weight:bold;"><?php echo $table_object_account[0]->Tokens; ?> + <?php echo $table_object_account[0]->NewTokens; ?></span>
										</a>
									</div>
								</div>
							</div>
					</div>
		</div>
	<?php
	}
	?>
	<?php
}
if($table_object_character)
{
?>
	<h2 style="margin-bottom:0;"><span>Informations Personnages :</span></h2>
	<div class="content-padding" style="background:white;padding-top:10px;padding-bottom:10px;border:1px solid #e0e0e0;border-width:1px 0;">
	<table class="bordered bordered-blue">
		<thead>
			<tr>
				<th style="text-align:center;width:50px;">Id</th>
				<th>Nom du personnage</th>
				<th style="text-align:center;">Classe</th>
				<th style="width:2%;">Niveau</th>
				<th style="text-align:center;width:20%;">Expérience</th>
				<th style="text-align:center;width:5%;">Honneur</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$resultado = $result = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.experiences') or die ($error);
		$resultado->execute();
		$XP_TABLE = $resultado->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
		$resultado->closeCursor();
		foreach($table_object_character as $perso)
		{
		$colorToSex = ($perso->Sex) ? '#e80068' : '#1371e5'; // 1er meuf 2eme male
		switch ($perso->AlignmentSide) {
			case 0:
				$colorToHonor = 'black'; // Neutre
				break;
			case 1:
				$colorToHonor = '#00a9ef'; // Bonta
				break;
			case 2:
				$colorToHonor = '#cc0000'; // Brack
				break;
			case 3:
				$colorToHonor = '#f67a00'; // Mercenaire
				break;
			default:
			   $colorToHonor = 'black'; // Unknow
		}
		?>
			<tr style="font-family:Verdana;">
				<td style="text-align:center;"><strong><a style="color:black;" href="index.php?page=administration&amp;action=rechercher&amp;from=character&amp;type=id&amp;value=<?php echo urlencode($perso->Id); ?>"><?php echo $perso->Id; ?></a></strong></td>
				<td><a style="color:gray;" href="index.php?page=administration&amp;action=rechercher&amp;from=character&amp;type=name&amp;value=<?php echo urlencode($perso->Name); ?>"><?php echo htmlspecialchars($perso->Name); ?></a></td>
				<td style="text-align:center;"><span style="color:<?php echo $colorToSex; ?>;font-weight:bold;"><?php echo $classe[$perso->Breed]; ?></span></td>
				<td style="text-align:center;"><?php echo getLevelByExperience($XP_TABLE, 'CharacterExp', $perso->Experience); ?></td>
				<td style="text-align:center;font-family:verdana;"><?php echo $perso->Experience; ?></td>
				<td style="text-align:center;font-family:verdana;"><span style="color:<?php echo $colorToHonor; ?>;font-family:verdana;"><?php echo $perso->Honor; ?></span></td>
			</tr>
		<?php
		}
		?>
		</tbody>
	</table>
	</div>
<?php
}

if($table_object_account OR $table_object_character)
{
	?>
<div class="clear-float do-the-split" style="margin:-7px 0 0 0;"></div>

	<?php
}

if($SHOW_FORM_SEARCH)
{
?>
<h2 style="margin-bottom:0;"><span>Recherche dans la table <strong>Comptes</strong> :</span></h2>
<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">
	<form action="index.php?page=administration&action=rechercher" method="post" class="" style="width:100%;margin:auto;text-align:center;">
		<div class="clearfix" style="">
			Par :
			<select name="account_type" id="account_type" style="font-family:verdana;width:300px;">
				<option style="padding-left:5px;" value="Login">Login (nom de compte)</option> 
				<option style="padding-left:5px;" value="LastHardwareId">LastHardwareId</option> 
				<option style="padding-left:5px;" value="Email">Email</option> 
				<option style="padding-left:5px;" value="Ip">Ip (ig et web)</option> 
				<option style="padding-left:5px;" value="Id">Id du compte</option> 
			</select>
			
			<div class="input-icon-wrap clearfix" style="width:350px;display:inline;">
				<span class="icon-search"></span>
				<input class="input-icon required" style="border-width:2px;" type="text" name="account_value" id="account_value" value="" placeholder="Valeur à rechercher" />
			</div>
		</div>

		<br />
		<input class="button" name="account_submit" type="submit" value="Effectuer la recherche dans COMPTES" style="display:block;margin:auto;" />

	</form>
	
</div>
<div class="clear-float do-the-split" style="margin:-7px 0 0 0;"></div>

<h2 style="margin-bottom:0;"><span>Recherche dans la table <strong>Personnages</strong> :</span></h2>
<div class="content-padding" style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">

	<form action="index.php?page=administration&action=rechercher" method="post" class="contact-form clearfix" style="width:100%;margin:auto;text-align:center;">
		<div class="clearfix">
			Par :
			<select name="character_type" id="character_type" style="font-family:verdana;width:300px;">
				<option style="padding-left:5px;" value="Name">Name (nom de personnage)</option> 
				<option style="padding-left:5px;" value="Id">Id du personnage</option> 
			</select>
			
			<div class="input-icon-wrap clearfix" style="width:350px;display:inline;">
				<span class="icon-search"></span>
				<input class="input-icon required" style="border-width:2px;" type="text" name="character_value" id="character_value" value="" placeholder="Valeur à rechercher" />
			</div>
		</div>

		<br />
		<input class="button" name="character_submit" type="submit" value="Effectuer la recherche dans PERSONNAGES" style="display:block;margin:auto;" />

	</form>
	
</div>
<?php
}
?>