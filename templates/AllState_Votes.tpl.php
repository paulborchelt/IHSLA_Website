<?php if (TRUE == $summary ): ?>
   <h4>Summary of <?php echo $team->Team_Name?> votes for <?php echo $Team_Level_Description?> </h4>
<?php else: ?>
   <h4>Please enter <?php echo $team->Team_Name?> votes for <?php echo $Team_Level_Description?> <?php echo $position->Description?>.</h4>
<?php endif; ?>

<table id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
<tr>
	<td>Name</td>
	<td>Position</td>
   <?php if (FALSE == $summary ): ?>
	  <td>Modify</td>
   <?php endif; ?>
</tr>
<?php while ( $vote = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo $vote->_PlayersObject->getFullName()?></td>
      <td><?php echo $vote->_PositionObject->Description?></td>
      <?php if (FALSE == $summary ): ?>
         <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Team_ID=<?php echo $team->Team_ID?>&ID=<?php echo $vote->ID?>&Position_ID=<?php echo $position->Position_ID?>&Team_Level=<?php echo $Team_Level?>"> <img src= /images/site_images/icon_delete.gif> </td>
      <?php endif; ?>
   </tr>
<?php endwhile; ?>
</table>
<?php echo $voteform?>

<br /><br /> 
<?php if (FALSE == $summary ): ?>
   <?php if ( 8 == $nextposition->Position_ID ) : ?>
      <p>Once you have finished entering <?php echo $position->Description?> votes, hit next to see a summary of your votes.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?action=Summary&Position_ID=1&Team_ID=<?php echo $team->Team_ID?>&Team_Level=<?php echo $Team_Level?>'">Next</button>
   <?php else: ?>
      <p>Once you have finished entering <?php echo $position->Description?> votes, hit next to enter your <?php echo $nextposition->Description?> votes.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?Position_ID=<?php echo $nextposition->Position_ID?>&Team_ID=<?php echo $team->Team_ID?>&Team_Level=<?php echo $Team_Level?>'">Next</button>
   <?php endif; ?>
<?php else: ?>
   <!-- <input TYPE="button" value="Back" onClick="location.href='<?php echo $_SERVER['PHP_SELF']?>?Position_ID=6&Team_ID=<?php echo $team->Team_ID?>'" class="style2" style="width: 63px"> -->
   <?php if (1 == $Team_Level) : ?>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?Position_ID=1&Team_Level=2&Team_ID=<?php echo $team->Team_ID?>'">Second Team All State</button>
   <?php else : ?>
      <button type="button" class="btn btn-default" onClick="window.location='login.php'">Done</button>
   <?php endif; ?>
   
<?php endif; ?> 