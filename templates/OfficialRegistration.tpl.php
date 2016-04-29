<table cellspacing="1" cellpadding="1" border="1">
<tr>
	<td>First Name:</td>
	<td>Last Name:</td>
	<td>Address:</td>
	<td>City:</td>
	<td>State:</td>
	<td>Zip:</td>
	<td>Age:</td>
	<td>School Attending</td>
	<td>Grade in School</td>
	<td>Currently Certified:</td>
	<td>Us Lacrosse Number:</td>
    <td>Carmel Dads Club:</td>

</tr>
<? while ( $registration = $result->fetchNextObject() ): ?>
<tr>
	<td><?=$registration->firstname?></td>
	<td><?=$registration->lastname?></td>
	<td><?=$registration->address?></td>
	<td><?=$registration->city?></td>
	<td><?=$registration->state?></td>
	<td><?=$registration->zip?></td>
	<td><?=$registration->email?></td>
	<td><?=$registration->schoolattending?></td>
	<td><?=$registration->gradeinschool?> </td>
	<td><?=$registration->certifiedYesOrNo()?> </td>
	<td><?=$registration->uslacrossenumber?> </td>
    <td><?=$registration->carmeldadsclubYesOrNo()?> </td>
</tr>
<? endwhile; ?>
</table>