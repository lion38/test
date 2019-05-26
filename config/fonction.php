<?php

function get_contents($url_api_go) {

  file_get_contents($url_api_go);
  if(isset($http_response_header) AND isset($http_response_header[0])) return $http_response_header[0];
  else return 'erreur';

  //return file_get_contents($url_api_go);
}

function generer_mdp_aleatoire()
{
	$guid = crypt(uniqid(rand(),1));
	$guid = strip_tags(stripslashes($guid));
	$guid = str_replace(".","",$guid);
	$guid = strrev(str_replace("/","",$guid));
	$guid = substr($guid,0,20);
	$guid = str_replace('$', 'a', $guid);
	return $guid;
}
function generer_hash_md5($longueur = 32){
	return substr(md5(uniqid(mt_rand(), true)), 0, $longueur);
}

function addTenPercent($val)
{
	// return ($val*75);
	// return ($val * ((100 * 80 / 100) - (100 * 3.9 / 100) - 0.30 - (100 * 10 / 100)));
	$NbOgrineBeforeTax = ($val * 100); // $val = nombre de euros payé , 100 = le nombre d'ogrine pour 1 €
	$NbOgrineAfterTax = $NbOgrineBeforeTax - (($NbOgrineBeforeTax * 20 / 100) + ($NbOgrineBeforeTax * 3.9 / 100) + 0.30);
	$NbOgrineAfterTax = $NbOgrineAfterTax - ($NbOgrineAfterTax * 10 / 100);
	// $NbOgrineAfterTax = $NbOgrineAfterTax - ($NbOgrineBeforeTax * 10 / 100);
	return floor($NbOgrineAfterTax); // Et on enleve 20 % HMA + 3.9% PP + 10% Convertion + 0.30€ PP
	//return ($val*100) + ($val*100) * 0.1;
}

function WithoutaddTenPercent($val)
{
	$NbOgrineBeforeTax = ($val * 100); // $val = nombre de euros payé , 100 = le nombre d'ogrine pour 1 €
	$NbOgrineAfterTax = $NbOgrineBeforeTax - (($NbOgrineBeforeTax * 20 / 100) + ($NbOgrineBeforeTax * 3.9 / 100) + 0.30);
	// $NbOgrineAfterTax = $NbOgrineAfterTax - ($NbOgrineBeforeTax * 10 / 100);
	return floor($NbOgrineAfterTax); // Et on enleve 20 % HMA + 3.9% PP + 10% Convertion + 0.30€ PP
}

// Renvois false si dans $str il detect un char ($arr = array de charactere)
function post_is_valid_not_chevron($str, array $arr)
{
    foreach($arr as $a) {
        if (stripos($str,$a) !== false) return false;
    }
    return true;
}

// Renvois le level selon l'xp depuis la table Experiences, $experience table = array de la table , $typexp = characterXp, $experience = une val d'xp
function getLevelByExperience($experiences_table, $typeXp, $valeurXp)
{
	$levelToReturn = 1;
	foreach($experiences_table as $level => $val)
	{
		//echo 'level : '.$level . ' xp : ' . $val[$typeXp].'<br />';
		if($val[$typeXp] > $valeurXp) return $levelToReturn;
		else $levelToReturn = $level;
	}
	return $levelToReturn;
}

/**
 * paginate($url, $param, $total, $current [, $adj]) appelée à chaque affichage de la pagination
 * @param string $url - URL ou nom de la page appelant la fonction, ex: 'index.php' ou 'http://example.com/'
 * @param string $param - paramètre à ajouter à l'URL, ex: '?page=' ou '&amp;p='
 * @param int $total - nombre total de pages
 * @param int $current - numéro de la page courante
 * @param int $adj (facultatif) - nombre de numéros de chaque côté du numéro de la page courante (défaut : 3)
 * @return string $pagination
 */
