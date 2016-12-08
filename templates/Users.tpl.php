<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable();
         } );
</script>

<?php echo $newuserform?>

<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
<thead>
   <tr>
   	<th>Last Name: </th>
      <th>First Name: </th>
      <th>User Name: </th>
      <th>Email:</th>
      <th>Edit:</th>
   </tr>
</thead>
<tbody>
   <?php while ( $user = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo $user->_contactInfoObject->LastName?></td>
   	<td><?php echo $user->_contactInfoObject->FirstName?></td>
      <td><?php echo $user->username?></td>
      <td><?php echo $user->_contactInfoObject->Email?></td>
   	<td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=edit_user&userid=<?php echo $user->userid?>"> <img src= /images/site_images/icon_edit.gif>
         <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Permissions&userid=<?php echo $user->userid?>"> <img src= /images/site_images/permissions.gif>
         <a href="<?php echo $_SERVER['PHP_SELF']?>?action=delete_user&userid=<?php echo $user->userid?>&Id=<?php echo $user->contactinfo_id?>"> <img src= /images/site_images/icon_delete.gif>
       </td>
   </tr>
   <?php endwhile; ?>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <?php while ( $user = $result->fetchNextObject() ): ?> 
         <td></td>
      <?php endwhile; ?>
      <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=new_user"> [Add New User]</a></td>
   </tr>

</tbody>

</table>