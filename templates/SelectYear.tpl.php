<form action="<?php echo$_SERVER['PHP_SELF']?>" method="post">
<a>Year:  <SELECT NAME="Year"><?php echo$yearOptions?></SELECT>
<INPUT TYPE="hidden" name ="Team_ID" value=<?php echo$Team_ID?> >
<INPUT TYPE="hidden" name ="subpage" value=<?php echo$subpage?> >
<INPUT type="submit" name="selectYear" value="GO" ></a>
</form>