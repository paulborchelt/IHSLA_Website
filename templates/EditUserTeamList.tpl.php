
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <p>Edit Teams here:</p>
   <table cellspacing="1" cellpadding="1" border="0">
      <tr>
         <td>Teams: </td>
      </tr>
      <tr>
         <td><select name="TID"><?php echo $teamoptions?></select></td>
         <td><input type="hidden" name="action" value="add_team" >
         <td><input type="hidden" name="teamlist_userid" value=<?php echo $userid?> >
         <td><input type="hidden" name="userid" value=<?php echo $userid?> >
         <td><input type="submit" value="ADD" > </td>
      </tr>
   </table>
</form>

<?php echo $userteamlist?>


