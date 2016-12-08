<TABLE cellspacing="1" cellpadding="1" border="0">
<?php while ( $teams = $result->fetchNextObject() ): ?>
    <TR>
        <TD><?php echo $teams->_teams->name?></TD>
        <TD><a href="<?php echo $_SERVER['PHP_SELF']?>?action=DELETE_TEAM&team_id=<?php echo $teams->_teams->Team_ID?>"> <img src= /HighSchool/images/icon_delete.gif></a></TD></TR>
    </TR>
<?php endwhile; ?>
</TABLE>