<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable( {"iDisplayLength": 100 });
         } );
</script>


<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
      	<th>First Name:</th>
      	<th>Last Name:</th>
         <th>Graduation Year:</th>
         <th>Height</th>
         <th>Weight</th>
         <? if(1 == $team->Club): ?>
            <th>School</th>
          <? endif; ?>
         <th>Edit/Delete</th>
      </tr>
   </thead>
   <tbody>
   <? while ( $players = $result->fetchNextObject() ): ?>
      <tr>
      	<td><?=$players->First_Name?></td>
      	<td><?=$players->Last_Name?></td>
          <td><?=$players->getGradeName()?></td>
          <td><?=$players->getHeight()?></td>
          <td><?=$players->getWeight()?></td>
          <? if(1 == $players->_teamObject->Club): ?>
            <td><?=$players->_schoolObject->Team_Name?></td>
          <? endif; ?>
      	 <td><a href="<?=$_SERVER['PHP_SELF']?>?action=Edit&Player_ID=<?=$players->Player_ID?>&Team_ID=<?=$players->Team_ID?>"> <img src= ../images/site_images/icon_edit.gif>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=Delete&Player_ID=<?=$players->Player_ID?>&Team_ID=<?=$players->Team_ID?>"> <img src= ../images/site_images/icon_delete.gif>
          </td>
      </tr>
   <? endwhile; ?>
   </tbody>
</table>