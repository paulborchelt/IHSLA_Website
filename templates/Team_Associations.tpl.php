

<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Linked Team:</td>
	<td>Host Team:</td>
    <td>Delete:</td>
</tr>
<? while ( $teamassociations = $result->fetchNextObject() ): ?>
<tr>
	<td><?=$teamassociations->_LinkedTeam->Team_Name?></td>
	<td><?=$teamassociations->_HostTeam->Team_Name?></td>
	<td><a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&idlinkedteam=<?=$teamassociations->idlinkedteam?>"> <img src= /HighSchool/images/icon_delete.gif></td>
</tr>
<? endwhile; ?>
</table>