<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - Marché des personnages : Les ventes"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
<h2><span>Administration - Marché des personnages : Les ventes</span></h2>
<div class="content-padding">
<?php
	$nb_de_ligne_tableau_a_use = $CONFIG['marcheperso_classement_nbdeligne_partableau'];
	?>

		<table id="demoTable" class="bordered" style="width:100%;border:1px solid #b4b4b4;">
			<thead>
				<tr style="text-shadow:1px 1px 0 white;">
					<th sort="" style="font-weight:normal;padding:5px 10px;">Nom du personnage</th>
					<th sort="" style="text-align:center;width:10%;font-weight:normal;">Niveau</th>
					<th sort="" style="text-align:center;width:15%;font-weight:normal;">Classe</th>
					<th sort="" style="text-align:center;width:20%;font-weight:normal;">Prix (Ogrines)</th>
					<th sort="" style="text-align:center;width:20%;font-weight:normal;">Date d'achat</th>
				</tr>
			</thead>
			<tbody>
	<?php
		$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? AND timestampAchat >= ? ORDER BY timestampAchat DESC');
		$query->execute(array($CONFIG['marcheperso_array_etat']['vendu'], (time() - 86400 * 7)));
		$nb_de_ligne_bdd = 0;
		while($row = $query->fetch())
		{
		$nb_de_ligne_bdd++;
		?>
			<tr style="background:white;">
				<td style="line-height:33px;font-weight:bold;padding-top:5px;" class="new_a_link"><img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;float:left;" />&nbsp; &nbsp;<?php echo htmlentities($row['nomPerso']); ?></td>
				<td style="line-height:33px;text-align:center;font-weight:bold;"><span style="font-family:verdana;position:relative;top:6px;"><?php echo $row['level']; ?></span><span style="display:none;">0</span></td>
				<td style="line-height:33px;text-align:center;font-family:verdana;"><span style="font-family:verdana;position:relative;top:6px;"><?php echo $classe[$row['classe']]; ?></span></td>
				<td style="line-height:33px;text-align:center;font-size:16px;font-weight:bold;"><span style="font-family:verdana;position:relative;top:6px;"><?php echo $row['prix']; ?></span><span style="display:none;">0</span></td>
				<td style="line-height:33px;text-align:center;font-family:Arial;"><span style="position:relative;top:6px;" title="Date de mise en vente : <?php echo date('d/m/Y H\hi', $row['timetampStartVente']); ?>"><?php echo date('d/m/Y H\hi', $row['timestampAchat']); ?></span></td>
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
			<td colspan="5" style="line-height:33px;text-align:center;font-size:14px;color:red;font-weight:bold;">Aucun personnage dans le marché vendu.</td>
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
			jQuery(function () { 
				jQuery('#demoTable').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
			});
		</script>
		
</div>