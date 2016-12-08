<form class="well form-inline" role="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
   <legend><h4>Enter New User <?php echo $teamname?>:</h4></legend>
   <p></p>
   <div class="form-group">
      <label>Contact Type</label>
      <select name="CTID"><?php echo $contacttypeoptions?></select>
   </div>
   <div class="form-group">
      <label>First Name</label>
      <input type="text" value="<?php echo $FirstName?>" name="FirstName" size="20">
   </div>
   <div class="form-group">
      <label>Last Name</label>
      <input type="text" value="<?php echo $LastName?>" name="LastName" size="20">
   </div>
   <div class="form-group">
      <label>Home Phone</label>
      <input type="text" value="<?php echo $PhoneHome?>" name="PhoneHome" size="20">
   </div>
   <div class="form-group">
      <label>Phone Work</label>
      <input type="text" value="<?php echo $PhoneWork?>" name="PhoneWork" size="20">
   </div>
   <div class="form-group">
      <label>Phone Cell</label>
      <input type="text" value="<?php echo $PhoneCell?>" name="PhoneCell" size="20">
   </div>
   <div class="form-group">
      <label>Email</label>
      <input type="text" value="<?php echo $Email?>" name="Email" size="20">
   </div>
   <div class="form-group">
      <label>Main Contact</label>
      <select name="MainContact"><?php echo $maincontactoptions?></select>
   </div>
   <?php if ($submittype == "Submit"): ?>
      <input type="HIDDEN" name="action" value=EnterContact ><input type="submit" name="Submit" value="SUBMIT" >
   <?php else:?>
      <input type="HIDDEN" name="action" value=SubmitEdit ><input type="submit" name="Edit" value="EDIT" >
   <?php endif; ?>
      <input type="HIDDEN" name="Team_ID" value=<?php echo $teamid?> >
      <input type="HIDDEN" name="Id" value=<?php echo $Id?> >
      <input type="HIDDEN" name="contactinfoteamslistid" value=<?php echo $contactinfoteamslistid?> >
</form>
