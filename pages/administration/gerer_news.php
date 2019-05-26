<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
if(!defined("ADMIN_DS")) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }

/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */
if(!in_array(strtolower($COMPTE->Login), $CONFIG['admin_a_pas_changer_FULL_DROIT'])) { header('Location: '.$CONFIG['URL_SITE'].'index.php?page=erreur'); die(); }
/* CETTE LIGNE EST POUR BLOQUER L'ACCES AU PAGE AU NON FONDATEUR !! */

$page_title = "Administration - News"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar_admin.php');
?>
<script type="text/javascript">
function deleteConfirm() {
 var a = confirm("Êtes vous sûr de vouloir supprimer ce message ?");
 
 if (a) { return true; }
 else { return false; }

}
</script>
<?php
$GET_ACTION = (isset($_GET['actionnews']) AND !empty($_GET['actionnews'])) ? $_GET['actionnews'] : ''; 
$error_to_show = '';

switch ($GET_ACTION)
{

/* AJOUTER UNE NEWS */
case 'edit':
	if(isset($_GET['id']) AND !empty($_GET['id']) AND $_GET['id'] == intval($_GET['id']))
	{
		$resulta = $Sql->prepare("SELECT * FROM site_news WHERE id = ? LIMIT 1");
		$resulta->execute(array($_GET['id']));
		$THIS_NEWS = $resulta->fetch();
		$resulta->closeCursor();
		if($THIS_NEWS)
		{
			if(isset($_POST['news_titre'], $_POST['news_icone'], $_POST['news_contenu'], $_POST['news_image_presentation_top'], $_POST['news_url_forum']))
			{
				$news_titre = (!empty($_POST['news_titre'])) ? $_POST['news_titre'] : '';
				$news_icone = (!empty($_POST['news_icone'])) ? $_POST['news_icone'] : 'calendar-empty';
				$news_contenu = (!empty($_POST['news_contenu'])) ? $_POST['news_contenu'] : '';
				$news_image_presentation_top = (!empty($_POST['news_image_presentation_top'])) ? $_POST['news_image_presentation_top'] : '';
				$news_url_forum = (!empty($_POST['news_url_forum'])) ? $_POST['news_url_forum'] : '';
				if(!empty($news_titre) AND !empty($news_contenu) )
				{
					$query = $Sql->prepare("UPDATE site_news SET icon = ?, titre = ?, image_presentation_top = ?, content = ?, url_forum = ? WHERE id = ?");
					$query->execute(array($news_icone, $news_titre, $news_image_presentation_top, $news_contenu, $news_url_forum, $THIS_NEWS['id']));
					$query->closeCursor();
					header('Location: '.$CONFIG['URL_SITE'].'index.php?page=administration&action=gerer_news');
				}
				else $error_to_show = 'Veuillez compléter le titre et le contenu de la news';
			}

			
			?>
			<h2 style="margin-bottom:10px;"><span>Editer la news <div style="font-family:verdana;color:#006ede;display:inline;"><?php echo $THIS_NEWS['id']; ?></div> | <a href="index.php?page=administration&action=gerer_news" style="font-family:Verdana;color:red;">Retour</a></span></h2>
			<div class="content-padding">
			
				<form method="post" name="post" action="">
			<?php
			if($error_to_show != '')
			{
			?>
			<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_to_show; ?></span>
			<?php
			}
			?>
				<label for="news_titre"><h3>Titre :</h3></label>
				<input style="width:100%;margin-top:5px;" type="text" name="news_titre" id="news_titre" value="<?php echo $THIS_NEWS['titre']; ?>" placeholder="Titre de la news" />
					<div style="margin-top:10px;"></div>

				<input type="hidden" name="news_icone" id="news_icone" placeholder="Icone de la news" value="calendar-empty" />
				
				<label for="news_contenu"><h3>Contenu de la news :</h3></label>
				<?php echo bouttonBBcode(); ?>
				<textarea name="news_contenu" id="news_contenu" rows="10" style="width:97%;"><?php echo $THIS_NEWS['content']; ?></textarea>
					<div style="margin-top:10px;"></div>

				<label for="news_image_presentation_top"><h3>Lien vers l'image de présentation du haut (pas obligatoire) :</h3></label>
				<input style="width:100%;margin-top:5px;" type="text" name="news_image_presentation_top" id="news_image_presentation_top" value="<?php echo $THIS_NEWS['image_presentation_top']; ?>" placeholder="Lien vers l'image de présentation du haut" />
					<div style="margin-top:10px;"></div>
					
				<label for="news_url_forum"><h3>Url forum :</h3></label>
				<input style="width:100%;margin-top:5px;" type="text" name="news_url_forum" id="news_url_forum" value="<?php echo $THIS_NEWS['url_forum']; ?>" placeholder="Url du forum (Lire le contenu de la mise à jour et réagir !)" />
				

				<div class="clear-float do-the-split" style="margin-top:20px;margin-bottom:10px;"></div>
				<input class="button big-size" style="width:100%;" name="postnews" type="submit" value="Modifier la news" />
				<div class="clear-float do-the-split" style="margin-top:10px;margin-bottom:20px;"></div>

				</form>

				<h3 style="text-align:center;">PREVIEW DE LA FUTUR NEWS : <input style="cursor:pointer;background-color:#b90000;" class="button" id="button_see_preview" type="button" value="Prévisualiser la news" /></h3>
				<div id="news_preview" class="clearfix"></div>
				<div class="clearfix" style="clear:both;">&nbsp;</div>
				
				<script>
				jQuery('#button_see_preview').click(function()
				{
					var message = jQuery("#news_contenu").val();
					var titre = jQuery("#news_titre").val();
					var icone = jQuery("#news_icone").val();
					var news_image_presentation_top = jQuery("#news_image_presentation_top").val();
					var news_url_forum = jQuery("#news_url_forum").val();
					jQuery("#news_preview").hide();
					jQuery("#news_preview").load('previewbbcode_9d6e.php', {'message':message, 'titre':titre, 'icone':icone, 'news_image_presentation_top':news_image_presentation_top, 'news_url_forum':news_url_forum} , function()
					{
						jQuery("#news_preview").show();
					});
					
					return false;
				});
				</script>
				<style>
				input, select, textarea{font-family:verdana;}
				</style>
				</div>
			<?php
		}
		else header('Location: '.$CONFIG['URL_SITE'].'index.php?page=administration&action=gerer_news');
	}
	else header('Location: '.$CONFIG['URL_SITE'].'index.php?page=administration&action=gerer_news');
break;

/* DELETE UNE NEWS */
case 'delete':
	if(isset($_GET['id']) AND !empty($_GET['id']) AND $_GET['id'] == intval($_GET['id']))
	{
		$resulta = $Sql->prepare("SELECT * FROM site_news WHERE id = ? LIMIT 1");
		$resulta->execute(array($_GET['id']));
		$row = $resulta->fetch();
		$resulta->closeCursor();
		if($row)
		{
			$resulta = $Sql->prepare("UPDATE site_news SET visible = 0 WHERE id = ?");
			$resulta->execute(array($_GET['id']));
			$resulta->closeCursor();
		}
	}
	header('Location: '.$CONFIG['URL_SITE'].'index.php?page=administration&action=gerer_news');
break;

/* AJOUTER UNE NEWS */
case 'add':

if(isset($_POST['news_titre'], $_POST['news_icone'], $_POST['news_contenu'], $_POST['news_image_presentation_top'], $_POST['news_url_forum']))
{
	$news_titre = (!empty($_POST['news_titre'])) ? $_POST['news_titre'] : '';
	$news_icone = (!empty($_POST['news_icone'])) ? $_POST['news_icone'] : 'calendar-empty';
	$news_contenu = (!empty($_POST['news_contenu'])) ? $_POST['news_contenu'] : '';
	$news_image_presentation_top = (!empty($_POST['news_image_presentation_top'])) ? $_POST['news_image_presentation_top'] : '';
	$news_url_forum = (!empty($_POST['news_url_forum'])) ? $_POST['news_url_forum'] : '';
	if(!empty($news_titre) AND !empty($news_contenu) )
	{
		$query = $Sql->prepare("INSERT INTO site_news(icon ,titre, image_presentation_top, content, url_forum, timestamp, visible) VALUES(?, ?, ?, ?, ?, ?, 1)");
		$query->execute(array($news_icone, $news_titre, $news_image_presentation_top, $news_contenu, $news_url_forum, time()));
		$query->closeCursor();
		header('Location: '.$CONFIG['URL_SITE'].'index.php?page=administration&action=gerer_news');
	}
	else $error_to_show = 'Veuillez compléter le titre et le contenu de la news';
}

?>
<h2 style="margin-bottom:10px;"><span>Ajouter une news | <a href="index.php?page=administration&action=gerer_news" style="font-family:Verdana;color:red;">Retour</a></span></h2>
<div class="content-padding">

	<form method="post" name="post" action="">
<?php
if($error_to_show != '')
{
?>
	<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i><?php echo $error_to_show; ?></span>
<?php
}
?>
	<label for="news_titre"><h3>Titre :</h3></label>
	<input style="width:100%;margin-top:5px;" type="text" name="news_titre" id="news_titre" value="" placeholder="Titre de la news" />
		<div style="margin-top:10px;"></div>

	<input type="hidden" name="news_icone" id="news_icone" placeholder="Icone de la news" value="calendar-empty" />
		
	<label for="news_contenu"><h3>Contenu de la news :</h3></label>
	<?php echo bouttonBBcode(); ?>
	<textarea name="news_contenu" id="news_contenu" rows="10" style="width:97%;"></textarea>
		<div style="margin-top:10px;"></div>

	<label for="news_image_presentation_top"><h3>Lien vers l'image de présentation du haut (pas obligatoire) :</h3></label>
	<input style="width:100%;margin-top:5px;" type="text" name="news_image_presentation_top" id="news_image_presentation_top" value="" placeholder="Lien vers l'image de présentation du haut" />
		<div style="margin-top:10px;"></div>
		
	<label for="news_url_forum"><h3>Url forum :</h3></label>
	<input style="width:100%;margin-top:5px;" type="text" name="news_url_forum" id="news_url_forum" value="" placeholder="Url du forum (Lire le contenu de la mise à jour et réagir !)" />

	<div class="clear-float do-the-split" style="margin-top:20px;margin-bottom:10px;"></div>
	<input class="button big-size" style="width:100%;" name="postnews" type="submit" value="Poster la news" />
	<div class="clear-float do-the-split" style="margin-top:10px;margin-bottom:20px;"></div>
	</form>

	<h3 style="text-align:center;">PREVIEW DE LA FUTUR NEWS : <input style="cursor:pointer;background-color:#b90000;" class="button" id="button_see_preview" type="button" value="Prévisualiser la news" /></h3>
	<div id="news_preview" class="clearfix"></div>
	<div class="clearfix" style="clear:both;">&nbsp;</div>
	
	<script>
	jQuery('#button_see_preview').click(function()
	{
		var message = jQuery("#news_contenu").val();
		var titre = jQuery("#news_titre").val();
		var icone = jQuery("#news_icone").val();
		var news_image_presentation_top = jQuery("#news_image_presentation_top").val();
		var news_url_forum = jQuery("#news_url_forum").val();
		jQuery("#news_preview").hide();
		jQuery("#news_preview").load('previewbbcode_9d6e.php', {'message':message, 'titre':titre, 'icone':icone, 'news_image_presentation_top':news_image_presentation_top, 'news_url_forum':news_url_forum} , function()
		{
			jQuery("#news_preview").show();
		});
		
		return false;
	});
	</script>
	<style>
	input, select, textarea{font-family:verdana;}
	</style>
</div>
<?php
break;

/* DEFAULT */
/* Tableau de news */
default:
?>
<h2 style="margin-bottom:10px;"><span>Tableau des news</span></h2>
<div class="content-padding">
	<a class="button right" href="index.php?page=administration&action=gerer_news&amp;actionnews=add"><span class="icon-leaf" style="color:white;"></span> Ajouter une news</a><br /><br />
	<div class="do-the-split" style="margin:10px auto 5px auto;"></div>
	<table id="table_gerernews" class="bordered" style="width:100%;border:1px solid #b4b4b4;">
		<thead>
			<tr>
				<th style="text-align:center;width:1%;padding:5px 10px;">#</th>
				<th>Titre</th>
				<th style="text-align:center;width:175px;">Date</th>
				<th style="text-align:center;width:50px;">Edit</th>
				<th style="text-align:center;width:50px;">X</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$nb_de_ligne_tableau_a_use = 20;
		$query = $Sql->prepare('SELECT * FROM site_news WHERE visible = 1 ORDER BY timestamp DESC');
		$query->execute();
		$nb_de_ligne_bdd=$id=0;		
		while ($row = $query->fetch())
		{
			$id++;	
			$nb_de_ligne_bdd = $id;
			?>
			<tr style="background:white;">
				<td style="line-height:33px;text-align:center;font-weight:bold;"><?php echo $row['id']; ?></td>
				<td style="line-height:33px;"><a href="index.php?page=administration&action=gerer_news&amp;actionnews=edit&amp;id=<?php echo $row['id']; ?>" style="color:inherit;"><?php echo $row['titre']; ?></a></td>
				<td style="line-height:33px;text-align:center;font-weight:bold;"><?php echo date('d/m/Y \- H\:i', $row['timestamp']); ?></td>
				<td style="line-height:33px;"><a href="index.php?page=administration&action=gerer_news&amp;actionnews=edit&amp;id=<?php echo $row['id']; ?>"><img src="images/edit.png" alt="Edit" style="display:block;margin:auto;position:relative;top:10px;" /></a></td>
				<td style="line-height:33px;"><a href="index.php?page=administration&action=gerer_news&amp;actionnews=delete&amp;id=<?php echo $row['id']; ?>" onclick="return deleteConfirm()"><img src="images/delete.png" alt="Delete" style="width:32px;height:32px;display:block;margin:auto;" /></a></td>
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
			<td colspan="5" style="line-height:33px;text-align:center;font-size:14px;color:red;font-weight:bold;">Aucune news en base de donnée.</td>
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
			jQuery('#table_gerernews').jTPS( {perPages:[<?php echo $nb_de_ligne_tableau_a_use; ?>]} );
		});
	</script>
</div>
<?php
break;
}
?>	