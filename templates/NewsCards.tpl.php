<div class="row-fluid">
     <?php for ( $x = 0; $x < 3; $x++ ): ?>
     <?php $news = $result->fetchNextObject() ?>
        <div class="span4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a></p>
        </div><!--/span-->
     <?php endfor; ?> 
    </div><!--/span-->
    <div class="row-fluid">
        <?php for ( $y = 0; $y < 3; $y++ ): ?>
        <?php $news = $result->fetchNextObject() ?>
        <div class="span4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a></p>
        </div><!--/span-->
     <?php endfor; ?> 
</div><!--/span-->