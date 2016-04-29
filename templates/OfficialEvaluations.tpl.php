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


<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
   <thead>
      <tr>
      	<th>Name</th>
      	<th>Rating</th>
         <th>View</th>
      </tr>
   </thead>
   <tbody>
      <? while ( $eval = $result->fetchNextObject() ): ?>
         <tr>
         	<td><?=$eval->_contactInfoObject->getFullName()?></td>
         	<td><?=$eval->rating?></td>
            <td><button type="button" onClick="window.location='OfficialsEvaluation.php?action=DisplayEvaluation&view=true&Team_ID=<?=$eval->Team_ID?>&Game_ID=<?=$eval->_schedule->Game_ID?>&official=<?=$eval->idcontactinfo?>'" name="ViewEval">View</button></td>
         </tr>
      <? endwhile; ?>
   </tbody>
</table>