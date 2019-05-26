<?php 
/* **********************************************/
/** A inclure dans chage page du dossier /page/ */
/* **********************************************/
if(!defined("BASE_DS")) die();
$page_title = "Accueil"; // Nom de la page dans le content
$page_is_full_width = false; // Supprime le menu de droite

include('include/header.php');
include('include/rightbar.php');

$cache_to_read = $CONFIG['cache_folder'].'news.cache';
$SITE_NEWS = ''; // array des news
$expire = time() - $CONFIG['cache_news_seconde']; // TEMP CACHE CLASSEMENT
	
if(file_exists($cache_to_read) && filemtime($cache_to_read) > $expire)
{
	$SITE_NEWS = file_get_contents($cache_to_read);
}
else
{
	ob_start();	
	
	$resultado = $result = $Sql->prepare('SELECT * FROM site_news WHERE visible = 1 ORDER BY timestamp DESC') or die ($error);
	$resultado->execute();
	$resultado->setFetchMode(PDO::FETCH_OBJ);
	$SITE_NEWS_TEMP = $resultado->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
	$resultado->closeCursor();
	echo serialize($SITE_NEWS_TEMP);
	
	// Fin cache
	$SITE_NEWS = ob_get_contents();
	ob_end_clean();
	file_put_contents($cache_to_read, $SITE_NEWS);
}

	$SITE_NEWS = unserialize($SITE_NEWS);
	$SITE_NEWS = array_values($SITE_NEWS); // Reinitialise les key (start par 0)
	/*
	echo '<pre>';
	print_r($SITE_NEWS);
	echo '</pre>';
	*/

	$nbnews = count($SITE_NEWS);
	$nbpage= ceil($nbnews / $CONFIG['nb_news_par_page']);
	$id = (isset($_GET['idpage']) AND !empty($_GET['idpage']) AND $_GET['idpage'] > 0) ? intval($_GET['idpage']) : 1;
	$id = ($id <= $nbpage) ? $id : 4;
	$limitpage = ($id * $CONFIG['nb_news_par_page']) - $CONFIG['nb_news_par_page'];
	
	if($CONFIG['boutique_offre_ogrine_double'] == true)
	{
	?>
	<div class="content-padding">
		<a href="index.php?page=achat_dedipass" class="top-alert-message">
			<span><span class="pod-live">Offre en cours</span>Les Ogrines achetées sont doublées à chaque achat ! <em style="color:#ededed;text-shadow:1px 1px 0 #9b1818;font-weight:bold;">Fin de l'offre : <strong>Lundi 23 Mai 2016 à 12h00</strong>.</em></span>
		</a>
	</div>
	<?php
	}
	?>
	
	<h2 style="margin-bottom:0;"><span>Quoi de neuf sur Neft-Gaming ?</span></h2>
	<div class="content-padding" style="background:white;padding-top:10px;padding-bottom:10px;border:1px solid #e0e0e0;border-width:1px 0;">
		<div class="grid-articles">
	<?php
	for($aa = $limitpage; $aa < ($limitpage + $CONFIG['nb_news_par_page']) ; $aa++)
	{
		if (array_key_exists($aa, $SITE_NEWS))
		{
			$actual_news = $SITE_NEWS[$aa];
			?>
			
			<div class="item">
				<span class="article-image-out">
					<span class="image-comments"><span><?php echo date('d/m/Y', $actual_news->timestamp); ?></span></span>
					<span class="article-image">
						<a href="<?php echo $actual_news->url_forum; ?>" target="_blank"><img src="<?php echo $actual_news->image_presentation_top; ?>" alt="" title="<?php echo $actual_news->titre; ?>" /></a>
					</span>
				</span>
				<h3><a href="<?php echo $actual_news->url_forum; ?>" target="_blank"><?php echo $actual_news->titre; ?></a></h3>
				<p><?php echo parsebbcode(nl2br($actual_news->content)); ?></p>
				<div>
					<a href="<?php echo $actual_news->url_forum; ?>" target="_blank" class="defbutton" style="font-family:Raleway;background:#2e96d1;color:white;"><i class="fa fa-comments"></i>Lire la suite et réagir à cette news !</a>
				</div>
			</div>
			<?php
		}
	}
?>
		</div>
	</div>
	
<div class="clear-float do-the-split" style="margin-top:20px;margin-bottom:20px;"></div>
<?php
//Pagination
echo paginate('index.php', '?idpage=', $nbpage, $id);
?>
<style>
a.plusetmoinpagination
{
	cursor:pointer;font-weight:bold;background:#e7e7e7;color:gray;
}
a.plusetmoinpagination:hover
{
	cursor:pointer;font-weight:bold;background:#f0f0f0;color:gray;
	border-size:0;
	box-shadow: 0 0 0;
}
</style>
<?php
	
	/* DEBUG */
	/*
	echo 'NB de news : '.$nbnews.'<br />';
	echo 'nb_news_par_page : '.$CONFIG['nb_news_par_page'].'<br />';
	echo 'nbpage : '.$nbpage.'<br />';
	echo 'id : '.$id.'<br />';
	echo 'limitpage : '.$limitpage.'<br />';
	echo '<br />';
	*/
?>