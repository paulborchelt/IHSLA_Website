<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table cellspacing="1" cellpadding="1" border="0">
        <tr>
            <td></td>
    
            <td></td>
    
            <td style="width: 143px"></td>
    
            <td></td>
        </tr>
        <tr>
            <td style="width: 121px">Contact Type</td>
            <td style="height: 63px"><select name="CTID"><?php echo $contacttypeoptions?></select></td>
        </tr>
        <tr>
            <td style="width: 121px">First Name</td><td style="height: 63px">
			<input type="text" value="<?php echo $FirstName?>" name="FirstName" size="20"></td>
        </tr>
        	<td style="width: 121px">Last Name</td><td style="height: 63px">
			<input type="text" value="<?php echo $LastName?>" name="LastName" size="20"></td>
        </td>
        <tr>
            <td style="width: 121px">Phone (Home)</td><td style="height: 63px">
			<input type="text" value="<?php echo $PhoneHome?>" name="PhoneHome" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Phone (Work)</td><td style="height: 63px">
			<input type="text" value="<?php echo $PhoneWork?>" name="PhoneWork" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Phone (Cell)</td><td style="height: 63px">
			<input type="text" value="<?php echo $PhoneCell?>" name="PhoneCell" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Email</td><td style="height: 63px">
			<input type="text" value="<?php echo $Email?>" name="Email" size="20"></td>
        </tr>
        <tr>
            <td style="width: 121px">Teams</td>
            <td style="height: 63px"><select name="TID"><?php echo $teams?></select></td>
        </tr>
        <tr>
        	<?php if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=EnterContact ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <?php else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <?php endif; ?>
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
<?php while ( $newcontact = $list_of_newcontacts->fetchNextObject() ): ?>
<tr>
    <td><?php echo $newcontact->FirstName?>  <?php echo $newcontact->LastName?></td>
    <td><?php echo $newcontact->getPhoneHome()?></td>
    <td><?php echo $newcontact->getPhoneWork()?></td>
    <td><?php echo $newcontact->getPhoneCell()?></td>
    <td><?php echo $newcontact->Email?></td>
    <td><?php echo $newcontact->_ContactInfoTeamsListObject->_TeamObject->Team_Name?></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=ContactRecordForm&Id=<?php echo $newcontact->Id?>"> ADD </a></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=ContactRecordView&idcontactinfo=<?php echo $newcontact->Id?>"> VIEW </a></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Id=<?php echo $newcontact->Id?>&contactinfoteamslistid=<?php echo $newcontact->_ContactInfoTeamsListObject->contactinfoteamslistid?>"> <img src= /HighSchool/images/icon_delete.gif></a></td>
</tr>
<?php endwhile; ?>
</table>