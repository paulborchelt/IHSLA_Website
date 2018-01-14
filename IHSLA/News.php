<?php session_start();
require('Security.php');
Authentication();
include("header.html");
echo('<div id="Layer1" style="position:absolute; left:143px; top:136px; width:600px; height:560px; z-index:2"> ');
require('functions.php');
// Connect to the database server
ConnectDatabase();

echo('<p>Test: '.$_SESSION['CoachID'].'</p>');

$page = $_REQUEST['action'];
switch($page)
{
	case Enter:
		$headline = $_POST['headline'];
		$message = mysql_real_escape_string($_POST['message']);
		$author_id = $_SESSION['CoachID'];
		$team_id = $_SESSION['TeamID'];
		$date = date(Ymd);
		$sql = "INSERT INTO News SET
		author_id ='$author_id',
		team_id ='$team_id',
		message ='$message',
		headline='$headline'";
		if (@mysql_query($sql)) {
			echo('<p>Your message has been entered.</p>');
		} else {
			echo('<p>Error adding message: ' .
			mysql_error() . '</p>');
		}
		echo('<p><a href="login.php">Return to Coaches Area.</a></p>');
		break;
	default:
	echo('<FORM action="'.$_SERVER['PHP_SELF'].'" method="post"> 	
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
		<TD><INPUT TYPE="HIDDEN" NAME="team_id" VALUE='.$_SESSION['TeamID'].'</TD>
		<INPUT TYPE="submit" NAME="News" VALUE="Enter"></TD></TR></TABLE> 
		</FORM>');
		break;
}

?>