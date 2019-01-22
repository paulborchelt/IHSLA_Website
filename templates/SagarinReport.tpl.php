<style type="text/css" title="currentStyle">
			@import "DataTables-1.9.4/media/css/demo_page.css";
			@import "DataTables-1.9.4/media/css/demo_table.css";
</style>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({ "iDisplayLength": 25, "bProcessing": true, "aoColumns": [
                                                   {"bVisible": false},
                                                   {"iDataSort": 0},
                                                   null,
                                                   null,
                                                   null,
                                                   null ]});
         } );
</script>

<?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
 <button type="button" class="btn btn-primary" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?action=File'">Download Report</button>
 
 <p></p>
 
 <?php endif; ?>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
   <tr>
      <td>SortDate</td>
   	<td>Date:</td>
   	<td>Home Team:</td>
   	<td>Away Team:</td>
   	<td>Site:</td>
    <td>Result</td>
   </tr>
</thead>
<tbody>
<?php while ( $schedule = $result->fetchNextObject() ): ?>
   <tr>
      <td><?php echo$schedule->_DateObject->getScheduleSortFormat()?></td>
   	<td><?php echo$schedule->_DateObject->getScheduleFormat()?></td>
   	<td><?php echo$schedule->_HomeTeamObject->Team_Name?></td>
   	<td><?php echo$schedule->_AwayTeamObject->Team_Name?></td>
   	<td><?php echo$schedule->_SiteObject->field_name?></td>
    <td><?php echo$schedule->getResults(TRUE)?></td>
   </tr>
<?php endwhile; ?>
</tbody>
</table>