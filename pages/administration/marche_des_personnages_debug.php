<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Marché des personnages : Debug"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');

set_time_limit(0);
?>
<h2><span>Administration - Marché des personnages : Debug</span></h2>
	<a onClick="return updateConfirm()" class="button" style="position:absolute;top:55px;right:15px;font-size:12px;font-weight:bold;padding-left:5px;background-color:#b70000;" href="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=administration&amp;action=marche_des_personnages_debug&amp;refresh_fiche_where_image_good"><span class="icon-cog" style="margin-left:0;"></span> ADMIN: Refresh TOUTES les fiches des personnage en vente avec image correct.</a>
<div class="content-padding">
<?php
	$nb_de_ligne_tableau_a_use = $CONFIG['marcheperso_classement_nbdeligne_partableau'];
	?>
		<table id="demoTable" class="bordered bordered-blue" style="width:100%;border:1px solid #b4b4b4;margin-top:47px;">
			<thead>
				<tr style="text-shadow:1px 1px 0 white;">
					<th sort="" style="font-weight:normal;padding:5px 10px;">Nom du personnage</th>
					<th sort="" style="text-align:center;width:25%;font-weight:normal;">Classe/Niveau</th>
					<th sort="" style="text-align:center;width:17%;font-weight:normal;">Prix</th>
					<th sort="" style="text-align:center;width:17%;font-weight:normal;">Débug</th>
				</tr>
			</thead>
			<tbody>
	<?php
		$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? ORDER BY timetampStartVente DESC');
		$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente']));
		$nb_de_ligne_bdd = 0;
		while($row = $query->fetch())
		{
			$goCancel = false;
			if(file_exists('pages/marche_des_personnages_images/mini/'.$row['id_perso'].'.png') AND exif_imagetype('pages/marche_des_personnages_images/mini/'.$row['id_perso'].'.png')) $goCancel = true;
			if(file_exists('pages/marche_des_personnages_images/big/'.$row['id_perso'].'.png') AND exif_imagetype('pages/marche_des_personnages_images/big/'.$row['id_perso'].'.png')) $goCancel = true;
			
			$QUERYBOT2 = $Sql->prepare('SELECT Name FROM '.$CONFIG['db_world'].'.characters WHERE Id = ?');
			$QUERYBOT2->execute(array($row['id_perso']));
			$rowOfCharactersForTry = $QUERYBOT2->fetch();
			$QUERYBOT2->closeCursor();
			if($rowOfCharactersForTry)
			{
				if(empty($rowOfCharactersForTry['Name'])) $goCancel = false;
			}
			else $goCancel = false;
			
			if($goCancel) continue;
		$nb_de_ligne_bdd++;
		?>
			<tr style="background:white;">
				<td style="line-height:33px;font-weight:bold;padding-top:5px;" class="new_a_link"><a title="Mise en vente le <?php echo date('d/m/Y - H\hi', $row['timetampStartVente']); ?>" href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>"><img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;float:left;" />&nbsp; &nbsp;<?php echo htmlentities($row['nomPerso']); ?></a></td>
				<td style="line-height:33px;text-align:center;font-weight:bold;"><span style="font-family:verdana;position:relative;top:6px;"><?php echo $classe[$row['classe']]; ?></span> <?php echo $row['level']; ?><span style="display:none;">0</span></td>
				<td style="line-height:33px;text-align:center;font-size:16px;font-weight:bold;"><span style="position:relative;top:6px;"><?php echo $row['prix']; ?></span><span style="display:none;">0</span></td>
				<td style="line-height:33px;text-align:center;"><a style="padding:0px 8px;background-color: #1c7eb1;position:relative;top:6px;" class="button" target="_blank" style="margin:auto;" href="<?php echo $CONFIG['URL_SITE']; ?>index.php?page=vendre_personnages&amp;confirm_hash=<?php echo $row['hash']; ?>&amp;confirm_id=<?php echo md5(md5($row['id_perso']) . 'Ae9d6fsd41f'); ?>&amp;admin_refresh_fiche"><span style="position:relative;top:1px;">DEBUG</span></a></td>
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
			<td colspan="4" style="line-height:33px;text-align:center;font-size:14px;color:red;font-weight:bold;">Aucun personnage dans le marché BUG actuellement.</td>
		</tr>
		<?php
		}
	?>
			</tbody>
			<tfoot class="nav">
				<tr>
					<td colspan="4">
						<div class="pagination"></div>
						<div class="paginationTitle">Page</div>
						<div class="selectPerPage"></div>
						<div class="status"></div>
					</td>
				</tr>
			</tfoot>
		</table>
		<script>
			jQuery(function () { 
				jQuery('#demoTable').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
			});
		</script>
		
	<div class="clear-float do-the-split" style="margin-top:15px;margin-bottom:15px;"></div>

	
	<?php
	if(isset($_GET['refresh_fiche_where_image_good']))
	{
		$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ?');
		$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente']));
		$nb_de_ligne_bdd = 0;
		while($rowPersoSelectedRow = $query->fetch())
		{
			if(!file_exists('pages/marche_des_personnages_images/mini/'.$rowPersoSelectedRow['id_perso'].'.png') OR !exif_imagetype('pages/marche_des_personnages_images/mini/'.$rowPersoSelectedRow['id_perso'].'.png')) continue;
			if(!file_exists('pages/marche_des_personnages_images/big/'.$rowPersoSelectedRow['id_perso'].'.png') OR !exif_imagetype('pages/marche_des_personnages_images/big/'.$rowPersoSelectedRow['id_perso'].'.png')) continue;
			$nb_de_ligne_bdd++;
			$cache_to_read = $CONFIG['cache_folder'] .'marche_des_personnages/'.$rowPersoSelectedRow['id_perso'].'.cache';
			$cache_perso_preview = ''; 
			ob_start();	
			// Debut cache
								
				$API_ID_PERSO_PARSING = $rowPersoSelectedRow['id_perso'];
				$API_PERSO_PICT_ALREADY_DOWNLOADED_MINI = true;
				$API_PERSO_PICT_ALREADY_DOWNLOADED_BIG = true;
				include('include/api_marche_des_personnages.php');
								
			// Fin cache
			$cache_perso_preview = ob_get_contents();
			ob_end_clean();
			file_put_contents($cache_to_read, $cache_perso_preview);
		}
		$query->closeCursor();
		header('Location: index.php?page=administration&action=marche_des_personnages_debug&refresh_fiche_good__noimage_number='.$nb_de_ligne_bdd);
	}
	
	if(isset($_GET['refresh_fiche_good__noimage_number']))
	{
		?>
			<span class="the-success-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-check"></i>Félicitations, vous venez de refresh les <strong><?php echo intval($_GET['refresh_fiche_good__noimage_number']); ?></strong> fiches de personnage en vente actuellement débug.</span>
		<?php
	}
	?>
	<script>
		function updateConfirm() {
		 var a = confirm('Êtes vous sûr de vouloir actualiser toutes les fiches des personnages en vente ? (hors image)');
		 if (a) { return true; }
		 else { return false; }
		}
	</script>
</div>