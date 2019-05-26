<?php if(!defined("BASE_DS")) die(); ?>
<?php 
if(!isset($API_ID_PERSO_PARSING) OR empty($API_ID_PERSO_PARSING)) die();
?>
<?php
	$QUERYBOT2 = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.characters WHERE Id = ?');
	$QUERYBOT2->execute(array($API_ID_PERSO_PARSING));
	$rowOfCharactersForTry = $QUERYBOT2->fetch();
	$QUERYBOT2->closeCursor();
	
	$cache_to_readooo = $CONFIG['cache_folder'].'classement_xprate.cache';
	$XP_TABLE = '';
	if(file_exists($cache_to_readooo))
	{
		$XP_TABLE = file_get_contents($cache_to_readooo);
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

		file_put_contents($cache_to_readooo, $XP_TABLE);
	}
	$XP_TABLE = unserialize($XP_TABLE);
		
// echo $rowOfCharactersForTry['EntityLookString'];
		
/* AFFICHE LE PERSONNAGE EN GROS */
if(isset($API_PERSO_PICT_ALREADY_DOWNLOADED_BIG))
	$b64_image_big = '';
else
{
	$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/full/1/270_361-10.png';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
	$ret_val = curl_exec($curl);
	$b64_image_big =  chunk_split(base64_encode($ret_val));
	curl_close($curl);
	$b64_image_big=nl2br($b64_image_big); 
	$b64_image_big=str_replace('<br />',"",$b64_image_big); 
	$b64_image_big=str_replace(CHR(10),"",$b64_image_big); 
	$b64_image_big=str_replace(CHR(13),"",$b64_image_big);

	if($b64_image_big == '' OR $b64_image_big == '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')
	{
		$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/full/1/270_361-10.png';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		$ret_val = curl_exec($curl);
		$b64_image_big =  chunk_split(base64_encode($ret_val));
		curl_close($curl);
		$b64_image_big=nl2br($b64_image_big); 
		$b64_image_big=str_replace('<br />',"",$b64_image_big); 
		$b64_image_big=str_replace(CHR(10),"",$b64_image_big); 
		$b64_image_big=str_replace(CHR(13),"",$b64_image_big);
	}
	if($b64_image_big == '' OR $b64_image_big == 'iVBORw0KGgoAAAANSUhEUgAAAQ4AAAFpCAYAAABtQMZHAAAABmJLR0QA/wD/AP+gvaeTAAAMjUlEQVR42u3dX6hl10HH8d9ae++zz/0z91/mf9uJcWhqaGIZE4S0aH1QIVIUC76oCFFRK4rSh8THgmARiuhbjQ+CBAK2arVRhClia9OkNcZJmz+TtHGm43Rm7tw79/8995x99l7Lh4GRIU8/H+ZW9vfzvBfsxTl8z9rrnL1PyDlnAYAhHvYJAPj/h3AAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHAVh72CeD7T0pJkpRzVghBkhQjnzH4X4QDd3Rdp729PV27ekUbazfVjEeqqoFWjp/Uqfee0cLCgoqiOOzTxPeBkHPOh30SOFwpJU2nU73+zQtKm9d139xAMTcabd5UTq2m04k29keq3/eozj3+UdV1zQqk5whHz6WUdHBwoFe+9hXdf0TauvFdrX77Fe3f+La2b21oYX5GM8tHNbtyVLE50ObiI/qJX/o9zc3NEY8e41Kl55qm0Ytf+ie9f6nSd176V61dOK+d61c0Hk/UpaC2DhoMKg0Wl1SvnFQ5fV3/vLurj/3OpzQzM3PYp49Dwoqjx7qu03+89IJmr72qa+98UzdfOa+t1VXtTJJSyiqLQvN11PxAqgppMDenNJhT3tnS6d96Rh954uPsefQUK46eSilpfW1N44tf02jrqt748nlt3Lyuzb1Gbaw0t7ykbmddUZXKUKkIUj44UJmzmiDdePZp3fyRD+vEyVNcsvQQr3hPpZT0xje+ornxLV298HXFvXUdNFOdfORH9duf/Xv9wedf1hOf/IxWx1G7405dFzRupb3dRqMDKe6u6+Xnn7vz1S36hXD01Obmpqq1i5pOd1Tu39B4PFGxdFq/8ad/rUc++oSOnj6jn/7VT+rcxz+h1c2xdifSwViqYtbiMGu2jhp9+S+1ubFx2FPBISAcPdR1nS5dfE3LeUdbly9qvL2t/XGrUw8+rGPvvf+uY3/8F55UGh7RpOk0WwXNDqJmBkEpB903ua5Lr7+irusOe0q4xwhHD7Vtq823vqE02lG3cUM5JeUsBYV3HXvigQe1cv/7pa5RSlLXSVUMqsqoKmatvvQ84eghwtFD21tbGq5f0vjWqjTe0WwVdaQuNNrcVDOd3nVsXdcq55e0M+6UUlAZgooQVCooKCpeelF7u7uHPSXcY4SjZ1JKWrtxTcfKfaX9LVVto2EVtTgz1Nbli1q99Pa7xszNz6sOUl1ISrffNEWWppOs4nuXtb56nU3SniEcPZNz1tZ/X9L0+pr2r91UO+pUhajFmUrlaFtvfvX8u8bEUClIGhRBdRGUWykmaTLKWhpIu+s3DntauMcIR8+klDS+/o7quUp1btTsJWmaVUpaGZb6z394Tk0zuWtMXdeqQlRQVBGiQiuNNjsNyqiZmaD9KxdZcfQM4eiZruuUt69rUEjDMmllsVJupJiDFmZnde3Vf9eLX/z8XWOqIA1iUBWDuiZrspu0slJqcaGQuqDmxn8Rjp4hHD2TUlIx2lTa21PRTTUsg+brqGMLUacWSz1030AvPvNpbd9avzNmMmm0P846GCWpyVpeKlQWQWWWZupC3fZNcedCvxCOnmkmEw33txS6scqYNTOMGsagKgfND6NOLM2p+t4b+sc/flrNtFUnaTjd10IdNQhSEaRBXdzeIFVQniTFZsSKo2e4V6VnUupUNwcqUqciSykHzR8pNdrvVAZpfhB05uii3nn+r/SFlVN69Gd/Ud3aVR09UmtmWKgbJcUk1XWhGKU6BBVde9jTwj1GOHonKKapwmSios0qYlAoo6rFqJ3dTpPUqY6FVuZmdOEv/kiX/uazivubOrkwo91x1tIgqp1mDWJWrKKqOqosuUO2bwhHzwzqWuMUVU0P1CooxNu/F01BGgyCyi5o2iWlptGZH35Mxx46p9xNtPnay9q49LaWzywo6/YmaT2QSmV1BQ/16RvC0TNVValdOa3B/luaBik3UlEHdZKqMqosskI30oM//6Q+8tRnVM/OSZK219f08p88pealv1WYLRVyVhGCYhc0PH2WcPQMr3bPFEWh8gOPa5CzBsOgItz+MVcRgsogjfdaHeQ5PfbrT9+JhiQtHj2mx373DzUthspdJ3VS7KTZmVIzH/wwD/TpGcLRMzFGHTv3Y0qhUFVEDepS2u2Ut1p1e52qELRQJW1ffuuucdOm0dufe0bt7kiDqtJAQWWTtJHmdfLBh1lx9AyXKj0TY9R7Hjir1x74ST1y+bx2mk5FzirmS+Uu62hdKI4afevTv6krj39MR953VilHXfu3L6p76+s6sTyjqs0qu6ylYaVXH/1lPXrs+GFPC/cYzxztoZSSrnznbc1/6udU7W6rmymUh1FdmzVK0sE0aXcy1cb2vsbjqRSkI/OzWl6Y1dwganCQtDIM2j5zVsOnPqejx46z4ugZwtFTbdvqzRf+RQ89+wlNJ1NNY1BKWdMuaxqCmpQ1abOaNqmMQVUZFA86Va20ELImp45r5/ef1QM/9EH2N3qIcPTYdDrVm1/9kn7guae0MNnRKGe1IaibJqUotW2WiqBQBIUsxZsTLR+vdWP5fu392p/p7MMfIho9RTh6rus6Xb30jjb/7s/1gYtf0MxskNqkdpqUuqw4iCrLII2z1vcqffenntR7fuZXdOzESaLRY4QDd/4CcvXqFa1deEGDq9/S0q3LCjtbSkeWtXH0rNIPntOJDz2u46dOqygK9jR6jnDgjpSScs5q21ZN06hrWxVlefvxgeXtL+AIBiTCAeD/gI8PADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHABvhAGAjHABshAOAjXAAsBEOADbCAcBGOADYCAcAG+EAYCMcAGyEA4CNcACwEQ4ANsIBwEY4ANgIBwAb4QBgIxwAbIQDgI1wALARDgA2wgHARjgA2AgHANv/AN0YW+yaxUhEAAAAAElFTkSuQmCC')
	{
		$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/full/1/270_361-10.png';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		$ret_val = curl_exec($curl);
		$b64_image_big =  chunk_split(base64_encode($ret_val));
		curl_close($curl);
		$b64_image_big=nl2br($b64_image_big); 
		$b64_image_big=str_replace('<br />',"",$b64_image_big); 
		$b64_image_big=str_replace(CHR(10),"",$b64_image_big); 
		$b64_image_big=str_replace(CHR(13),"",$b64_image_big);
	}
}

