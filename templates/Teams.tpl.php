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

<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
   <thead>
      <tr>
      	<td>Team Name:</td>
      	<td>City:</td>
          <td>State:</td>
          <?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
            <td>Edit/Delete</td>
          <?php endif; ?>
      </tr>
   </thead>
   <tbody>
       <?php while ( $teams = $result->fetchNextObject() ): ?>
       <tr>
      	<td><?php echo $teams->Team_Name?></td>
      	<td><?php echo $teams->City?></td>
          <td><?php echo $teams->State?></td>
          <?php if ($user->hasPermisions(Groups_Row::Administrators)): ?>
         	 <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=Edit&league=<?php echo $teams->League?>&Team_ID=<?php echo $teams->Team_ID?>"> <img src= images/site_images/icon_edit.gif>
                 <a href="<?php echo $_SERVER['PHP_SELF']?>?action=Delete&league=<?php echo $teams->League?>&Team_ID=<?php echo $teams->Team_ID?>"> <img src= images/site_images/icon_delete.gif>
             </td>
          <?php endif; ?>
      </tr>
      <?php endwhile; ?>
   </tbody>
</table>