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
<?php while ( $registration = $result->fetchNextObject() ): ?>
<tr>
	<td><?php echo $registration->firstname?></td>
	<td><?php echo $registration->lastname?></td>
	<td><?php echo $registration->address?></td>
	<td><?php echo $registration->city?></td>
	<td><?php echo $registration->state?></td>
	<td><?php echo $registration->zip?></td>
	<td><?php echo $registration->email?></td>
	<td><?php echo $registration->schoolattending?></td>
	<td><?php echo $registration->gradeinschool?> </td>
	<td><?php echo $registration->certifiedYesOrNo()?> </td>
	<td><?php echo $registration->uslacrossenumber?> </td>
    <td><?php echo $registration->carmeldadsclubYesOrNo()?> </td>
</tr>
<?php endwhile; ?>
</table>