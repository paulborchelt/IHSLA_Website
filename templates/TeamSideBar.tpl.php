<div class="span3">
   <div class="well sidebar-nav">
      <ul class="nav nav-list">
         <li class="nav-header">Varsity</li>
 		   <?php while ( $varsity = $result->fetchNextObject() ): ?>
            <li class="<?php echo$varsity->Team_ID == $navigation->Team_ID ? "active" : "" ?>"><a href="teams.php?Team_ID=<?php echo$varsity->Team_ID?>&subpage=<?php echo$navigation->subpage?>"><?php echo$varsity->Team_Name?></a></li>
         <?php endwhile; ?>
         <li class="nav-header">Club</li>
         <?php while ( $club = $clubResults->fetchNextObject() ): ?>
            <li class="<?php echo$club->Team_ID == $navigation->Team_ID ? "active" : "" ?>"><a href="teams.php?Team_ID=<?php echo$club->Team_ID?>&subpage=<?php echo$navigation->subpage?>"><?php echo$club->Team_Name?></a></li>
         <?php endwhile; ?>
      </ul>
   </div><!--/.well -->
</div><!--/span-->