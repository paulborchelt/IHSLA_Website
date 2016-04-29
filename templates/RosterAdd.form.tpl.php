<form action="Roster.php" method="post">
<p>Enter player info:</p>
<table cellspacing="1" cellpadding="1" border="0">
<TR>
   <TD>Team Name: </TD>
   <TD><?=$player->_teamObject->Team_Name?></TD>
</TR>
<TR>
   <TD>Players Name: </TD>
   <TD><?=$player->getFullName()?></TD>
   <TD><INPUT TYPE="hidden" NAME="player_id" VALUE="<?=$player->Player_ID?>"></TD>
   <TD><INPUT TYPE="hidden" NAME="Team_ID" VALUE="<?=$player->_teamObject->Team_ID?>"></TD>
   <TD><INPUT TYPE="hidden" NAME="level" VALUE="<?=$roster->level?>"></TD>
   <TD><INPUT TYPE="hidden" NAME="action" VALUE="addplayer"></TD>
</TR>
<TR>
   <TD>Number: </TD>
   <TD><INPUT TYPE="text" NAME="number" size="5"></TD>
</TR>
<TR>
   <TD>Position: </TD>
   <TD><SELECT NAME="position">
	            <?=$positionoptions?>
	            </SELECT></TD>
</TR>
<TR>
   <TD><INPUT type="submit" name="AddRoster" value="ENTER"> </TD>
</TABLE></FORM>