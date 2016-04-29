<? while ( $news = $result->fetchNextObject() ): ?>
 <p><a href="ViewNews.php?id=<?=$news->id?>"><?=$news->headline?></a></p>
<? endwhile; ?>
<p><a class="btn" href="#">News Archive &raquo;</a></p>