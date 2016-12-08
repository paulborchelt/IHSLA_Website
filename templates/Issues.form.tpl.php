<FORM action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 	
    <TABLE cellspacing="1" cellpadding="1" border="0">
        <TR>
            <TD>Title:</TD>
        </TR>
        <TR>
            <TD><INPUT TYPE="text" VALUE="<?php echo $issue->title?>" NAME="title" size="50"></TD>
        </TR>
        <TR>
            <TD>Description:</TD>
        </TR>
        <TR>
            <TD><textarea name="description" rows="5" cols="60"><?php echo $issue->description?></textarea></TD>
            <TD><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ></TD>
            <TD><INPUT TYPE="submit" NAME="News" VALUE="Enter"></TD>
        </TR>
    </TABLE> 
</FORM>
<?php echo $list_of_issues?>
<?php echo $list_of_teams?>