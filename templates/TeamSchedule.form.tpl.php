<script type="text/javascript" src="javascript/html_form_input_mask.js"></script>
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

<?php echo $leagueoptionsform?>

<form class="well form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Games for <?php echo $team->Team_Name?>:</h4></legend>
   <p></p>
   <label>Date</label>
   <input type="text" id="dp1" class="span2 datepicker" value="<?php echo $Date?>" name="Date" required>
   <label>Opponent</label>
   <select class="span2" name="opponent"><?php echo $opponentoptions?></select>
   <label>location</label>
   <select class="span2" name="location"><?php echo $locationoptions?></select>
   <label>Site</label>
   <select class="span2" name="Site_ID"><?php echo $siteidoptions?></select>
   <div class="input-group">
   <label>Time</label>
   <select class="span1" name="Hour"><?php echo $houroptions?></select><span class="input-group-addon">:</span><select class="span1" name="Minutes"><?php echo $minuteoptions?></select><select class="span1" name="Period"><?php echo $periodoptions?></select>
   </div>
   
   <label>Level</label>
   <select class="span2" name="Game_Level"><?php echo $leveloptions?></select>
   <label>Type</label>
   <select class="span2" name="Game_Type"><?php echo $gametypeoptions?></select>
   <td></td>
   <?php if ($submittype == "Submit"): ?>
      <input type="HIDDEN" name="action" value=Enter>
      <button type="submit" class="btn btn-primary">Enter</button>
   <?php else:?>
      <input type="HIDDEN" name="action" value=SubmitEdit >
      <button type="submit" class="btn btn-primary">Edit</button>
   <?php endif; ?>
   <input type="HIDDEN" name="Game_ID" value=<?php echo $gameid?> >
   <input type="HIDDEN" name="Team_ID" value=<?php echo $team->Team_ID?> >
</form>

<p>If you do not see an out of state team in your opponent list click on ADD TEAM to add it.</p> 
<p><a href="AdminTeams.php?league=<?php echo $league?>&link=<?php echo $_SERVER['PHP_SELF']?>?Team_ID=<?php echo $team->Team_ID?>"> ADD TEAM </a></p>

<?php echo $list_of_schedule?>