<?php
/*
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
*/
function updateStatsArrayWithItemStats(&$array_of_stats_perso, $statArgs, $statstexte_plus, $statstexte_malus)
{
	// $array_of_stats_perso['vitalite']['bonus'] = 13371337;
	$statArgs = strtolower($statArgs);
	$statsexplode = explode(',', $statArgs);
	
	foreach($statsexplode AS $oneStat)
	{
		if(!strstr($oneStat, '#'))continue;
		$statshexa=explode('#', $oneStat);
		$jetMAX = $statshexa[2];
			// Negatif
			if(array_key_exists($statshexa[0], $statstexte_malus))
			{
				if(isset($statstexte_malus[$statshexa[0]][3]) AND !empty($statstexte_malus[$statshexa[0]][3])) $array_of_stats_perso[$statstexte_malus[$statshexa[0]][3]]['bonus'] -= $jetMAX;
			}
			// Positif
			elseif(array_key_exists($statshexa[0], $statstexte_plus))
			{
				if(isset($statstexte_plus[$statshexa[0]][3]) AND !empty($statstexte_plus[$statshexa[0]][3])) $array_of_stats_perso[$statstexte_plus[$statshexa[0]][3]]['bonus'] += $jetMAX;
			}
	}
}

$items_array = array(
'coiffe' => 16,
'cape' => 17,
'ceinture' => 10,
'botte' => 11,
'amulette' => 1,
'anneau' => 9,
'familier' => 18,
'dofus' => 23,
'bouclier' => 82,
'arc' => 2,
'baguette' => 3,
'baton' => 4,
'dague' => 5,
'epee' => 6,
'hache' => 19,
'pelle' => 8,
'marteau' => 7,
'dragodinde' => 97
);

$TypeItemTOrealNameArray = array(
16 => 'Coiffe',
17 => 'Cape',
10 => 'Ceinture',
11 => 'Botte',
1 => 'Amulette',
9 => 'Anneau',
18 => 'Familier',
23 => 'Dofus',
82 => 'Bouclier',
2 => 'Arc',
3 => 'Baguette',
4 => 'B&acirc;ton',
5 => 'Dague',
6 => '&Eacute;p&eacute;e',
19 => 'Hache',
8 => 'Pelle',
7 => 'Marteau',
97 => 'Dragodinde',
22 => 'Faux',
20 => 'Outil',
83 => 'Pierre d\'&acirc;me',
21 => 'Pioche',
81 => 'Sac &agrave; dos',
151 => 'Troph&eacute;e',
121 => 'Montilier'
);

$services_array = array(
'parchemin' => 76,
'objet_vivant' => 113
);


$statstexte_cac=array(
	//Degats
	'62' => array('(air)','air', 'air'),
    '61' => array('(terre)','terre', 'earth'),
	'63' => array('(feu)','feu', 'fire'),
	'60' => array('(eau)','eau', 'water'),
	'64' => array('(neutre)','neutre', 'neutral'),
	//Vole de vie
	'5b' => array('(eau)','eau', 'water'),
	'5c' => array('(terre)','terre', 'earth'),
	'5d' => array('(air)','air', 'air'),
	'5e' => array('(feu)','feu', 'fire'),
	'5f' => array('(neutre)','neutre', 'neutral'),
	//Vol de kamas
	'82' => array('','defaut', 'tx-stalskamas'),
	'6e' => array('Vie','vie', 'life'),
	// PV rendus
	'6c' => array('PV rendus','vie', 'life')
);


