<table cellspacing="1" cellpadding="1" border="0">
   <?php while ( $team = $result->fetchNextObject()) : ?>
   <tr>
      <td><?php echo $team->_teamObject->Team_Name?></td>
      <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=delete_team&teamlist_userid=<?php echo $team->teamlist_userid?>&TID=<?php echo $team->TID?>&userid=<?php echo $userid?>"> <img src= /images/site_images/icon_delete.gif></a></td>
   </tr>
	<?endwhile;?>
</table>