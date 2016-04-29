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
<? while ( $saves = $result->fetchNextObject() ): ?>
         <tr>
            <td><?=$saves->_TeamsObject->Team_Name?></td>
         	<td><?=$saves->_RostersObject->number?></td>
         	<td><?=$saves->_PlayersObject->getFullName()?></td>
            <td><?=$saves->Quarter?></td>
            <td><?=$saves->Saves?></td>
            <td><?=$saves->Goals_Against?></td>
            <td><?=$saves->getAverage()?></td>
            <td><a href="<?=$_SERVER['PHP_SELF']?>?action=SavesEdit&Game_ID=<?=$saves->Game_ID?>&Team_ID=<?=$saves->Team_ID?>&Player_ID=<?=$saves->Player_ID?>&Quarter=<?=$saves->Quarter?>&Saves=<?=$saves->Saves?>&Goals_Against=<?=$saves->Goals_Against?>"> <img src= ../images/site_images/icon_edit.gif>
            <a href="<?=$_SERVER['PHP_SELF']?>?action=SavesDelete&Game_ID=<?=$saves->Game_ID?>&Player_ID=<?=$saves->Player_ID?>&Quarter=<?=$saves->Quarter?>"> <img src= ../images/site_images/icon_delete.gif></td>
         </tr>
<? endwhile; ?>
      </tbody>
</table>

<br />

<?=$savesenterformhome?>

<?=$savesenterformaway?>

<button type="button" class="btn btn-default" onClick="window.location='<?=$_SERVER['PHP_SELF']?>?action=GameSummary&Game_ID=<?=$Game_ID?>'">Game Summary</button></td>