// Variable qui contients les données pour l'affichage des statistiques des objets.
$statstexte_plus=array(
	// Static
	'70' => array('Dommages','do', 'tx-damage', 'dommages'), // Celui la est use le suivant jcp mais on garde
	'79' => array('Dommages','do', 'tx-damage', 'dommages'),
	'dc' => array('Renvois de dommage','do', 'tx-return', 'dommages_renvoi'),
	'8a' => array('Puissances','do', 'tx-damagespercent', 'dommages_puissance'),
	'73' => array('Coups Critiques','cc', 'tx-criticalhit', 'coupscritiques'),
	'76' => array('Force','terre', 'earth', 'force'),
	'77' => array('Agilité','air', 'air', 'agilite'),
	'7c' => array('Sagesse','sagesse', 'tx-wisdom', 'sagesse'),
    '7e' => array('Intelligence','feu', 'fire', 'intelligence'),
	'7b' => array('Chance','eau', 'water', 'chance'),
	'7d' => array('Vitalité','vie', 'life', 'vitalite'),
	'ae' => array('Initiative','sagesse', 'tx-initiative', 'initiative'),
	'b0' => array('Prospection','pp', 'tx-prospecting', 'prospection'),
	'e1' => array('Dommages pièges','do', 'tx-trap', 'dommages_pieges_fixe'),
	'e2' => array('Puissance pièges','do', 'tx-trappercent', 'dommages_pieges_puissance'),
	'b8' => array('Reduction physique','defaut'),
    'b6' => array('Créatures invocables','defaut', 'tx-summonablecreaturesboost', 'invocation'),
	'b2' => array('Soins','rose', 'tx-heal', 'soins'),
	'6f' => array('PA','pa', 'tx-actionpoints', 'pa'),
	'75' => array('PO','po', 'tx-range', 'portee'),
	'80' => array('PM','defaut', 'tx-movementpoints', 'pm'),
	'd6' => array('% Résistances neutre','neutre', 'tx-neutral', 'resistances_neutre_percent'),
	'd2' => array('% Résistances terre','terre', 'tx-strength', 'resistances_terre_percent'),
	'd3' => array('% Résistances eau','eau', 'tx-chance', 'resistances_eau_percent'),
	'd4' => array('% Résistances air','air', 'tx-agility', 'resistances_air_percent'),
	'd5' => array('% Résistances feu','feu', 'tx-intelligence', 'resistances_feu_percent'),
	'f4' => array('Résistances neutre','neutre', 'tx-neutral', 'resistances_neutre_fixe'),
	'f0' => array('Résistances terre','terre', 'tx-strength', 'resistances_terre_fixe'),
	'f1' => array('Résistances eau','eau', 'tx-chance', 'resistances_eau_fixe'),
	'f2' => array('Résistances air','air', 'tx-agility', 'resistances_air_fixe'),
	'f3' => array('Résistances feu','feu', 'tx-intelligence', 'resistances_feu_fixe'),
	//Resistance ethere
	'32c' => array('','defaut'),
	'320' => array('Pods','defaut'),
	'9e' => array('Pods','defaut'),
	//Resistance pvp
	'fa' => array('% resistances terre PVP','terre', 'tx-strength', 'resistances_jcj_terre_percent'),
	'fb' => array('% resistances eau PVP','eau', 'tx-chance', 'resistances_jcj_eau_percent'),
	'fc' => array('% resistances air PVP','air', 'tx-agility', 'resistances_jcj_air_percent'),
	'fd' => array('% resistances feu PVP','feu', 'tx-intelligence', 'resistances_jcj_feu_percent'),
	'fe' => array('% resistances neutre PVP','neutre', 'tx-neutral', 'resistances_jcj_neutre_percent'),
	'104' => array('resistances terre PVP','terre', 'tx-strength', 'resistances_jcj_terre_fixe'),
	'105' => array('resistances eau PVP','eau', 'tx-chance', 'resistances_jcj_eau_fixe'),
	'106' => array('resistances air PVP','air', 'tx-agility', 'resistances_jcj_air_fixe'),
	'107' => array('resistances feu PVP','feu', 'tx-intelligence', 'resistances_jcj_feu_fixe'),
	'108' => array('resistances neutre PVP','neutre', 'tx-neutral', 'resistances_jcj_neutre_fixe'),
	// 2.0 Add Juillet 2k15
	'1ac' => array('Dommages air','air', 'tx-agility', 'dommages_air'),
	'1a8' => array('Dommages feu','feu', 'tx-intelligence', 'dommages_feu'),
	'1aa' => array('Dommages eau','eau', 'tx-chance', 'dommages_eau'),
	'1ae' => array('Dommages neutre','defaut', 'tx-neutral', 'dommages_neutre'),
	'1a6' => array('Dommages terre','terre', 'tx-strength', 'dommages_terre'),
	'1a4' => array('Résistances critiques','defaut', 'tx-criticalreduction', 'resistances_coupscritiques'),
	'2f1' => array('Tacle','defaut', 'tx-tackle', 'tacle'),
	'a0' => array('Esquive PA','defaut', 'tx-dodgeap', 'esquive_pa'),
	'a1' => array('Esquive PM','defaut', 'tx-dodgemp', 'esquive_pm'),
	'19a' => array('Retrait PA','defaut', 'tx-attackmp', 'retrait_pa'),
	'19c' => array('Retrait PM','defaut', 'tx-attackap', 'retrait_pm'),
	'1a0' => array('Resistance poussée','defaut', 'tx-pushreduction', 'resistances_poussee'),
	'19e' => array('Dommages poussée','defaut', 'tx-push', 'dommages_poussee'),
	'1a2' => array('Dommages critiques','defaut', 'tx-criticaldamage', 'dommages_critiques'),
	'2f0' => array('Fuite','defaut', 'tx-escape', 'fuite')
	
);

