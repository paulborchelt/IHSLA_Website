<script>
 function goBack() {
     window.history.back()
 }
</script>

<h3><?=$team->Team_Name?></h3>
<form class="well form-inline" role="form" action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <div class="form-group">
      <label>First Name</label>
      <input type="text" class="input-small" id="first_name" name="First_Name" value="<?=$First_Name?>" placeholder="First Name">
      <label>Last Name</label>
      <input type="text" class="input-small" name="Last_Name" value="<?=$Last_Name?>" placeholder="Last Name">
      <label>Grade</label>
      <select class="input-mini" name="Grade_Year"><?=$gradeoptions?></select>
      <label>Height</label>
      <input type="text" class="input-mini" name="Height" value="<?=$Height?>" placeholder="Height">
      <label>Weight</label>
      <input type="text" class="input-mini" name="Weight" value="<?=$Weight?>" placeholder="Weigth">
      <label>USL Number</label>
      <input type="text" class="input-medium" name="UsLacrosseNumber" value="<?=$UsLacrosseNumber?>" placeholder="US Lacrosse Number">
      <? if(0 == $team->Club): ?>
         <? if ($submittype == "Submit"): ?>
          <input type="HIDDEN" name="action" value= Enter >
          <input type="submit" class="btn btn-primary" name="Submit" value="SUBMIT" >
         <? else:?>
          <input type="HIDDEN" name="action" value=SubmitEdit >
          <input type="submit" class="btn btn-primary" name="Edit" value="EDIT" >
         <? endif; ?>
         <button type="button" class="btn"  onclick="window.location='<?=isset($_SESSION[Return_Link]) == true ? $_SESSION[Return_Link] : "login.php" ?>'"> Return</button>
         <input type="HIDDEN" name="School_ID" value=<?=$team->Team_ID?> >
      <? endif; ?>
    </div>
    <? if(1 == $team->Club): ?>
       <div class="form-group">
         <label>School Enrolled At</label>
         <select name="School_ID"><?=$schooloptions?></select>
         <button type="button" class="btn"  onclick="window.location='AdminTeams.php?league=<?=$team->League?>&link=EditPlayerInfo.php'"> Add Team</button>
         <? if ($submittype == "Submit"): ?>
           <input type="HIDDEN" name="action" value= Enter >
           <input type="submit" class="btn btn-primary" name="Submit" value="SUBMIT" >
         <? else:?>
           <input type="HIDDEN" name="action" value=SubmitEdit >
           <input type="submit" class="btn btn-primary" name="Edit" value="EDIT" >
         <? endif; ?>
         <button type="button" class="btn"  onclick="window.location='<?=isset($_SESSION[Return_Link]) == true ? $_SESSION[Return_Link] : login.php ?>'"> Return</button>
       </div>       
    <? endif; ?>
    <input type="HIDDEN" name="Team_ID" value=<?=$team->Team_ID?> >
    <input type="HIDDEN" name="Player_ID" value=<?=$Player_ID?> >
</form>
<?=$list_of_players?>