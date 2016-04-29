<TABLE cellspacing="1" cellpadding="1" border="0">
<? while ( $teams = $result->fetchNextObject() ): ?>
    <TR>
        <TD><?=$teams->_teams->name?></TD>
        <TD><a href="<?$_SERVER['PHP_SELF']?>?action=DELETE_TEAM&team_id=<?=$teams->_teams->Team_ID?>"> <img src= /HighSchool/images/icon_delete.gif></a></TD></TR>
    </TR>
<? endwhile; ?>
</TABLE>