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

<h3><?php echo$rostermanager->getTeamName()?></h3>


<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
   <thead>
      <tr>
         <th>Name</th>
         <th>Grade</th>
         <?php while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
            <th><?php echo$level->Level_Description?></th>
         <?php endwhile; ?>
         <th>Modify</th>
      </tr>
   </thead>
   <tbody>
      <?php while ( $player = $rostermanager->fetchNextPlayerObject() ): ?> 
         <tr>
            <td><?php echo$player->getFullName()?></td>
            <td><?php echo$player->getGradeName()?></td>
            <?php $rostermanager->resetNextLevelObject() ?>
            <?php while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
               <?php if ( TRUE == $rostermanager->PlayerIsRostered( $player->Player_ID, $level->Level_ID ) ): ?> 
                  <td><a href="Roster.php?action=removeplayer&player_id=<?php echo$player->Player_ID?>&Team_ID=<?php echo$player->Team_ID?>&level=<?php echo$level->Level_ID?>"> [REMOVE]</a></td>
               <?php else: ?>
                  <td><a href="Roster.php?action=Add&Player_ID=<?php echo$player->Player_ID?>&Team_ID=<?php echo$player->Team_ID?>&level=<?php echo$level->Level_ID?>"> [ADD]</a></td>
               <?php endif; ?>
            <?php endwhile; ?>
            <td><a href="EditPlayerInfo.php?action=Edit&Team_ID=<?php echo$rostermanager->getTeam_ID()?>&Player_ID=<?php echo$player->Player_ID?>"> <img src=../images/site_images/icon_edit.gif>
                <a href="EditPlayerInfo.php?action=Delete&Team_ID=<?php echo$rostermanager->getTeam_ID()?>&Player_ID=<?php echo$player->Player_ID?>"> <img src=../images/site_images/icon_delete.gif></a></td>
         </tr>
      <?php endwhile; ?>
   	<tr>
        <td></td>
   	  <td></td>
        <?php $rostermanager->resetNextLevelObject() ?>
   	  <?php while ( $level = $rostermanager->fetchNextLevelObject() ): ?> 
            <td></td>
        <?php endwhile; ?>
         <td><a href="EditPlayerInfo.php?Team_ID=<?php echo$rostermanager->getTeam_ID()?>&link=Roster.php?Team_ID=<?php echo$rostermanager->getTeam_ID()?>"> [Add New Player]</a></td>
      </tr>
   </tbody>
</table>