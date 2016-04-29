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

<?=$navbarstats?>

<?=$selectYear?>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
         <th>Team</th>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Savs:</th>
         <th>GA:</th>
         <th>SP:</th>
      </tr>
   </thead>
      <tbody>
<? while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?=$saves->_TeamsObject->Team_Name?></td>
         	<td><?=$saves->_RostersObject->number?></td>
         	<td><?=$saves->_PlayersObject->getFullName()?></td>
            <td><?=$saves->Saves?></td>
            <td><?=$saves->Goals_Against?></td>
            <td><?=$saves->getAverage()?></td>
         </tr>
<? endwhile; ?>
      </tbody>
</table>
