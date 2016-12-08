<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({ "iDisplayLength": 50
              });
         } );
      </script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
   <tr>
      <td>Team Name</td>
   	<td>Title</td>
   	<td>First Name</td>
   	<td>Last Name</td>
   	<td>email</td>
   </tr>
</thead>
<tbody>
<?php while ( $contactinfo = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo $contactinfo->_ContactInfoTeamsListObject->_TeamObject->Team_Name?></td>
   	<td><?php echo $contactinfo->_ContactTypeObject->Type?></td>
   	<td><?php echo $contactinfo->FirstName?></td>
   	<td><?php echo $contactinfo->LastName?></td>
   	<td><?php echo $contactinfo->Email?></td>
   </tr>
<?php endwhile; ?>
</tbody>
</table>