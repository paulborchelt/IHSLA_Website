<p>You have a couple of choice on how you want to send and email:</p>

<p>Use Link to open email client: <a href="mailto:<?php echo $mailtolinks?>">Email</a></p>

<p>Use <a href="ContactInfoList.php">Contact List</a> (cut and paste email address )</p>


<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 	

		 <p>Enter Your Email Below:</p>
		<tr>
<p>An e-mail will be sent to all main contacts in our database.</p>

<h5>Subjec:t</h5>
<p><textarea name="subject" rows="1" cols="260"></textarea><p>
<h5>Message:</h5>
<p><textarea name="message" rows="20" cols="260"></textarea><p>
   <input type="HIDDEN" name="action" value=sendemail >
<p><input type="submit" name="Mail" value="SEND"></p>
</form>