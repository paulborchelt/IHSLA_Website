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
<? while ( $contactinfo = $result->fetchNextObject() ): ?>
   <tr>
      <td><?=$contactinfo->_ContactInfoTeamsListObject->_TeamObject->Team_Name?></td>
   	<td><?=$contactinfo->_ContactTypeObject->Type?></td>
   	<td><?=$contactinfo->FirstName?></td>
   	<td><?=$contactinfo->LastName?></td>
   	<td><?=$contactinfo->Email?></td>
   </tr>
<? endwhile; ?>
</tbody>
</table>