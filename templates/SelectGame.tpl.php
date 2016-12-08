 <form action="<?php echo$_SERVER['PHP_SELF']?>" method="post">
     <a>Game: <select name="Game_ID"> <?php echo$gameOptions?> </select> 
     <input type="hidden" name="Team_ID" value="<?php echo$Team_ID?>"> 
     <input type="hidden" name="action" value="<?php echo$action?>"> 
     <input type="submit" name="selectYear" value="GO"></a>
 </form>
