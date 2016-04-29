<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<table cellspacing="1" cellpadding="1" border="0">
	<tr>
	<td>Name:</td>
	<td></td>
	<td></td></tr>
	<tr>
	<td><select name="Player_ID"><?=$playeroptions?></select></td>
   <td><input type="HIDDEN" name="Position_ID" value=<?=$Position_ID?>>
   <td><input type="HIDDEN" name="Year" value=<?=$Year?>>
   <td><input type="HIDDEN" name="action" value="Enter">
	<td><input type="HIDDEN" name="Team_ID" value=<?=$Team_ID?>>
   <td><input type="HIDDEN" name="Team_Level" value=<?=$Team_Level?>>
  <input type="submit" name="SubmitNomination" value="SUBMIT"></td></tr></table>
</form>