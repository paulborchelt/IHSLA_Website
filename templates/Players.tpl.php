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
         <?php if(1 == $team->Club): ?>
            <th>School</th>
          <?php endif; ?>
         <th>Edit/Delete</th>
      </tr>
   </thead>
   <tbody>
   <?php while ( $players = $result->fetchNextObject() ): ?>
      <tr>
      	<td><?php echo $players->First_Name?></td>
      	<td><?php echo $players->Last_Name?></td>
          <td><?php echo $players->getGradeName()?></td>
          <td><?php echo $players->getHeight()?></td>
          <td><?php echo $players->getWeight()?></td>
          <?php if(1 == $players->_teamObject->Club): ?>
            <td><?php echo $players->_schoolObject->Team_Name?></td>
          <?php endif; ?>
      	 <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&Player_ID=<?php echo $players->Player_ID?>&Team_ID=<?php echo $players->Team_ID?>"> <img src= ../images/site_images/icon_edit.gif>
              <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&Player_ID=<?php echo $players->Player_ID?>&Team_ID=<?php echo $players->Team_ID?>"> <img src= ../images/site_images/icon_delete.gif>
          </td>
      </tr>
   <?php endwhile; ?>
   </tbody>
</table>