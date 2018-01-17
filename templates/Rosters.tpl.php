<style type="text/css" title="currentStyle">
			@import "DataTables-1.9.4/media/css/demo_page.css";
			@import "DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({ "iDisplayLength": 50
              });
         } );
</script>


<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
   <thead>
      <tr>
      	<th>Number:</th>
      	<th>Name:</th>
         <th>Grade:</th>
         <th>Position:</th>
         <th>Level:</th>
         <?php if ( true == $showSchool) : ?>
         <th>School:</th>   
         <?php endif ?>
      </tr>
   </thead>
   <tbody>
      <?php while ( $roster = $result->fetchNextObject() ): ?>
         <tr>
         	<td><?php echo $roster->number?></td>
         	<td><?php echo $roster->_PlayersObject->getFullName()?></td>
            <td><?php echo $roster->_PlayersObject->getGradeName()?></td>
            <td><?php echo $roster->_PositionObject->Description?></td>
            <td><?php echo $roster->_LevelsObject->Level_Description?></td>
            <?php if ( true == $showSchool) : ?>
               <td><?php echo $roster->_PlayersObject->getSchool()?></td>
            <?php endif ?>
         </tr>
      <?php endwhile; ?>
   </tbody>
</table>