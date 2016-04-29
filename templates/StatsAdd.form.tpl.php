 <form class="well form-inline" action="<?=$_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Stats for <?=$teamname?>:</h4></legend>
   <p></p>
   <label>Player</label>
   <select name="Player_ID"><?=$playeroptions?> </select>
   <label>Quarter</label>
   <select class="input-mini" name="Quarter"><?=$quarteroptions?> </select>
   <label>Goals</label>
   <input type="text" class="input-mini" name="Goals" value="<?=$Goals != NULL ? $Goals : 0?>">
   <label>Assists</label>
   <input type="text" class="input-mini" name="Assists" value="<?=$Assists != NULL ? $Assists : 0?>">
   <label>GBs</label>
   <input type="text" class="input-mini" name="GroundBalls" value="<?=$GroundBalls != NULL ? $GroundBalls : 0?>">
   <label>Shots</label>
   <input type="text" class="input-mini" name="Shots" value="<?=$Shots != NULL ? $Shots : 0?>"></td>
   <label>T/O</label>
   <input type="text" class="input-mini" name="Turnovers" value="<?=$Turnovers != NULL ? $Turnovers : 0?>"></td>
   <label>CT</label>
   <input type="text" class="input-mini" name="CausedTurnovers" value="<?=$CausedTurnovers != NULL ? $CausedTurnovers : 0?>"></td>
   <? if ( FALSE == $Edit ): ?>
   <button type="submit" class="btn btn-primary">Enter</button>
   <input type="hidden" name="action" value="Insert">
   <? else: ?>
   <button type="submit" class="btn btn-primary">Edit</button>
   <input type="hidden" name="action" value="StatsUpdate">
   <? endif; ?>
   <input type="hidden" name="Game_ID" value="<?=$Game_ID?>">
   <input type="hidden" name="Team_ID" value="<?=$Team_ID?>">
 </form>

