 <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
     <a>Game: <select name="Game_ID"> <?=$gameOptions?> </select> 
     <input type="hidden" name="Team_ID" value="<?=$Team_ID?>"> 
     <input type="hidden" name="action" value="<?=$action?>"> 
     <input type="submit" name="selectYear" value="GO"></a>
 </form>
