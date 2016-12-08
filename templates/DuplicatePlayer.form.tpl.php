
<p>We have found a match to the player's name and graduation year you just entered. 
In an effort to avoid having the same player entered twice we give you the option to move the player from his current team to yours. 
Or it is possible that two players on different teams happen to have the same name and graduation year. In this case you will want to conintue entering your new player on your team.
Or Maybe you just made a mistake and want to cancel to start over.</p>

<p>Here are your 3 Options:</p>

<ol>
   <li>The player(s) below match the player you entered. Please select one to move to your team:</li>
   <ul>
      <?php while ( $player = $result->fetchNextObject() ): ?>
         <li><?php echo $player->First_Name?> <?php echo $player->Last_Name?> is currently on <?php echo $player->_teamObject->Team_Name != NULL ? $player->_teamObject->Team_Name : "NA"?>'s team. <button type="button" onClick="window.location='EditPlayerInfo.php?action=Move&Player_ID=<?php echo $player->Player_ID?>&Team_ID=<?php echo $Team_ID?>'"> MOVE</button> </li>
      <?php endwhile; ?>
   </ul>
    
   <li>None of the player above match the player I want to enter. Please add the contact I entered as a new player. <button type="button" onClick="window.location='EditPlayerInfo.php?Force=Force&action=Enter&First_Name=<?php echo $playerObject->First_Name?>&Last_Name=<?php echo $playerObject->Last_Name?>&Graduation_Year=<?php echo $playerObject->Graduation_Year?>&School_ID=<?php echo $playerObject->School_ID?>&Height=<?php echo $playerObject->Height?>&Weight=<?php echo $playerObject->Weight?>&Team_ID=<?php echo $Team_ID?>'"> ADD</button></li>
   
   <li>I made a mistake and would like to start over. <button type="button" onClick="window.location='EditPlayerInfo.php?Team_ID=<?php echo $Team_ID?>'"> Cancel</button></li>

</ol>