$statstexte_malus=array(
	'db' => array('% Résistances neutre','neutre', 'tx-neutral', 'resistances_neutre_percent'),
	'd7' => array('% Résistances terre','terre', 'tx-strength', 'resistances_terre_percent'),
	'd8' => array('% Résistances eau','eau', 'tx-chance', 'resistances_eau_percent'),
	'd9' => array('% Résistances air','air', 'tx-agility', 'resistances_air_percent'),
	'da' => array('% Résistances feu','feu', 'tx-intelligence', 'resistances_feu_percent'),
	'65' => array('PA à la cible','feu', 'tx-actionpoints', 'pa'),
	'99' => array('Vitalité','feu', 'life', 'vitalite'),
	'af' => array('Initiatives','sagesse', 'tx-initiative', 'initiative'),
	'9c' => array('Sagesse','sagesse', 'tx-wisdom', 'sagesse'),
	'74' => array('PO','po', 'tx-range', 'portee'),
	'98' => array('Chance','eau', 'water', 'chance'),
	'9d' => array('Force','terre', 'earth', 'force'),
	'9b' => array('Intelligence','feu', 'fire', 'intelligence'),
	'7f' => array('PM','feu', 'tx-movementpoints', 'pm'),
	'9f' => array('Pods','feu'),
	'9a' => array('Agilité','air', 'air', 'agilite'),
	'a3' => array('Esquive PM','defaut', 'tx-dodgemp', 'esquive_pm'),
	'a2' => array('Esquive PA','defaut', 'tx-dodgeap', 'esquive_pa'),
	'19b' => array('Retrait PA','defaut', 'tx-attackmp', 'retrait_pa'),
	'19d' => array('Retrait PM','defaut', 'tx-attackap', 'retrait_pm'),
	'1a5' => array('Résistances critiques','defaut', 'tx-criticalreduction', 'resistances_coupscritiques'),
	'1a1' => array('Résistances poussée','defaut', 'tx-pushreduction', 'resistances_poussee'),
	'1a3' => array('Dommages critique','defaut', 'tx-criticaldamage', 'dommages_critiques'),
	'ab' => array('Coups critique','defaut', 'tx-criticalhit', 'coupscritiques'),
	'19f' => array('Dommages poussée','defaut', 'tx-push', 'dommages_poussee'),
	'2f2' => array('Fuite','defaut', 'tx-escape', 'fuite'),
	'b3' => array('Soins','defaut', 'tx-heal', 'soins'),
	'2f3' => array('Tacle','defaut', 'tx-tackle', 'tacle'),
	'a8' => array('PA','feu', 'tx-actionpoints', 'pa'),
	'7a' => array('Echecs Critiques','cc', 'tx-criticalhit'),
	'a9' => array('PM','feu', 'tx-movementpoints', 'pm')
);

