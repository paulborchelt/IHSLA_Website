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
     <button type="button" class="<?=$filter->daterange == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?daterange=All&level=<?=$filter->level?>&type=<?=$filter->type?>'">All</button>
     <button type="button" class="<?=$filter->daterange == Today ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?daterange=Today&level=<?=$filter->level?>&type=<?=$filter->type?>'">Today</button>
     <button type="button" class="<?=$filter->daterange == Week ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?daterange=Week&level=<?=$filter->level?>&type=<?=$filter->type?>'">This Week</button>
     <button type="button" class="<?=$filter->daterange == LastWeek ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?daterange=LastWeek&level=<?=$filter->level?>&type=<?=$filter->type?>'">Last Week</button>
   </div>
   <div class="btn-group btn-group-xs">
     <h4>Filter on Level</h4>
     <button type="button" class="<?=$filter->level == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?level=All&daterange=<?=$filter->daterange?>&type=<?=$filter->type?>'">All</button>
     <button type="button" class="<?=$filter->level == Varsity ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?level=Varsity&daterange=<?=$filter->daterange?>&type=<?=$filter->type?>'">Varsity</button>
     <button type="button" class="<?=$filter->level == JV ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?level=JV&daterange=<?=$filter->daterange?>&type=<?=$filter->type?>'">JV</button>
     <button type="button" class="<?=$filter->level == Freshmen ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?level=Freshmen&daterange=<?=$filter->daterange?>&type=<?=$filter->type?>'">Freshmen</button>
   </div>
   <div class="btn-group btn-group-xs">
     <h4>Filter on Type</h4>
     <button type="button" class="<?=$filter->type == All ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?type=All&daterange=<?=$filter->daterange?>&level=<?=$filter->level?>'">All</button>
     <button type="button" class="<?=$filter->type == Regular ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?type=Regular&daterange=<?=$filter->daterange?>&level=<?=$filter->level?>'">Regular</button>
     <button type="button" class="<?=$filter->type == Tournament ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?type=Tournament&daterange=<?=$filter->daterange?>&level=<?=$filter->level?>'">Tournament</button>
     <button type="button" class="<?=$filter->type == Scrimmage ? "btn btn-primary" : "btn btn-default" ?>" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?type=Scrimmage&daterange=<?=$filter->daterange?>&level=<?=$filter->level?>'">Scrimmage</button>
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
<? while ( $schedule = $result->fetchNextObject() ): ?>
   <tr>
      <td><?=$schedule->_DateObject->getScheduleSortFormat()?></td>
   	<td><?=$schedule->_DateObject->getScheduleFormat()?></td>
   	<td><?=$schedule->_HomeTeamObject->Team_Name?></td>
   	<td><?=$schedule->_AwayTeamObject->Team_Name?></td>
   	<td><?=$schedule->_SiteObject->field_name?></td>
   	<td><?=$schedule->_TimeObject->getTime()?></td>
   	<td><?=$schedule->Game_Level?></td>
   	<td><?=$schedule->Game_Type?></td>
      <td><?=$schedule->getResults(TRUE)?></td>
   </tr>
<? endwhile; ?>
</tbody>
</table>