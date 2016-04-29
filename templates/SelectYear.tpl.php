<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<a>Year:  <SELECT NAME="Year"><?=$yearOptions?></SELECT>
<INPUT TYPE="hidden" name ="Team_ID" value=<?=$Team_ID?> >
<INPUT TYPE="hidden" name ="subpage" value=<?=$subpage?> >
<INPUT type="submit" name="selectYear" value="GO" ></a>
</form>