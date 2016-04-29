<?php 
 session_start();
require('Security.php');
require('functions.php');
Authentication();
include("header.html");
echo('<div id="MainBody" style="position:absolute; left:143px; top:200px; width:800px; height:560px; z-index:2">');

$gUserId = $_REQUEST['UID'];

// Connect to the database server
ConnectDatabase();


//TODO: Make it so official admin can  get here from assign page.

if( $page == "Report" )
{
	if ( isset($_REQUEST['gameid']) )
	{
		$gameid = $_REQUEST['gameid'];
	}
	else
	{
	   die("Error: Missing game id for report.");
	}
	$sql = "SELECT author_id, report, HomeTeam_ID, AwayTeam_ID, GameReport.date as Date
			FROM Schedule 
			LEFT JOIN GameReport ON Game_ID = gid 
			WHERE Game_ID = '$gameid'";

	$result = RunQuery( $sql, "Get Reports" );

	$report = "";
	$HomeTeamName = "NA";
	$AwayTeamName = "NA";
	if($row = mysql_fetch_array($result))
	{
		$HomeTeamName = GetTeamName($row['HomeTeam_ID']);
		$AwayTeamName = GetTeamName($row['AwayTeam_ID']);
		$report = $row['report'];
		$aurthor_id = $row['author_id'];
		$aurthorName = GetUserName( $aurthor_id );
        $test = $row['Date'];
		$date = date_convert($test,10);
        echo('<p>'.$HomeTeamName.' vs '.$AwayTeamName.'.</p>');
        echo('<textarea rows="10" cols="80" readonly="readonly">'.$report.'</textarea>');
        echo('<p>Last edited by '.$aurthorName.' on: '. $date.'.</p>');
        echo('<p><a href="'.$_SERVER['PHP_SELF'].'?UID='.$gUserId.'">Back</a></p>');
	}
	else
	{
		die("Unable to find game for game report.");
	}
}
else if ( $page == "evaluationview" ){
    
}
else
{
    $name = GetUserName($gUserId);
    echo('<p> Here are all the games for '.$name.': </p>');
    
    if( !$datesort = $_POST['datesort'] )
    {
    	$datesort = All;
    }
    
    $dateOptions = CreateDateOptions( $datesort);
    
    echo('<form action="'.$_SERVER['PHP_SELF'].'" method="post">
    <a>Date: <SELECT NAME="datesort">
    	'.$dateOptions.'
    </SELECT>
    <INPUT type="submit" name="selectYear" value="GO" ></a>
    </form>');
    
    $SeasonYear = date("Y");
    
    $Search = "WHERE 
    	  (Referee = '$gUserId' OR
    	   Umpire = '$gUserId' OR
    	   Field_Judge = '$gUserId')";
    
    switch($datesort)
    {
    	case Today:
    		$TodayDate = date("Y-m-d");
    		   $Search = $Search . " AND Date = '$TodayDate'";
    	  break;
    	case Yesterday:
    		$Yesterday = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-1,date("Y")));
    		$Search = $Search . " AND Date = '$Yesterday'";
    		break;
    	case Week:
    		$TodayDate = date("Y-m-d");
    		$Weekend = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")+7,date("Y")));
    		$Search = $Search . " AND Date >= '$TodayDate' AND Date <= '$Weekend'";
    		break;
    	case Last_Week:
    		$TodayDate = date("Y-m-d");
    		$Weekend = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-7,date("Y")));
    		$Search = $Search . " AND Date <= '$TodayDate' AND Date >= '$Weekend'";
    		break;	
    	case Next_Week:
    	case All:
    		$Search = $Search . " AND Year(Date) = '$SeasonYear'";
    		break;	
    }
    
    $sql = "SELECT *
    	FROM Schedule
    	LEFT JOIN Field_Info ON Schedule.Site_ID = Field_Info.ID
    	LEFT JOIN CancelOptions ON Cancel = cancelid 
    	$Search
    	ORDER BY Date";
    
    $result = @mysql_query($sql);
    if (!$result)
    {
    	die('<p>Error performing query: ' . mysql_error() . '</p>');
    }
    
    // Display each game with a "Delete this game link next to each.
    echo('<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
    	<TR>
    		<TD>Date: </TD>
    		<TD>Home: </TD>
    		<TD>Away: </TD>
    		<TD>Site: </TD>
    		<TD>Time:</TD>
    		<TD>Level:</TD>
    		<TD>Type:</TD>
    		<TD>Referee:</TD>
    		<TD>Umpire:</TD>
    		<TD>Field Judge:</TD>
    		<TD>Accept/Report/Status:</TD>
    	</TR>');
    while ( $row = mysql_fetch_array($result) )
    {
    	//Database values
    	$viewGameID = $row['Game_ID'];
    	$viewDate = $row['Date'];
    	$viewHomeTeam_ID = $row['HomeTeam_ID'];
    	$viewAwayTeam_ID = $row['AwayTeam_ID'];
    	$viewHomeTeamID = $row['HomeTeamID'];
    	$viewTime = $row['Time'];
    	$viewGameLevel = $row['Game_Level'];
    	$viewGameType = $row['Game_Type'];
    	$viewReferee_Accepted = $row['Referee_Accepted'];
    	$viewUmpire_Accepted = $row['Umpire_Accepted'];
    	$viewField_Judge_Accepted = $row['Field_Judge_Accepted'];
    	$viewReferee = GetUserLastName($row['Referee']);
    	if( $gUserId == $row['Referee'] )
    	{
    		$Official = "Ref";
    	}
    	$viewUmpire = GetUserLastName($row['Umpire']);
    	if( $gUserId == $row['Umpire'] )
    	{
    		$Official = "Umpire";
    	}
    	$viewField_Judge = GetUserLastName($row['Field_Judge']);
    	if( $gUserId == $row['Field_Judge'] )
    	{
    		$Official = "FieldJudge";
    	}
    	if ( "" == $row['Name'] )
    	{
    		if ( "" == $row['Site'])
    		{
    			$viewSite = "NA";
    		}
    		else
    		{
    			$viewSite = $row['Site'];
    		}
    	}
    	else
    	{
    		$viewSite = $row['Name'];
    	}
    
    	//figure out values not in database
    	$viewHomeTeam = GetTeamName($viewHomeTeam_ID);
    	$viewAwayTeam = GetTeamName($viewAwayTeam_ID);
    	$viewTime12Hour = time_convert( $viewTime );
    	$viewUSADate = date_convert($viewDate,10);
    	$viewcancelid = $row['cancelid'];
    	$viewcancelname = $row['cancelname'];
    	$bAccepted = FALSE;
    
    	if ( TRUE == IsIndianaTeams( $viewHomeTeam_ID ) || ( FALSE == IsIndianaTeams( $viewHomeTeam_ID ) && FALSE == IsIndianaTeams( $viewAwayTeam_ID ) ) )
    	{ 
    		echo('<TR>
    			<TD>'.$viewUSADate.'</TD>
    			<TD>'.$viewHomeTeam .'</TD>
    			<TD>'.$viewAwayTeam .'</TD>
    			<TD>'.$viewSite.'</TD>
    			<TD>'.$viewTime12Hour.'</TD>
    			<TD>'.$viewGameLevel.'</TD>
    			<TD>'.$viewGameType.'</TD>');
    		   if( $viewReferee_Accepted == 1 )
    		   {
    			   echo('<TD><strong style="color: green;"><a href="OfficialsEvaluationView.php?UID='.$row['Referee'].'&gameid='.$viewGameID.'">'.$viewReferee.'</strong></TD>');
    			   if( $_SESSION['CoachID'] == $row['Referee'] )
    			   {
    			      $bAccepted = TRUE;
    			   }
    		   }
    		   else
    		   {
    			   echo('<TD>'.$viewReferee.'</TD>');
    		   }
    		   if( $viewUmpire_Accepted == 1 )
    		   {
    			   echo('<TD><strong style="color: green;"><a href="OfficialsEvaluationView.php?UID='.$row['Umpire'].'&gameid='.$viewGameID.'">'.$viewUmpire.'</strong></TD>');
    			   if( $_SESSION['CoachID'] == $row['Umpire'] )
    			   {
    			      $bAccepted = TRUE;
    			   }
    		   }
    		   else
    		   {
    			   echo('<TD>'.$viewUmpire.'</TD>');
    		   }
    		   if( $viewField_Judge_Accepted == 1 )
    		   {
    			   echo('<TD><strong style="color: green;"><a href="OfficialsEvaluationView.php?UID='.$row['Field_Judge'].'&gameid='.$viewGameID.'">'.$viewField_Judge.'</strong></TD>');
    			   if( $_SESSION['CoachID'] == $row['Field_Judge'] )
    			   {
    			      $bAccepted = TRUE;
    			   }
    		   }
    		   else
    		   {
    			   echo('<TD>'.$viewField_Judge.'</TD>');
    		   }	
    			$bReject = FALSE;
    			$date = date("Y-m-d");
    			if( $viewDate <= $date  )
    		    {
    				if( $viewDate == $date )
    				{
    					if( date('His') < str_replace(':','',$viewTime) )
    					{
    						$bReject = TRUE;
    					}
    				}
    			}
    			else
    		    {
    				$bReject = TRUE;
    			}
    			if( 0 == $viewcancelid )
    		    {
    				if( TRUE == $bReject )
    				{
    					if ( $bAccepted == FALSE )
    					{
    						echo('<TD>PENDING</TD></TR>');
    					}
    					else
    					{
    						echo('<TD>ACCEPTED</TD></TR>');
    					}
    				}
    				else
    				{
    					echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?UID='.$gUserId.'&gameid='.$viewGameID.'&page=Report"> View Report</TD></TR>');
    				}
    			}
    			else
    		    {
    				echo('<TD>'.$viewcancelname.'</TD></TR>');
    			}
    
    	}
    }
    
    echo('</TABLE>');
}



include("footer.html")?>
</DIV>