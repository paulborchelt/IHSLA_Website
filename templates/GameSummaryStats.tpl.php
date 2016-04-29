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
<? while ( $points = $result->fetchNextObject() ): ?>
         <tr>
            <td><?=$points->_TeamsObject->Team_Name?></td>
         	<td><?=$points->_RostersObject->number?></td>
         	<td><?=$points->_PlayersObject->getFullName()?></td>
            <td><?=$points->Goals?></td>
            <td><?=$points->Assists?></td>
            <td><?=$points->getPoints()?></td>
         </tr>
<? endwhile; ?>
      </tbody>
</table>