$statstexte_ignored=array(
	'3d6' => array('Liée au compte'),
	'3d5' => array('Liée au compte'),
	'2d4' => array('Un titre'),
	'92' => array('Echange les paroles'),
	'31b' => array('Arme de chasse')
);
	
	
/*
25 Dommages air
15 résistances critiques
6 Tacle
*/

// Variable qui contient la couleur des stats à afficher.
$couleurstats=array(
	'defaut' => '5d5541',
	'pp' => '3e9795',
	'pa' => 'e17400',
	'do' => '0d4e27',
	'po' => '396c68',
	'vie' => '818181',
	'cc' => '9d391a',
	'rose' => 'ff8d8d',
	'sagesse' => '700b86',
	'neutre' => '000000',
	'feu' => 'ff0000',
	'terre' => '9d6617',
	'air' => '009933',
	'eau' => '127fc4');
	
// statstexte_cac
// statstexte_plus
// statstexte_malus
// statstexte_ignored
function boutique_stat_to_clear_html($statArgs, $statstexte_plus, $statstexte_malus, $statstexte_cac, $couleurstatss, $statstexte_ignored)
{
	
	$statArgs = strtolower($statArgs);
	$statsclear='';
	$dommage='';
	$statsexplode = explode(',', $statArgs);
	
	foreach($statsexplode AS $oneStat)
	{
		if(!strstr($oneStat, '#'))continue;
		//echo $oneStat.'<br />';
		$statshexa=explode('#', $oneStat);
		//$signe = ($statshexa[0]== '65' OR $statshexa[0]== '99' OR $statshexa[0]== 'af' OR $statshexa[0]== '9c' OR $statshexa[0]== '74' OR $statshexa[0]== '98' OR $statshexa[0]== '9d' OR $statshexa[0]== '9b' OR $statshexa[0]== '7f' OR $statshexa[0]== '9a' OR $statshexa[0]== 'db' OR $statshexa[0]== 'd7' OR $statshexa[0]== 'd8' OR $statshexa[0]== 'd9' OR $statshexa[0]== 'da') ? '<span style="color:#'.$couleurstatss['feu'].'">-</span>' : '+';
		$signe = "";
		// Ignore les TypeEffect de la liste $statstexte_ignored
		if(array_key_exists($statshexa[0], $statstexte_ignored)) continue;
		$signe = ($statshexa[0]== '60' OR $statshexa[0]== '61' OR $statshexa[0]== '62' OR $statshexa[0]== '63' OR $statshexa[0]== '64') ? 'Dommages :' : $signe;
		$signe = ($statshexa[0]== '5b' OR $statshexa[0]== '5c' OR $statshexa[0]== '5d' OR $statshexa[0]== '5e' OR $statshexa[0]== '5d') ? 'Vol de vie :' : $signe;
		$signe = ($statshexa[0]== '82') ? 'Vol de kamas :' : $signe;
		$signe = ($statshexa[0]== '32c') ? 'Resistance de l\'arme :' : $signe;
		$colorHexa = (array_key_exists($statshexa[0], $statstexte_plus)) ? $statstexte_plus[$statshexa[0]][1] : '';
		$colorHexa = ($colorHexa == '' AND array_key_exists($statshexa[0], $statstexte_malus)) ? $statstexte_malus[$statshexa[0]][1] : '';
		$colorHexa = ($colorHexa == '' AND array_key_exists($statshexa[0], $statstexte_cac)) ? $statstexte_cac[$statshexa[0]][1] : '';
		
		$iconOfLigneEffect = '';
		if(array_key_exists($statshexa[0], $statstexte_plus))
		{
			$colorHexa = $statstexte_plus[$statshexa[0]][1];
			if(isset($statstexte_plus[$statshexa[0]][2]) AND !empty($statstexte_plus[$statshexa[0]][2])) $iconOfLigneEffect = $statstexte_plus[$statshexa[0]][2];
		}
		elseif(array_key_exists($statshexa[0], $statstexte_malus))
		{
			$colorHexa = $statstexte_malus[$statshexa[0]][1];
			if(isset($statstexte_malus[$statshexa[0]][2]) AND !empty($statstexte_malus[$statshexa[0]][2])) $iconOfLigneEffect = $statstexte_malus[$statshexa[0]][2];
		}
		elseif(array_key_exists($statshexa[0], $statstexte_cac))
		{
			$colorHexa = $statstexte_cac[$statshexa[0]][1];
			if(isset($statstexte_cac[$statshexa[0]][2]) AND !empty($statstexte_cac[$statshexa[0]][2])) $iconOfLigneEffect = $statstexte_cac[$statshexa[0]][2];
		}
		else $colorHexa = 'defaut';
		
		$colorapres='</div>';
		$coloravant='<div style="color:#'.$couleurstatss[$colorHexa].';" class="ak-encyclo-detail-aligne">';
		if($iconOfLigneEffect != '') $coloravant.='<div class="ak-aside"><span class="ak-icon-small ak-'.$iconOfLigneEffect.'"></span></div>';
		
		// Affichage des effet à 2 jet (exemple Dommage de X à Y (CAC)
		if(array_key_exists($statshexa[0], $statstexte_cac))
		{
			if($statshexa[2] != 0)
				$dommage.= $coloravant.'<strong>'.$signe.' '.$statshexa[1].'</strong> à <strong>'.$statshexa[2].'</strong>';
			else
				$dommage.= $coloravant.'<strong>'.$signe.' '.$statshexa[1].'</strong></strong>';
			$dommage.= ' ';
			$dommage.= $statstexte_cac[$statshexa[0]][0].$colorapres;
			// $dommage.= '<br />';
		}
		// Affichage d'un jet simple et unique (negatif ou positif)
		else
		{
			/*
			$jetMAX = ($statshexa[2] == 0) ? $statshexa[1] : $statshexa[2] ;
			*/
			// Cas negatif
			if(array_key_exists($statshexa[0], $statstexte_malus))
			{
				// $jetMAX = ($statshexa[2] > $statshexa[1]) ? $statshexa[2] : $statshexa[1];
				$jetMAX = $statshexa[2];
				$signe = '<span style="color:#'.$couleurstatss['feu'].'">-</span>';
				$statsclear.= $coloravant.'<strong>'.$signe.' '.$jetMAX.'</strong>';
				$statsclear.= ' ';
				$statsclear.= $statstexte_malus[$statshexa[0]][0].$colorapres;
				// $statsclear.= '<br />';
			}
			// Cas positif
			elseif(array_key_exists($statshexa[0], $statstexte_plus))
			{
				// $jetMAX = ($statshexa[2] > $statshexa[1]) ? $statshexa[2] : $statshexa[1];
				$jetMAX = $statshexa[2];
				$signe = '+';
				$statsclear.= $coloravant.'<strong>'.$signe.' '.$jetMAX.'</strong>';
				$statsclear.= ' ';
				$statsclear.= $statstexte_plus[$statshexa[0]][0].$colorapres;
				// $statsclear.= '<br />';
			}
			else
			{
			
				$fp = fopen('Z_typeEffectErrorToFix.txt','a+');
				fseek($fp,SEEK_END);
				$returnErrorTypeEffect = '['.date("Y-m-d H:i:s").'] TypeEffectLost : '.$statshexa[0].' | TypeEffectComplet : '.$statArgs;
				fputs($fp, $returnErrorTypeEffect . "\r\n---------------------------------------------------------------\r\n");
				fclose($fp);
				
				//echo '<h2 style="color:red;">Erreur à fix : ' . $oneStat.'</h2><br />';
			}
		}
	}
	
	return $dommage.$statsclear;
}

