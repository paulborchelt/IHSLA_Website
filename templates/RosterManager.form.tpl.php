<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable();
         } );
</script>

<h3><?=$rostermanager->getTeamName()?></h3>


<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
   <thead>
      <tr>
         <th>Name</th>
         <th>Grade</th>
         <? while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
            <th><?=$level->Level_Description?></th>
         <? endwhile; ?>
         <th>Modify</th>
      </tr>
   </thead>
   <tbody>
      <? while ( $player = $rostermanager->fetchNextPlayerObject() ): ?> 
         <tr>
            <td><?=$player->getFullName()?></td>
            <td><?=$player->getGradeName()?></td>
            <? $rostermanager->resetNextLevelObject() ?>
            <? while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
               <? if ( TRUE == $rostermanager->PlayerIsRostered( $player->Player_ID, $level->Level_ID ) ): ?> 
                  <td><a href="Roster.php?action=removeplayer&player_id=<?=$player->Player_ID?>&Team_ID=<?=$player->Team_ID?>&level=<?=$level->Level_ID?>"> [REMOVE]</a></td>
               <? else: ?>
                  <td><a href="Roster.php?action=Add&Player_ID=<?=$player->Player_ID?>&Team_ID=<?=$player->Team_ID?>&level=<?=$level->Level_ID?>"> [ADD]</a></td>
               <? endif; ?>
            <? endwhile; ?>
            <td><a href="EditPlayerInfo.php?action=Edit&Team_ID=<?=$rostermanager->getTeam_ID()?>&Player_ID=<?=$player->Player_ID?>"> <img src=../images/site_images/icon_edit.gif>
                <a href="EditPlayerInfo.php?action=Delete&Team_ID=<?=$rostermanager->getTeam_ID()?>&Player_ID=<?=$player->Player_ID?>"> <img src=../images/site_images/icon_delete.gif></a></td>
         </tr>
      <? endwhile; ?>
   	<tr>
        <td></td>
   	  <td></td>
        <? $rostermanager->resetNextLevelObject() ?>
   	  <? while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
            <td></td>
        <? endwhile; ?>
         <td><a href="EditPlayerInfo.php?Team_ID=<?=$rostermanager->getTeam_ID()?>&link=Roster.php?Team_ID=<?=$rostermanager->getTeam_ID()?>"> [Add New Player]</a></td>
      </tr>
   </tbody>
</table>