
<script type="text/javascript" src="../javascript/html_form_input_mask.js"></script>
<script type="text/javascript" src="prototype.js"></script>

<script type="text/javascript">
<!--
/*Multiple onload function created by: Simon Willison
http://simonwillison.net/2004/May/26/addLoadEvent/

*/
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
  Xaprb.InputMask.setupElementMasks();
});
//-->
</script>

<?php echo$leagueoptionsform?>


<form action="<?php echo$_SERVER['PHP_SELF']?>" method="post">
    <table style="width: 1412px">
        <tr>
            <td style="width: 478px">Date:</td>

            <td>Home:</td>

            <td>Away:</td>

            <td>Site:</td>

            <td style="width: 536px">Time:</td>

            <td>Level:</td>

            <td>Type:</td>
        </tr>

        <tr>
            <td style="height: 43px; width: 478px">
                <?php echo$calendar->writeScript()?>
            </td>

            <td style="height: 43px"><select name="HomeTeam_ID">
                <?php echo$hometeamoptions?>
                </select></td>

            <td style="height: 43px"><select name="AwayTeam_ID">
                <?php echo$awayteamoptions?>
                </select></td>
                
            <td style="height: 43px"><select name="Site_ID">
                <?php echo$siteidoptions?>
                </select></td>

            <td style="width: 536px; height: 43px">
                &nbsp;<select name="Hour">
				<?php echo$houroptions?>
				</select>:<select name="Minutes">
				<?php echo$minuteoptions?>
				</select><select name="Period">
				<?php echo$periodoptions?>
				</select></td>

            <td style="height: 43px"><select name="Game_Level">
                <?php echo$leveloptions?>
                </select></td>

            <td style="height: 43px"><select name="Game_Type">
                <?php echo$gametypeoptions?>
                </select></td>
            <td style="height: 43px"></td>
            <?php if ($submittype == "Submit"): ?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ><INPUT type="submit" name="Submit" value="SUBMIT" ></td>
            <?php else:?>
            <td style="height: 43px"><INPUT TYPE="HIDDEN" NAME="action" VALUE=SubmitEdit ><INPUT type="submit" name="Edit" value="EDIT" ></td>
            <?php endif; ?>
            <input type="HIDDEN" name="Game_ID" value=<?php echo$gameid?> >
        </tr>
    </table>
</form>

<p>If you do not see an out of state team in your opponent list click on ADD TEAM to add it.</p> 
<p><a href="AdminTeams.php?league=<?php echo$league?>&link=AdminSchedule.php"> ADD TEAM </a></p>

<?php echo$list_of_schedule?>