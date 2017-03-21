<?php while ( $schedule = $result->fetchNextObject() ): ?>
   	<a><?php echo$schedule->_HomeTeamObject->Team_Name?></a>
   	<a><?php echo$schedule->_AwayTeamObject->Team_Name?></a>
   	<a><?php echo$schedule->_SiteObject->field_name?></a>
   	<a><?php echo$schedule->_TimeObject->getTime()?></a>
   	<a><?php echo$schedule->Game_Level?></a>
      <a><?php echo$schedule->getResults(TRUE)?></a>
      </br>
<?php endwhile; ?>