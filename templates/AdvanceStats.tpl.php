<TABLE cellspacing="1" cellpadding="1" border="1">
<TR><TD>Name</TD>
    <TD>Shots</TD>
    <TD>GBs</TD>
    <TD>TO</TD>
    <TD>CT</TD>
</TR>
<?php while ( $stats = $result->fetchNextObject() ): ?>
<TR>
    <TD>test</TD>
    <TD><?php echo$stats->shots?></TD>
    <TD><?php echo$stats->groundballs?></TD>
    <TD><?php echo$stats->turnovers?></TD>
    <TD><?php echo$stats->causedturnovers?></TD>
</TR>
<?php endwhile; ?>
</TABLE>

