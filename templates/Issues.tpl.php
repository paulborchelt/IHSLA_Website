<TABLE cellspacing="1" cellpadding="1" border="1">
<TR><TD>Title</TD>
    <TD>Edit</TD>
    <TD>Delete</TD>
</TR>
<?php while ( $issue = $result->fetchNextObject() ): ?>
<TR>
    <TD><?php echo $issue->title?></TD>
    <TD><a href="<?php echo $_SERVER['PHP_SELF']?>?action=EDIT_ISSUE&id=<?php echo $issue->id?>"> <img src= /HighSchool/images/icon_edit.gif></a></TD>
    <TD><a href="<?php echo $_SERVER['PHP_SELF']?>?action=DELETE_ISSUE&id=<?php echo $issue->id?>"> <img src= /HighSchool/images/icon_delete.gif></a></TD>
</TR>
<?php endwhile; ?>
</TABLE>