/* AFFICHE LE PERSONNAGE EN MINI */
if(isset($API_PERSO_PICT_ALREADY_DOWNLOADED_MINI))
	$b64_image_mini = '';
else
{
	$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/face/2/35_35-0.png';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
	$ret_val = curl_exec($curl);
	$b64_image_mini =  chunk_split(base64_encode($ret_val));
	curl_close($curl);
	$b64_image_mini=nl2br($b64_image_mini); 
	$b64_image_mini=str_replace('<br />',"",$b64_image_mini); 
	$b64_image_mini=str_replace(CHR(10),"",$b64_image_mini); 
	$b64_image_mini=str_replace(CHR(13),"",$b64_image_mini);

	if($b64_image_mini == '' OR $b64_image_mini == 'PGh0bWw+PGJvZHk+PGgxPjUwMiBCYWQgR2F0ZXdheTwvaDE+ClRoZSBzZXJ2ZXIgcmV0dXJuZWQgYW4gaW52YWxpZCBvciBpbmNvbXBsZXRlIHJlc3BvbnNlLgo8L2JvZHk+PC9odG1sPgoK' OR $b64_image_mini == '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')
	{
		$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/face/2/35_35-0.png';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		$ret_val = curl_exec($curl);
		$b64_image_mini =  chunk_split(base64_encode($ret_val));
		curl_close($curl);
		$b64_image_mini=nl2br($b64_image_mini); 
		$b64_image_mini=str_replace('<br />',"",$b64_image_mini); 
		$b64_image_mini=str_replace(CHR(10),"",$b64_image_mini); 
		$b64_image_mini=str_replace(CHR(13),"",$b64_image_mini);
	}
	if($b64_image_mini == '' OR $b64_image_mini == 'PGh0bWw+PGJvZHk+PGgxPjUwMiBCYWQgR2F0ZXdheTwvaDE+ClRoZSBzZXJ2ZXIgcmV0dXJuZWQgYW4gaW52YWxpZCBvciBpbmNvbXBsZXRlIHJlc3BvbnNlLgo8L2JvZHk+PC9odG1sPgoK' OR $b64_image_mini == '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')
	{
		$url = $urlcurl = 'http://staticns.ankama.com/dofus/renderer/look/'.bin2hex($rowOfCharactersForTry['EntityLookString']).'/face/2/35_35-0.png';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
		$ret_val = curl_exec($curl);
		$b64_image_mini =  chunk_split(base64_encode($ret_val));
		curl_close($curl);
		$b64_image_mini=nl2br($b64_image_mini); 
		$b64_image_mini=str_replace('<br />',"",$b64_image_mini); 
		$b64_image_mini=str_replace(CHR(10),"",$b64_image_mini); 
		$b64_image_mini=str_replace(CHR(13),"",$b64_image_mini);
	}
}
?>
<?php
	// Affiche les items+stats
	
	// $hoverBoxEasyTooltip = '';
	$listIdItemImageArray = array();
	
	$QUERYBOT = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.characters_items WHERE OwnerId = ? AND (Position <= 15 OR Position = 63) ORDER BY Position');
	// $QUERYBOT = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.characters_items WHERE OwnerId = ? AND Position = 63 ORDER BY Position');
	$QUERYBOT->execute(array($API_ID_PERSO_PARSING));
	$tableau_stat_perso_array = array(
	// Caractéristiques primaires
		'vitalite' => array('base' => 0, 'bonus' =>0),
		'sagesse' => array('base' => 0, 'bonus' =>0),
		'force' => array('base' => 0, 'bonus' =>0),
		'intelligence' => array('base' => 0, 'bonus' =>0),
		'chance' => array('base' => 0, 'bonus' =>0),
		'agilite' => array('base' => 0, 'bonus' =>0),
		'pa' => array('base' => 0, 'bonus' =>0),
		'pm' => array('base' => 0, 'bonus' =>0),
		'initiative' => array('base' => 0, 'bonus' =>0),
		'prospection' => array('base' => 100, 'bonus' =>0),
		'portee' => array('base' => 0, 'bonus' =>0),
		'invocation' => array('base' => 0, 'bonus' =>0),

	// Caractéristiques secondaires
		'retrait_pa' => array('base' => 0, 'bonus' =>0),
		'esquive_pa' => array('base' => 0, 'bonus' =>0),
		'retrait_pm' => array('base' => 0, 'bonus' =>0),
		'esquive_pm' => array('base' => 0, 'bonus' =>0),
		'coupscritiques' => array('base' => 0, 'bonus' =>0),
		'soins' => array('base' => 0, 'bonus' =>0),
		'tacle' => array('base' => 0, 'bonus' =>0),
		'fuite' => array('base' => 0, 'bonus' =>0),
		
	// Dommages
		'dommages' => array('base' => 0, 'bonus' =>0),
		'dommages_puissance' => array('base' => 0, 'bonus' =>0),
		'dommages_critiques' => array('base' => 0, 'bonus' =>0),
		'dommages_neutre' => array('base' => 0, 'bonus' =>0),
		'dommages_terre' => array('base' => 0, 'bonus' =>0),
		'dommages_feu' => array('base' => 0, 'bonus' =>0),
		'dommages_eau' => array('base' => 0, 'bonus' =>0),
		'dommages_air' => array('base' => 0, 'bonus' =>0),
		'dommages_renvoi' => array('base' => 0, 'bonus' =>0),
		'dommages_pieges_fixe' => array('base' => 0, 'bonus' =>0),
		'dommages_pieges_puissance' => array('base' => 0, 'bonus' =>0),
		'dommages_poussee' => array('base' => 0, 'bonus' =>0),
		
	// Résistances
		'resistances_neutre_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_neutre_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_terre_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_terre_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_feu_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_feu_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_eau_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_eau_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_air_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_air_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_coupscritiques' => array('base' => 0, 'bonus' =>0),
		'resistances_poussee' => array('base' => 0, 'bonus' =>0),
		
	// Résistances JCJ
		'resistances_jcj_neutre_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_neutre_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_terre_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_terre_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_feu_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_feu_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_eau_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_eau_percent' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_air_fixe' => array('base' => 0, 'bonus' =>0),
		'resistances_jcj_air_percent' => array('base' => 0, 'bonus' =>0)
	);
	$array_equipement_inventaire = array();
	$id_equipement_inventaire = 0;
	$array_easytoolbox_hover = array();
	
	while($rowItemsDuPerso = $QUERYBOT->fetch())
	{
		$nameid = positionItemToName($rowItemsDuPerso['Position']);
		
		$BINARY = $rowItemsDuPerso['SerializedEffects'];
		$binaryHexaSnaopo = binaryToHexaSnapzItems($BINARY);
		
		// UPDATE LES STATS DU PERSO DU TABLEAU DU BASE_DS
		if($nameid != 'inventaire' AND $nameid != '') updateStatsArrayWithItemStats($tableau_stat_perso_array, $binaryHexaSnaopo, $statstexte_plus, $statstexte_malus);
		
		// echo $rowItemsDuPerso['ItemId'].' en position '.$rowItemsDuPerso['Position'].'<br />';
		
		$QUERYBOT2 = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.item_with_name WHERE IdItem = ?');
		$QUERYBOT2->execute(array($rowItemsDuPerso['ItemId']));
		$rowItemWithName = $QUERYBOT2->fetch();
		$QUERYBOT2->closeCursor();
		if($rowItemWithName)
		{
			// echo 'Nom de l\'item : '.$rowItemWithName['Name'].'<br />';
			// echo 'Level : '.$rowItemWithName['Level'].'<br />';
			// echo 'Image : <img src="images/items_neft-gaming/'.$rowItemWithName['ImageId'].'.png" alt="" /><br />';
			if($nameid != 'inventaire' AND $nameid != '') $listIdItemImageArray[$nameid] = $rowItemWithName['ImageId'];
			if($nameid == 'inventaire')
			{
				$id_equipement_inventaire++;
				$nameid = $nameid.$id_equipement_inventaire;
				
				array_push($array_equipement_inventaire, array($nameid, $rowItemWithName['ImageId'], $rowItemsDuPerso['Stack']));
			}
		
			$stat_of_objet = boutique_stat_to_clear_html($binaryHexaSnaopo, $statstexte_plus, $statstexte_malus, $statstexte_cac, $couleurstats, $statstexte_ignored);
			if($stat_of_objet == '') $stat_of_objet = "<div class='ak-encyclo-detail-aligne' style='color:red;'>Aucune statistique.</div>";
			/*$TypeOfObjectShow = '';
			
			
			
			// On verif si c'est un ITEM (et donc pas un cac)
			$QUERYBOT2 = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.items_templates_arka WHERE Id = ?');
			$QUERYBOT2->execute(array($rowItemsDuPerso['ItemId']));
			$rowItemTemplateEmu = $QUERYBOT2->fetch();
			$QUERYBOT2->closeCursor();
			// Sinon c'est un cac
			if(!$rowItemTemplateEmu)
			{
				$QUERYBOT2 = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.items_templates_weapons WHERE Id = ?');
				$QUERYBOT2->execute(array($rowItemsDuPerso['ItemId']));
				$rowItemTemplateEmu = $QUERYBOT2->fetch();
				$QUERYBOT2->closeCursor();
			}
			// Si un ITEM/CAC a etait trouvé on recup son type + level
			if($rowItemTemplateEmu)
			{
				$TypeOfObjectShow = $TypeItemTOrealNameArray[$rowItemTemplateEmu['TypeId']];
				if(!isset($rowItemWithName['Level']) OR empty($rowItemWithName['Level'])) $rowItemWithName['Level'] = $rowItemTemplateEmu['Level'];
			}
			*/
			$imageid_to_push = $rowItemWithName['ImageId'];
			$nom_to_push = (isset($rowItemWithName['Name']) AND !empty($rowItemWithName['Name'])) ? $rowItemWithName['Name'] : '<strong style="color:red;">Nom inexistant.</strong>';
			$type_to_push = (isset($rowItemWithName['TypeId']) AND !empty($rowItemWithName['TypeId'])) ? $TypeItemTOrealNameArray[$rowItemWithName['TypeId']] : '<strong style="color:red;">Non disponible.</strong>';
			$level_to_push = (isset($rowItemWithName['Level']) AND !empty($rowItemWithName['Level'])) ? $rowItemWithName['Level'] : '<strong style="color:red;">Non disponible.</strong>';
			$stat_of_objet_to_push = $stat_of_objet;
			array_push($array_easytoolbox_hover, array($nameid, $imageid_to_push, $nom_to_push, $type_to_push, $level_to_push, $stat_of_objet_to_push));
			/*
			$hoverBoxEasyTooltip = $hoverBoxEasyTooltip . '
			  <div id="'.$nameid.'" style="display:none;">
				<div class="ak-top">
					<div class="ak-encyclo-detail-illu ak-illu"><img src="images/items_Neft-Gaming/'.$rowItemWithName['ImageId'].'.png" /></div>
					<div class="ak-detail">
						  <div class="ak-name">'.((isset($rowItemWithName['Name']) AND !empty($rowItemWithName['Name'])) ? $rowItemWithName['Name'] : '<strong style="color:red;">Nom inexistant.</strong>').'</div>
						  <div class="ak-type">Type '.((isset($rowItemWithName['TypeId']) AND !empty($rowItemWithName['TypeId'])) ? $TypeItemTOrealNameArray[$rowItemWithName['TypeId']] : '<strong style="color:red;">Non disponible.</strong>').'</div>
						  <div class="ak-level">Niveau&nbsp;'.((isset($rowItemWithName['Level']) AND !empty($rowItemWithName['Level'])) ? $rowItemWithName['Level'] : '<strong style="color:red;">Non disponible.</strong>').'</div>
					</div>
				</div>
				<div class="ak-encyclo-detail">
					'.$stat_of_objet.'
				</div>
			  </div>';
			*/
		 }
	}
	$QUERYBOT->closeCursor();
	
	$array_of_spell_perso = array();
	
	$QUERYBOT = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.characters_spells WHERE OwnerId = ?');
	$QUERYBOT->execute(array($API_ID_PERSO_PARSING));
	while($rowSpellDuPerso = $QUERYBOT->fetch())
	{
		if($rowSpellDuPerso['SpellId'] == 0) continue;
		$QUERYBOT2 = $Sql->prepare('SELECT * FROM '.$CONFIG['db_world'].'.spell_with_name WHERE IdSpell = ?');
		$QUERYBOT2->execute(array($rowSpellDuPerso['SpellId']));
		$rowSpellWithName = $QUERYBOT2->fetch();
		$QUERYBOT2->closeCursor();
		if($rowSpellWithName)
		{
			array_push($array_of_spell_perso, array($rowSpellWithName['Name'], $rowSpellDuPerso['Level'], $rowSpellDuPerso['SpellId']));
		}
	}
	$QUERYBOT->closeCursor();
	
	$tableau_stat_perso_array['vitalite']['base'] = $rowOfCharactersForTry['BaseHealth'] + $rowOfCharactersForTry['Vitality'];
	$tableau_stat_perso_array['sagesse']['base'] = $rowOfCharactersForTry['Wisdom'];
	$tableau_stat_perso_array['force']['base'] = $rowOfCharactersForTry['Strength'];
	$tableau_stat_perso_array['intelligence']['base'] = $rowOfCharactersForTry['Intelligence'];
	$tableau_stat_perso_array['chance']['base'] = $rowOfCharactersForTry['Chance'];
	$tableau_stat_perso_array['agilite']['base'] = $rowOfCharactersForTry['Agility'];
	$tableau_stat_perso_array['pa']['base'] = $rowOfCharactersForTry['AP'];
	$tableau_stat_perso_array['pm']['base'] = $rowOfCharactersForTry['MP'];
	$tableau_stat_perso_array['initiative']['base'] = $tableau_stat_perso_array['force']['base'] + $tableau_stat_perso_array['force']['bonus'] + $tableau_stat_perso_array['intelligence']['base'] + $tableau_stat_perso_array['intelligence']['bonus'] + $tableau_stat_perso_array['chance']['base'] + $tableau_stat_perso_array['chance']['bonus'] + $tableau_stat_perso_array['agilite']['base'] + $tableau_stat_perso_array['agilite']['bonus'];
	$tableau_stat_perso_array['portee']['base'] = 0;
	$tableau_stat_perso_array['invocation']['base'] = 1;

	
	$API_RETURN_ARRAY_OF_A_PERSO = array();
	$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso'] = $rowOfCharactersForTry;
	$API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'] = $listIdItemImageArray;
	$API_RETURN_ARRAY_OF_A_PERSO['hover_toolbox_des_items'] = $array_easytoolbox_hover;
	$API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso'] = $tableau_stat_perso_array;
	$API_RETURN_ARRAY_OF_A_PERSO['equipement_inventaire'] = $array_equipement_inventaire;
	$API_RETURN_ARRAY_OF_A_PERSO['spell_perso_list'] = $array_of_spell_perso;
	$API_RETURN_ARRAY_OF_A_PERSO['level'] = getLevelByExperience($XP_TABLE, 'CharacterExp', $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Experience']);
	
	echo serialize($API_RETURN_ARRAY_OF_A_PERSO);
	
?>