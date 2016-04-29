<FORM action="'.$_SERVER['PHP_SELF'].'" method="post">
	<TABLE cellspacing="1" cellpadding="1" border="0">
	<TR>
	<TD>Name:</TD>
	<TD>Shots:</TD>
	<TD>GBs:</TD>
    <TD>TO:</TD>
    <TD>CT:</TD></TR>
	<TR>
	<TD><SELECT NAME="Player_ID">
		'.$Options.'
		</SELECT></TD>
	<TD><INPUT TYPE="text" NAME="shots" size="2"></TD>
	<TD><INPUT TYPE="text" NAME="groundballs" size="2"></TD>
    <TD><INPUT TYPE="text" NAME="turnovers" size="2"></TD>
    <TD><INPUT TYPE="text" NAME="causedturnovers" size="2"></TD>
	<TD><INPUT TYPE="HIDDEN" NAME="page" VALUE='.$page.' >
    <INPUT TYPE="submit" NAME="SubmitScoringStats" VALUE="SUBMIT"></TD></TR></TABLE>
</FORM