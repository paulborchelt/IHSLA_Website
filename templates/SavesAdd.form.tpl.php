<form class="well form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Saves for <?php echo $teamname?>:</h4></legend>
   <label>Player</label>
   <select name="Player_ID"><?php echo $playeroptions?> </select>
   <label>Quarter</label>
   <select class="input-mini" name="Quarter"><?php echo $quarteroptions?> </select>
   <label>Saves</label>
   <input type="text" class="input-mini" name="Saves" value="<?php echo $Saves != NULL ? $Saves : 0?>">
   <label>Goals Against</label>
   <input type="text" class="input-mini" name="Goals_Against" value="<?php echo $Goals_Against != NULL ? $Goals_Against : 0?>">
   <?php if ( FALSE == $Edit ): ?>
      <button type="submit" class="btn btn-primary">Enter</button>
      <input type="hidden" name="action" value="SavesInsert">
   <?php else: ?>
      <button type="submit" class="btn btn-primary">Edit</button>
      <input type="hidden" name="action" value="SavesUpdate">
   <?php endif; ?>
   <input type="hidden" name="Game_ID" value="<?php echo $Game_ID?>">
   <input type="hidden" name="Team_ID" value="<?php echo $Team_ID?>">
 </form>