function paginate($url, $param, $total, $current, $adj=3)
{
	/* Déclaration des variables */
	$prev = $current - 1; // numéro de la page précédente
	$next = $current + 1; // numéro de la page suivante
	$n2l = $total - 1; // numéro de l'avant-dernière page (n2l = next to last)

	/* Initialisation : s'il n'y a pas au moins deux pages, l'affichage reste vide */
	$pagination = '';
	
	$pagination .= '<div class="pagination2 right" style="margin-right:15px;">';
	$pagination .= '	<span class="bg-dark">Page '.$current.' sur '.$total.'</span>';

	/* Sinon ... */
	if ($total > 1)
	{
		/* ////////// Début affichage du bouton [précédent] ////////// */
		if ($current == 2) // la page courante est la 2, le bouton renvoit donc sur la page 1, remarquez qu'il est inutile de mettre ?p=1
			$pagination .= "<a href=\"{$url}\" class=\"plusetmoinpagination\">&laquo;</a>";
		elseif ($current > 2) // la page courante est supérieure à 2, le bouton renvoit sur la page dont le numéro est immédiatement inférieur
			$pagination .= "<a href=\"{$url}{$param}{$prev}\" class=\"plusetmoinpagination\">&laquo;</a>";
		else // dans tous les autres, cas la page est 1 : désactivation du bouton [précédent]
			$pagination .= "<a class=\"plusetmoinpagination\" style=\"cursor:default;\">&laquo;</a>";
		/* Fin affichage du bouton [précédent] */

		/* ///////////////
		Début affichage des pages, l'exemple reprend le cas de 3 numéros de pages adjacents (par défaut) de chaque côté du numéro courant
		- CAS 1 : il y a au plus 12 pages, insuffisant pour faire une troncature
		- CAS 2 : il y a au moins 13 pages, on effectue la troncature pour afficher 11 numéros de pages au total
		/////////////// */

		/* CAS 1 */
		if ($total < 7 + ($adj * 2))
		{
			/* Ajout de la page 1 : on la traite en dehors de la boucle pour n'avoir que index.php au lieu de index.php?p=1 et ainsi éviter le duplicate content */
			$pagination .= ($current == 1) ? '<span class="current">1</span>' : "<a href=\"{$url}\">1</a>"; // Opérateur ternaire : (condition) ? 'valeur si vrai' : 'valeur si fausse'

			/* Pour les pages restantes on utilise une boucle for */
			for ($i = 2; $i<=$total; $i++)
			{
				if ($i == $current) // Le numéro de la page courante est mis en évidence (cf fichier CSS)
				$pagination .= "<span class=\"current\">{$i}</span>";
				else // Les autres sont affichés normalement
				$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
			}
		}

		/* CAS 2 : au moins 13 pages, troncature */
		else
		{
			/*
			Troncature 1 : on se situe dans la partie proche des premières pages, on tronque donc la fin de la pagination.
			l'affichage sera de neuf numéros de pages à gauche ... deux à droite (cf figure 1)
			*/
			if ($current < 2 + ($adj * 2))
			{
				/* Affichage du numéro de page 1 */
				$pagination .= ($current == 1) ? "<span class=\"current\">1</span>" : "<a href=\"{$url}\">1</a>";

				/* puis des huit autres suivants */
				for ($i = 2; $i < 4 + ($adj * 2); $i++)
				{
				if ($i == $current)
					$pagination .= "<span class=\"current\">{$i}</span>";
					else
					$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}

				/* ... pour marquer la troncature */
				//$pagination .= '<li><a href="#navigation"> ... </a></li>';
				$pagination .= '<span class="point"> ... </span>';

				/* et enfin les deux derniers numéros */
				$pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
				$pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
			}

			/*
			Troncature 2 : on se situe dans la partie centrale de notre pagination, on tronque donc le début et la fin de la pagination.
			l'affichage sera deux numéros de pages à gauche ... sept au centre ... deux à droite (cf figure 2)
			*/
			elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) )
			{
				/* Affichage des numéros 1 et 2 */
				$pagination .= "<a href=\"{$url}\">1</a>";
				$pagination .= "<a href=\"{$url}{$param}2\">2</a>";

				$pagination .= '<span class="point"> ... </span>';

				/* les septs du milieu : les trois précédents la page courante, la page courante, puis les trois lui succédant */
				for ($i = $current - $adj; $i <= $current + $adj; $i++)
				{
					if ($i == $current)
					$pagination .= "<span class=\"current\">{$i}</span>";
					else
					$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}

				$pagination .= '<span class="point"> ... </span>';

				/* et les deux derniers numéros */
				$pagination .= "<a href=\"{$url}{$param}{$n2l}\">{$n2l}</a>";
				$pagination .= "<a href=\"{$url}{$param}{$total}\">{$total}</a>";
			}

			/*
			Troncature 3 : on se situe dans la partie de droite, on tronque donc le début de la pagination.
			l'affichage sera deux numéros de pages à gauche ... neuf à droite (cf figure 3)
			*/
			else
			{
				/* Affichage des numéros 1 et 2 */
				$pagination .= "<a href=\"{$url}\">1</a></li>";
				$pagination .= "<a href=\"{$url}{$param}2\">2</a>";

				$pagination .= '<span class="point"> ... </span>';

				/* puis des neufs dernières */
				for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++)
				{
					if ($i == $current)
						$pagination .= "<span class=\"current\">{$i}</span>";
					else
						$pagination .= "<a href=\"{$url}{$param}{$i}\">{$i}</a>";
				}
			}
		}
		/* Fin affichage des pages */

		/* ////////// Début affichage du bouton [suivant] ////////// */
		if ($current == $total)
			$pagination .= '<a href="" style="cursor:default;" class="plusetmoinpagination">&raquo;</a>';
		else
			$pagination .= "<a href=\"{$url}{$param}{$next}\" class=\"plusetmoinpagination\">&raquo;</a>";
		/* Fin affichage du bouton [suivant] */

	}
	
		/* </div> de fermeture */
		$pagination .= "</div>";

	/* Fin de la fonction, renvoi de $pagination au programme */
	return ($pagination);
}



