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
<? while ( $schedule = $result->fetchNextObject() ): ?>
   <tr>
   	<td><?=$schedule->_DateObject->getScheduleFormat()?></td>
   	<td><?=$schedule->_HomeTeamObject->Team_Name?></td>
   	<td><?=$schedule->_AwayTeamObject->Team_Name?></td>
   	<td><?=$schedule->_SiteObject->field_name?></td>
   	<td><?=$schedule->_TimeObject->getTime()?></td>
   	<td><?=$schedule->Game_Level?></td>
   	<td><?=$schedule->Game_Type?></td>
      <td><?=$schedule->getResults(TRUE)?></td>
   </tr>
<? endwhile; ?>
</tbody>
</table>