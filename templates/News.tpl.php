<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Title:</td>
</tr>
<?php while ( $news = $result->fetchNextObject() ): ?>
<tr>
	<td><?php echo $news->headline?></td>
</tr>
<?php endwhile; ?>
</table>