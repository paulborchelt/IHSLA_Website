<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({"aoColumns": [
                                                   {"bVisible": false},
                                                   {"iDataSort": 0},
                                                   null,
                                                   null,
                                                   null,
                                                   null,
                                                   null,
                                                   null ]});
         } );
</script>

<?php if ($enterschedule != "yes"): ?>
   <?php echo $navbarteam?>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
         <td>SortDate</td>
         <td>Date</td>
         <td>Location</td>
         <td>Opponent</td>
         <td>Site</td>
         <td>Time</td>
         <td>Level</td>
         <?php if ($enterschedule == "yes"): ?>
            <td>Edit/Delete</td>
         <?php else: ?>
            <td>Result</td>
         <?php endif; ?>
      </tr>
   </thead>
   <tbody>
<?php while ( $schedule = $result->fetchNextObject() ): ?>
      <tr>
         <td><?php echo $schedule->_DateObject->getScheduleSortFormat()?></td>
         <td><?php echo $schedule->_DateObject->getScheduleFormat()?></td>
         <td><?php echo $schedule->getLocation($Team_ID)?></td>
         <td><?php echo $schedule->getOpponent($Team_ID)?></td>
         <td><?php echo $schedule->_SiteObject->field_name?></td>
         <td><?php echo $schedule->_TimeObject->getTime()?></td>
         <td><?php echo $schedule->Game_Level?></td>
         <?php if ($enterschedule == "yes" && FALSE == $schedule->_Score->scoreSetHome && FALSE == $schedule->_Score->scoreSetAway ): ?>
            <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?php echo $schedule->Game_ID?>&Team_ID=<?php echo $Team_ID?>"> <img src= ../images/site_images/icon_edit.gif>
            <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?php echo $schedule->Game_ID?>&Team_ID=<?php echo $Team_ID?>"> <img src= ../images/site_images/icon_delete.gif></td>
         <?php else: ?>
            <td><?php echo $schedule->getResults(TRUE)?></td>
         <?php endif; ?>
      </tr>
<?php endwhile; ?>
 </tbody>
</table>