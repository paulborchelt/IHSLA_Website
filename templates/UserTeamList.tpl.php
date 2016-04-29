<table cellspacing="1" cellpadding="1" border="0">
   <? while ( $team = $result->fetchNextObject()) : ?>
   <tr>
      <td><?=$team->_teamObject->Team_Name?></td>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?action=delete_team&teamlist_userid=<?=$team->teamlist_userid?>&TID=<?=$team->TID?>&userid=<?=$userid?>"> <img src= /images/site_images/icon_delete.gif></a></td>
   </tr>
	<?endwhile;?>
</table>