<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Classement"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');
?>
<h2 style="margin-bottom:0;"><span>Classement de Neft-Gaming.</span></h2>
<div style="background:white;padding-top:20px;padding-bottom:20px;border:1px solid #e0e0e0;border-width:1px 0;">
<center><em>Ce classement est mis à jour toutes les <strong>10 minutes</strong>.</em></center>
<?php
	$cache_to_read = $CONFIG['cache_folder'].'classement_xprate.cache';
	$XP_TABLE = '';
	if(file_exists($cache_to_read))
	{
		$XP_TABLE = file_get_contents($cache_to_read);
	}
	else
	{
		ob_start();	
		$resultado = $result = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.experiences') or die ($error);
		$resultado->execute();
		$rowofxp = $resultado->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
		$resultado->closeCursor();
		echo serialize($rowofxp);
		$XP_TABLE = ob_get_contents();
		ob_end_clean();

		file_put_contents($cache_to_read, $XP_TABLE);
	}
	$XP_TABLE = unserialize($XP_TABLE);
?>
<?php
$cache_to_read = $CONFIG['cache_folder'] . $page . '.cache';
$page_show = ''; // Html du classement tableau
$expire = time() - $CONFIG['cache_classement_seconde']; // TEMP CACHE CLASSEMENT
	
