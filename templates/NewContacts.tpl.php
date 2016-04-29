<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table cellspacing="1" cellpadding="1" border="0">
        <tr>
            <td></td>
    
            <td></td>
    
            <td style="width: 143px"></td>
    
            <td></td>
        </tr>
        <tr>
            <td style="width: 121px">Contact Type</td>
            <td style="height: 63px"><select name="CTID"><?=$contacttypeoptions?></select></td>
        </tr>
        <tr>
            <td style="width: 121px">First Name</td><td style="height: 63px">
			<input type="text" value="<?=$FirstName?>" name="FirstName" size="20"></td>
        </tr>
        	<td style="width: 121px">Last Name</td><td style="height: 63px">
			<input type="text" value="<?=$LastName?>" name="LastName" size="20"></td>
        </td>
        <tr>
            <td style="width: 121px">Phone (Home)</td><td style="height: 63px">
			<input type="text" value="<?=$PhoneHome?>" name="PhoneHome" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Phone (Work)</td><td style="height: 63px">
			<input type="text" value="<?=$PhoneWork?>" name="PhoneWork" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Phone (Cell)</td><td style="height: 63px">
			<input type="text" value="<?=$PhoneCell?>" name="PhoneCell" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Email</td><td style="height: 63px">
			<input type="text" value="<?=$Email?>" name="Email" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Teams</td>
            <td style="height: 63px"><select name="TID"><?=$teams?></select></td>
        </tr>
        <tr>
        	<? if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=EnterContact ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <? else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <? endif; ?>
            <td style="height: 63px">&nbsp;</td>
        </tr>
    
    </table>
</form>




<table cellspacing="1" cellpadding="1" border="1">
<tr>
    <td>Name</td>
    <td>Phone Home</td>
    <td>Phone Work</td>
    <td>Phone Cell</td>
    <td>email</td>
    <td>Team/Area</td>
    <td>Add Contact Record</td>
    <td>View Contact Records</td>
    <td>Delete</td>

</tr>
<? while ( $newcontact = $list_of_newcontacts->fetchNextObject() ): ?>
<tr>
    <td><?=$newcontact->FirstName?>  <?=$newcontact->LastName?></td>
    <td><?=$newcontact->getPhoneHome()?></td>
    <td><?=$newcontact->getPhoneWork()?></td>
    <td><?=$newcontact->getPhoneCell()?></td>
    <td><?=$newcontact->Email?></td>
    <td><?=$newcontact->_ContactInfoTeamsListObject->_TeamObject->Team_Name?></td>
    <td><a href="<?=$_SERVER['PHP_SELF']?>?action=ContactRecordForm&Id=<?=$newcontact->Id?>"> ADD </a></td>
    <td><a href="<?=$_SERVER['PHP_SELF']?>?action=ContactRecordView&idcontactinfo=<?=$newcontact->Id?>"> VIEW </a></td>
    <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Id=<?=$newcontact->Id?>&contactinfoteamslistid=<?=$newcontact->_ContactInfoTeamsListObject->contactinfoteamslistid?>"> <img src= /HighSchool/images/icon_delete.gif></a></td>
</tr>
<? endwhile; ?>
</table>