<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Ventes en cours | Historique Achat/Vente"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

if(!$_SESSION['Neft-Gaming_connecter'] OR !isset($COMPTE)) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=nous_rejoindre'); die(); }
?>
<h2 style="margin-bottom:0;"><span>Ventes en cours | Historique Achat/Vente</span></h2>
<div style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">

	  <script>
	  $(function() {
		$( "#tabsHistorique" ).tabs();
	  });
	  </script>
	  
	<div id="tabsHistorique" style="width:95%;margin:auto;">
		<ul class="content-padding" style="text-align:center;list-style:none;">
			<li style="display:inline;"><a href="#tabs-ventesencours" class="button big-size" style="margin-bottom:5px;background-color: #519623;">Mes ventes en cours</a></li> &nbsp;
			<li style="display:inline;"><a href="#tabs-historiqueachatvente" class="button big-size" style="margin-bottom:5px;">Historique achat/vente</a></li>
		</ul>
		
		<div class="breaking-line"></div>
		
		<div class="content-padding">
			
			<div id="tabs-ventesencours">
				<h2 style="text-align:center;text-shadow:1px 1px 0 white;">Mes ventes en cours</h2>
				<div class="do-the-split" style="margin:0 auto 5px auto;"></div>
				
			<?php		
			if(isset($_GET['cancel_id'], $_GET['cancel_hash']) AND !empty($_GET['cancel_id']) AND !empty($_GET['cancel_hash']) AND is_numeric($_GET['cancel_id']))
			{
				$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? AND sellByAccountId = ? AND id = ? AND hash = ? LIMIT 1');
				$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente'], $COMPTE->Id, $_GET['cancel_id'], trim($_GET['cancel_hash'])));
				$row = $query->fetch();
				$query->closeCursor();
				
				if($row)
				{
					$query = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.worlds_characters SET AccountId = ? WHERE CharacterId = ? AND AccountId = ? LIMIT 1');
					$query->execute(array($COMPTE->Id, $row['id_perso'], $CONFIG['marcheperso_idaccount_stackpersotosell']));
					$query->closeCursor();
					
					$query = $Sql->prepare('UPDATE '. $CONFIG['db_auth'] .'.marche_des_personnages SET etat = ? WHERE id = ? LIMIT 1');
					$query->execute(array($CONFIG['marcheperso_array_etat']['annule'], $row['id']));
					$query->closeCursor();
				?>
				<span class="the-error-msg" style="width:95%;margin:10px auto 10px auto;"><i class="fa fa-warning"></i>La vente du personnage <strong><?php echo $row['nomPerso']; ?></strong> a bien été annulée.</span>
				<?php
				}
			}
			$nb_de_ligne_tableau_a_use = 10;
			?>

				<table class="bordered bordered-blue" id="table_ventencours" style="width:100%;border:1px solid #b4b4b4;">
					<thead>
						<tr style="text-shadow:1px 1px 0 white;">
							<th sort="off" style="font-weight:normal;width:27%;padding-top:5px;padding-bottom:5px;">Nom du personnage</th>
							<th sort="lvl" style="text-align:center;width:10%;font-weight:normal;padding-top:5px;padding-bottom:5px;">Niveau</th>
							<th sort="bread" style="text-align:center;width:15%;font-weight:normal;padding-top:5px;padding-bottom:5px;">Classe</th>
							<th sort="price" style="text-align:center;width:15%;font-weight:normal;padding-top:5px;padding-bottom:5px;">Prix (Ogrines)</th>
							<th sort="price" style="text-align:center;width:21%;font-weight:normal;padding-top:5px;padding-bottom:5px;">Date</th>
							<th style="text-align:center;width:12%;font-weight:normal;padding-top:5px;padding-bottom:5px;">Annuler</th>
						</tr>
					</thead>
					<tbody>
			<?php
				$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE etat = ? AND sellByAccountId = ? ORDER BY timestampAchat DESC, timetampStartVente DESC');
				$query->execute(array($CONFIG['marcheperso_array_etat']['en_vente'], $COMPTE->Id));
				$nb_de_ligne_bdd = 0;
				while($row = $query->fetch())
				{
				$nb_de_ligne_bdd++;
				$date_to_use = ($row['timestampAchat'] > $row['timetampStartVente']) ? $row['timestampAchat'] : $row['timetampStartVente'];
				?>
					<tr style="background:white;">
						<td style="line-height:33px;font-weight:bold;padding-top:5px;" class="new_a_link"><a href="index.php?page=achat_personnages&amp;show_id=<?php echo $row['id']; ?>"><img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;float:left;" />&nbsp; &nbsp;<?php echo htmlentities($row['nomPerso']); ?></a></td>
						<td style="line-height:33px;text-align:center;"><strong style="position:relative;top:6px;"><?php echo $row['level']; ?></strong></td>
						<td style="line-height:33px;text-align:center;font-family:verdana;"><span style="position:relative;top:6px;"><?php echo $classe[$row['classe']]; ?></span></td>
						<td style="line-height:33px;text-align:center;font-size:16px;"><strong style="position:relative;top:6px;"><?php echo $row['prix']; ?></strong></td>
						<td style="line-height:33px;text-align:center;font-size:14px;font-family:verdana;"><span style="position:relative;top:6px;"><?php echo date('d/m/Y - H\hi', $date_to_use); ?></span></td>
						<td style="text-align:center;"><a class="button" style="padding:5px;background-color: #B1221C;position:relative;top:8px;" onClick="return deleteConfirm('<?php echo str_replace('"', "", str_replace("'", "", $row['nomPerso'])); ?>', <?php echo $row['prix']; ?>)" href="index.php?page=historique_marche_personnage&amp;cancel_id=<?php echo $row['id']; ?>&amp;cancel_hash=<?php echo $row['hash']; ?>"><span style="position:relative;top:1px;"><span class="icon-cancel"></span></span></a></td>
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
				<tr>
					<td colspan="6" style="text-align:center;padding:5px;font-size:14px;color:red;">Aucun personnage en vente actuellement.</td>
				</tr>
				<?php
				}
			?>
					</tbody>
					<tfoot class="nav">
						<tr>
							<td colspan="6">
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
						jQuery('#table_ventencours').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
					});
					
					function deleteConfirm(name_perso, price) {
					 var a = confirm('Êtes vous sûr de vouloir annuler la vente du personnage ' + name_perso + ' à ' + price + ' Ogrines ?');
					 if (a) { return true; }
					 else { return false; }
					}
				</script>
				
				
				
				
			</div>
			
			<div id="tabs-historiqueachatvente">
				<h2 style="text-align:center;text-shadow:1px 1px 0 white;">Historique achat/vente</h2>
				<div class="do-the-split" style="margin:0 auto 5px auto;"></div>
				
				
			<?php
			
			$nb_de_ligne_tableau_a_use = 10;
			?>

				<table class="bordered bordered-blue" id="table_historique" style="width:100%;border:1px solid #b4b4b4;">
					<thead>
						<tr style="text-shadow:1px 1px 0 white;padding-top:5px;padding-bottom:5px;">
							<th sort="off" style="font-weight:normal;width:27%;padding-bottom:5px;">Nom du personnage</th>
							<th sort="lvl" style="text-align:center;width:10%;font-weight:normal;padding-bottom:5px;">Niveau</th>
							<th sort="bread" style="text-align:center;width:15%;font-weight:normal;padding-bottom:5px;">Classe</th>
							<th sort="price" style="text-align:center;width:15%;font-weight:normal;padding-bottom:5px;">Prix (Ogrines)</th>
							<th sort="price" style="text-align:center;width:21%;font-weight:normal;padding-bottom:5px;">Date</th>
							<th style="text-align:center;width:12%;font-weight:normal;padding-bottom:5px;">Etat</th>
						</tr>
					</thead>
					<tbody>
			<?php
				$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_auth'] .'.marche_des_personnages WHERE (etat = ? OR etat = ?) AND (sellByAccountId = ? OR buyByAccountId = ?) ORDER BY timestampAchat DESC, timetampStartVente DESC');
				$query->execute(array($CONFIG['marcheperso_array_etat']['vendu'], $CONFIG['marcheperso_array_etat']['annule'], $COMPTE->Id, $COMPTE->Id));

				$nb_de_ligne_bdd = 0;
				while($row = $query->fetch())
				{
				$nb_de_ligne_bdd++;
				$date_to_use = ($row['timestampAchat'] > $row['timetampStartVente']) ? $row['timestampAchat'] : $row['timetampStartVente'];
				if($row['etat'] == $CONFIG['marcheperso_array_etat']['annule'])
					$etat_toshow = '<span class="bg-red" style="display:block;position:relative;top:5px;">Annulé</span>';
				else
				{
					if($row['sellByAccountId'] == $COMPTE->Id)
						$etat_toshow = '<span class="bg-green" style="display:block;position:relative;top:5px;">Vendu</span>';
					else
						$etat_toshow = '<span class="bg" style="display:block;position:relative;top:5px;">Acheté</span>';
				}
				?>
					<tr style="background:white;">
						<td style="line-height:33px;font-weight:bold;padding-top:5px;padding-bottom:5px;" class="new_a_link"><img src="pages/marche_des_personnages_images/mini/<?php echo $row['id_perso']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;float:left;" />&nbsp; &nbsp;<?php echo htmlentities($row['nomPerso']); ?></td>
						<td style="line-height:33px;text-align:center;"><strong style="position:relative;top:6px;"><?php echo $row['level']; ?></strong></td>
						<td style="line-height:33px;text-align:center;font-family:verdana;"><span style="position:relative;top:6px;"><?php echo $classe[$row['classe']]; ?></span></td>
						<td style="line-height:33px;text-align:center;font-size:16px;"><strong style="position:relative;top:6px;"><?php echo $row['prix']; ?></strong></td>
						<td style="line-height:33px;text-align:center;font-size:14px;font-family:verdana;"><span style="position:relative;top:6px;"><?php echo date('d/m/Y - H\hi', $date_to_use); ?></span></td>
						<td style="line-height:33px;text-align:center;"><?php echo $etat_toshow; ?></td>
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
				<tr>
					<td colspan="6" style="text-align:center;padding:5px;font-size:14px;color:red;">Aucun personnage en vente actuellement.</td>
				</tr>
				<?php
				}
			?>
					</tbody>
					<tfoot class="nav">
						<tr>
							<td colspan="6">
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
						jQuery('#table_historique').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
					});
				</script>
				
			</div>
		
		</div>
		
	</div>
</div>