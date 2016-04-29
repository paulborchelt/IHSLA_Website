<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <a>Select Game:  <SELECT name="Game_ID"><?=$selectteamoptionsform?></SELECT>
    <input name="action" type="hidden" value="selectGame">
    <INPUT TYPE="hidden" NAME="Team_ID" VALUE=<?=$Team_ID?> >
    <INPUT type="submit" name="selectGame" value="GO" ></a>
</form>