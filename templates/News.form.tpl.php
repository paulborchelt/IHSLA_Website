<FORM action="<?php $_SERVER['PHP_SELF'] ?>" method="post"> 	
	<TABLE cellspacing="1" cellpadding="1" border="0">
    	<TR>
    	   <TD>Headline:</TD></TR>
    	<TR>
    	   <TD><INPUT TYPE="text" NAME="headline" size="50"></TD></TR>
    	<TR>
    	   <TD>Message:</TD></TR>
    	<TR>
    	   <TD><textarea name="message" rows="5" cols="60"></textarea></TD>
    	   <TD><INPUT TYPE="HIDDEN" NAME="action" VALUE=Enter ></TD>
    	   <TD><INPUT TYPE="HIDDEN" NAME="team_id" VALUE= <?php $_SESSION['TeamID'] ?></TD>
    	   <INPUT TYPE="submit" NAME="News" VALUE="Enter"></TD>
        </TR>
    </TABLE> 
 </FORM>