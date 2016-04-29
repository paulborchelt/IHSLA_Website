<TABLE cellspacing="1" cellpadding="1" border="1">
<TR><TD>Name</TD>
    <TD>Shots</TD>
    <TD>GBs</TD>
    <TD>TO</TD>
    <TD>CT</TD>
</TR>
<? while ( $stats = $result->fetchNextObject() ): ?>
<TR>
    <TD>test</TD>
    <TD><?=$stats->shots?></TD>
    <TD><?=$stats->groundballs?></TD>
    <TD><?=$stats->turnovers?></TD>
    <TD><?=$stats->causedturnovers?></TD>
</TR>
<? endwhile; ?>
</TABLE>

