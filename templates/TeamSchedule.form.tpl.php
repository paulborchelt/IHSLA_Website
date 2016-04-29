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

<?=$leagueoptionsform?>

<form class="well form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Games for <?=$team->Team_Name?>:</h4></legend>
   <p></p>
   <label>Date</label>
   <input type="text" id="dp1" class="span2 datepicker" value="<?=$Date?>" name="Date" required>
   <label>Opponent</label>
   <select class="span2" name="opponent"><?=$opponentoptions?></select>
   <label>location</label>
   <select class="span2" name="location"><?=$locationoptions?></select>
   <label>Site</label>
   <select class="span2" name="Site_ID"><?=$siteidoptions?></select>
   <div class="input-group">
   <label>Time</label>
   <select class="span1" name="Hour"><?=$houroptions?></select><span class="input-group-addon">:</span><select class="span1" name="Minutes"><?=$minuteoptions?></select><select class="span1" name="Period"><?=$periodoptions?></select>
   </div>
   
   <label>Level</label>
   <select class="span2" name="Game_Level"><?=$leveloptions?></select>
   <label>Type</label>
   <select class="span2" name="Game_Type"><?=$gametypeoptions?></select>
   <td></td>
   <? if ($submittype == "Submit"): ?>
      <input type="HIDDEN" name="action" value=Enter>
      <button type="submit" class="btn btn-primary">Enter</button>
   <? else:?>
      <input type="HIDDEN" name="action" value=SubmitEdit >
      <button type="submit" class="btn btn-primary">Edit</button>
   <? endif; ?>
   <input type="HIDDEN" name="Game_ID" value=<?=$gameid?> >
   <input type="HIDDEN" name="Team_ID" value=<?=$team->Team_ID?> >
</form>

<p>If you do not see an out of state team in your opponent list click on ADD TEAM to add it.</p> 
<p><a href="AdminTeams.php?league=<?=$league?>&link=<?=$_SERVER['PHP_SELF']?>?Team_ID=<?=$team->Team_ID?>"> ADD TEAM </a></p>

<?=$list_of_schedule?>