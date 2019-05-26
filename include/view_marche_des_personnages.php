<?php if(!defined("BASE_DS")) die(); ?>
<div class="pg-meta split bg-blue clearfix" style="padding:0;height:58px;margin-bottom:15px;">

	<div style="background:white;padding:7px;margin-left:10px;">
		<img src="pages/marche_des_personnages_images/mini/<?php echo $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Id']; ?>.png" alt="" style="display:block;width:35px;height:35px;margin:0;" />
	</div>
	
	<div class="span3 clear-margin" style="padding:0px 10px;line-height:20px;color:white;text-shadow:1px 1px 0 #196590;border-right:1px solid #146593;height:43px;margin-top:7px;">
		<span><strong>Niveau <?php echo $API_RETURN_ARRAY_OF_A_PERSO['level']; ?></strong></span><br />
		<span><?php echo $classe[$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Breed']]; ?></span>
	</div>
	
	<div class="span3 clear-margin" style="padding:0px 20px 0px 10px;line-height:20px;color:white;text-shadow:1px 1px 0 #196590;border-right:1px solid #146593;height:43px;margin-top:7px;text-align:center;">
		<span><strong>Honneur</strong></span><br />
		<span><strong style="font-size:20px;"><?php echo $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Honor']; ?></strong></span>
	</div>
	
	<div class="span3 clear-margin" style="padding:0px 15px 0px 10px;line-height:20px;color:white;text-shadow:1px 1px 0 #196590;height:43px;margin-top:7px;text-align:center;">
		<span><strong>Côte kolizeum</strong></span><br />
		<span><strong style="font-size:20px;"><?php echo $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['ArenaRank']; ?></strong></span>
	</div>
	
	<div class="span5 visible-tablet visible-desktop" style="padding:0px 0 0px 10px;margin-left:10px;line-height:20px;color:white;text-shadow:1px 1px 0 #196590;height:43px;margin-top:7px;text-align:center;border-left:1px solid #146593;">
		<span><strong>Points de sort restants</strong></span><br />
		<span><strong style="font-size:20px;"><?php echo $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['SpellsPoints']; ?></strong></span>
	</div>
</div>		

<h2 style="margin-bottom:5px;">Objets équipés et prévisualisation du personnage <strong style="color:#0079bd;"><?php echo htmlentities($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Name']); ?></strong> :</h2>
  <div class="ak-equipment-left">
	<a class="hover_boxjs" href="#bouclier">
		<div class="ak-equipment-item ak-equipment-shield">
			<img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('bouclier', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['bouclier']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
		</div>
	</a>
	<a class="hover_boxjs" href="#amulette">
    <div class="ak-equipment-item ak-equipment-amulet">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('amulette', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['amulette']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#anneauG">
    <div class="ak-equipment-item ak-equipment-ring1">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('anneauG', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['anneauG']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#cape">
    <div class="ak-equipment-item ak-equipment-cap">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('cape', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['cape']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#botte">
    <div class="ak-equipment-item ak-equipment-boots">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('botte', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['botte']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
  </div>
  
  <div class="ak-equipment-middle">
    <div class="ak-character-equipments">
      <div class="ak-chracter-illustration">
        <div class="ak-set-illu">
           <div class="ak-entitylook" alt="" style="background:url(pages/marche_des_personnages_images/big/<?php echo $API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['Id']; ?>.png) top left;width:270px;height:361px;position:relative;top:25px;left:55px"></div>
		 </div>
      </div>
    </div>
   </div>
         
  
  <div class="ak-equipment-right">
	<a class="hover_boxjs" href="#cac">
		<div class="ak-equipment-item ak-equipment-weapon">
			<img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('cac', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['cac']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
		</div>
	</a>
	<a class="hover_boxjs" href="#coiffe">
    <div class="ak-equipment-item ak-equipment-hat">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('coiffe', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['coiffe']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#anneauD">
    <div class="ak-equipment-item ak-equipment-ring2">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('anneauD', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['anneauD']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#ceinture">
    <div class="ak-equipment-item ak-equipment-belt">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('ceinture', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['ceinture']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#familie">
    <div class="ak-equipment-item ak-equipment-pet">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('familie', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['familie']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
  </div>
  
   <div class="ak-equipment-right">
    <a class="hover_boxjs" href="#dofus1">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus1', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus1']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#dofus2">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus2', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus2']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#dofus3">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus3', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus3']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
  </div>
  
   <div class="ak-equipment-right">
    <a class="hover_boxjs" href="#dofus4">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus4', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus4']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#dofus5">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus5', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus5']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
	<a class="hover_boxjs" href="#dofus6">
    <div class="ak-equipment-item ak-equipment-dofus">
        <img src="images/items_Neft-Gaming_mini/<?php if(array_key_exists('dofus6', $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image'])) echo $API_RETURN_ARRAY_OF_A_PERSO['list_iditem_to_image']['dofus6']; else echo 'emptypix'; ?>.png" alt="" class="ak-show-one-png-52" />
	</div>
	</a>
  </div>

<?php
	foreach($API_RETURN_ARRAY_OF_A_PERSO['hover_toolbox_des_items'] AS $one_hover_item)
	{
		?>
			  <div id="<?php echo $one_hover_item[0]; ?>" style="display:none;">
				<div class="ak-top">
					<div class="ak-encyclo-detail-illu ak-illu"><img src="images/items_Neft-Gaming/<?php echo $one_hover_item[1]; ?>.png" /></div>
					<div class="ak-detail">
						  <div class="ak-name"><?php echo $one_hover_item[2]; ?></div>
						  <div class="ak-type"><?php echo $one_hover_item[3]; ?></div>
						  <div class="ak-level">Niveau&nbsp;<?php echo $one_hover_item[4]; ?></div>
					</div>
				</div>
				<div class="ak-encyclo-detail">
					<?php echo $one_hover_item[5]; ?>
				</div>
			  </div>
		<?php
	}
?>
 <script type="text/javascript">
	jQuery(document).ready(function(){	
		jQuery("a.hover_boxjs").each(function(){
			var thisone = jQuery(this);
			thisone.easyTooltip({ 
				useElement : thisone.attr('href').replace('#', '')
			}); 
		});
	});
</script>

<div class="clear-float do-the-split" style="margin-top:0px;margin-bottom:5px;"></div>

<h2 class="clearfix" style="clear:both;margin-bottom:5px;">Sorts  :</h2>

<div class="ak-spells-list">
<div>
  <div class="ak-spell-list-row">

<?php
	foreach($API_RETURN_ARRAY_OF_A_PERSO['spell_perso_list'] AS $one_spell_of_this_perso)
	{
		?>
		  <div class="ak-list-block ak-spell ak-spell-out">
			<a href="javascript:void(0)" class="tipsy-s" title="<?php echo $one_spell_of_this_perso[0]; ?>" style="font-family:Arial;">
				<span class="ak-spell-nb" style="font-family:Verdana;"><?php echo $one_spell_of_this_perso[1] ?></span>
				<img src="images/spell_Neft-Gaming/<?php echo $one_spell_of_this_perso[2]; ?>.png" alt="">
			</a>
		  </div>
		<?php
	}
?>
	  
	  
   </div>
</div>
</div>
<p style="clear:both;height:5px;"></p>
<div class="clear-float do-the-split" style="margin-top:10px;margin-bottom:0px;display:block;"></div>

<h2 class="clearfix" style="clear:both;padding-top:10px;margin-bottom:5px;">Caractéristiques   :</h2>
<div class="ak-caracteristics-table-container split">
	<div class="size6 ak-primary-caracteristics" >
		<table border="1" class="ak-table ak-displaymode-alternative" style="margin-bottom:0;padding-bottom:0px;">
			<thead>
				<tr>
					<th colspan="2">Caractéristiques primaires</th>
					<th>Base</th>
					<th>Bonus</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-vitality"></span></td>
					<td><strong>Vitalité</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedVitality'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedVitality'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['vitalite']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['vitalite']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['vitalite']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['vitalite']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-wisdom"></span></td>
					<td><strong>Sagesse</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedWisdom'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedWisdom'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['sagesse']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['sagesse']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['sagesse']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['sagesse']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-strength"></span></td>
					<td><strong>Force</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedStrength'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedStrength'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['force']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['force']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['force']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['force']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-intelligence"></span></td>
					<td><strong>Intelligence</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedIntelligence'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedIntelligence'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['intelligence']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['intelligence']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['intelligence']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['intelligence']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-chance"></span></td>
					<td><strong>Chance</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedChance'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedChance'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['chance']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['chance']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['chance']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['chance']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-agility"></span></td>
					<td><strong>Agilité</strong><?php if($API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedAgility'] > 0) echo ' <span>Parchotage : <em style="color:green;">'.$API_RETURN_ARRAY_OF_A_PERSO['characters_db_this_perso']['PermanentAddedAgility'].'</em></span>'; ?></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['agilite']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['agilite']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['agilite']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['agilite']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-actionpoints"></span></td>
					<td><strong>Points d'action (PA)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pa']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pa']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pa']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pa']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-movementpoints"></span></td>
					<td><strong>Points de mouvement (PM)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pm']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pm']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pm']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['pm']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-initiative"></span></td>
					<td><strong>Initiative</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['initiative']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['initiative']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['initiative']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['initiative']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-prospecting"></span></td>
					<td><strong>Prospection</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['prospection']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['prospection']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['prospection']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['prospection']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-range"></span></td>
					<td><strong>Portée</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['portee']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['portee']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['portee']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['portee']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-invocation"></span></td>
					<td><strong>Invocation</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['invocation']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['invocation']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['invocation']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['invocation']['bonus']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="size6 ak-secondary-caracteristics">
		<table border="1" class="ak-table ak-displaymode-alternative" style="margin-bottom:0;padding-bottom:0px;">
			<thead>
				<tr>
					<th data-priority="4" colspan="2">Caractéristiques secondaires</th>
					<th data-priority="4">Base</th>
					<th data-priority="4">Bonus</th>
					<th data-priority="4">Total</th>
				</tr>
			</thead>
			<tbody>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-attackmp"></span></td>
					<td><strong>Retrait (PA)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pa']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pa']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pa']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pa']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-dodgeap"></span></td>
					<td><strong>Esquive (PA)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pa']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pa']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pa']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pa']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-attackap"></span></td>
					<td><strong>Retrait (PM)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pm']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pm']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pm']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['retrait_pm']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-dodgemp"></span></td>
					<td><strong>Esquive (PM)</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pm']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pm']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pm']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['esquive_pm']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-criticalhit"></span></td>
					<td><strong>Coups critiques</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['coupscritiques']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['coupscritiques']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['coupscritiques']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['coupscritiques']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-heal"></span></td>
					<td><strong>Soins</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['soins']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['soins']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['soins']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['soins']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-tackle"></span></td>
					<td><strong>Tacle</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['tacle']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['tacle']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['tacle']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['tacle']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-escape"></span></td>
					<td><strong>Fuite</strong></td>
					<td><span class="ak-tooltip" ><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['fuite']['base']; ?></span></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['fuite']['bonus']; ?></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['fuite']['base'] + $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['fuite']['bonus']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<br />

<div class="ak-caracteristics-table-container clearfix split" style="clear:both;">
	<div class="size6 ak-primary-caracteristics">
		<table border="1" class="ak-table ak-displaymode-alternative" style="margin-bottom:0;padding-bottom:0px;">
			<thead>
				<tr>
					<th colspan="2">Dommages</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-damage"></span></td>
					<td><strong>Dommages</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-damagespercent"></span></td>
					<td><strong>Puissance</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_puissance']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-criticaldamage"></span></td>
					<td><strong>Dommages critiques</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_critiques']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-neutral"></span></td>
					<td><strong>Neutre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_neutre']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-earth"></span></td>
					<td><strong>Terre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_terre']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-fire"></span></td>
					<td><strong>Feu (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_feu']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-water"></span></td>
					<td><strong>Eau (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_eau']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-air"></span></td>
					<td><strong>Air (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_air']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-return"></span></td>
					<td><strong>Renvoi</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_renvoi']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-trap"></span></td>
					<td><strong>Pièges (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_pieges_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-trappercent"></span></td>
					<td><strong>Pièges (Puissance)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_pieges_puissance']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-push"></span></td>
					<td><strong>Poussée</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['dommages_poussee']['bonus']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="size6 ak-secondary-caracteristics">
		<table border="1" class="ak-table ak-displaymode-alternative" style="margin-bottom:0;padding-bottom:0px;">
			<thead>
				<tr>
					<th colspan="2">Résistances</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-neutral"></span></td>
					<td><strong>Neutre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_neutre_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-neutral"></span></td>
					<td><strong>Neutre (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_neutre_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-earth"></span></td>
					<td><strong>Terre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_terre_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-earth"></span></td>
					<td><strong>Terre (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_terre_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-fire"></span></td>
					<td><strong>Feu (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_feu_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-fire"></span></td>
					<td><strong>Feu (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_feu_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-water"></span></td>
					<td><strong>Eau (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_eau_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-water"></span></td>
					<td><strong>Eau (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_eau_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-air"></span></td>
					<td><strong>Air (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_air_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-air"></span></td>
					<td><strong>Air (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_air_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-criticalhit"></span></td>
					<td><strong>Coups critiques (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_coupscritiques']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-push"></span></td>
					<td><strong>Poussée (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_poussee']['bonus']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<br />

<div class="ak-caracteristics-table-container clearfix split" style="clear:both;">
	<div class="size6 ak-primary-caracteristics">
		<table border="1" class="ak-table ak-displaymode-alternative" style="margin-bottom:0;padding-bottom:0;">
			<thead>
				<tr>
					<th colspan="2">Résistances JCJ</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-neutral"></span></td>
					<td><strong>Neutre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_neutre_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-tx-neutral"></span></td>
					<td><strong>Neutre (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_neutre_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-earth"></span></td>
					<td><strong>Terre (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_terre_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-earth"></span></td>
					<td><strong>Terre (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_terre_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-fire"></span></td>
					<td><strong>Feu (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_feu_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-fire"></span></td>
					<td><strong>Feu (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_feu_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-water"></span></td>
					<td><strong>Eau (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_eau_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-water"></span></td>
					<td><strong>Eau (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_eau_percent']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-odd" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-air"></span></td>
					<td><strong>Air (fixe)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_air_fixe']['bonus']; ?></td>
				</tr>
				<tr class="ak-bg-even" >
					<td style="padding:5px 0 0 3px;width:10px;overflow:hidden;"><span class="ak-icon-small ak-air"></span></td>
					<td><strong>Air (%)</strong></td>
					<td><?php echo $API_RETURN_ARRAY_OF_A_PERSO['tableau_stat_perso']['resistances_jcj_air_percent']['bonus']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="clear-float do-the-split" style="margin-top:15px;margin-bottom:10px;display:block;"></div>

<h2 class="clearfix" style="padding-top:0px;clear:both;margin-bottom:5px;">Équipements dans l'inventaire :</h2>

<div class="ak-spells-list">
<div>
  <div class="ak-spell-list-row" style="<?php if(count($API_RETURN_ARRAY_OF_A_PERSO['equipement_inventaire']) > 0) echo 'height:305px;overflow:scroll;'; ?>">
<?php
	foreach($API_RETURN_ARRAY_OF_A_PERSO['equipement_inventaire'] AS $OneEquipInventaire)
	{
?>
		<a class="hover_boxjs" href="#<?php echo $OneEquipInventaire[0]; ?>" style="color:#cbcbcb;">
			<div class="ak-equipment-item2 ak-equipment-none" style="position: relative;">
				<span class="ak-spell-nb2" style="opacity:0.8"><?php echo $OneEquipInventaire[2]; ?></span>
				<img src="images/items_Neft-Gaming_mini/<?php echo $OneEquipInventaire[1]; ?>.png" alt="" class="ak-show-one-png-52">
			</div>
		</a>
<?php
		
	}
	if(count($API_RETURN_ARRAY_OF_A_PERSO['equipement_inventaire']) == 0) echo '<center style="font-weight:bold;color:red;">Aucun équipements dans l\'inventaire.</center>';
?>
	  
	  
   </div>
</div>
</div>

<div class="breaking-line" style="margin-bottom:0px;"></div>