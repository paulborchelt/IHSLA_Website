<div class="span3">
   <div class="well sidebar-nav">
      <ul class="nav nav-list">
         <li class="nav-header">Varsity</li>
 		   <? while ( $varsity = $result->fetchNextObject() ): ?>
            <li class="<?=$varsity->Team_ID == $navigation->Team_ID ? "active" : "" ?>"><a href="teams.php?Team_ID=<?=$varsity->Team_ID?>&subpage=<?=$navigation->subpage?>"><?=$varsity->Team_Name?></a></li>
         <? endwhile; ?>
         <li class="nav-header">Club</li>
         <? while ( $club = $clubResults->fetchNextObject() ): ?>
            <li class="<?=$club->Team_ID == $navigation->Team_ID ? "active" : "" ?>"><a href="teams.php?Team_ID=<?=$club->Team_ID?>&subpage=<?=$navigation->subpage?>"><?=$club->Team_Name?></a></li>
         <? endwhile; ?>
      </ul>
   </div><!--/.well -->
</div><!--/span-->