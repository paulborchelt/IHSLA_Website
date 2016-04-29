<table>
   <? while ( $permissions = $result->fetchNextObject() ): ?>
   <tr>
      <td><?= $permissions->_Groups->GroupName ?></td>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?action=delete_permissions&userid=<?=$permissions->_Users->userid ?>&UID=<?=$permissions->UID ?>&GID=<?=$permissions->GID ?>"> <img src= /images/site_images/icon_delete.gif></a></td>
   </tr>
   <? endwhile; ?>
</table>
