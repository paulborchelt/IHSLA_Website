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

<?=$newuserform?>

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
   <? while ( $user = $result->fetchNextObject() ): ?>
   <tr>
      <td><?=$user->_contactInfoObject->LastName?></td>
   	<td><?=$user->_contactInfoObject->FirstName?></td>
      <td><?=$user->username?></td>
      <td><?=$user->_contactInfoObject->Email?></td>
   	<td><a href="<?=$_SERVER['PHP_SELF']?>?action=edit_user&userid=<?=$user->userid?>"> <img src= /images/site_images/icon_edit.gif>
         <a href="<?=$_SERVER['PHP_SELF']?>?action=Permissions&userid=<?=$user->userid?>"> <img src= /images/site_images/permissions.gif>
         <a href="<?=$_SERVER['PHP_SELF']?>?action=delete_user&userid=<?=$user->userid?>&Id=<?=$user->contactinfo_id?>"> <img src= /images/site_images/icon_delete.gif>
       </td>
   </tr>
   <? endwhile; ?>
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <? while ( $user = $result->fetchNextObject() ): ?> 
         <td></td>
      <? endwhile; ?>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?action=new_user"> [Add New User]</a></td>
   </tr>

</tbody>

</table>