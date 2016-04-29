<form action="<?$_SERVER['PHP_SELF']?>" method="post">
   <p>Edit permissions here:</p>
   <table cellspacing="1" cellpadding="1" border="0">
      <tr>
         <td>Name </td>
         <td>Permissions: </td>
      </tr>
      <tr>
         <td><input type="text" disabled="disabled" value="<?= $user->_contactInfoObject->GetFullName()?>"></td>
         <td><select name="GID"><?= $groupoptions ?></select></td>
         <td><input type="hidden" name="action" value="add_permissions" ></td>
         <td><input type="hidden" name="UID" value=<?=$user->userid?> ></td>
         <td><input type="hidden" name="userid" value=<?=$user->userid?> ></td>
         <td><input type="submit" value="ADD" > </td>
      </tr>
   </table>
</form>

<?=$grouplist?>

<br />

<?=$teamassociation?>

<br />

<p><button type="button" onClick="window.location='AdminUser.php'">Return User Administration</button></p>