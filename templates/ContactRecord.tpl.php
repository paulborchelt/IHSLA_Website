<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>Date:</td>
    <td>Name</td>
	<td>Info:</td>
    <td>Delete:</td>

</tr>
<? while ( $contactrecord = $result->fetchNextObject() ): ?>
<tr>
	<td><?=$contactrecord->Date?></td>
    <td><?=$contactrecord->_ContactInfoObject->FirstName?>  <?=$contactrecord->_ContactInfoObject->LastName?></td>
	<td><?=$contactrecord->info?></td>
    <td><a href="<?=$_SERVER['PHP_SELF']?>?action=DeleteContactRecord&idcontactrecord=<?=$contactrecord->idcontactrecord?>&idcontactinfo=<?=$contactrecord->idcontactinfo?>"> <img src= /HighSchool/images/icon_delete.gif></a></td>
</tr>
</tr>
<? endwhile; ?>
</table>

<input TYPE="button" value="Back" onClick="location.href='ViewNewContacts.php'" class="style2" style="width: 63px">