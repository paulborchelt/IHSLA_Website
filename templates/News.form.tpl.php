 <div class="container">
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="form-group">
    <label for="heading">Heading</label>
    <input type="text" class="span5" id="heading" name="headline" value="<?php echo $headline?>" size="50">
    </div>
    <div class="form-group">
      <label for="news">News:</label>
      <textarea class="input-block-level" id="news" name="message" rows="25"><?php echo $message?></textarea>
    </div>
    <div class="form-group">
        <?php if ($submittype == "Edit"): ?>
            <input type="HIDDEN" name="action" value=SubmitEdit >
            <input type="submit" class="btn btn-primary" name="Edit" value="EDIT" >
        <?php else:?>
            <input type="HIDDEN" name="action" value= Enter >
            <input type="submit" class="btn btn-primary" name="Submit" value="SUBMIT" >
        <?php endif; ?>
        <input type="HIDDEN" name="author_id" value="<?php echo $_SESSION['userid'] ?>"/>
        <input type="HIDDEN" name="team_id" value="<?php echo $_SESSION['TeamID'] ?>"/>
        <input type="HIDDEN" name="timestamp" value="<?php echo date("Y-m-d\TH:i:s",time()); ?>"/>
    </div>
  </form>
</div>