/*
function boutique_stat_to_clear_html($statArgs, $statstexte_plus, $statstexte_malus, $statstexte_cac, $couleurstatss, $statstexte_ignored)
{
	
	$statArgs = strtolower($statArgs);
	$statsclear='';
	$dommage='';
	$statsexplode = explode(',', $statArgs);
	
	foreach($statsexplode AS $oneStat)
	{
		if(!strstr($oneStat, '#'))continue;
		//echo $oneStat.'<br />';
		$statshexa=explode('#', $oneStat);
		//$signe = ($statshexa[0]== '65' OR $statshexa[0]== '99' OR $statshexa[0]== 'af' OR $statshexa[0]== '9c' OR $statshexa[0]== '74' OR $statshexa[0]== '98' OR $statshexa[0]== '9d' OR $statshexa[0]== '9b' OR $statshexa[0]== '7f' OR $statshexa[0]== '9a' OR $statshexa[0]== 'db' OR $statshexa[0]== 'd7' OR $statshexa[0]== 'd8' OR $statshexa[0]== 'd9' OR $statshexa[0]== 'da') ? '<span style="color:#'.$couleurstatss['feu'].'">-</span>' : '+';
		$signe = "";
		// Ignore les TypeEffect de la liste $statstexte_ignored
		if(array_key_exists($statshexa[0], $statstexte_ignored)) continue;
		$signe = ($statshexa[0]== '60' OR $statshexa[0]== '61' OR $statshexa[0]== '62' OR $statshexa[0]== '63' OR $statshexa[0]== '64') ? 'Dommages :' : $signe;
		$signe = ($statshexa[0]== '5b' OR $statshexa[0]== '5c' OR $statshexa[0]== '5d' OR $statshexa[0]== '5e' OR $statshexa[0]== '5d') ? 'Vol de vie :' : $signe;
		$signe = ($statshexa[0]== '82') ? 'Vol de kamas :' : $signe;
		$signe = ($statshexa[0]== '32c') ? 'Resistance de l\'arme :' : $signe;
		$colorHexa = (array_key_exists($statshexa[0], $statstexte_plus)) ? $statstexte_plus[$statshexa[0]][1] : '';
		$colorHexa = ($colorHexa == '' AND array_key_exists($statshexa[0], $statstexte_malus)) ? $statstexte_malus[$statshexa[0]][1] : '';
		$colorHexa = ($colorHexa == '' AND array_key_exists($statshexa[0], $statstexte_cac)) ? $statstexte_cac[$statshexa[0]][1] : '';
		
		if(array_key_exists($statshexa[0], $statstexte_plus)) $colorHexa = $statstexte_plus[$statshexa[0]][1];
		elseif(array_key_exists($statshexa[0], $statstexte_malus)) $colorHexa = $statstexte_malus[$statshexa[0]][1];
		elseif(array_key_exists($statshexa[0], $statstexte_cac)) $colorHexa = $statstexte_cac[$statshexa[0]][1];
		else $colorHexa = 'defaut';
		
		$colorapres='</span>';
		$coloravant='<span style="color:#'.$couleurstatss[$colorHexa].';">';
		
		// Affichage des effet à 2 jet (exemple Dommage de X à Y (CAC)
		if(array_key_exists($statshexa[0], $statstexte_cac))
		{
			if($statshexa[2] != 0)
				$dommage.= $coloravant.'<strong>'.$signe.' '.$statshexa[1].'</strong> à <strong>'.$statshexa[2].'</strong>';
			else
				$dommage.= $coloravant.'<strong>'.$signe.' '.$statshexa[1].'</strong></strong>';
			$dommage.= ' ';
			$dommage.= $statstexte_cac[$statshexa[0]][0].$colorapres;
			$dommage.= '<br />';
		}
		// Affichage d'un jet simple et unique (negatif ou positif)
		else
		{
			// Cas negatif
			if(array_key_exists($statshexa[0], $statstexte_malus))
			{
				// $jetMAX = ($statshexa[2] > $statshexa[1]) ? $statshexa[2] : $statshexa[1];
				$jetMAX = $statshexa[2];
				$signe = '<span style="color:#'.$couleurstatss['feu'].'">-</span>';
				$statsclear.= $coloravant.'<strong>'.$signe.' '.$jetMAX.'</strong>';
				$statsclear.= ' ';
				$statsclear.= $statstexte_malus[$statshexa[0]][0].$colorapres;
				$statsclear.= '<br />';
			}
			// Cas positif
			elseif(array_key_exists($statshexa[0], $statstexte_plus))
			{
				// $jetMAX = ($statshexa[2] > $statshexa[1]) ? $statshexa[2] : $statshexa[1];
				$jetMAX = $statshexa[2];
				$signe = '+';
				$statsclear.= $coloravant.'<strong>'.$signe.' '.$jetMAX.'</strong>';
				$statsclear.= ' ';
				$statsclear.= $statstexte_plus[$statshexa[0]][0].$colorapres;
				$statsclear.= '<br />';
			}
			else
			{
			
				$fp = fopen('Z_typeEffectErrorToFix.txt','a+');
				fseek($fp,SEEK_END);
				$returnErrorTypeEffect = '['.date("Y-m-d H:i:s").'] TypeEffectLost : '.$statshexa[0].' | TypeEffectComplet : '.$statArgs;
				fputs($fp, $returnErrorTypeEffect . "\r\n---------------------------------------------------------------\r\n");
				fclose($fp);
				
				//echo '<h2 style="color:red;">Erreur à fix : ' . $oneStat.'</h2><br />';
			}
		}
	}
	
	return $dommage.$statsclear;
}
*/

