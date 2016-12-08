<p>You are about to change officials for this game. An evaluation form for this 
official has already been filled out. Changing officials will delete this 
evaluation form.&nbsp; Would you still like to change officials: </p>
<form action="" method="post" style="height: 72px">
	Yes<input  name="forceedit" type="radio" value="Yes"> No<input checked="true" name="forceedit" type="radio" value="No">
	<input type="hidden" name="action" value="EditOfficial">
    <input type="hidden" name="Game_ID" value=<?php echo $Game_ID?>>
    <input type="hidden" name="Team_ID" value=<?php echo $Team_ID?>>
	<br>&nbsp;<br>
<input name="Submit1" type="submit" value="submit"></form>