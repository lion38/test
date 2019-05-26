<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']) AND !in_array(strtolower($COMPTE->Login), $CONFIG['administration_CHEF_STAFF'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Dons d'Ogrines"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
<h2><span>Administration - Dons d'Ogrines</span></h2>
<div class="content-padding">
<?php

$error_to_show = '';
$success_to_show = '';

if(isset($_POST['dons_submit'], $_POST['accountname_value'], $_POST['personame_value'], $_POST['ogrines_value']) AND !empty($_POST['ogrines_value']) AND $_POST['ogrines_value'] != null)
{
	$thisAccount = false;
	// if(!empty($_POST['accountname_value']) AND $_POST['accountname_value'] != null AND)
	$accountToGive = (strlen(trim($_POST['accountname_value'])) > 0) ? trim($_POST['accountname_value']) : '';
	$persoToGive = (strlen(trim($_POST['personame_value'])) > 0) ? trim($_POST['personame_value']) : '';
	$ogrineToGive = (intval($_POST['ogrines_value']) > 0) ? intval(trim($_POST['ogrines_value'])) : '0';
	if($ogrineToGive <= 0) $error_to_show = 'Nombre d\'Ogrines incorrect ! > 0 only';
	if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT']) AND $ogrineToGive > 300) $error_to_show = 'Nombre d\'Ogrines incorrect ! <= 300 only';
	if($accountToGive == '' AND $persoToGive == '') $error_to_show = 'Veuillez remplir le Nom de compte, ou personnage.';
	if($accountToGive != '' AND $persoToGive != '') $error_to_show = 'Veuillez remplir Nom de compte ou personnage mais pas les deux en même temps.';
	// Si pas d'erreur
	if($error_to_show == '')
	{
		// Si on demande un perso
		if($persoToGive != '')
		{
			$resultado = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.characters WHERE Name = ? LIMIT 0,1') or die ($error);
			$resultado->execute(array($persoToGive));
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$table_object_character = $resultado->fetch();
			$resultado->closeCursor();
			// Si il y as des perso
			if($table_object_character)
			{
				$query = $Sql->prepare('SELECT DISTINCT r.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE p.Name = ? AND p.Id = a.CharacterId AND a.AccountId = r.Id AND a.WorldId = 1');
				$query->execute(array($persoToGive));
				$query->setFetchMode(PDO::FETCH_OBJ);
				$thisAccount = $query->fetch();
				$query->closeCursor();
			}
			else $error_to_show = 'Le personnage <strong>'.htmlspecialchars($persoToGive).'</strong> n\'existe pas.';
		}
		if(!$thisAccount)
		{
			$resultado = $Sql->prepare('SELECT * FROM accounts WHERE Login=:login') or die ($error);
			$resultado->bindvalue(':login', $accountToGive, PDO::PARAM_STR);
			$resultado->execute();
			$resultado->setFetchMode(PDO::FETCH_OBJ);
			$thisAccount = $resultado->fetch();
			$resultado->closeCursor();
		}
		
		if(!$thisAccount) $error_to_show = 'Ce nom de compte n\'existe pas !';
		else
		{
			$query = $Sql->prepare("UPDATE accounts SET Tokens = Tokens + ? WHERE Login = ?");
			$query->execute(array($ogrineToGive, $thisAccount->Login));
			$query->closeCursor();
			$query = $Sql->prepare("INSERT INTO log_admin_dons_ogrines (AdminAccount, AdminIp, Value, IdAccount, NameAccount, Timestamp) VALUES (?, ?, ?, ?, ?, ?)");
			$query->execute(array($COMPTE->Login, get_real_ip(), $ogrineToGive, $thisAccount->Id, $thisAccount->Login, time()));
			$query->closeCursor();
			if($persoToGive != '')
				$success_to_show = 'Le personnage <strong>'.htmlspecialchars($persoToGive).'</strong> (ndc : '.$thisAccount->Login.') a reçus <strong>'.$ogrineToGive.'</strong> Ogrines avec succés.';
			else
				$success_to_show = 'Le compte <strong>'.htmlspecialchars($accountToGive).'</strong> a reçus <strong>'.$ogrineToGive.'</strong> Ogrines avec succés.';
		}
	}
}

if($error_to_show != '')
{
?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_to_show; ?></span>
<?php
}

