<table class="table table-hover">
   <thead>
      <tr>
         <th colspan="6"> <h4>Goalie Summary</h4></th>
      </tr>
      <tr>
         <th>Team</th>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Savs:</th>
         <th>GA:</th>
         <th>SP:</th>
      </tr>
   </thead>
      <tbody>
<? while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?=$saves->_TeamsObject->Team_Name?></td>
         	<td><?=$saves->_RostersObject->number?></td>
         	<td><?=$saves->_PlayersObject->getFullName()?></td>
            <td><?=$saves->Saves?></td>
            <td><?=$saves->Goals_Against?></td>
            <td><?=$saves->getAverage()?></td>
         </tr>
<? endwhile; ?>
      </tbody>
</table>