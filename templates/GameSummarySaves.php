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
<?php while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?php echo $saves->_TeamsObject->Team_Name?></td>
         	<td><?php echo $saves->_RostersObject->number?></td>
         	<td><?php echo $saves->_PlayersObject->getFullName()?></td>
            <td><?php echo $saves->Saves?></td>
            <td><?php echo $saves->Goals_Against?></td>
            <td><?php echo $saves->getAverage()?></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>