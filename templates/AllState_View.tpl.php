

<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <button type="button" class="<?=$Position->Position_ID == 1 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=1&year=2015'">Attack</button>
     <button type="button" class="<?=$Position->Position_ID == 2 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=2&year=2015'">Midfield</button>
     <button type="button" class="<?=$Position->Position_ID == 3 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=3&year=2015'">Defense</button>
     <button type="button" class="<?=$Position->Position_ID == 4 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=4&year=2015'">Goalie</button>
     <button type="button" class="<?=$Position->Position_ID == 5 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=5&year=2015'">LSM</button>
     <button type="button" class="<?=$Position->Position_ID == 6 ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?Position_ID=6&year=2015'">FaceOff</button>
   </div>
</div> 
<div>
<h4>All-State <?=$Position->Description?> </h4>
<?$previousPoints = 0; $count = -1; $Team_Level = 1 ?>
<table id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
<tr>
   <td>Team</td>
   <td>Name</td>
	<td>School</td>
</tr>
<? while ( $vote = $result->fetchNextObject() ): ?>
   <?$Points = $vote->Points; ?>
   <?if ( 2 < $Points ): ?>
      <?$positionCount = AllState_Votes_Row::getPositionLimit($Position->Position_ID) ?>
      <?if ( $count >= $positionCount  && $previousPoints != $Points && $Team_Level != 3): ?>
        <? $count = 0; $Team_Level++; $previousPoints = 0; ?>
      <?else:?>
         <? $count++; $previousPoints = $Points;  ?>	
      <?endif;?>
      <?if( $count == 0 ):?>
         <?if( $Team_Level == 1 ): ?>
            <tr>
               <td>First Team</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
         <?elseif ( $Team_Level == 2): ?>
            <tr>
               <td>Second Team</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
         <? else: ?>
           <tr>
               <td>Honorable Mention</td>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
         <? endif; ?>
      <?endif;?>
      <tr>
         <td>&nbsp;</td>
         <td><?= $vote->_PlayersObject->getFullName()?></td>
         <td><?= $vote->_PlayersObject->_teamObject->Team_Name?></td>
      </tr>
   <?endif;?>
<? endwhile; ?>
</table>
</div>