function binaryToHexaSnapzItems($SerializedEffects)
{
	$ValueToReturn = '';
		$effects = new binaryReader($SerializedEffects);
		while(true)
		{
				$effectType = $effects->readByte();
				if ($effectType == 6)
				{
					$effects->readByte();
					$idendecimal = $effects->readShort();
					$valueOfEffect = $effects->readShort();

					$ValueToReturn = $ValueToReturn.dechex($idendecimal).'#0#'.$valueOfEffect.',';
				}
				elseif ($effectType == 4)
				{
					$effects->readByte();
					$idendecimal = $effects->readShort();
					$effects->readShort(); // A laisser mais retourne 0 osef
					$valueOfEffect1 = $effects->readShort();
					$valueOfEffect2 = $effects->readShort();
					
					$ValueToReturn = $ValueToReturn.dechex($idendecimal).'#'.$valueOfEffect1.'#'.$valueOfEffect2.',';
				}
				elseif ($effectType == 10)
				{
					$ValueToReturn = 'Dragodinde : impossible d\'afficher les statistiques.';
				}
				else
				{
					break;
				}
		}
	return $ValueToReturn;
}

function positionItemToName($position)
{
	$nameid='';
			switch($position)
			{ 
			case '0':
				$nameid='amulette';
			break;
			case '1':
				$nameid='cac';
			break;
			case '2':
				$nameid='anneauG';
			break;
			case '3':
				$nameid='ceinture';
			break;
			case '4':
				$nameid='anneauD';
			break;
			case '5':
				$nameid='botte';
			break;
			case '6':
				$nameid='coiffe';
			break;
			case '7':
				$nameid='cape';
			break;
			case '8':
				$nameid='familie';
			break;
			case '9':
				$nameid='dofus1';
			break;
			case '10':
				$nameid='dofus2';
			break;
			case '11':
				$nameid='dofus3';
			break;
			case '12':
				$nameid='dofus4';
			break;
			case '13':
				$nameid='dofus5';
			break;
			case '14':
				$nameid='dofus6';
			break;
			case '15':
				$nameid='bouclier';
			break;
			case '63':
				$nameid='inventaire';
			break;
			}
	return $nameid;
}
?>