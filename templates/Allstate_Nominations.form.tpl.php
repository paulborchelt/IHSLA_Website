<form action="<?php echo$_SERVER['PHP_SELF']?>" method="post">
	<table cellspacing="1" cellpadding="1" border="0">
	<tr>
	<td>Name:</td>
	<td></td>
	<td></td></tr>
	<tr>
	<td><select name="Player_ID"><?php echo$playeroptions?></select></td>
   <td><input type="HIDDEN" name="Position_ID" value=<?php echo$Position_ID?>>
   <td><input type="HIDDEN" name="Year" value=<?php echo$Year?>>
   <td><input type="HIDDEN" name="action" value="Enter">
	<td><input type="HIDDEN" name="Team_ID" value=<?php echo$Team_ID?>>
  <input type="submit" name="SubmitNomination" value="SUBMIT"></td></tr></table>
</form>