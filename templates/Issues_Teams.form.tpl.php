<FORM action="<?=$_SERVER['PHP_SELF']?>" method="post"> 	
    <TABLE cellspacing="1" cellpadding="1" border="0">
        <TR>
            <TD>Teams involved in issue:</TD>
        </TR>
        <TR>
            <TD><SELECT NAME="teams_id"><?=$teamoptions?></SELECT></TD>
            <INPUT TYPE="hidden" NAME="issues_id" VALUE=<?=$issues_teams_issues_id?> >
            <INPUT TYPE="hidden" NAME="id" VALUE=<?=$issues_id?> >
            <INPUT TYPE="hidden" NAME="action" VALUE="ADD_TEAM" >
            <TD><INPUT TYPE="submit" VALUE="ADD"></TD>
        </TR>
    </TABLE> 
</FORM>
<?=$list_of_teams?>