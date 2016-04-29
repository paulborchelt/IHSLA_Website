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
<?=$score?>
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
<? while ( $points = $result->fetchNextObject() ): ?>
         <tr>
            <td><?=$points->_TeamsObject->Team_Name?></td>
         	<td><?=$points->_RostersObject->number?></td>
         	<td><?=$points->_PlayersObject->getFullName()?></td>
            <td><?=$points->Quarter?></td>
            <td><?=$points->Goals?></td>
            <td><?=$points->Assists?></td>
            <td><?=$points->getPoints()?></td>
            <td><?=$points->GroundBalls?></td>
            <td><?=$points->Shots?></td>
            <td><?=$points->Turnovers?></td>
            <td><?=$points->CausedTurnovers?></td>
            <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?=$points->Game_ID?>&Team_ID=<?=$points->Team_ID?>&Player_ID=<?=$points->Player_ID?>&Quarter=<?=$points->Quarter?>&Goals=<?=$points->Goals?>&Assists=<?=$points->Assists?>&GroundBalls=<?=$points->GroundBalls?>&Shots=<?=$points->Shots?>&Turnovers=<?=$points->Turnovers?>&CausedTurnovers=<?=$points->CausedTurnovers?>"> <img src= ../images/site_images/icon_edit.gif>
            <a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?=$points->Game_ID?>&Player_ID=<?=$points->Player_ID?>&Quarter=<?=$points->Quarter?>"> <img src= ../images/site_images/icon_delete.gif></td>
         </tr>
<? endwhile; ?>
      </tbody>
</table>

<br />

<?=$statsenterformhome?>

<?=$statsenterformaway?>

<button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=GoalieEnter&Game_ID=<?=$Game_ID?>'">Enter Goalie Scores ></button></td>

