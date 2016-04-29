<form class="well form-inline" role="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter New User <?=$teamname?>:</h4></legend>
   <p></p>
   <div class="form-group">
      <label>Contact Type</label>
      <select name="CTID"><?=$contacttypeoptions?></select>
   </div>
   <div class="form-group">
      <label>First Name</label>
      <input type="text" value="<?=$FirstName?>" name="FirstName" size="20">
   </div>
   <div class="form-group">
      <label>Last Name</label>
      <input type="text" value="<?=$LastName?>" name="LastName" size="20">
   </div>
   <div class="form-group">
      <label>Home Phone</label>
      <input type="text" value="<?=$PhoneHome?>" name="PhoneHome" size="20">
   </div>
   <div class="form-group">
      <label>Phone Work</label>
      <input type="text" value="<?=$PhoneWork?>" name="PhoneWork" size="20">
   </div>
   <div class="form-group">
      <label>Phone Cell</label>
      <input type="text" value="<?=$PhoneCell?>" name="PhoneCell" size="20">
   </div>
   <div class="form-group">
      <label>Email</label>
      <input type="text" value="<?=$Email?>" name="Email" size="20">
   </div>
   <div class="form-group">
      <label>Main Contact</label>
      <select name="MainContact"><?=$maincontactoptions?></select>
   </div>
   <? if ($submittype == "Submit"): ?>
      <input type="HIDDEN" name="action" value=EnterContact ><input type="submit" name="Submit" value="SUBMIT" >
   <? else:?>
      <input type="HIDDEN" name="action" value=SubmitEdit ><input type="submit" name="Edit" value="EDIT" >
   <? endif; ?>
      <input type="HIDDEN" name="Team_ID" value=<?=$teamid?> >
      <input type="HIDDEN" name="Id" value=<?=$Id?> >
      <input type="HIDDEN" name="contactinfoteamslistid" value=<?=$contactinfoteamslistid?> >
</form>
