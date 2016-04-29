<FORM action="<?=$_SERVER['PHP_SELF']?>" method="post"> 	
    <TABLE cellspacing="1" cellpadding="1" border="0">
        <TR>
            <TD>Title:</TD>
        </TR>
        <TR>
            <TD><INPUT TYPE="text" VALUE="<?=$issue->title?>" NAME="title" size="50"></TD>
        </TR>
        <TR>
            <TD>Description:</TD>
        </TR>
        <TR>
            <TD><textarea name="description" rows="5" cols="60"><?=$issue->description?></textarea></TD>
            <TD><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ></TD>
            <TD><INPUT TYPE="submit" NAME="News" VALUE="Enter"></TD>
        </TR>
    </TABLE> 
</FORM>
<?=$list_of_issues?>
<?=$list_of_teams?>