<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <a>Select Game:  <SELECT name="Game_ID"><?php echo $selectteamoptionsform?></SELECT>
    <input name="action" type="hidden" value="selectGame">
    <INPUT TYPE="hidden" NAME="Team_ID" VALUE=<?php echo $Team_ID?> >
    <INPUT type="submit" name="selectGame" value="GO" ></a>
</form>