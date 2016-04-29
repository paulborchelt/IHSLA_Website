
<? if (TRUE == $summary ): ?>
   <h4>Summary of <?=$team->Team_Name?> nominations</h4>
<? else: ?>
   <h4>Please enter <?=$team->Team_Name?> <?=$position->Description?> nominations</h4>
<? endif; ?>

<table id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
<tr>
	<td>Name</td>
	<td>Position</td>
   <? if (FALSE == $summary ): ?>
	  <td>Modify</td>
   <? endif; ?>
</tr>
<? while ( $nomination = $result->fetchNextObject() ): ?>
   <tr>
      <td><?= $nomination->_PlayersObject->getFullName()?></td>
      <td><?= $nomination->_PositionObject->Description?></td>
      <? if (FALSE == $summary ): ?>
         <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Team_ID=<?=$team->Team_ID?>&allstatenom_id=<?=$nomination->allstatenom_id?>&Position_ID=<?=$position->Position_ID?>"> <img src= /images/site_images/icon_delete.gif> </td>
      <? endif; ?>
   </tr>
<? endwhile; ?>
</table>
<?=$nominationform?>

<br /><br /> 
<? if (FALSE == $summary ): ?>
   <? if ( 7 == $nextposition->Position_ID ) : ?>
      <p>Once you have finished entering <?=$position->Description?> Nominations, hit next to see a summary nominations.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=Summary&Position_ID=1&Team_ID=<?=$team->Team_ID?>'">Next</button>
   <? else: ?>
      <p>Once you have finished entering <?=$position->Description?> Nominations, hit next to enter your <?=$nextposition->Description?> nominations.</p>
      <button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=<?=$nextposition->Position_ID?>&Team_ID=<?=$team->Team_ID?>'">Next</button>
   <? endif; ?>
<? else: ?>
   <!-- <input TYPE="button" value="Back" onClick="location.href='<?=$_SERVER['PHP_SELF']?>?Position_ID=6&Team_ID=<?=$team->Team_ID?>'" class="style2" style="width: 63px"> -->
   <button type="button" class="btn btn-default" onClick="window.location='login.php'">Done</button>
<? endif; ?> 