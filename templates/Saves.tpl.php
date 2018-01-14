<style type="text/css" title="currentStyle">
			@import "DataTables-1.9.4/media/css/demo_page.css";
			@import "DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable();
         } );
</script>

<?php echo $navbarstats?>

<?php echo $selectYear?>

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
<?php while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?php echo $saves->_TeamsObject->Team_Name?></td>
         	<td><?php echo $saves->_RostersObject->number?></td>
         	<td><?php echo $saves->_PlayersObject->getFullName()?></td>
            <td><?php echo $saves->Saves?></td>
            <td><?php echo $saves->Goals_Against?></td>
            <td><?php echo $saves->getAverage()?></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>
