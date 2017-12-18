<div class="container">
     <?php for ( $x = 0; $x < 3; $x++ ): ?>
     <?php $news = $result->fetchNextObject() ?>
        <div class="col-md-4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a></p>
        </div><!--/col-->
     <?php endfor; ?> 
</div><!--/container-->
<div class="container">
        <?php for ( $y = 0; $y < 3; $y++ ): ?>
        <?php $news = $result->fetchNextObject() ?>
        <div class="col-md-4">
    	   <h3><?php echo $news->headline?></h3>
            <p><?php echo $news->teaser() ?> <a class="btn" href="ViewNews.php?id=<?php echo $news->id?>">View details >></a></p>
        </div><!--/span-->
     <?php endfor; ?> 
</div><!--/container-->