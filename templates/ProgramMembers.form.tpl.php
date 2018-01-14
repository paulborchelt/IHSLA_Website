<style type="text/css" title="currentStyle">
			@import "DataTables-1.9.4/media/css/demo_page.css";
			@import "DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable( {"iDisplayLength": 100 });
         } );
</script>

<h3><?php echo $team->Team_Name?></h3>

<p>Here a list of all student athelets in your program.  Please review the list for accurace and confirm your player's US Lacrosse membership if valid thourgh out the season. 
If you need to make changes please click modify list button.  After reviewing the list please click the submit button of the page to send to the league office.
If any new players join your team after you submit this list you need to add them and submit it again.</p>
<p><button type="button" onClick="window.location='EditPlayerInfo.php?Team_ID=<?php echo $team->Team_ID?>&link=SubmitProgramMembers.php?Team_ID=<?php echo $team->Team_ID?>'"> Modify List </button></p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
   <thead>
      <tr>
      	<th>First Name:</th>
      	<th>Last Name:</th>
         <th>Graduation Year:</th>
         <th>Us Lacrosse Number</th>
         <?php if(1 == $team->Club): ?>
            <th>School</th>
          <?php endif; ?>
      </tr>
   </thead>
   <tbody>
   <?php while ( $players = $result->fetchNextObject() ): ?>
      <tr>
      	<td><?php echo $players->First_Name?></td>
      	<td><?php echo $players->Last_Name?></td>
          <td><?php echo $players->getGradeName()?></td>
      	 <td><?php echo $players->UsLacrosseNumber?></td>
          <?php if(1 == $team->Club): ?>
            <td><?php echo $players->_schoolObject->Team_Name?></td>
          <?php endif; ?>
      </tr>
   <?php endwhile; ?>   
   </tbody>
</table>

</br>

<p>By Clicking the submit button I hearby affirm that all players listed above are elgiable to play in the IHSLA and on this team. </p>
<p><button type="button" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>?action=Submit&Team_ID=<?php echo $team->Team_ID?>'"> SUBMIT </button></p>