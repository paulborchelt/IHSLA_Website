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

<div>
<?php echo $score?>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
         <th>Team</th>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Quarter:</th>
         <th>Goals:</th>
         <th>Assists:</th>
         <th>Points:</th>
         <th>GB</th>
         <th>Shots:</th>
         <th>T/0:</th>
         <th>CT:</th>
         <th>Edit/Delete</th>
      </tr>
   </thead>
      <tbody>
<?php while ( $points = $result->fetchNextObject() ): ?>
         <tr>
            <td><?php echo $points->_TeamsObject->Team_Name?></td>
         	<td><?php echo $points->_RostersObject->number?></td>
         	<td><?php echo $points->_PlayersObject->getFullName()?></td>
            <td><?php echo $points->Quarter?></td>
            <td><?php echo $points->Goals?></td>
            <td><?php echo $points->Assists?></td>
            <td><?php echo $points->getPoints()?></td>
            <td><?php echo $points->GroundBalls?></td>
            <td><?php echo $points->Shots?></td>
            <td><?php echo $points->Turnovers?></td>
            <td><?php echo $points->CausedTurnovers?></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?php echo $points->Game_ID?>&Team_ID=<?php echo $points->Team_ID?>&Player_ID=<?php echo $points->Player_ID?>&Quarter=<?php echo $points->Quarter?>&Goals=<?php echo $points->Goals?>&Assists=<?php echo $points->Assists?>&GroundBalls=<?php echo $points->GroundBalls?>&Shots=<?php echo $points->Shots?>&Turnovers=<?php echo $points->Turnovers?>&CausedTurnovers=<?php echo $points->CausedTurnovers?>"> <img src= ../images/site_images/icon_edit.gif>
            <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?php echo $points->Game_ID?>&Player_ID=<?php echo $points->Player_ID?>&Quarter=<?php echo $points->Quarter?>"> <img src= ../images/site_images/icon_delete.gif></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>

<br />

<?php echo $statsenterformhome?>

<?php echo $statsenterformaway?>

<button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?action=GoalieEnter&Game_ID=<?php echo $Game_ID?>'">Enter Goalie Scores ></button></td>

