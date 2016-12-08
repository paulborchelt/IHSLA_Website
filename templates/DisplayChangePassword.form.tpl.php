<form class="well form-horizontal" role="form">
  <div class="form-group">
    <label for="currentpassword" class="col-sm-2 control-label">Current Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="currentpassword" placeholder="Current Password" name="currentpassword">
    </div>
  </div>
  <div class="form-group">
    <label for="newpassword" class="col-sm-2 control-label">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="newpassword" placeholder="New Password" name="newpassword">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Change Password</button>
      <button type="button" class="btn btn-default" onClick="window.location='<?php echo $_SERVER['PHP_SELF']?>'">Cancel</button>
      <input type="hidden" name="action" value="changepassword">
    </div>
  </div>
</form>