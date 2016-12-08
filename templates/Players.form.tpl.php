<script>
 function goBack() {
     window.history.back()
 }
</script>

<h3><?php echo $team->Team_Name?></h3>
<form class="well form-inline" role="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <div class="form-group">
      <label>First Name</label>
      <input type="text" class="input-small" id="first_name" name="First_Name" value="<?php echo $First_Name?>" placeholder="First Name">
      <label>Last Name</label>
      <input type="text" class="input-small" name="Last_Name" value="<?php echo $Last_Name?>" placeholder="Last Name">
      <label>Grade</label>
      <select class="input-mini" name="Grade_Year"><?php echo $gradeoptions?></select>
      <label>Height</label>
      <input type="text" class="input-mini" name="Height" value="<?php echo $Height?>" placeholder="Height">
      <label>Weight</label>
      <input type="text" class="input-mini" name="Weight" value="<?php echo $Weight?>" placeholder="Weigth">
      <label>USL Number</label>
      <input type="text" class="input-medium" name="UsLacrosseNumber" value="<?php echo $UsLacrosseNumber?>" placeholder="US Lacrosse Number">
      <?php if(0 == $team->Club): ?>
         <?php if ($submittype == "Submit"): ?>
          <input type="HIDDEN" name="action" value= Enter >
          <input type="submit" class="btn btn-primary" name="Submit" value="SUBMIT" >
         <?php else:?>
          <input type="HIDDEN" name="action" value=SubmitEdit >
          <input type="submit" class="btn btn-primary" name="Edit" value="EDIT" >
         <?php endif; ?>
         <button type="button" class="btn"  onclick="window.location='<?php echo isset($_SESSION[Return_Link]) == true ? $_SESSION[Return_Link] : "login.php" ?>'"> Return</button>
         <input type="HIDDEN" name="School_ID" value=<?php echo $team->Team_ID?> >
      <?php endif; ?>
    </div>
    <?php if(1 == $team->Club): ?>
       <div class="form-group">
         <label>School Enrolled At</label>
         <select name="School_ID"><?php echo $schooloptions?></select>
         <button type="button" class="btn"  onclick="window.location='AdminTeams.php?league=<?php echo $team->League?>&link=EditPlayerInfo.php'"> Add Team</button>
         <?php if ($submittype == "Submit"): ?>
           <input type="HIDDEN" name="action" value= Enter >
           <input type="submit" class="btn btn-primary" name="Submit" value="SUBMIT" >
         <?php else:?>
           <input type="HIDDEN" name="action" value=SubmitEdit >
           <input type="submit" class="btn btn-primary" name="Edit" value="EDIT" >
         <?php endif; ?>
         <button type="button" class="btn"  onclick="window.location='<?php echo isset($_SESSION[Return_Link]) == true ? $_SESSION[Return_Link] : login.php ?>'"> Return</button>
       </div>       
    <?php endif; ?>
    <input type="HIDDEN" name="Team_ID" value=<?php echo $team->Team_ID?> >
    <input type="HIDDEN" name="Player_ID" value=<?php echo $Player_ID?> >
</form>
<?php echo $list_of_players?>