//*** Parsage BBCODE
function parsebbcode($texte)
{
	$bbcode = array(
		'#\[url=([http://].+?)](.+?)\[/url]#si' 	        => '<a href="$1" title="$1">$2</a>',
		'#\[url=(.+?)](.+?)\[/url]#si' 				=> '<a href="http://$1" title="$1">$2</a>',
		'#\[url]([http://].+?)\[/url]#si' 			=> '<a href="$1" title="$1">$1</a>',
		'#\[url](.+?)\[/url]#si'	 			=> '<a href="http://$1" title="$1">$1</a>',
		'#\[b](.+?)\[/b]#si'					=> '<strong>$1</strong>',
		'#\[u](.+?)\[/u]#si'					=> '<span style="text-decoration:underline;">$1</span>',
		'#\[overline](.+?)\[/overline]#si'					=> '<span style="text-decoration:overline;">$1</span>',
		'#\[i](.+?)\[/i]#si'					=> '<em>$1</em>',
		'#\[strike](.+?)\[/strike]#si'				=> '<span style="text-decoration:line-through;">$1</span>',
		'#\[overline](.+?)\[/overline]#si'			=> '<span style="text-decoration:overline;">$1</span>',
		'#\[quote=me](.+?)\[/quote]#si'				=> '<br /><strong>J\'ai &eacute;crit</strong> :<br/><div class="quote">$1 </div><br />',
		'#\[quote=(.+?)](.+?)\[/quote]#si'			=> '<br /><strong>$1 &agrave; &eacute;crit</strong> :<br/><div class="quote">$2 </div><br />',
		'#\[quote](.+?)\[/quote]#si'				=> '<br /><strong>Citation</strong> :<br/><div class="quote">$1 </div><br />',
		'#\[img=(.+?)](.+?)\[/img]#si'				=> '<a href="$1"><img class="imageforum" src="$1" alt="$2"/></a>',
		'#\[img](.+?)\[/img]#si'				=> '<a href="$1"><img class="imageforum" src="$1" /></a>',
		'#\[email=([mailto:].+?)](.+?)\[/email]#si'	        => '<a href="$1">$2</a>',
		'#\[email=(.+?)](.+?)\[/email]#si'			=> '<a href="mailto:$1">$2</a>',
		'#\[email]([mailto:].+?)\[/email]#si'			=> '<a href="$1">$1</a>',
		'#\[email](.+?)\[/email]#si'				=> '<a href="mailto:$1">$1</a>',
		'#\[align=(left|center|right)](.+?)\[/align]#si'	=> '<div style="text-align:$1; width:100%;">$2</div>',
		'#\[color=(.+?)](.+?)\[/color]#si'			=> '<span style="color:$1;">$2</span>',
		'#\[size=([0-9]{1,2})](.+?)\[/size]#si'		        => '<span style="font-size:$1px;">$2</span>',
		'#\[decoration=(underline|line-through|overline|blink)](.+?)\[/decoration]#si'	=> '<span style="text-decoration:$1;">$2</span>',
		'#\[font=(.+?)](.+?)\[/font]#si'			=> '<span style="font-family:$1;">$2</span>',
		'#\[list=(circle|disc|square|i|none)](.+?)\[/list]#si'	=> '<ul style="list-style-type:$1;">$2</ul>',
		'#\[list](.+?)\[/list]#si'				=> '<ul>$1</ul>',
		'#\[list=1](.+?)\[/list]#si'				=> '<ol>$1</ol>',
		'#\[\*=(circle|disc|square|i)](.+?)#si'		        => '<li type="$1">$2</li>',
		'#\[\*](.+?)\[/\*]#si'					=> '<li>$1</li>',
		'#\[spc=([0-9]{1,2})](.+?)\[/spc]#si'			=> '<span style="letter-spacing:$1px;">$2</span>',
		'#\[low](.+?)\[/low]#si'	 			=> '<span style="text-transform:lowercase;">$1</span>',
		'#\[caps](.+?)\[/caps]#si'	 			=> '<span style="text-transform:uppercase;">$1</span>',
		'#\[sub](.+?)\[/sub]#si'	 			=> '<sub>$1</sub>',
		'#\[sup](.+?)\[/sup]#si'	 			=> '<sup>$1</sup>',
		'#\[left](.+?)\[/left]#si'	 			=> '<span style="float:left;">$1</span>',
		'#\[right](.+?)\[/right]#si'	 			=> '<span style="float:right;">$1</span>',
		'#:(\^\^|666|ange|angel|arf|arrow|aww|bad|beurk|biggrin|clown|cool|cry|diablo|eek|erf|frown|glasses|great|grrrrrr|happy|he|heart|idea|info|intello|jap|kiss|lol|love|mad|mdr|money|na|neutral|no|oh|oops|ouch|paf|panpan|party|rofl|rules|sarcastic|shocked|sleep|smile|star|surprised|tongue|unlove|user|warn|whip|whistle|wink|winktongue|yipi|zzz):#si'	=> '<img src="images/smilie/$1.gif" alt="$1" />',
		'#\[couleur=(.+)\](.+)\[/couleur\]#isU'	 			=> '<span style="color: $1;">$2</span>',
		'#\[size=([0-9]{1,2})\](.+)\[/size\]#isU'	 			=> '<span style="font-size: $1;">$2</span>'
	);
	$bbcodeADMIN=array(
		'#\[flash@largeur=\[([0-9]{1,3})\]@hauteur=\[([0-9]{1,3})\]\](.+?)\[/flash\]#si'	 			=> '<object width="$1" height="$2"><param name=movie value="$3"><param name="quality "value="high"><embed src="$3" quality="high" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="$1" height="$2"></embed></object>',
		'#\[spoil\](.+)\[/spoil\]#is'				=> '<span class="spoilertexte">Texte cach&eacute; : cliquez sur le cadre pour l\'afficher</span><div class="spoiler" onclick="switch_spoiler(this)"><div style="visibility: hidden;" class="spoiler3">$1</div></div>'
	);
	$bbcode=$bbcode+$bbcodeADMIN;
return preg_replace(array_flip($bbcode), $bbcode, $texte);
}

