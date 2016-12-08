<table>
   <?php while ( $permissions = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo $permissions->_Groups->GroupName ?></td>
      <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=delete_permissions&userid=<?php echo $permissions->_Users->userid ?>&UID=<?php echo $permissions->UID ?>&GID=<?php echo $permissions->GID ?>"> <img src= /images/site_images/icon_delete.gif></a></td>
   </tr>
   <?php endwhile; ?>
</table>
