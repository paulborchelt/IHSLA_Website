<? if (TRUE == $summary ): ?>
   <h4>Summary of <?=$team->Team_Name?> votes for <?=$Team_Level_Description?> </h4>
<? else: ?>
   <h4>Please enter <?=$team->Team_Name?> votes for <?=$Team_Level_Description?> <?=$position->Description?>.</h4>
<? endif; ?>

<table id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
<tr>
	<td>Name</td>
	<td>Position</td>
   <? if (FALSE == $summary ): ?>
	  <td>Modify</td>
   <? endif; ?>
</tr>
<? while ( $vote = $result->fetchNextObject() ): ?>
   <tr>
      <td><?= $vote->_PlayersObject->getFullName()?></td>
      <td><?= $vote->_PositionObject->Description?></td>
      <? if (FALSE == $summary ): ?>
         <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Team_ID=<?=$team->Team_ID?>&ID=<?=$vote->ID?>&Position_ID=<?=$position->Position_ID?>&Team_Level=<?=$Team_Level?>"> <img src= /images/site_images/icon_delete.gif> </td>
      <? endif; ?>
   </tr>
<? endwhile; ?>
</table>
<?=$voteform?>

<br /><br /> 
<? if (FALSE == $summary ): ?>
   <? if ( 7 == $nextposition->Position_ID ) : ?>
      <p>Once you have finished entering <?=$position->Description?> votes, hit next to see a summary of your votes.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=Summary&Position_ID=1&Team_ID=<?=$team->Team_ID?>&Team_Level=<?=$Team_Level?>'">Next</button>
   <? else: ?>
      <p>Once you have finished entering <?=$position->Description?> votes, hit next to enter your <?=$nextposition->Description?> votes.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=<?=$nextposition->Position_ID?>&Team_ID=<?=$team->Team_ID?>&Team_Level=<?=$Team_Level?>'">Next</button>
   <? endif; ?>
<? else: ?>
   <!-- <input TYPE="button" value="Back" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?Position_ID=6&Team_ID=<?=$team->Team_ID?>'" class="style2" style="width: 63px"> -->
   <? if (1 == $Team_Level) : ?>
      <button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=1&Team_Level=2&Team_ID=<?=$team->Team_ID?>'">Second Team All State</button>
   <? else : ?>
      <button type="button" class="btn btn-default" onClick="window.location='login.php'">Done</button>
   <? endif; ?>
   
<? endif; ?> 