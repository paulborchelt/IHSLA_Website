<form class="well form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Saves for <?=$teamname?>:</h4></legend>
   <label>Player</label>
   <select name="Player_ID"><?=$playeroptions?> </select>
   <label>Quarter</label>
   <select class="input-mini" name="Quarter"><?=$quarteroptions?> </select>
   <label>Saves</label>
   <input type="text" class="input-mini" name="Saves" value="<?=$Saves != NULL ? $Saves : 0?>">
   <label>Goals Against</label>
   <input type="text" class="input-mini" name="Goals_Against" value="<?=$Goals_Against != NULL ? $Goals_Against : 0?>">
   <? if ( FALSE == $Edit ): ?>
      <button type="submit" class="btn btn-primary">Enter</button>
      <input type="hidden" name="action" value="SavesInsert">
   <? else: ?>
      <button type="submit" class="btn btn-primary">Edit</button>
      <input type="hidden" name="action" value="SavesUpdate">
   <? endif; ?>
   <input type="hidden" name="Game_ID" value="<?=$Game_ID?>">
   <input type="hidden" name="Team_ID" value="<?=$Team_ID?>">
 </form>

