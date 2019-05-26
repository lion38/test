<?php
require_once('config/fonction.php');
if(isset($_POST['message']))
{
	if(!empty($_POST['message']))
	{
	$titre = (isset($_POST['titre']) AND !empty($_POST['titre'])) ? $_POST['titre'] : '';
	$icon = (isset($_POST['icone']) AND !empty($_POST['icone'])) ? $_POST['icone'] : 'calendar-empty';
	$image_presentation_top = (isset($_POST['news_image_presentation_top']) AND !empty($_POST['news_image_presentation_top'])) ? $_POST['news_image_presentation_top'] : '';
	$url_forum = (isset($_POST['news_url_forum']) AND !empty($_POST['news_url_forum'])) ? $_POST['news_url_forum'] : '';
	$timestamp = time();
	?>
		<br />
		<div class="grid-articles">
			<div class="item">
				<span class="article-image-out">
					<span class="image-comments"><span><?php echo date('d/m/Y', $timestamp); ?></span></span>
					<span class="article-image">
						<a href="<?php echo htmlspecialchars($url_forum); ?>" target="_blank"><img src="<?php echo $image_presentation_top; ?>" alt="" title="<?php echo htmlspecialchars($titre); ?>" /></a>
					</span>
				</span>
				<h3><a href="<?php echo htmlspecialchars($url_forum); ?>" target="_blank"><?php echo htmlspecialchars($titre); ?></a></h3>
				<p><?php echo parsebbcode(nl2br(htmlspecialchars($_POST['message']))); ?></p>
				<div>
					<a href="<?php echo htmlspecialchars($url_forum); ?>" target="_blank" class="defbutton" style="font-family:Raleway;background:#2e96d1;color:white;"><i class="fa fa-comments"></i>Lire la suite et réagir à cette news !</a>
				</div>
			</div>
		</div>
<?php
	}
	else
	{
		?>
		<br />
		<span class="the-error-msg" style="width:95%;margin:0 auto 15px auto;"><i class="fa fa-warning"></i>Veuillez remplir le champ texte de la news.</span>
		<?php
	}
}
?>