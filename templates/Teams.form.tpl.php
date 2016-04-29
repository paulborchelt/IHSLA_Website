

 
<p>Please uuse the search box below to search for the team before entering it so we do not end up with teams entered twice in database.</p>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412">
        <tr>
            <td style="width: 121px">Name</td><td style="height: 43px; width: 391px;"><input type="text" value="<?=$Team_Name?>" name="Team_Name" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Address</td></td><td style="height: 43px; width: 391px;"><input type="text" value="<?=$Address?>" name="Address" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">City</td></td><td style="height: 43px; width: 391px;"><input type="text" value="<?=$City?>" name="City" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">State</td><td style="height: 63px"><select name="State"><?=$stateoptions?></select></td>
        </tr>
        <tr>
        <td style="width: 121px">Zip</td><td style="height: 63px">
			<input type="text" value="<?=$ZIP?>" name="ZIP" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Phone</td><td style="height: 63px">
			<input type="text" value="<?=$Phone?>" name="Phone" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Home Colors </td><td style="height: 63px">
			<input type="text" value="<?=$Home_Colors?>" name="Home_Colors" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Away Colors</td><td style="height: 63px">
			<input type="text" value="<?=$Away_Colors?>" name="Away_Colors" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Mascot</td><td style="height: 63px">
			<input type="text" value="<?=$Mascot?>" name="Mascot" size="20"></td>
        </tr>
        <? if ($user->hasPermisions(Groups_Row::Administrators)): ?>
        <tr>
        <td style="width: 121px">Member</td><td style="height: 63px">
			<select name="Member" style="width: 154px"><?=$Member?></select></td>
        </tr>
        <td style="width: 121px">Club</td><td style="height: 63px">
			<select name="Club" style="width: 154px"><?=$Club?></select></td>
        </tr>
        <tr>
        <td style="width: 121px">League</td><td style="height: 63px">
			<select name="League"><?=$leagueoptions?></select></td>
        </tr>
        <? else: ?>
        <input type="HIDDEN" name="Member" value=0 >
        <input type="HIDDEN" name="Club" value=0 >
        <input type="HIDDEN" name="League" value=1 >
        <? endif; ?>
        <tr>
        	<? if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <? else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <? endif; ?>
            <input type="HIDDEN" name="Team_ID" value=<?=$teamid?> >
            <input type="HIDDEN" name="link" value=<?=$returnlink?> >
            <td style="height: 63px">&nbsp;</td>
        </tr>
    </table>
</form>
<p><button type="button" onClick="window.location='<?=$returnlink?>'">Return</button></p>
<? if ($user->hasPermisions(Groups_Row::Administrators)): ?>
<?=$leagueSort?>
<? endif; ?>
<?=$list_of_teams?>