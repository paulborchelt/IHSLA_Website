<?php session_save_path("/home/users/web/b414/apo.pblgn1/cgi-bin/tmp");
 session_start();
require('Security.php');
require('functions.php');
Authentication();
include("header.html");
echo('<div id="MainBody" style="position:absolute; left:143px; top:200px; width:800px; height:560px; z-index:2">');

$gUserId = $_SESSION['CoachID'];

// Connect to the database server
ConnectDatabase();

if ( $_GET['ActionType'] == "Delete" )
{
	if ( $_GET['OfficalType'] == "Ref" )
	{
	  $editRef = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Referee = NULL
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You now removed as the referee for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to remove you as the referee to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
	if ( $_GET['OfficalType'] == "Umpire" )
	{
	  $editUmpire = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Umpire = NULL
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You are now removed as the umpire for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to remove you as the umpire to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
	if ( $_GET['OfficalType'] == "FieldJudge" )
	{
	  $editUmpire = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Field_Judge = NULL
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You are now removed as the FieldJudge for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to remove you as the FieldJudge to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
}

if ( $_GET['ActionType'] == "Add" )
{
	if ( $_GET['OfficalType'] == "Ref" )
	{
	  $editRef = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Referee ='$editRef'
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You are now assigned as the referee for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to assign you as the referee to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
	if ( $_GET['OfficalType'] == "Umpire" )
	{
	  $editUmpire = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Umpire ='$editUmpire'
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You are now assigned as the umpire for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to assign you as the umpire to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
	if ( $_GET['OfficalType'] == "FieldJudge" )
	{
	  $editUmpire = $_GET['UserId'];
	  $editGameID = $_GET['GameId'];
	  $sql = "UPDATE Schedule
	   SET Field_Judge ='$editUmpire'
	   WHERE Game_ID ='$editGameID'";
	   if (@mysql_query($sql))
	   {
			echo('<p>You are now assigned as the FieldJudge for game ID: '.$editGameID.'.</p>');
	   }
	   else
	   {
			echo('<p>Error attempting to assign you as the FieldJudge to game ID: '.$editGameID.' ' . mysql_error() . '</p>');
	   }
	}
}

echo('<p>Once you have finished selecting the games you wish to officiate click exit to return to login page.</P> <a href="login.php"> Exit </a>');

//Make sure level is always set
if( !$Level = $_GET['l'] )
{
	$Level = All;
}
if( !$Type = $_GET['t'] )
{
	$Type = All;
}

//initialize
$Search = "";

//TODO: Make Function
switch($Level)
{
	case ALL:
		$Search = "";
	  break;
	case Varsity:
		$Search = "AND Game_Level = 'Varsity'";
	  break;
	case JV:
		$Search = "AND Game_Level = 'JV'";
		break;
    case Freshmen:
    	$Search = "AND Game_Level = 'Freshmen'";
        break;
	default:
    $Search = "";
	  break;
}


echo('<p> Here are all the games on the master schedule: </p>');

$SeasonYear = GetCurrentSeasonYear();

$sql = "SELECT *
        FROM Schedule
		LEFT JOIN Field_Info ON Schedule.Site_ID = Field_Info.ID
        WHERE Year(Date) = '$SeasonYear'
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
			 <TD>Referee</TD>
			 <TD>Umpire</TD>
			 <TD>Field Judge</TD>
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
   $UserAssignedToThisRow = "FALSE";
   if ( NULL == $row['Referee'] )
   {
   		$viewRef = "NA";
   }
   else
   {
		$id = $row['Referee'];
   		$viewRef = GetUserLastName($id);
		if( $id == $_SESSION['CoachID'] )
	    {
			$UserAssignedToThisRow = "Referee";
		}
   }
   if ( NULL == $row['Umpire'] )
   {
   		$viewUmpire= "NA";
   }
   else
   {
	    $id = $row['Umpire'];
   		$viewUmpire = GetUserLastName($id);
		if( $id == $_SESSION['CoachID'] )
	    {
			$UserAssignedToThisRow = "Umpire";
		}
   }
   if ( NULL == $row['Field_Judge'] )
   {
   		$viewRef3= "NA";
   }
   else
   {
	    $id = $row['Field_Judge'];
   		$viewRef3 = GetUserLastName($id);
		if( $id == $_SESSION['CoachID'] )
	    {
			$UserAssignedToThisRow = "FieldJudge";
		}
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

   if ( TRUE == IsIndianaTeams( $viewHomeTeam_ID ) )
   { 
		echo('<TR>
				 <TD>'.$viewUSADate.'</TD>
				 <TD>'.$viewHomeTeam .'</TD>
				 <TD>'.$viewAwayTeam .'</TD>
				 <TD>'.$viewSite.'</TD>
				 <TD>'.$viewTime12Hour.'</TD>
				 <TD>'.$viewGameLevel.'</TD>
				 <TD>'.$viewGameType.'</TD>');
		if( $viewRef == "NA" AND $UserAssignedToThisRow == "FALSE" )
		{
			echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Add&OfficalType=Ref&GameId='.$viewGameID.'&UserId='.$gUserId.'"> [SELECT]</a></TD>');
		}
		else
		{
			if( $UserAssignedToThisRow == "Referee" )
			{
				echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Delete&OfficalType=Ref&GameId='.$viewGameID.'&UserId='.$gUserId.'"> ['.$viewRef.']</a></TD>');
			}
			else
			{
				echo('<TD>'.$viewRef.'</TD>');
			}
		}
		if( $viewUmpire == "NA" AND $UserAssignedToThisRow == "FALSE" )
		{
			echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Add&OfficalType=Umpire&GameId='.$viewGameID.'&UserId='.$gUserId.'"> [SELECT]</a></TD>');
		}
		else
		{
			if( $UserAssignedToThisRow == "Umpire" )
			{
				echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Delete&OfficalType=Umpire&GameId='.$viewGameID.'&UserId='.$gUserId.'"> ['.$viewUmpire.']</a></TD>');
			}
			else
			{
				echo('<TD>'.$viewUmpire.'</TD>');
			}
		}
		if( $viewRef3 == "NA" AND $UserAssignedToThisRow == "FALSE" )
		{
			echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Add&OfficalType=FieldJudge&GameId='.$viewGameID.'&UserId='.$gUserId.'"> [SELECT]</a></TD>');
		}
		else
		{
			if( $UserAssignedToThisRow == "FieldJudge" )
			{
				echo('<TD><a href="'.$_SERVER['PHP_SELF'].'?ActionType=Delete&OfficalType=FieldJudge&GameId='.$viewGameID.'&UserId='.$gUserId.'"> ['.$viewRef3.']</a></TD>');
			}
			else
			{
				echo('<TD>'.$viewRef3.'</TD>');
			}
		}
						  
		echo('</TR>
			 ');
   }
}

echo('</TABLE>');

include("footer.html")?>
</DIV>