//*** Boutton BBCODE
//*** bouttonBBcode(VAR) FALSE = Pour users         TRUE = pour admin
function bouttonBBcode()
{
	$affichage = 'oui';
?>
<p style="text-align:center;margin-top:8px;margin-bottom:4px;">
<a href="javascript:AddB()"><img src="images/bbcode/bold.jpg" border="0" alt="Bold" /></a>
<a href="javascript:AddI()"><img src="images/bbcode/italic.jpg" border="0" alt="Italic" /></a>
<a href="javascript:AddU()"><img src="images/bbcode/underline.jpg" border="0" alt="Underline" /></a>
<a href="javascript:AddS()"><img src="images/bbcode/strike.jpg" border="0" alt="Strike" /></a>
<a href="javascript:AddOv()"><img src="images/bbcode/overline.jpg" border="0" alt="Overline" /></a>
<a onmouseover="showWMTT('tooltip_caps')" onmouseout="hideWMTT()" href="javascript:AddCaps()"><img src="images/bbcode/all_caps.jpg" border="0" alt="En majuscule" /></a>
<a onmouseover="showWMTT('tooltip_low')" onmouseout="hideWMTT()" href="javascript:AddLow()"><img src="images/bbcode/all_lowercase.jpg" border="0" alt="En minuscule" /></a>
<a onmouseover="showWMTT('tooltip_spacing')" onmouseout="hideWMTT()" href="javascript:AddSpc()"><img src="images/bbcode/spacing.jpg" border="0" alt="Espacement entre lettre" /></a>
<img src="images/bbcode/spacer.png" border="0" width="2" alt="separate" />
<a onmouseover="showWMTT('tooltip_email')" onmouseout="hideWMTT()" accesskey="e" href="javascript:AddLink('EMAIL')"><img src="images/bbcode/email.jpg" border="0" alt="Email" /></a>
<a onmouseover="showWMTT('tooltip_url')" onmouseout="hideWMTT()" accesskey="w" href="javascript:AddLink('URL')"><img src="images/bbcode/link.jpg" border="0" alt="Lien" /></a>
<a onmouseover="showWMTT('tooltip_img')" onmouseout="hideWMTT()" accesskey="p" href="javascript:AddImg()"><img src="images/bbcode/image.jpg" border="0" alt="Image" /></a>
<a onmouseover="showWMTT('tooltip_list')" onmouseout="hideWMTT()" accesskey="l" href="javascript:AddList()"><img src="images/bbcode/list.jpg" border="0" alt="liste" /></a>
<a onmouseover="showWMTT('tooltip_quote')" onmouseout="hideWMTT()" accesskey="q" href="javascript:AddQuote()"><img src="images/bbcode/quote.jpg" border="0" alt="Quote" /></a>
<?php if($affichage=='oui'){?><a onmouseover="showWMTT('tooltip_spoil')" onmouseout="hideWMTT()" accesskey="t" href="javascript:Addspoil()"><img src="images/bbcode/spoil.jpg" border="0" alt="Spoil" /></a><?php } ?>
<a href="javascript:AddTag('[ALIGN=left]', '[/ALIGN]', '')"><img src="images/bbcode/align_left.jpg" border="0" alt="Align left" /></a>
<a href="javascript:AddTag('[ALIGN=center]', '[/ALIGN]', '')"><img src="images/bbcode/align_center.jpg" border="0" alt="Align center" /></a>
<a href="javascript:AddTag('[ALIGN=right]', '[/ALIGN]', '')"><img src="images/bbcode/align_right.jpg" border="0" alt="Align right" /></a>
<a href="javascript:AddSub()"><img src="images/bbcode/sub.jpg" border="0" alt="Subscript" /></a>
<a href="javascript:AddSup()"><img src="images/bbcode/sup.jpg" border="0" alt="Superscript" /></a>
<a onmouseover="showWMTT('tooltip_floatleft')" onmouseout="hideWMTT()" href="javascript:AddLeft()"><img src="images/bbcode/float_left.jpg" border="0" alt="Float left" /></a>
<a onmouseover="showWMTT('tooltip_floatright')" onmouseout="hideWMTT()" href="javascript:AddRight()"><img src="images/bbcode/float_right.jpg" border="0" alt="Float right" /></a>
<?php if($affichage=='oui'){?><a onmouseover="showWMTT('tooltip_flash')" onmouseout="hideWMTT()" accesskey="e" href="javascript:Addflash()"><img src="images/bbcode/flash.jpg" border="0" alt="Flash" /></a><?php } ?>
&nbsp;<select name="fontcolor" onchange="AddTag('[couleur=' + this.value + ']','[/couleur]', '');" style="width:125px;padding-left:0;padding-right:0;position:relative;top:-10px;">
        <option value="#">COULEUR</option>
        <option value="#87CEEB" style="color:#87CEEB;">Bleu ciel</option>
        <option value="#4169E1" style="color:#4169E1;">Bleu clair</option>
        <option value="#0000FF" style="color:#0000FF;">Bleu</option>
        <option value="#00008B" style="color:#00008B;">Bleu foncé</option>
        <option value="#FFA500" style="color:#FFA500;">Orange</option>
        <option value="#FF4500" style="color:#FF4500;">Orange foncé</option>
        <option value="#DC143C" style="color:#DC143C;">Cramoisi</option>
        <option value="#FF0000" style="color:#FF0000;">Rouge</option>
        <option value="#B22222" style="color:#B22222;">Brique</option>
        <option value="#8B0000" style="color:#8B0000;">Rouge foncé</option>
        <option value="#008000" style="color:#008000;">Vert</option>
        <option value="#32CD32" style="color:#32CD32;">Vert clair</option>
        <option value="#2E8B57" style="color:#2E8B57;">Vert marin</option>
        <option value="#FF1493" style="color:#FF1493;">Rose</option>
        <option value="#FF6347" style="color:#FF6347;">Tomate</option>
        <option value="#FF7F50" style="color:#FF7F50;">Corail</option>
        <option value="#800080" style="color:#800080;">Violet</option>
        <option value="#4B0082" style="color:#4B0082;">Indigo</option>
        <option value="#DEB887" style="color:#DEB887;">Bois</option>
        <option value="#F4A460" style="color:#F4A460;">Marron clair</option>
        <option value="#A0522D" style="color:#A0522D;">Marron</option>
        <option value="#D2691E" style="color:#D2691E;">Chocolat</option>
        <option value="#008080" style="color:#008080;">Sarcelle</option>
        <option value="#C0C0C0" style="color:#C0C0C0;">Gris</option>
</select>
<select name="fontsize" onchange="AddTag('[size=' + this.value + ']','[/size]', '');" style="width:85px;padding-left:0;padding-right:0;position:relative;top:-10px;">
        <option value="0">TAILLE</option>
        <option value="8">Minuscule</option>
        <option value="10">Petite</option>
        <option value="12">Normal</option>
        <option value="15">Grande</option>
        <option value="20">Enorme</option>
</select>
<div class="tooltip" style="width: 315px; text-align: center;" id="tooltip_email">[EMAIL=une@adresse.fr]mon@adresse.fr[/EMAIL]<br />[EMAIL]mon@adresse.fr[/EMAIL]</div>
<div class="tooltip" style="width: 265px; text-align: center;" id="tooltip_url">[URL=http://monsite.fr]Mon site[/URL]<br />[URL]http://monsite.fr[/URL]</div>
<div class="tooltip" style="width: 250px; text-align: center;" id="tooltip_img">[IMG]http://monsite.com/image.jpg[/IMG]</div>
<div class="tooltip" style="width: 350px; text-align: center;" id="tooltip_spacing">[spc=x]x = Nombre de pixels entre chaque lettres[/spc]</div>
<div class="tooltip" style="width: 100px; text-align: center;" id="tooltip_caps">MAJUSCULE</div>
<div class="tooltip" style="width: 100px; text-align: center;" id="tooltip_low">minuscule</div>
<div class="tooltip" style="width: 310px; text-align: center;" id="tooltip_list">[LIST=a][*]point 1[/*][*]point 2[/*][/LIST]<br />[LIST=1][*]point 1[/*][*]point 2[/*][/LIST]</div>
<div class="tooltip" style="width: 220px; text-align: center;" id="tooltip_quote">[QUOTE=Nom]Sa citation[/QUOTE]<br />[QUOTE]Une citation[/QUOTE]</div>
<?php if($affichage=='oui'){?><div class="tooltip" style="width: 250px; text-align: center;" id="tooltip_spoil">[spoil]Ici le texte cacher.[/spoil]</div><?php } ?>
<div class="tooltip" style="width: 220px; text-align: center;" id="tooltip_floatleft">[left]Contenu en float left[/left]</div>
<div class="tooltip" style="width: 230px; text-align: center;" id="tooltip_floatright">[right]Contenu en float right[/right]</div>
<?php if($affichage=='oui'){?><div class="tooltip" style="width: 300px; text-align: center;" id="tooltip_flash">[flash@largeur=[100]@hauteur=[100]]http://www.site.com/anim.swf[/flash]</div><?php } ?>
</p>
<?php
}
?>