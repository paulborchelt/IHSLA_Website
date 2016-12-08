<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Date:</td>
    <td>Name</td>
	<td>Info:</td>
    <td>Delete:</td>

</tr>
<?php while ( $contactrecord = $result->fetchNextObject() ): ?>
<tr>
	<td><?php echo $contactrecord->Date?></td>
    <td><?php echo $contactrecord->_ContactInfoObject->FirstName?>  <?php echo $contactrecord->_ContactInfoObject->LastName?></td>
	<td><?php echo $contactrecord->info?></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF']?>?action=DeleteContactRecord&idcontactrecord=<?php echo $contactrecord->idcontactrecord?>&idcontactinfo=<?php echo $contactrecord->idcontactinfo?>"> <img src= /HighSchool/images/icon_delete.gif></a></td>
</tr>
</tr>
<?php endwhile; ?>
</table>

<input TYPE="button" value="Back" onClick="location.href='ViewNewContacts.php'" class="style2" style="width: 63px">