<form class="well form-inline" role="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter New User <?=$teamname?>:</h4></legend>
   <p></p>
   <div class="form-group">
      <label class="sr-only" for="username">User ID</label>
      <input type="text" name="username" class="form-control" placeholder="User ID" value="<?=$username?>" >
   </div>
   <div class="form-group">
      <label>Email</label>
      <input type="text" name="Email" value="<?=$Email?>">
   </div>
   <div class="form-group">
      <label>First Name</label>
      <input type="text" name="FirstName" value="<?=$FirstName?>">
   </div>
   <div class="form-group">
      <label>Last Name</label>
      <input type="text" name="LastName" value="<?=$LastName?>">
   </div>
   <div class="form-group">
      <label>Cell Phone</label>
      <input type="text" name="PhoneCell" value="<?=$PhoneCell?>">
   </div>
   <div class="form-group">
      <label>Home Phone</label>
      <input type="text" name="PhoneHome" value="<?=$PhoneHome?>">
   </div>
   <div class="form-group">
      <label>Work Phone</label>
      <input type="text" name="PhoneWork" value="<?=$PhoneWork?>">
   </div>
   <? if ( "FALSE" == $Edit ): ?>
      <button type="submit" class="btn btn-primary">Enter</button>
      <input type="hidden" name="action" value="insert_user">
      <input type="hidden" name="pn_uid" value=0>
      <input type="hidden" name="contactinfo_id" value=0>
   <? else: ?>
      <button type="submit" class="btn btn-primary">Edit</button>
      <input type="hidden" name="action" value="update_user">
      <input type="hidden" name="userid" value=<?=$userid?> >
      <input type="hidden" name="Id" value=<?=$Id?> >
      <input type="hidden" name="password" value=<?=$password?> >
      <input type="hidden" name="contactinfo_id" value=<?=$Id?> >
   <? endif; ?>
</form>
