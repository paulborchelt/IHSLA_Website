<style type="text/css" title="currentStyle">
			@import "../DataTables-1.9.4/media/css/demo_page.css";
			@import "../DataTables-1.9.4/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../DataTables-1.9.4/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
            $('#example').dataTable({
                "aaSorting": [[0,'desc']]
                });
         } );
</script>

<table cellspacing="1" cellpadding="1" border="1" class="display" id="example">
<thead>
   <tr>
    <th>Date: </th>
   	<th>Headline: </th>
   </tr>
</thead>
<tbody>
   <?php while ( $news = $results->fetchNextObject() ): ?>
   <tr>
        <td><?php echo $news->_DateObject->getMonthDayYearFormat() ?></td>
        <td><a href="ViewNews.php?id=<?php echo $news->id?>"><?php echo $news->headline?></td>     
   </tr>
   <?php endwhile; ?>
</tbody>

</table>