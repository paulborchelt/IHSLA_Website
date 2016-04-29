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
<? while ( $schedule = $result->fetchNextObject() ): ?>
<tr>
	<td><?=$schedule->_DateObject->getScheduleFormat()?></td>
	<td><?=$schedule->_HomeTeamObject->Team_Name?></td>
	<td><?=$schedule->_AwayTeamObject->Team_Name?></td>
	<td><?=$schedule->_SiteObject->field_name?></td>
	<td><?=$schedule->_TimeObject->getTime()?></td>
	<td><?=$schedule->Game_Level?></td>
	<td><?=$schedule->Game_Type?></td>
	<td><a href="<?=$_SERVER['PHP_SELF']?>?action=Edit&Game_ID=<?=$schedule->Game_ID?>"> <img src= /HighSchool/images/icon_edit.gif>
   <a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Game_ID=<?=$schedule->Game_ID?>"> <img src= /HighSchool/images/icon_delete.gif></td>
	<td><?=$schedule->_CancelOptionsObject->cancelname?></td>
	<td><?=$schedule->_RefereeObject->GetFullName()?> </td>
	<td><?=$schedule->_UmpireObject->GetFullName()?> </td>
	<td><?=$schedule->_FieldJudgeObject->GetFullName()?> </td>
</tr>
<? endwhile; ?>
</table>