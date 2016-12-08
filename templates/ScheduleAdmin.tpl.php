<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Date:</td>
	<td>Home Team:</td>
	<td>Away Team:</td>
	<td>Site:</td>
	<td>Time:</td>
	<td>Level:</td>
	<td>Type:</td>
	<td>Edit:</td>
	<td>Status:</td>
	<td>Referee:</td>
	<td>Umpire:</td>
	<td>Field Judge:</td>
</tr>
<?php while ( $schedule = $result->fetchNextObject() ): ?>
<tr>
	<td><?php echo $schedule->_DateObject->getScheduleFormat()?></td>
	<td><?php echo $schedule->_HomeTeamObject->Team_Name?></td>
	<td><?php echo $schedule->_AwayTeamObject->Team_Name?></td>
	<td><?php echo $schedule->_SiteObject->field_name?></td>
	<td><?php echo $schedule->_TimeObject->getTime()?></td>
	<td><?php echo $schedule->Game_Level?></td>
	<td><?php echo $schedule->Game_Type?></td>
	<td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?php echo $schedule->Game_ID?>"> <img src= /HighSchool/images/icon_edit.gif>
   <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?php echo $schedule->Game_ID?>"> <img src= /HighSchool/images/icon_delete.gif></td>
	<td><?php echo $schedule->_CancelOptionsObject->cancelname?></td>
	<td><?php echo $schedule->_RefereeObject->GetFullName()?> </td>
	<td><?php echo $schedule->_UmpireObject->GetFullName()?> </td>
	<td><?php echo $schedule->_FieldJudgeObject->GetFullName()?> </td>
</tr>
<?php endwhile; ?>
</table>