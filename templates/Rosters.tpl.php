<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
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
         <? if ( true == $showSchool) : ?>
         <th>School:</th>   
         <? endif ?>
      </tr>
   </thead>
   <tbody>
      <? while ( $roster = $result->fetchNextObject() ): ?>
         <tr>
         	<td><?=$roster->number?></td>
         	<td><?=$roster->_PlayersObject->getFullName()?></td>
            <td><?=$roster->_PlayersObject->getGradeName()?></td>
            <td><?=$roster->_PositionObject->Description?></td>
            <td><?=$roster->_LevelsObject->Level_Description?></td>
            <? if ( true == $showSchool) : ?>
               <td><?=$roster->_PlayersObject->getSchool()?></td>
            <? endif ?>
         </tr>
      <? endwhile; ?>
   </tbody>
</table>