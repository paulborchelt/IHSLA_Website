<FORM action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 	
    <TABLE cellspacing="1" cellpadding="1" border="0">
        <TR>
            <TD>Teams involved in issue:</TD>
        </TR>
        <TR>
            <TD><SELECT NAME="teams_id"><?php echo $teamoptions?></SELECT></TD>
            <INPUT TYPE="hidden" NAME="issues_id" VALUE=<?php echo $issues_teams_issues_id?> >
            <INPUT TYPE="hidden" NAME="id" VALUE=<?php echo $issues_id?> >
            <INPUT TYPE="hidden" NAME="action" VALUE="ADD_TEAM" >
            <TD><INPUT TYPE="submit" VALUE="ADD"></TD>
        </TR>
    </TABLE> 
</FORM>
<?php echo $list_of_teams?>