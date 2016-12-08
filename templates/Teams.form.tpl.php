

 
<p>Please uuse the search box below to search for the team before entering it so we do not end up with teams entered twice in database.</p>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412">
        <tr>
            <td style="width: 121px">Name</td><td style="height: 43px; width: 391px;"><input type="text" value="<?php echo $Team_Name?>" name="Team_Name" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Address</td></td><td style="height: 43px; width: 391px;"><input type="text" value="<?php echo $Address?>" name="Address" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">City</td></td><td style="height: 43px; width: 391px;"><input type="text" value="<?php echo $City?>" name="City" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">State</td><td style="height: 63px"><select name="State"><?php echo $stateoptions?></select></td>
        </tr>
        <tr>
        <td style="width: 121px">Zip</td><td style="height: 63px">
			<input type="text" value="<?php echo $ZIP?>" name="ZIP" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Phone</td><td style="height: 63px">
			<input type="text" value="<?php echo $Phone?>" name="Phone" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Home Colors </td><td style="height: 63px">
			<input type="text" value="<?php echo $Home_Colors?>" name="Home_Colors" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Away Colors</td><td style="height: 63px">
			<input type="text" value="<?php echo $Away_Colors?>" name="Away_Colors" size="20"></td>
        </tr>
        <tr>
        <td style="width: 121px">Mascot</td><td style="height: 63px">
			<input type="text" value="<?php echo $Mascot?>" name="Mascot" size="20"></td>
        </tr>
        <?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
        <tr>
        <td style="width: 121px">Member</td><td style="height: 63px">
			<select name="Member" style="width: 154px"><?php echo $Member?></select></td>
        </tr>
        <td style="width: 121px">Club</td><td style="height: 63px">
			<select name="Club" style="width: 154px"><?php echo $Club?></select></td>
        </tr>
        <tr>
        <td style="width: 121px">League</td><td style="height: 63px">
			<select name="League"><?php echo $leagueoptions?></select></td>
        </tr>
        <?php else: ?>
        <input type="HIDDEN" name="Member" value=0 >
        <input type="HIDDEN" name="Club" value=0 >
        <input type="HIDDEN" name="League" value=1 >
        <?php endif; ?>
        <tr>
        	<?php if ($submittype == "Submit"): ?>
            <td style="height: 63px; width: 121px;"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <?php else:?>
            <td style="height: 63px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <?php endif; ?>
            <input type="HIDDEN" name="Team_ID" value=<?php echo $teamid?> >
            <input type="HIDDEN" name="link" value=<?php echo $returnlink?> >
            <td style="height: 63px">&nbsp;</td>
        </tr>
    </table>
</form>
<p><button type="button" onClick="window.location='<?php echo $returnlink?>'">Return</button></p>
<?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
<?php echo$leagueSort?>
<?php endif; ?>
<?php echo $list_of_teams?>