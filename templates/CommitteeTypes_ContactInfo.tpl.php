<TABLE cellspacing="1" cellpadding="1" border="1">
<TR><TD>Name</TD>
    <TD>Committee Type</TD>
    <TD>Start Year</TD>
    <TD>End Year</TD>
    <TD>Delete</TD>
</TR>
<? while ( $member = $result->fetchNextObject() ): ?>
<TR>
    <TD><?=$member->_ContactInfo->FirstName?> <?=$member->_ContactInfo->LastName?></TD>
    <TD><?=$member->_CommitteeTypes->name?></TD>
    <TD><?=$member->startyear?></TD>
    <TD><?=$member->endyear?></TD>
    <TD><a href="<?=$_SERVER['PHP_SELF']?>?page=DELETE_COMMITTEE_MEMBER&contactinfo_id=<?=$member->contactinfo_id?>"> <img src= /HighSchool/images/icon_delete.gif></a></TD>
</TR>
<? endwhile; ?>
</TABLE>