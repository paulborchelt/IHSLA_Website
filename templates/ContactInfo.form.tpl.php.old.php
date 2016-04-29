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
            <td style="width: 121px">Main Contact</td>
            <td style="height: 63px"><select name="MainContact"><?=$maincontactoptions?></select></td>
        </tr>
        <tr>
        	<? if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=EnterContact ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <? else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <? endif; ?>
            <input type="HIDDEN" name="Team_ID" value=<?=$teamid?> >
            <input type="HIDDEN" name="Id" value=<?=$Id?> >
            <input type="HIDDEN" name="contactinfoteamslistid" value=<?=$contactinfoteamslistid?> >
            <td style="height: 63px">&nbsp;</td>
        </tr>
    
    </table>
</form>