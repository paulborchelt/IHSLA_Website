<table class="table" cellpadding="1" cellspacing="1" border="1" >
<thead>
   <tr>
   	<td>Date:</td>
   	<td>Home Team:</td>
   	<td>Away Team:</td>
   	<td>Site:</td>
   	<td>Time:</td>
   	<td>Level:</td>
   	<td>Type:</td>
      <td>Result</td>
   </tr>
</thead>
<tbody>
<?php while ( $schedule = $result->fetchNextObject() ): ?>
   <tr>
   	<td><?php echo $schedule->_DateObject->getScheduleFormat()?></td>
   	<td><?php echo $schedule->_HomeTeamObject->Team_Name?></td>
   	<td><?php echo $schedule->_AwayTeamObject->Team_Name?></td>
   	<td><?php echo $schedule->_SiteObject->field_name?></td>
   	<td><?php echo $schedule->_TimeObject->getTime()?></td>
   	<td><?php echo $schedule->Game_Level?></td>
   	<td><?php echo $schedule->Game_Type?></td>
      <td><?php echo $schedule->getResults(TRUE)?></td>
   </tr>
<?php endwhile; ?>
</tbody>
</table>