if($success_to_show != '')
{
?>
	<span class="the-success-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-check"></i><?php echo $success_to_show; ?></span>
<?php
}
?>


	<form action="index.php?page=administration&action=dons_ogrines" method="post" class="contact-form clearfix" style="width:100%;margin:auto;">
		<div class="split">
			<div class="size6" style="text-align:right;">
				<div class="input-icon-wrap" style="">
					<span class="icon-users"></span>
					<input class="input-icon required" type="text" name="personame_value" id="personame_value" value="" placeholder="Par Personnage" />
				</div>
				<div class="input-icon-wrap" style="margin-top:15px;">
					<span class="icon-user"></span>
					<input class="input-icon required" type="text" name="accountname_value" id="accountname_value" value="" placeholder="Par Nom de compte" />
				</div>
			</div>
			<div class="size6" style="text-align:left;">
				<div class="input-icon-wrap" style="position:relative;top:20px;">
					<span class="icon-code"></span>
					<input class="input-icon required" type="text" name="ogrines_value" id="ogrines_value" value="" placeholder="Nombres d'ogrines" />
				</div>
			</div>
		</div>

		<br />
		<input class="button big-size" name="dons_submit" type="submit" value="Donner les Ogrines" style="display:block;margin:auto;" />

	</form>
	
	<div class="clear-float do-the-split" style="margin-top:10px;margin-bottom:10px;"></div>
	
	<center><a class="button  aot-button-red" id="pushShowLoghide" href="javascript:pushShowLog()" style="margin:10px auto 0 auto;font-family:verdana;background:red;"><span style="position:relative;top:1px;"><span class="icon-eye"></span> Voir les logs</span></a></center>

	
	<table id="demoTable" class="bordered" style="width:100%;border:1px solid #b4b4b4;display:none;">
		<thead>
			<tr>
				<th style="text-align:center;width:1%;padding:5px 10px;">#</th>
				<th sort="admin" style="text-align:left;">Admin</th>
				<th sort="ogrine" style="width:20%;">Ogrines</th>
				<th sort="receveur">Receveur</th>
				<th style="width:30%;">Date</th>
			</tr>
		</thead>
		<tbody>
<?php
$nb_de_ligne_tableau_a_use = 15;
$nb_de_ligne_bdd=$ii = 0;
$query = $Sql->prepare("SELECT * FROM log_admin_dons_ogrines ORDER BY timestamp DESC");
$query->execute();
while($data = $query->fetch())
{
$ii++;
$nb_de_ligne_bdd = $ii;
?>
	<tr style="background:white;">
		<td style="line-height:33px;text-align:center;font-weight:bold;"><?php echo $ii; ?></td>
		<td style="line-height:33px;"><a href="index.php?page=administration&action=rechercher&from=account&type=login&value=<?php echo $data['AdminAccount']; ?>" style="color:#c40000;"><?php echo $data['AdminAccount']; ?></a></td>
		<td style="line-height:33px;text-align:center;"><?php echo $data['Value']; ?></td>
		<td style="line-height:33px;"><a href="index.php?page=administration&action=rechercher&from=account&type=login&value=<?php echo $data['NameAccount']; ?>" style="color:#0065c4;"><?php echo $data['NameAccount']; ?></a></td>
		<td style="line-height:33px;text-align:center;font-weight:bold;"><?php echo date('d/m/Y - H:i:s', $data['Timestamp']); ?></td>
	</tr>
<?php
}
$query->closeCursor();

if($nb_de_ligne_tableau_a_use > $nb_de_ligne_bdd)
{
	if($nb_de_ligne_bdd == 0) $nb_de_ligne_tableau_a_use = 1;
	else $nb_de_ligne_tableau_a_use = $nb_de_ligne_bdd;
}
if($nb_de_ligne_bdd == 0)
{
?>
<tr style="background:white;">
	<td colspan="5" style="line-height:33px;text-align:center;font-size:14px;color:red;font-weight:bold;">Aucune données à afficher.</td>
</tr>
<?php
}
?>
		</tbody>
		<tfoot class="nav">
			<tr>
				<td colspan="5">
					<div class="pagination"></div>
					<div class="paginationTitle">Page</div>
					<div class="selectPerPage"></div>
					<div class="status"></div>
				</td>
			</tr>
		</tfoot>
	</table>
									
    <script>
		function pushShowLog()
		{
			jQuery(function () { 
				jQuery('#demoTable').jTPS( {perPages:[15]} );
				jQuery('#demoTable').show();
				jQuery('#pushShowLoghide').hide();
			});
		}
    </script>
</div>