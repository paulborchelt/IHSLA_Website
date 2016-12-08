 <form class="well form-inline" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter Stats for <?php echo $teamname?>:</h4></legend>
   <p></p>
   <label>Player</label>
   <select name="Player_ID"><?php echo $playeroptions?> </select>
   <label>Quarter</label>
   <select class="input-mini" name="Quarter"><?php echo $quarteroptions?> </select>
   <label>Goals</label>
   <input type="text" class="input-mini" name="Goals" value="<?php echo $Goals != NULL ? $Goals : 0?>">
   <label>Assists</label>
   <input type="text" class="input-mini" name="Assists" value="<?php echo $Assists != NULL ? $Assists : 0?>">
   <label>GBs</label>
   <input type="text" class="input-mini" name="GroundBalls" value="<?php echo $GroundBalls != NULL ? $GroundBalls : 0?>">
   <label>Shots</label>
   <input type="text" class="input-mini" name="Shots" value="<?php echo $Shots != NULL ? $Shots : 0?>"></td>
   <label>T/O</label>
   <input type="text" class="input-mini" name="Turnovers" value="<?php echo $Turnovers != NULL ? $Turnovers : 0?>"></td>
   <label>CT</label>
   <input type="text" class="input-mini" name="CausedTurnovers" value="<?php echo $CausedTurnovers != NULL ? $CausedTurnovers : 0?>"></td>
   <?php if ( FALSE == $Edit ): ?>
   <button type="submit" class="btn btn-primary">Enter</button>
   <input type="hidden" name="action" value="Insert">
   <?php else: ?>
   <button type="submit" class="btn btn-primary">Edit</button>
   <input type="hidden" name="action" value="StatsUpdate">
   <?php endif; ?>
   <input type="hidden" name="Game_ID" value="<?php echo $Game_ID?>">
   <input type="hidden" name="Team_ID" value="<?php echo $Team_ID?>">
 </form>

