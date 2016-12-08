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

<?php echo $navbarstats?>

<?php echo $selectYear?>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>School</th>
         <th>Grade:</th>
         <th>Position:</th>
         <th>Goals:</th>
         <th>Assists:</th>
         <th>Points:</th>
         <th>GB</th>
         <th>Shots:</th>
         <th>T/0:</th>
         <th>CT:</th>
      </tr>
   </thead>
      <tbody>
<?php while ( $points = $result->fetchNextObject() ): ?>
         <tr>
         	<td><?php echo $points->_RostersObject->number?></td>
         	<td><?php echo $points->_PlayersObject->getFullName()?></td>
            <td><?php echo $points->_PlayersObject->_teamObject->Team_Name?></td>
            <td><?php echo $points->_PlayersObject->getGradeName()?></td>
            <td><?php echo $points->_RostersObject->_PositionObject->Description?></td>
            <td><?php echo $points->Goals?></td>
            <td><?php echo $points->Assists?></td>
            <td><?php echo $points->getPoints()?></td>
            <td><?php echo $points->GroundBalls?></td>
            <td><?php echo $points->Shots?></td>
            <td><?php echo $points->Turnovers?></td>
            <td><?php echo $points->CausedTurnovers?></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>