if(file_exists($cache_to_read) && filemtime($cache_to_read) > $expire)
{
	$page_show = file_get_contents($cache_to_read);
}
else
{
	ob_start();	
	// Debut cache
?>
	  <div class="breaking-line" style=""></div>
	  <script>
	  $(function() {
		$( "#tabsClassement" ).tabs();
	  });
	  </script>
	<div id="tabsClassement" style="width:95%;margin:auto;">
		<ul class="content-padding" style="text-align:center;list-style:none;">
			<li style="display:inline;"><a href="#tabs-pvm" class="button big-size" style="margin-bottom:5px;">PVM</a></li> &nbsp;
			<li style="display:inline;"><a href="#tabs-pvp" class="button big-size" style="margin-bottom:5px;background-color: #B1221C;">PVP</a></li> &nbsp;
			<li style="display:inline;"><a href="#tabs-kolizeum" class="button big-size" style="margin-bottom:5px;background-color: #519623;">Kolizeum</a></li> &nbsp;
			<li style="display:inline;"><a href="#tabs-guildes" class="button big-size" style="margin-bottom:5px;background-color: #DB6D1D;">Guildes</a></li>
		</ul>
		
		<div id="tabs-pvm">
			<div class="table_neph">
				<div class="row_neph header_neph">
					<div class="cell_neph" style="width:1%;">#</div>
					<div class="cell_neph">Nom du personnage</div>
					<div class="cell_neph">Classe</div>
					<div class="cell_neph" style="width:5%;">Niveau</div>
					<div class="cell_neph" style="width:15%;">Expérience</div>
				</div>
				<?php
				$query = $Sql->prepare('SELECT DISTINCT p.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE p.Id = a.CharacterId AND a.AccountId = r.Id AND r.UserGroupId < '.$CONFIG['ladder_show_Roles_less_than'].' AND a.WorldId = 1 AND r.IsBanned = 0 ORDER BY p.Experience DESC LIMIT 0, '.$CONFIG['nb_de_ligne_par_classement']);
				$query->execute();
				$id=0;		
				while ($row = $query->fetch())
				{
					if(strpos($row['Name'], '[') !== false) continue;
					if(strpos($row['Name'], ']') !== false) continue;
					$colorToSex = ($row['Sex']) ? '#e80068' : '#1371e5'; // 1er meuf 2eme male
					$id++;	
					?>
					<div class="row_neph">
						<div class="cell_neph"><strong><?php echo $id; ?></strong></div>
						<div class="cell_neph"><?php echo htmlspecialchars($row['Name']); ?></div>
						<div class="cell_neph"><span style="color:<?php echo $colorToSex; ?>;font-weight:bold;"><?php echo $classe[$row['Breed']]; ?></span></div>
						<div class="cell_neph"><strong><?php echo getLevelByExperience($XP_TABLE, 'CharacterExp', $row['Experience']); ?></strong></div>
						<div class="cell_neph"><?php echo $row['Experience']; ?></div>
					</div>
					<?php
				}
				$query->closeCursor();
				?>
			</div>
		</div>
		<div id="tabs-pvp">
			<div class="table_neph">
				<div class="row_neph header_neph" style="background-color: #B1221C;">
					<div class="cell_neph" style="width:1%;">#</div>
					<div class="cell_neph">Nom du personnage</div>
					<div class="cell_neph">Classe</div>
					<div class="cell_neph" style="width:5%;">Niveau</div>
					<div class="cell_neph" style="width:15%;">Honneur</div>
				</div>
				<?php
				$query = $Sql->prepare('SELECT DISTINCT p.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE p.Id = a.CharacterId AND a.AccountId = r.Id AND r.UserGroupId < '.$CONFIG['ladder_show_Roles_less_than'].' AND a.WorldId = 1 AND r.IsBanned = 0 ORDER BY p.Honor DESC LIMIT 0, '.$CONFIG['nb_de_ligne_par_classement']);

				$query->execute();
				$id=0;		
				while ($row = $query->fetch())
				{
					if(strpos($row['Name'], '[') !== false) continue;
					if(strpos($row['Name'], ']') !== false) continue;
					$colorToSex = ($row['Sex']) ? '#e80068' : '#1371e5'; // 1er meuf 2eme male
					switch ($row['AlignmentSide']) {
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
					$id++;	
					?>
					<div class="row_neph">
						<div class="cell_neph"><strong><?php echo $id; ?></strong></div>
						<div class="cell_neph"><?php echo htmlspecialchars($row['Name']); ?></div>
						<div class="cell_neph"><span style="color:<?php echo $colorToSex; ?>;font-weight:bold;"><?php echo $classe[$row['Breed']]; ?></span></div>
						<div class="cell_neph"><strong><?php echo getLevelByExperience($XP_TABLE, 'CharacterExp', $row['Experience']); ?></strong></div>
						<div class="cell_neph"><span style="color:<?php echo $colorToHonor; ?>;font-family:verdana;"><?php echo $row['Honor']; ?></span></div>
					</div>
					<?php
				}
				$query->closeCursor();
				?>			
			</div>
		</div>
		<div id="tabs-kolizeum">
			<div class="table_neph">
				<div class="row_neph header_neph" style="background-color: #519623;">
					<div class="cell_neph" style="width:1%;">#</div>
					<div class="cell_neph" style="width:20%;">Personnage</div>
					<div class="cell_neph">Côte</div>
					<div class="cell_neph">Matchs du jours</div>
				</div>
				<?php
				$query = $Sql->prepare('SELECT DISTINCT p.* FROM '. $CONFIG['db_world'] .'.characters AS p, '.$CONFIG['db_auth'].'.worlds_characters AS a, '.$CONFIG['db_auth'].'.accounts AS r WHERE p.Id = a.CharacterId AND a.AccountId = r.Id AND r.UserGroupId < '.$CONFIG['ladder_show_Roles_less_than'].' AND a.WorldId = 1 AND r.IsBanned = 0 ORDER BY p.ArenaRank DESC LIMIT 0, '.$CONFIG['nb_de_ligne_par_classement']);
				$query->execute();
				$id=0;		
				while ($row = $query->fetch())
				{
					$id++;	
					$koli_lose = $row['ArenaDailyMatchsCount'] - $row['ArenaDailyMatchsWon'];
					$koli_win = $row['ArenaDailyMatchsCount'] - $koli_lose;
					?>
					<div class="row_neph">
						<div class="cell_neph"><strong><?php echo $id; ?></strong></div>
						<div class="cell_neph"><?php echo htmlspecialchars($row['Name']); ?></div>
						<div class="cell_neph"><div style="float:right;">Maximum : <strong><?php echo $row['ArenaMaxRank']; ?></strong></div><div>Actuel : <strong><?php echo $row['ArenaRank']; ?></strong></div></div>
						<div class="cell_neph"><div style="float:right;">Perdu : <strong style="color:red;"><?php echo $koli_lose; ?></strong></div><div>Remportés : <strong style="color:#348d18;"><?php echo $koli_win; ?></strong></div></div>
					</div>
					<?php
				}
				$query->closeCursor();
				?>
			</div>
		</div>
		<div id="tabs-guildes">
			<div class="table_neph">
				<div class="row_neph header_neph" style="background-color: #DB6D1D;">
					<div class="cell_neph" style="width:1%;">#</div>
					<div class="cell_neph">Nom de la guilde</div>
					<div class="cell_neph" style="width:5%;">Niveau</div>
					<div class="cell_neph" style="width:15%;">Expérience</div>
				</div>
				<?php
				$query = $Sql->prepare('SELECT * FROM '. $CONFIG['db_world'] .'.guilds WHERE Id != 134 ORDER BY Experience DESC LIMIT 0, '.$CONFIG['nb_de_ligne_par_classement']);
				$query->execute();
				$id=0;		
				while ($row = $query->fetch())
				{
					$id++;	
					?>
					<div class="row_neph">
						<div class="cell_neph"><strong><?php echo $id; ?></strong></div>
						<div class="cell_neph"><?php echo htmlspecialchars($row['Name']); ?></div>
						<div class="cell_neph"><strong><?php echo getLevelByExperience($XP_TABLE, 'GuildExp', $row['Experience']); ?></strong></div>
						<div class="cell_neph"><?php echo $row['Experience']; ?></div>
					</div>
					<?php
				}
				$query->closeCursor();
				?>
			</div>
		</div>
	</div>

<?php
	// Fin cache
	$page_show = ob_get_contents();
	ob_end_clean();
	file_put_contents($cache_to_read, $page_show);
}

echo $page_show;
?>
</div>