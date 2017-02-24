<?php while ( $news = $results->fetchNextObject() ): ?>
 <p><a href="ViewNews.php?id=<?php echo $news->id?>"><?php echo $news->headline?></a></p>
<?php endwhile; ?>
<p><a class="btn" href="#">News Archive &raquo;</a></p>