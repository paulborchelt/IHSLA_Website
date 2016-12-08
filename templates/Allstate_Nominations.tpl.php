
<?php if (TRUE == $summary ): ?>
   <h4>Summary of <?php echo$team->Team_Name?> nominations</h4>
<?php else: ?>
   <h4>Please enter <?php echo$team->Team_Name?> <?php echo$position->Description?> nominations</h4>
<?php endif; ?>

<table id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
<tr>
	<td>Name</td>
	<td>Position</td>
   <?php if (FALSE == $summary ): ?>
	  <td>Modify</td>
   <?php endif; ?>
</tr>
<?php while ( $nomination = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo$nomination->_PlayersObject->getFullName()?></td>
      <td><?php echo$nomination->_PositionObject->Description?></td>
      <?php if (FALSE == $summary ): ?>
         <td><a href="<?php echo$_SERVER['PHP_SELF']?>?action=Delete&Team_ID=<?php echo$team->Team_ID?>&allstatenom_id=<?php echo$nomination->allstatenom_id?>&Position_ID=<?php echo$position->Position_ID?>"> <img src= /images/site_images/icon_delete.gif> </td>
      <?php endif; ?>
   </tr>
<?php endwhile; ?>
</table>
<?php echo$nominationform?>

<br /><br /> 
<?php if (FALSE == $summary ): ?>
   <?php if ( 8 == $nextposition->Position_ID ) : ?>
      <p>Once you have finished entering <?php echo$position->Description?> Nominations, hit next to see a summary nominations.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?action=Summary&Position_ID=1&Team_ID=<?php echo$team->Team_ID?>'">Next</button>
   <?php else: ?>
      <p>Once you have finished entering <?php echo$position->Description?> Nominations, hit next to enter your <?php echo$nextposition->Description?> nominations.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?Position_ID=<?php echo$nextposition->Position_ID?>&Team_ID=<?php echo$team->Team_ID?>'">Next</button>
   <?php endif; ?>
<?php else: ?>
   <!-- <input TYPE="button" value="Back" onClick="location.href='<?php echo$_SERVER['PHP_SELF']?>?Position_ID=6&Team_ID=<?php echo$team->Team_ID?>'" class="style2" style="width: 63px"> -->
   <button type="button" class="btn btn-default" onClick="window.location='login.php'">Done</button>
<?php endif; ?> 