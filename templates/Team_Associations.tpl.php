

<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Linked Team:</td>
	<td>Host Team:</td>
    <td>Delete:</td>
</tr>
<?php while ( $teamassociations = $result->fetchNextObject() ): ?>
<tr>
	<td><?php echo $teamassociations->_LinkedTeam->Team_Name?></td>
	<td><?php echo $teamassociations->_HostTeam->Team_Name?></td>
	<td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&idlinkedteam=<?php echo $teamassociations->idlinkedteam?>"> <img src= /HighSchool/images/icon_delete.gif></td>
</tr>
<?php endwhile; ?>
</table>