<div class="row-fluid">
    <div class="span4">
    <h3>Varsity Games Today:</h3>
    <p>
        <?php $games = 0 ?>
        <?php while ( $schedule = $resultschedule->fetchNextObject() ): ?>
            <?php $games++ ?>
           	<?php echo$schedule->_HomeTeamObject->Team_Name?> vs <?php echo$schedule->_AwayTeamObject->Team_Name?> <?php echo$schedule->_TimeObject->getTime()?>
            </br>
        <?php endwhile; ?>
        <?php if ( 0 == $games ): ?>
        No Games Today
        </br>
        <?php endif; ?>
        <a class="btn" href="schedule.php">Full Schedule >></a>
    </p>
    </div>
    <?php for ( $x = 0; $x < 2; $x++ ): ?>
     <?php $news = $resultnews->fetchNextObject() ?>
        <div class="span4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> 
               </br>
               <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a>
            </p>
        </div><!--/span-->
     <?php endfor; ?> 
    </div><!--/span-->
    <div class="row-fluid">
        <?php for ( $y = 0; $y < 3; $y++ ): ?>
        <?php $news = $resultnews->fetchNextObject() ?>
        <div class="span4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> 
               </br>
               <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a>
            </p>
        </div><!--/span-->
     <?php endfor; ?> 
</div> 