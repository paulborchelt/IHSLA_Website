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

<? if ($enterschedule != "yes"): ?>
   <?=$navbarteam?>
<? endif; ?>

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
         <? if ($enterschedule == "yes"): ?>
            <td>Edit/Delete</td>
         <? else: ?>
            <td>Result</td>
         <? endif; ?>
      </tr>
   </thead>
   <tbody>
<? while ( $schedule = $result->fetchNextObject() ): ?>
      <tr>
         <td><?=$schedule->_DateObject->getScheduleSortFormat()?></td>
         <td><?=$schedule->_DateObject->getScheduleFormat()?></td>
         <td><?=$schedule->getLocation($Team_ID)?></td>
         <td><?=$schedule->getOpponent($Team_ID)?></td>
         <td><?=$schedule->_SiteObject->field_name?></td>
         <td><?=$schedule->_TimeObject->getTime()?></td>
         <td><?=$schedule->Game_Level?></td>
         <? if ($enterschedule == "yes" && FALSE == $schedule->_Score->scoreSetHome && FALSE == $schedule->_Score->scoreSetAway ): ?>
            <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?=$schedule->Game_ID?>&Team_ID=<?=$Team_ID?>"> <img src= ../images/site_images/icon_edit.gif>
            <a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?=$schedule->Game_ID?>&Team_ID=<?=$Team_ID?>"> <img src= ../images/site_images/icon_delete.gif></td>
         <? else: ?>
            <td><?=$schedule->getResults(TRUE)?></td>
         <? endif; ?>
      </tr>
<? endwhile; ?>
 </tbody>
</table>