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

<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
         <th>Team</th>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Quarter:</th>
         <th>Saves:</th>
         <th>GA:</th>
         <th>SP:</th>
         <th>Edit/Delete</th>
      </tr>
   </thead>
      <tbody>
<?php while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?php echo $saves->_TeamsObject->Team_Name?></td>
         	<td><?php echo $saves->_RostersObject->number?></td>
         	<td><?php echo $saves->_PlayersObject->getFullName()?></td>
            <td><?php echo $saves->Quarter?></td>
            <td><?php echo $saves->Saves?></td>
            <td><?php echo $saves->Goals_Against?></td>
            <td><?php echo $saves->getAverage()?></td>
            <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=SavesEdit&Game_ID=<?php echo $saves->Game_ID?>&Team_ID=<?php echo $saves->Team_ID?>&Player_ID=<?php echo $saves->Player_ID?>&Quarter=<?php echo $saves->Quarter?>&Saves=<?php echo $saves->Saves?>&Goals_Against=<?php echo $saves->Goals_Against?>"> <img src= images/site_images/icon_edit.gif>
            <a href="<?php echo $_SERVER['PHP_SELF']?>?action=SavesDelete&Game_ID=<?php echo $saves->Game_ID?>&Player_ID=<?php echo $saves->Player_ID?>&Quarter=<?php echo $saves->Quarter?>"> <img src= images/site_images/icon_delete.gif></td>
         </tr>
<?php endwhile; ?>
      </tbody>
</table>

<br />

<?php echo $savesenterformhome?>

<?php echo $savesenterformaway?>

<button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?action=GameSummary&Game_ID=<?php echo $Game_ID?>'">Game Summary</button></td>