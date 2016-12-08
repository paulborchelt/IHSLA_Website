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
            <td style="width: 121px">Main Contact</td>
            <td style="height: 63px"><select name="MainContact"><?php echo $maincontactoptions?></select></td>
        </tr>
        <tr>
        	<?php if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=EnterContact ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <?php else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <?php endif; ?>
            <input type="HIDDEN" name="Team_ID" value=<?php echo $teamid?> >
            <input type="HIDDEN" name="Id" value=<?php echo $Id?> >
            <input type="HIDDEN" name="contactinfoteamslistid" value=<?php echo $contactinfoteamslistid?> >
            <td style="height: 63px">&nbsp;</td>
        </tr>
    
    </table>
</form>