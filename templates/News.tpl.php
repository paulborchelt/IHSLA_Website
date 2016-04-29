<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Title:</td>
</tr>
<? while ( $news = $result->fetchNextObject() ): ?>
<tr>
	<td><?=$news->headline?></td>
</tr>
<? endwhile; ?>
</table>