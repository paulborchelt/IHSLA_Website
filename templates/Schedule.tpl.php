<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({ "iDisplayLength": 25, "bProcessing": true, "aoColumns": [
                                                   {"bVisible": false},
                                                   {"iDataSort": 0},
                                                   null,
                                                   null,
                                                   null,
                                                   null,
                                                   null,
                                                   null,
                                                   null ]});
         } );
</script>
<div class="btn-toolbar" role="toolbar">
   <div class="btn-group btn-group-xs">
     <h4>Filter on Date</h4>
     <button type="button" class="<?php echo$filter->daterange == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?daterange=All&level=<?php echo$filter->level?>&type=<?php echo$filter->type?>'">All</button>
     <button type="button" class="<?php echo$filter->daterange == Today ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?daterange=Today&level=<?php echo$filter->level?>&type=<?php echo$filter->type?>'">Today</button>
     <button type="button" class="<?php echo$filter->daterange == Week ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?daterange=Week&level=<?php echo$filter->level?>&type=<?php echo$filter->type?>'">This Week</button>
     <button type="button" class="<?php echo$filter->daterange == LastWeek ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?daterange=LastWeek&level=<?php echo$filter->level?>&type=<?php echo$filter->type?>'">Last Week</button>
   </div>
   <div class="btn-group btn-group-xs">
     <h4>Filter on Level</h4>
     <button type="button" class="<?php echo$filter->level == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?level=All&daterange=<?php echo$filter->daterange?>&type=<?php echo$filter->type?>'">All</button>
     <button type="button" class="<?php echo$filter->level == Varsity ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?level=Varsity&daterange=<?php echo$filter->daterange?>&type=<?php echo$filter->type?>'">Varsity</button>
     <button type="button" class="<?php echo$filter->level == JV ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?level=JV&daterange=<?php echo$filter->daterange?>&type=<?php echo$filter->type?>'">JV</button>
     <button type="button" class="<?php echo$filter->level == Freshmen ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?level=Freshmen&daterange=<?php echo$filter->daterange?>&type=<?php echo$filter->type?>'">Freshmen</button>
   </div>
   <div class="btn-group btn-group-xs">
     <h4>Filter on Type</h4>
     <button type="button" class="<?php echo$filter->type == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?type=All&daterange=<?php echo$filter->daterange?>&level=<?php echo$filter->level?>'">All</button>
     <button type="button" class="<?php echo$filter->type == Regular ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?type=Regular&daterange=<?php echo$filter->daterange?>&level=<?php echo$filter->level?>'">Regular</button>
     <button type="button" class="<?php echo$filter->type == Tournament ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?type=Tournament&daterange=<?php echo$filter->daterange?>&level=<?php echo$filter->level?>'">Tournament</button>
     <button type="button" class="<?php echo$filter->type == Scrimmage ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?php echo$_SERVER['PHP_SELF']?>?type=Scrimmage&daterange=<?php echo$filter->daterange?>&level=<?php echo$filter->level?>'">Scrimmage</button>
   </div>
</div>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
<thead>
   <tr>
      <td>SortDate</td>
   	<td>Date:</td>
   	<td>Home Team:</td>
   	<td>Away Team:</td>
   	<td>Site:</td>
   	<td>Time:</td>
   	<td>Level:</td>
   	<td>Type:</td>
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
   	<td><?php echo$schedule->_TimeObject->getTime()?></td>
   	<td><?php echo$schedule->Game_Level?></td>
   	<td><?php echo$schedule->Game_Type?></td>
      <td><?php echo$schedule->getResults(TRUE)?></td>
   </tr>
<?php endwhile; ?>
</tbody>
</table>