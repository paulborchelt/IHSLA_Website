<table class="table table-condensed table-hover">
   <thead>
      <tr>
         <th colspan="6"><h4>Scoring Summary</h4></th>
      </tr>
      <tr>
         <th>Team</th>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Goals:</th>
         <th>Assists:</th>
         <th>Points:</th>
      </tr>
   </thead>
      <tbody>
<?php while ( $points = $result->fetchNextObject() ): ?>
         <tr>
            <td><?php echo $points->_TeamsObject->Team_Name?></td>
         	<td><?php echo $points->_RostersObject->number?></td>
         	<td><?php echo $points->_PlayersObject->getFullName()?></td>
            <td><?php echo $points->Goals?></td>
            <td><?php echo $points->Assists?></td>
            <td><?php echo $points->getPoints()?></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>