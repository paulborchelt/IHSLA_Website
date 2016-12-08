<TABLE cellspacing="1" cellpadding="1" border="1">
<TR><TD>Name</TD>
    <TD>Committee Type</TD>
    <TD>Start Year</TD>
    <TD>End Year</TD>
    <TD>Delete</TD>
</TR>
<?php while ( $member = $result->fetchNextObject() ): ?>
<TR>
    <TD><?php echo $member->_ContactInfo->FirstName?> <?php echo $member->_ContactInfo->LastName?></TD>
    <TD><?php echo $member->_CommitteeTypes->name?></TD>
    <TD><?php echo $member->startyear?></TD>
    <TD><?php echo $member->endyear?></TD>
    <TD><a href="<?php echo $_SERVER['PHP_SELF']?>?page=DELETE_COMMITTEE_MEMBER&contactinfo_id=<?php echo $member->contactinfo_id?>"> <img src= /HighSchool/images/icon_delete.gif></a></TD>
</TR>
<?php endwhile; ?>
</TABLE>