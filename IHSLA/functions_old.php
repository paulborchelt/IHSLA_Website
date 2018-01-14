<?php

//Global vars
$gGameLevelArray = array('Varsity','JV','Freshmen');
$gLocationArray = array('HOME','away','Neutral');
$gGameTypeArray = array('Regular','Scrimmage');

//NOTE: These defines must match the Groups table.
define ('Administrators', 1);
define ('TeamAdmin', 2);
define ('Officials', 4);
define ('Scheduler', 8);
define ('News', 16);
define ('TeamAdminYouth', 32);
define ('AdministratorsYouth', 64); 
define ('IndianaUSL', 64); 

define('ON', 1);
define('OFF', 0);

define('TRUE', 1);
define('FALSE', 0);


function setflag(&$var, $flag, $set=ON ) {
if (($set == ON)) $var = ($var | $flag);
if (($set == OFF)) $var = ($var & ~$flag);
return;
}


function ConnectDatabase(){
        //$dbcnx = @mysql_connect('pblgn1.apollomysql.com', 'ihsla', 'lacrosse');
        $dbcnx = @mysql_connect('pblgn1.apollomysql.com', 'root', 'bu4227');
        if (!$dbcnx) {
                die( '<p>Unable to connect to the ' .
                        'database server at this time.</p>' );
        }
        // Select the Players database
        if (! @mysql_select_db('indianalacrosse_org') ) {
                die( '<p>Unable to locate the ' .
                        'database at this time.</p>' );
        }
        
        $sql = "SET SESSION SQL_BIG_SELECTS=1";
        
        RunQuery($sql,"Big Selects");

        
        
}

function genRandStr($minLen, $maxLen, $alphaLower = 1, $alphaUpper = 1, $num = 1, $batch = 1) {
    
    $alphaLowerArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $alphaUpperArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $numArray = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    
    if (isset($minLen) && isset($maxLen)) {
        if ($minLen == $maxLen) {
            $strLen = $minLen;
        } else {
            $strLen = rand($minLen, $maxLen);
        }
        $merged = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
        
        if ($alphaLower == 1 && $alphaUpper == 1 && $num == 1) {
            $finalArray = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 1 && $num == 0) {
            $finalArray = array_merge($alphaLowerArray, $alphaUpperArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 1) {
            $finalArray = array_merge($alphaLowerArray, $numArray);
        } elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 1) {
            $finalArray = array_merge($alphaUpperArray, $numArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 0) {
            $finalArray = $alphaLowerArray;
        } elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 0) {
            $finalArray = $alphaUpperArray;                        
        } elseif ($alphaLower == 0 && $alphaUpper == 0 && $num == 1) {
            $finalArray = $numArray;
        } else {
            return FALSE;
        }
        
        $count = count($finalArray);
        
        if ($batch == 1) {
            $str = '';
            $i = 1;
            while ($i <= $strLen) {
                $rand = rand(0, $count);
                $newChar = $finalArray[$rand];
                $str .= $newChar;
                $i++;
            }
            $result = $str;
        } else {
            $j = 1;
            $result = array();
            while ($j <= $batch) { 
                $str = '';
                $i = 1;
                while ($i <= $strLen) {
                    $rand = rand(0, $count);
                    $newChar = $finalArray[$rand];
                    $str .= $newChar;
                    $i++;
                }
                $result[] = $str;
                $j++;
            }
        }
        
        return $result;
    }
}

function DisplayGoalieSaves( $fTeamID ) {
        global $GameId;
        //Display Game Stats Home Team
        $currentYear = GetCurrentSeasonYear();
        $sql = "SELECT Rosters.Number, First_Name, Last_Name, Saves, Goals_Against
                         FROM Saves LEFT JOIN Players ON Saves.Player_ID = Players.Player_ID
                         LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND 
				                     Rosters.level = 1 AND Rosters.Year = '$currentYear'
                         WHERE Game_ID = '$GameId' and Saves.Team_ID = '$fTeamID'";

        $result = @mysql_query($sql);
        if (!$result) {
        die('<p>Error performing query: ' .
                mysql_error() . '</p>');
        }
                echo('<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="400" border="1">
                                        <TR>
                                                <TD>No.</TD>
                                                <TD>Name</TD>
                                                <TD>Saves</TD>
                                                <TD>Goals Against</TD>
                                        </TR>');

        while ( $row = mysql_fetch_array($result) ) {
		$Number = $row['Number'];
        $LastName = $row['Last_Name'];
        $FirstName = $row['First_Name'];
        $Saves = $row['Saves'];
        $GA = $row['Goals_Against'];;
        echo('<TR>
                        <TD>'.$Number.'</TD>
                        <TD>'.$FirstName.' '.$LastName.'</TD>
                        <TD>'.$Saves.'</TD>
                        <TD>'.$GA.'</TD>
                </TR>');
        }
        echo("</TABLE>");
}

function time_convert($time){
        if( $time == "00:00:00" || $time == ""){
                $return = TBA;
        }
        else{
                $time_hour=substr($time,0,2);
                $time_minute=substr($time,3,2);
                $time_seconds=substr($time,6,2);
                        // 12 Hour Format with uppercase AM-PM
                $return=date("g:i A", mktime($time_hour,$time_minute,$time_seconds));
        }
  return $return;
}

function date_convert($date,$type){
  $date_year=substr($date,0,4);
  $date_month=substr($date,5,2);
  $date_day=substr($date,8,2);
  if($type == 1):
        // Returns the year Ex: 2003
        $date=date("Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 2):
        // Returns the month Ex: January
        $date=date("F", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 3):
        // Returns the short form of month Ex: Jan
        $date=date("M", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 4):
        // Returns numerical representation of month with leading zero Ex: Jan = 01, Feb = 02
        $date=date("m", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 5):
        // Returns numerical representation of month without leading zero Ex: Jan = 1, Feb = 2
        $date=date("n", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 6):
        // Returns the day of the week Ex: Monday
        $date=date("l", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 7):
        // Returns the day of the week in short form Ex: Mon, Tue
        $date=date("D", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 8):
        // Returns a combo ExL Wed,Nov 12th,2003
        $date=date("D, M jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 9):
        // Returns a combo Ex: November 12th,2003
        $date=date("F jS, Y", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 10 ):
        // Returns a combo ExL with no year Wed,Nov 12th
        $date=date("D, M jS", mktime(0,0,0,$date_month,$date_day,$date_year));
  elseif($type == 11):
        $date=date("m/d/y", mktime(0,0,0,$date_month,$date_day,$date_year));
  endif;
  return $date;
}

function GetScore( $GameId, $HomeTeamId, $AwayTeamId ){
        $Score['Home'] = NA;
        $Score['Away'] = NA;
        //TODO: Get rid of unused selected items.
        $sql = "SELECT Points.Team_ID,Team_Name,SUM(Goals) as Score
                        FROM Points LEFT JOIN Teams
                        ON Points.Team_ID = Teams.Team_ID
                        WHERE Game_ID = $GameId
                        GROUP BY Points.Team_ID";

        $result = @mysql_query($sql);
        if (!$result) {
        die('<p>Error performing score query: ' .
                mysql_error() . '</p>');
        }
        while ( $row = mysql_fetch_array($result) ){
                if( $HomeTeamId == $row['Team_ID'] ){
                        $Score['Home'] = $row['Score'];
                }
                else{
                        $Score['Away'] = $row['Score'];
                }
        }
        return $Score;
}

function GetScore2005( $GameId, $HomeTeamId, $AwayTeamId ){
        $Score['Home'] = NA;
        $Score['Away'] = NA;
        //TODO: Get rid of unused selected items.
        $sql = "SELECT Points_2005.Team_ID,Team_Name,SUM(Goals) as Score
                        FROM Points_2005 LEFT JOIN Teams
                        ON Points_2005.Team_ID = Teams.Team_ID
                        WHERE Game_ID = $GameId
                        GROUP BY Points_2005.Team_ID";

        $result = @mysql_query($sql);
        if (!$result) {
        die('<p>Error performing score query: ' .
                mysql_error() . '</p>');
        }
        while ( $row = mysql_fetch_array($result) ){
                if( $HomeTeamId == $row['Team_ID'] ){
                        $Score['Home'] = $row['Score'];
                }
                else{
                        $Score['Away'] = $row['Score'];
                }
        }
        return $Score;
}

function GetTeamName( $teamId )
{
        $sql = "SELECT Team_Name FROM Teams WHERE Team_ID = '$teamId'";
        $result = @mysql_query($sql);
        if (!$result)
   {
        die('<p>Error performing query (GetTeamName()): ' .mysql_error() . '</p>');
        }
        if($row = mysql_fetch_array($result))
   {
                $TeamName = $row[Team_Name];
        }
        else
   {
                //die('<p>Error: The system could not find a team it was looking for! TeamID = '.$teamId .' <a href="login.php">Return to coaches area.</a></p>');
      $TeamName = "NA";
        }
        return $TeamName;
}

//TODO: Join this with GetTeamName above so we have one entery and fail point for teaminfo stuff.
function GetTeamInfo( $teamId )
{
   $sql = "SELECT Team_Name, Address, City, Zip, Phone, Fax, Home_Colors, Away_Colors, Mascot FROM Teams WHERE Team_ID = '$teamId'";
   $result = @mysql_query($sql);
   if (!$result)
   {
      die('<p>Error performing query (GetTeamName()): ' .mysql_error() . '</p>');
   }
   if($row = mysql_fetch_array($result))
   {
     $returnRow= $row;
   }
   else
   {
     $returnRow = NULL;
   }

   return $returnRow;
}

function GetTeamID( $teamName )
{
        $sql = "SELECT Team_ID FROM Teams WHERE Team_Name = '$teamName'";
        $result = @mysql_query($sql);
        if (!$result)
   {
        die('<p>Error performing query (GetTeamID()): ' .mysql_error() . '</p>');
        }
        if($row = mysql_fetch_array($result))
    {
                $TeamID = $row[Team_ID];
        }
        return $TeamID;
}

function ConvertPositionNameToLetter( $PositionName )
{
        switch($PositionName)
   {
        case Attack:
                $PositionLetter = A;
                break;
        case Midfield:
                $PositionLetter = M;
                break;
        case Defense:
                $PositionLetter = D;
                break;
        case LSM:
                $PositionLetter = LSM;
                break;
        case Goalie:
                $PositionLetter = G;
                break;
        case Attack/Midfield:
                $PositionLetter = A/M;
                break;
        case Defense/Midfield:
                $PositionLetter = D/M;
                break;
        default:
                $PositionLetter = NA;
        }
        return $PositionLetter;
}

function GetTeamRecored( $TeamId, $selectedYear ){
    $Recored[winsTotal] = $Recored[lossesTotal] = $Recored[winsState] = $Recored[lossesState] = 0;
        $sql = "SELECT Game_ID, h.Team_ID as homeid, h.OutOfState as HomeOutState, a.Team_ID as awayid, a.OutOfState as AwayOutState
                                   FROM Schedule LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
                                   LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
                                   WHERE (Game_Level = 'Varsity') AND (HomeTeam_ID = '$TeamId' OR AwayTeam_ID = '$TeamId') AND  Year(Date) = '$selectedYear'
                                   ORDER BY Date";
        $result_schedule = @mysql_query($sql);
        if (!$result_schedule) {
                die('<p>Error performing query: ' .
                        mysql_error() . '</p>');
        }
        while ( $row = mysql_fetch_array($result_schedule) ) {
                $Score = GetScore($row[Game_ID],$row[homeid],$row[awayid]);
                if( $Score[Home] != NA && $Score[Away] != NA ){
                        //Home games
                        if($row[homeid] == $TeamId){
                                //echo('<p> Home games Home = '.$Score[Home].' Away = '.$Score[Away].' ');
                                if( $Score[Home] > $Score[Away] ){
                                        if( $row[AwayOutState] != 1 ){
                                                $Recored[winsState]++;
                                        }
                                        $Recored[winsTotal]++;
                                        //echo('Win</p>');
                                }
                                else{
                                        if( $row[AwayOutState] != 1 ){
                                                $Recored[lossesState]++;
                                        }
                                        $Recored[lossesTotal]++;
                                        //echo('Loss</p>');
                                }
                        }
                        //Away games
                        else if($row[awayid] == $TeamId){
                                //echo('<p> Away games Home = '.$Score[Home].' Away = '.$Score[Away].' ');
                                if( $Score[Home] < $Score[Away] ){
                                        if( $row[HomeOutState] != 1 ){
                                                $Recored[winsState]++;
                                        }
                                        $Recored[winsTotal]++;
                                        //echo('Win</p>');
                                }
                                else{
                                        if( $row[HomeOutState] != 1 ){
                                                $Recored[lossesState]++;
                                        }
                                        $Recored[lossesTotal]++;
                                        //echo('Loss</p>');
                                }
                        }
                }
        }
        return $Recored;
}

function GetTeamRecored2005( $TeamId )
{
    $Recored[winsTotal] = $Recored[lossesTotal] = $Recored[winsState] = $Recored[lossesState] = 0;
        $sql = "SELECT Game_ID, h.Team_ID as homeid, h.OutOfState as HomeOutState, a.Team_ID as awayid, a.OutOfState as AwayOutState
                                   FROM Schedule_2005 LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
                                   LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
                                   WHERE (Game_Level = 'Varsity') AND (HomeTeam_ID = '$TeamId' OR AwayTeam_ID = '$TeamId')
                                   ORDER BY Date";
        $result_schedule = @mysql_query($sql);
        if (!$result_schedule) {
                die('<p>Error performing query: ' .
                        mysql_error() . '</p>');
        }
        while ( $row = mysql_fetch_array($result_schedule) ) {
                $Score = GetScore($row[Game_ID],$row[homeid],$row[awayid]);
                if( $Score[Home] != NA && $Score[Away] != NA ){
                        //Home games
                        if($row[homeid] == $TeamId){
                                //echo('<p> Home games Home = '.$Score[Home].' Away = '.$Score[Away].' ');
                                if( $Score[Home] > $Score[Away] ){
                                        if( $row[AwayOutState] != 1 ){
                                                $Recored[winsState]++;
                                        }
                                        $Recored[winsTotal]++;
                                        //echo('Win</p>');
                                }
                                else{
                                        if( $row[AwayOutState] != 1 ){
                                                $Recored[lossesState]++;
                                        }
                                        $Recored[lossesTotal]++;
                                        //echo('Loss</p>');
                                }
                        }
                        //Away games
                        else if($row[awayid] == $TeamId){
                                //echo('<p> Away games Home = '.$Score[Home].' Away = '.$Score[Away].' ');
                                if( $Score[Home] < $Score[Away] ){
                                        if( $row[HomeOutState] != 1 ){
                                                $Recored[winsState]++;
                                        }
                                        $Recored[winsTotal]++;
                                        //echo('Win</p>');
                                }
                                else{
                                        if( $row[HomeOutState] != 1 ){
                                                $Recored[lossesState]++;
                                        }
                                        $Recored[lossesTotal]++;
                                        //echo('Loss</p>');
                                }
                        }
                }
        }
        return $Recored;
}

function GetGradeNameFromGradYear( $GraduationYear )
{
   $currentYear = GetCurrentSeasonYear();
   switch( $GraduationYear - $currentYear )
        {
		   case 0:
               $Grade = Senior;
               break;
           case 1:
               $Grade = Junior;
               break;
           case 2:
               $Grade = Sophomore;
               break;
           case 3:
               $Grade = Freshman;
               break;
           default:
               $Grade = NA;
               break;
        }

    return $Grade;
}

function CreateGameLevelOptions( $previousValue='Varsity' )
{
   $test = array('Varsity','JV','Freshmen');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
        $returnGameLevelOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
        $returnGameLevelOptions .= "<OPTION> $i </OPTION>";;
        }
    }

   return $returnGameLevelOptions;
}

function CreateGameLevelOptionsYouth( $previousValue='7/8' )
{
   $test = array('7/8','5/6','3/4');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
			$returnGameLevelOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
			$returnGameLevelOptions .= "<OPTION> $i </OPTION>";;
        }
   }

   return $returnGameLevelOptions;
}

function CreateGameLevelOptionsCollege( $previousValue='College' )
{
   $test = array('College');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
			$returnGameLevelOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
			$returnGameLevelOptions .= "<OPTION> $i </OPTION>";;
        }
   }

   return $returnGameLevelOptions;
}

function CreateGameLevelOptionsSummer( $previousValue='3/4' )
{
   $test = array('3/4','5/6','7/8','JV','Varsity','College');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
			$returnGameLevelOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
			$returnGameLevelOptions .= "<OPTION> $i </OPTION>";;
        }
   }

   return $returnGameLevelOptions;
}

function CreateAllLegueLevelOptions( $previousValue='All' )
{
   $test = array('All','Varsity','JV','Freshmen');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
        $returnGameLevelOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
        $returnGameLevelOptions .= "<OPTION> $i </OPTION>";;
        }
        }

   return $returnGameLevelOptions;
}

function CreateDateOptions( $previousValue='All' )
{
   $test = array('All','Today','Week','Next_Week','Month','Last_Week');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
        $returnMonthOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
        $returnMonthOptions .= "<OPTION> $i </OPTION>";;
        }
        }

   return $returnMonthOptions;
}

function CreateOfficialSortOptions( $previousValue='All' )
{
   $test = array('All','None','Referee','Umpire','Field_Judge');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
        $returnMonthOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
        $returnMonthOptions .= "<OPTION> $i </OPTION>";;
        }
        }

   return $returnMonthOptions;
}

function CreateGameTypeOptions( $previousValue='Regular' )
{
   $test = array('Regular','Scrimmage','Tournament');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
        $returnGameTypeOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
        $returnGameTypeOptions .= "<OPTION> $i </OPTION>";;
        }
    }

   return $returnGameTypeOptions;
}

function CreateIndianaTeamOptions( $previousValue )
{
    $sql = "SELECT * FROM Teams
           WHERE Member=1
           ORDER BY Team_Name";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding Indiana teams for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   { 
     $editTeam_ID = $row['Team_ID'];
     $editTeam_Name = $row['Team_Name'];
     if( $editTeam_ID == $previousValue )
     {
        $returnTeamOptions .= "<option selected value =$editTeam_ID>$editTeam_Name </option>";
     }
     else
     {
        $returnTeamOptions .= "<option value =$editTeam_ID>$editTeam_Name </option>";
     }
   }	

   return $returnTeamOptions;
}

function CreateOpponentOptions( $excludeTeam, $previousValue, $league = 1 )
{
   //Create the list with all Indiana teams on top then out of state teams.
   //First pass find only indiana teams
   $sql = "SELECT * FROM Teams LEFT JOIN Leagues on League = Leagues.ID 
           WHERE Team_ID != '$excludeTeam' && State='IN' && ID = '$league' && Member = 1
           ORDER BY Team_Name";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding teams for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   {
     $editTeam_ID = $row['Team_ID'];
     $editTeam_Name = $row['Team_Name'];
     if( $editTeam_ID == $previousValue )
     {
        $returnTeamOptions .= "<option selected value =$editTeam_ID>$editTeam_Name </option>";
     }
     else
     {
        $returnTeamOptions .= "<option value =$editTeam_ID>$editTeam_Name </option>";
     }
   }

   //Create the next list with all NON Indiana teams group by their states.
   $sql = "SELECT * FROM Teams LEFT JOIN Leagues on League = Leagues.ID
           WHERE Team_ID != '$excludeTeam' && member != 1 && ID = '$league'
           ORDER BY State,Team_Name";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding teams for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   {
     $editTeam_ID = $row['Team_ID'];
     $editTeam_Name = $row['Team_Name'];
     $editState = $row['State'];
     if( $editTeam_ID == $previousValue )
     {
        $returnTeamOptions .= "<option selected value =$editTeam_ID>$editTeam_Name ($editState) </option>";
     }
     else
     {
        $returnTeamOptions .= "<option value =$editTeam_ID>$editTeam_Name ($editState) </option>";
     }
   }

   return $returnTeamOptions;
}

function CreateOpponentOptionsYouth( $excludeTeam, $previousValue )
{
   //Create the list with all Indiana teams on top then out of state teams.
   //First pass find only indiana teams
   $sql = "SELECT * FROM Teams LEFT JOIN Leagues on League = Leagues.ID
           WHERE Team_ID != '$excludeTeam' && State='IN' && Name = 'IYLA'
           ORDER BY Team_Name";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding teams for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   {
     $editTeam_ID = $row['Team_ID'];
     $editTeam_Name = $row['Team_Name'];
     if( $editTeam_ID == $previousValue )
     {
        $returnTeamOptions .= "<option selected value =$editTeam_ID>$editTeam_Name </option>";
     }
     else
     {
        $returnTeamOptions .= "<option value =$editTeam_ID>$editTeam_Name </option>";
     }
   }

   //Create the next list with all NON Indiana teams group by their states.
   $sql = "SELECT * FROM Teams LEFT JOIN Leagues on League = Leagues.ID
           WHERE Team_ID != '$excludeTeam' && State!='IN' && Name = 'IYLA'
           ORDER BY State,Team_Name";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding teams for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   {
     $editTeam_ID = $row['Team_ID'];
     $editTeam_Name = $row['Team_Name'];
     $editState = $row['State'];
     if( $editTeam_ID == $previousValue )
     {
        $returnTeamOptions .= "<option selected value =$editTeam_ID>$editTeam_Name ($editState) </option>";
     }
     else
     {
        $returnTeamOptions .= "<option value =$editTeam_ID>$editTeam_Name ($editState) </option>";
     }
   }

   return $returnTeamOptions;
}

/*NOTE: Need to change name of function to site.*/
function CreateLocationOptions( $previousValue='HOME' )
{  $locationArray = array('HOME', 'away', 'Neutral');
   foreach( $locationArray as $i )
   {
        if ( $previousValue == $i)
      {
                $returnLocationOptions .= "<OPTION SELECTED> $i </OPTION>";
      }
      else
      {
                        $returnLocationOptions .= "<OPTION> $i </OPTION>";
      }
   }

   return $returnLocationOptions;
}

function DetermineGameLocation( $userTeamID, $homeTeamID )
{
   $locationArray = array('HOME', 'away', 'Neutral');
        if( 0 == $homeTeamID )
   {
        $returnLocation = $locationArray[2];
   }
   else if ( $userTeamID == $homeTeamID )
   {
        $returnLocation = $locationArray[0];
   }
   else
   {
        $returnLocation = $locationArray[1];
   }

   return $returnLocation;
}

function DetermineGameOpponent( $userTeamID, $teamID1, $teamID2)
{
        if( $userTeamID == $teamID1 )
   {
        $returnOpponentName = GetTeamName( $teamID2 );
   }
   else if ( $userTeamID == $teamID2 )
   {
        $returnOpponentName = GetTeamName( $teamID1 );
   }
   else
   {
        $returnOpponentName;
      //die('<p>Error determining game opponent. User does not match any team in game.</p>');
   }

   return $returnOpponentName;
}

function CreateTimeOptions( $previousValue='17:30:00' )
{
        $timearray = array('00:00:00','08:00:00','08:15:00','08:30:00','08:45:00','09:00:00','09:15:00','09:30:00','09:45:00','10:00:00','10:15:00','10:30:00','10:45:00','11:00:00','11:15:00','11:30:00','11:45:00','12:00:00','12:15:00','12:30:00','12:45:00',
                      '13:00:00','13:15:00','13:30:00','13:45:00','14:00:00','14:15:00','14:30:00','14:45:00','15:00:00','15:15:00','15:30:00','15:45:00','16:00:00','16:15:00','16:30:00','16:45:00','17:00:00','17:15:00','17:30:00','17:45:00',
                      '18:00:00','18:15:00','18:30:00','18:45:00','19:00:00','19:15:00','19:30:00','19:45:00','20:00:00','20:15:00','20:30:00','20:45:00','21:00:00','21:15:00','21:30:00','21:45:00','22:00:00','22:15:00','22:30:00','22:45:00','23:00:00','23:15:00','23:30:00','23:45:00','24:00:00');
   if( $previousValue == 'TBA' )
   {
   $returnTimeOptions .= "<option selected value =00:00:00>TBA</option>";
   }
   else
   {
        $returnTimeOptions .= "<option value =00:00:00>TBA </option>";
   }
        foreach( $timearray as $i )
   {
        $display12HourTime = time_convert( $i );

      if( $previousValue == $i )
      {
        $returnTimeOptions .= "<option selected value =$i>$display12HourTime </option>";
      }
      else
      {
        $returnTimeOptions .= "<option value =$i>$display12HourTime </option>";
      }
   }

   return $returnTimeOptions;
}

function CreateTimeOptionsOfficials( $previousValue='00:00:00' )
{
        $timearray = array('00:00:00','08:00:00','08:30:00','09:00:00','09:30:00','10:00:00','10:30:00','11:00:00','11:30:00','12:00:00','12:30:00',
                      '13:00:00','13:30:00','14:00:00','14:30:00','15:00:00','15:30:00','16:00:00','16:30:00','17:00:00','17:30:00',
                      '18:00:00','18:30:00','19:00:00','19:30:00','20:00:00','20:30:00');
   if( $previousValue == 'TBA' )
   {
   $returnTimeOptions .= "<option selected value =00:00:00>All Day</option>";
   }
   else
   {
        $returnTimeOptions .= "<option value =00:00:00>All Day </option>";
   }
        foreach( $timearray as $i )
   {
        $display12HourTime = time_convert( $i );

	  if( $display12HourTime == 'TBA' )
	   {
		  $display12HourTime = 'All Day';
	   }

      if( $previousValue == $i )
      {
        $returnTimeOptions .= "<option selected value =$i>$display12HourTime </option>";
      }
      else
      {
        $returnTimeOptions .= "<option value =$i>$display12HourTime </option>";
      }
   }

   return $returnTimeOptions;
}

function CreateMonthOptions ( $previousValue='March' )
{
        $monthArray = array('January','February','March','April','May','June','July','August','September','October','November','December');
   foreach( $monthArray as $i )
   {
      if( $previousValue == $i )
      {
        $returnMonthOptions .= "<option selected >$i </option>";
      }
      else
      {
        $returnMonthOptions .= "<option >$i </option>";
      }
   }

   return $returnMonthOptions;
}

function CreateYearOptions ( $previousValue='2010' )
{
   $yearArray = array('2011','2012');
   foreach( $yearArray as $i )
   {
      if( $previousValue == $i )
      {
        $returnYearOptions .= "<option selected >$i </option>";
      }
      else
      {
        $returnYearOptions .= "<option >$i </option>";
      }
   }

   return $returnYearOptions;
}

function CreateDayOptions ( $previousValue='1' )
{
        $dayArray = array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16',
                     '17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
   foreach( $dayArray as $i )
   {
      if( $previousValue == $i )
      {
        $returnDayOptions .= "<option selected >$i </option>";
      }
      else
      {
        $returnDayOptions .= "<option >$i </option>";
      }
   }

   return $returnDayOptions;
}


function ValidateAndConvertDateWithYear( $month, $day, $year )
{
   if( $month == 'January' )
   {
        $returnDate = $year."-01-".$day;
   }
   else if( $month == 'February' )
   {
        $returnDate = $year."-02-".$day;
   }
   else if( $month == 'March' )
   {
        $returnDate = $year."-03-".$day;
   }
   else if ( $month == 'April' )
   {
        $returnDate = $year."-04-".$day;
   }
   else if ( $month == 'May' )
   {
        $returnDate = $year."-05-".$day;
   }
   else if ( $month == 'June' )
   {
	    $returnDate = $year."-06-".$day;
   }
   else if ( $month == 'July' )
   {
	    $returnDate = $year."-07-".$day;
   }
   else if ( $month == 'August' )
   {
	    $returnDate = $year."-08-".$day;
   }
   else if ( $month == 'Septemper' )
   {
	    $returnDate = $year."-09-".$day;
   }
   else if ( $month == 'October' )
   {
	    $returnDate = $year."-10-".$day;
   }
   else if ( $month == 'November' )
   {
	    $returnDate = $year."-11-".$day;
   }
   else if ( $month == 'December' )
   {
	    $returnDate = $year."-12-".$day;
   }
   else
   {
        die('<p>Error: invalid month! Month = '.$month .' <a href="login.php">Return to coaches area.</a></p>');
   }

   return $returnDate;
}




function ValidateAndConvertDate( $month, $day )
{
   $year= GetCurrentSeasonYear();
   if( $month == 'January' )
   {
        $returnDate = $year."-01-".$day;
   }
   else if( $month == 'February' )
   {
        $returnDate = $year."-02-".$day;
   }
   else if( $month == 'March' )
   {
        $returnDate = $year."-03-".$day;
   }
   else if ( $month == 'April' )
   {
        $returnDate = $year."-04-".$day;
   }
   else if ( $month == 'May' )
   {
        $returnDate = $year."-05-".$day;
   }
   else if ( $month == 'June' )
   {
	    $returnDate = $year."-06-".$day;
   }
   else if ( $month == 'July' )
   {
	    $returnDate = $year."-07-".$day;
   }
   else if ( $month == 'August' )
   {
	    $returnDate = $year."-08-".$day;
   }
   else if ( $month == 'Septemper' )
   {
	    $returnDate = $year."-09-".$day;
   }
   else if ( $month == 'October' )
   {
	    $returnDate = $year."-10-".$day;
   }
   else if ( $month == 'November' )
   {
	    $returnDate = $year."-11-".$day;
   }
   else if ( $month == 'December' )
   {
	    $returnDate = $year."-12-".$day;
   }
   else
   {
        die('<p>Error: invalid month! Month = '.$month .' <a href="login.php">Return to coaches area.</a></p>');
   }

   return $returnDate;
}

function ValidateAndConvertDateCurrentYear( $month, $day )
{
   $year= date("Y");
   if( $month == 'January' )
   {
        $returnDate = $year."-01-".$day;
   }
   else if( $month == 'February' )
   {
        $returnDate = $year."-02-".$day;
   }
   else if( $month == 'March' )
   {
        $returnDate = $year."-03-".$day;
   }
   else if ( $month == 'April' )
   {
        $returnDate = $year."-04-".$day;
   }
   else if ( $month == 'May' )
   {
        $returnDate = $year."-05-".$day;
   }
   else if ( $month == 'June' )
   {
	    $returnDate = $year."-06-".$day;
   }
   else if ( $month == 'July' )
   {
	    $returnDate = $year."-07-".$day;
   }
   else if ( $month == 'August' )
   {
	    $returnDate = $year."-08-".$day;
   }
   else if ( $month == 'September' )
   {
	    $returnDate = $year."-09-".$day;
   }
   else if ( $month == 'October' )
   {
	    $returnDate = $year."-10-".$day;
   }
   else if ( $month == 'November' )
   {
	    $returnDate = $year."-11-".$day;
   }
   else if ( $month == 'December' )
   {
	    $returnDate = $year."-12-".$day;
   }
   else
   {
        die('<p>Error: invalid month! Month = '.$month .' <a href="login.php">Return to coaches area.</a></p>');
   }

   return $returnDate;
}

function CreateStateOptions( $previousValue='OH' )
{
        $stateArray = array ('AL','AL','AK','AZ','AR','CA','CO','CT','DE','DC','FL','GA','HI','ID','IL','IN',
                       'IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ',
                       'NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA',
                       'WA','WV','WI','WY');
   foreach ( $stateArray as $i )
   {
      if( $previousValue == $i )
      {
        $returnStateOptions .= "<option selected >$i </option>";
      }
      else
      {
        $returnStateOptions .= "<option >$i </option>";
      }
   }

   return $returnStateOptions;
}

function FigurePointsPerGame( $TeamName, $Points )
{
    $TeamId = GetTeamID( $TeamName );
    echo('<p>Test ID : ' . $TeamId . '</p>');
        $GameTotal = 0;
    $sql = "SELECT COUNT('Schedule.Game_ID') as GameTotal
           FROM Schedule LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
                   LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
                   WHERE (Game_Level = 'Varsity') AND (HomeTeam_ID = '$TeamId' OR AwayTeam_ID = '$TeamId')";
    $result = @mysql_query($sql);
        if (!$result)
    {
        echo('<p>Error finding points per game: ' . mysql_error() . '</p>');
    }

    while( $row = mysql_fetch_array($result) )
    {
        $GameTotal = $row[GameTotal];
    }

    echo('<p>Test : ' . $GameTotal . '</p>');
    $returnPPG = $Points / $GameTotal;

    return $returnPPG;
}

function CreateContactTypeOptions( $previousValue='Head Coach' )
{
   $test = array('Head Coach','Assistant Coach','Parent Rep');
   foreach( $test as $i)
   {
        if ( $previousValue == $i)
        {
                $returnContactTypeOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else
        {
                $returnContactTypeOptions .= "<OPTION> $i </OPTION>";
        }
   }

   return $returnContactTypeOptions;
}

function ShowContacts( $teamId, $showType='normal' )
{
   $sql = "SELECT *
        FROM ContactInfoTeamsList, ContactType as CT, ContactInfo as CI
        WHERE CI.Id = CID  AND CT.ID = CTID AND TID = '$teamId'";

   $result = @mysql_query($sql);
   if (!$result)
   {
        die('<p>Error performing query: ' . mysql_error() . '</p>');
   }

  while ( $row = mysql_fetch_array($result) )
  {
    ShowContact( $row, $showType, $teamId );
  }
  if( $showType == EDIT )
  {
    echo('<TR>
             <TD>&nbsp;</TD>
             <TD>&nbsp;</TD>
             <TD>&nbsp;</TD>
             <TD><a href="'.$_SERVER['PHP_SELF'].'?page=DisplayContactInfo&teamid='.$teamId.'"> Add New Contact </a></TD>
          </TR>');
  }
}

function ShowContact( $row, $showType='normal', $teamId=0, $uid = null, $UserContactInfo=0 )
{
     //Database values
     $viewContactID = $row['Id'];
     $viewContactTeamId = $row['TID'];
     $viewContactType = $row['Type'];
     $viewContactFirstName = $row['FirstName'];
     $viewContactLastName = $row['LastName'];
     $viewContactPhoneHome = $row['PhoneHome'];
     $viewContactPhoneWork = $row['PhoneWork'];
     $viewContactPhoneCell = $row['PhoneCell'];
     $viewContactEmail = $row['Email'];
     $viewMainContact = $row['MainContact'];
     echo('
     <TR>
       <TD><B>'.$viewContactType.' </B></TD>
       <TD><B>Name:</B></TD>
       <TD><B>'.$viewContactFirstName.' '.$viewContactLastName.'</B></TD>');
       if( $showType == EDIT )
       {
          echo('
          <TD><a href="'.$_SERVER['PHP_SELF'].'?contactid='.$viewContactID.'&contacttype='.$viewContactType.'&teamid='.$viewContactTeamId.'&fname='.$viewContactFirstName.'&lname='.$viewContactLastName.'&phoneh='.$viewContactPhoneHome.'&phonew='.$viewContactPhoneWork.'&phonec='.$viewContactPhoneCell.'&email='.$viewContactEmail.'&maincontact='.$viewMainContact.'"> <img src= /HighSchool/images/icon_edit.gif></a>
              <a href="'.$_SERVER['PHP_SELF'].'?action=Delete&cid='.$viewContactID.'&teamid='.$viewContactTeamId.'"> <img src= /HighSchool/images/icon_delete.gif></a></TD>');
       }
       else if( $showType == MATCH )
       {
          echo('
          <TD> <a href="'.$_SERVER['PHP_SELF'].'?page=DisplayContactInfo&id='.$viewContactID.'&pn_uid='.$uid.'&EditTeamId='.$teamId.'"> MATCH </a> </TD>');
       }
       else
       {
          echo('<TD>&nbsp;</TD>');
       }
     echo('</TR> ');
     if( "" != $viewContactPhoneHome )
     {
        echo('<TR>
               <TD>&nbsp;</TD>
               <TD>Phone (Home):</TD>
               <TD>'.$viewContactPhoneHome.'</TD>
             </TR>');
     }
     if( ""  != $viewContactPhoneWork )
     {
        echo('<TR>
              <TD>&nbsp;</TD>
              <TD>Phone (Work):</TD>
              <TD>'.$viewContactPhoneWork.'</TD>
            </TR>');
     }
     if( ""  != $viewContactPhoneCell )
     {
        echo('<TR>
              <TD>&nbsp;</TD>
              <TD>Phone (Cell):</TD>
              <TD>'.$viewContactPhoneCell.'</TD>
            </TR>');
     }
     if( ""  != $viewContactEmail )
     {
        echo('<TR>
               <TD>&nbsp;</TD>
               <TD>Email:</TD>
               <TD>'.$viewContactEmail.'</TD>
            </TR>');
     }
     if( 1  == $viewMainContact )
     {
        echo('<TR>
               <TD>&nbsp;</TD>
               <TD>Main Contact: </TD>
			   <TD>YES </TD>
              </TR>');
     }
     else
     {
      echo('<TR>
               <TD>&nbsp;</TD>
               <TD>Main Contact: </TD>
			   <TD>NO </TD>
              </TR>');
		
	}
}

function ShowSchoolInformation( $teamId, $showType=NORMAL )
{
   $schoolName = GetTeamName($teamId);
   $row = GetTeamInfo( $teamId);
   echo('<valign="top"><font color="#000066"><b><font size="3" face="Arial, Helvetica, sans-serif">'.$schoolName.' High School</font></b></font>');
    if( $showType == EDIT )
    {
       echo('<TR>
                <TD><B>School Information</B></TD>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD><a href="EditSchoolInfo.php?teamId='.$teamId.'&address='.$row[Address].'&city='.$row[City].'&zip='.$row[Zip].'&phone='.$row[Phone].'&fax='.$row[Fax].'&homecolors='.$row[Home_Colors].'&awaycolors='.$row[Away_Colors].'&mascot='.$row[Mascot].'"> <img src= /HighSchool/images/icon_edit.gif></a></TD>
             </TR>');
    }
    else
    {
      echo('<TR>
                <TD><B>School Information</B></TD>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
                <TD>&nbsp;</TD>
             </TR>');
    }
    echo('
    <TR>
       <TD>&nbsp;</TD>
       <TD>School Address:</TD>
       <TD>'.$row[Address].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>&nbsp;</TD>
      <TD>'.$row[City].' '.$row[Zip].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>Phone:</TD>
      <TD>'.$row[Phone].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>Fax:</TD>
      <TD>'.$row[Fax].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>Home Colors</TD>
      <TD>'.$row[Home_Colors].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>Away Colors</TD>
      <TD>'.$row[Away_Colors].'</TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>Mascot</TD>
      <TD>'.$row[Mascot].'</TD>
    </TR>');
}

function ShowFieldInformation( $teamId, $showType=NORMAL )
{
   $sql = "SELECT *
   FROM Field_Info
   WHERE Team_ID = '$teamId'";

   $result = @mysql_query($sql);
   if (!$result)
   {
        die('<p>Error performing query: ' . mysql_error() . '</p>');
   }

   echo('<TR>
            <TD><B>Field Information</B></TD>
            <TD>&nbsp;</TD>
            <TD>&nbsp;</TD>
            <TD>&nbsp;</TD>
         </TR>');

   while ( $row = mysql_fetch_array($result) )
   {
     if( $showType == EDIT )
     {
       echo('
       <TR>
          <TD>&nbsp;</TD>
          <TD>Field Name:</TD>
          <TD>'.$row[Name].'</TD>
          <TD><a href="EditFieldInfo.php?teamId='.$teamId.'&fieldId='.$row[ID].'&name='.$row[Name].'&address='.$row[Address].'&city='.$row[City].'&zip='.$row[Zip].'&directions='.$row[Directions].'"> <img src= /HighSchool/images/icon_edit.gif></a>
          <a href="'.$_SERVER['PHP_SELF'].'?action=DeleteField&fid='.$row[ID].'&teamid='.$teamId.'"> <img src= /HighSchool/images/icon_delete.gif></a></TD>
       </TR>');
     }
     else
     {
       echo('
       <TR>
          <TD>&nbsp;</TD>
          <TD>Field Name:</TD>
          <TD>'.$row[Name].'</TD>
          <TD>&nbsp;</TD>
       </TR>');
     }
     echo('
     <TR>
        <TD>&nbsp;</TD>
        <TD>Field Address:</TD>
        <TD>'.$row[Address].'</TD>
     </TR>
     <TR>
        <TD>&nbsp;</TD>
        <TD>&nbsp;</TD>
        <TD>'.$row[City].' '.$row[Zip].'</TD>
     </TR>') ;
     if( ""  != $row[Directions] )
     {
       echo('
       <TR>
          <TD>&nbsp;</TD>
          <TD>Directions</TD>
          <TD>'.$row[Directions].'</TD>
       </TR>');
     }
     $link = "";
   }

   if( $showType == EDIT )
   {
     echo('<TR>
             <TD>&nbsp;</TD>
             <TD>&nbsp;</TD>
             <TD>&nbsp;</TD>
             <TD><a href="EditFieldInfo.php?teamId='.$teamId.'"> Add New Field Location </a></TD>
          </TR>');
   }
}

function ShowPlayers($row,$showType,$teamId)
{
$playersTeamName = GetTeamName($row['Team_ID']);
echo('
 <TR>
   <TD>'.$row['firstName'].' '.$row['lastName'].'</TD>
   <TD>'.$playersTeamName.'</TD>');
   if( $showType == EDIT )
   {
      echo('
      <TD><a href="EditPlayerInfo.php"> <img src=images/icon_edit.gif></a>
          <a href="'.$_SERVER['PHP_SELF'].'"> <img src=images/icon_delete.gif></a></TD>');
   }
   else if( $showType == MATCH )
   {
      echo('
      <TD> <a href="EditContactInfo.php"> MATCH </a> </TD>');
   }	
}

function GetRosterPlayers( $teamId, $level, $order = "Number", $year = null )
{
    if( null == $year ){
       $currentYear = GetCurrentSeasonYear(); 
    }
    else{
        $currentYear = $year;
    }
    
    $orderby = "";
    if( "Name" == $order )
    {
		$orderby = "Players.Last_Name";
	}
	else
	{
		$orderby = "Rosters.Number ASC";
	}
	$sql = "SELECT ID, Last_Name, First_Name, Graduation_Year, Weight, Height, School, Rosters.Position, Rosters.Number
	   FROM Rosters JOIN Players ON Players.Player_ID = Rosters.player_id 
	   WHERE Rosters.team_id = '$teamId' AND Rosters.level = '$level' AND Year = '$currentYear'
	   ORDER BY $orderby";
	   
	return RunQuery( $sql, "GetRosterPlayers");	
}

function GetPlayersToPrint( $teamId )
{
   $currentYear = GetCurrentSeasonYear();
   // Request the ID and text of all the players
   $sql = "SELECT Player_ID, Last_Name, First_Name, Graduation_Year, School
	   FROM Players WHERE Team_ID = '$teamId' 
	   ORDER BY Last_Name";

   $result = @mysql_query($sql);
   if (!$result) 
   {
      die('<p>Error trying to get players: ' .mysql_error(). '</p>');
   }

   return $result;
}

function GetTeamPlayers( $teamId )
{
   // Request the ID and text of all the players
   $sql = "SELECT Player_ID, Last_Name, First_Name, Graduation_Year
	   FROM Players WHERE Team_ID = '$teamId'
	   ORDER BY Last_Name";

   $result = @mysql_query($sql);
   if (!$result) 
   {
      die('<p>Error trying to get players: ' .mysql_error(). '</p>');
   }

   return $result;
}

function GetTeamIdPassedToPage( $checkAccess )
{
   $teamId = 0;

   if(isset($_REQUEST['teamid']))
   {
      $teamId = $_REQUEST['teamid'];
   }

   if( 0 == $teamId )
   {
      die('<p>ERROR: No team id selected!</p>');
   }

   if( TRUE == $checkAccess )
   {
      //Check to make sure current user has rights to this team
      if( 1 != $_SESSION['secreatary'] && $teamId != $_SESSION['TeamID'] )
      {
         $teamName = GetTeamName($teamId);
         die('<p>You do not have access to ' .$teamName. ' team pages.</p>');
      }
   }

   return $teamId;   
}



function InRoster( $playerId, $roster)
{  
   $year = GetCurrentSeasonYear();
   
   $sql = "SELECT *
	   FROM Rosters 
        WHERE Player_ID = '$playerId' AND level = '$roster' AND Year = '$year'"; 

   $result = RunQuery( $sql, "InRoster");

   $row = mysql_fetch_array($result);
   if( $row == 0 )
   {
      return "FALSE";
   }
   else
   {
      return "TRUE";
   } 
} 

function InRosterAll( $playerid )
{
	$sql = "SELECT *
	       FROM Rosters 
          WHERE Player_ID = '$playerId' "; 

   $result = RunQuery( $sql, "InRosterAll");

   $row = mysql_fetch_array($result);
   if( $row == 0 )
   {
      return "FALSE";
   }
   else
   {
      return "TRUE";
   } 	
} 

function RunQuery( $sql, $action = "" )
{
   $result = @mysql_query($sql);
   if (!$result) 
   {
      die('<p><strong style="color: red;">Error running query ' .$action.' : ' .mysql_error(). '</strong></p>');
   }

   return $result;
 
}

function GetPlayerNameFromId( $playerId, &$firstName, &$lastName )
{
	GetPlayerInfoFromId( $playerId, $firstName, $lastName, $gradYear, $height, $weight, $school );
}

function GetPlayerInfoFromId( $playerId, &$firstName, &$lastName, &$gradYear, &$height, &$weight, &$school )
{
   $sql = "SELECT * FROM Players WHERE Player_ID = '$playerId'";
   
   $result = RunQuery( $sql, "Getting Player Name" );
   
   if($row = mysql_fetch_array($result))
   {
      $firstName = $row[First_Name];
      $lastName = $row[Last_Name];
      $gradYear = $row[Graduation_Year];
      $height = $row[Height];
      $weight = $row[Weight];
      $school = $row[School];
   }
   else
   {
      die('<p>Error getting player name.</p>');
   }     
}

function GetLevelDescription( $level )
{
  $sql = "SELECT Level_Description FROM Levels WHERE Level_ID = '$level'";

  $result = RunQuery( $sql, "Getting level description" );

  if($row = mysql_fetch_array($result))
  {
      return $row[Level_Description];
  }
  else
  {
     die('<p>Error getting level description.</p>');
  }   
}

function GetGameLevels()
{
	$sql = "SELECT *
	        FROM levels";
	        
	return RunQuery( $sql, "GetGameLevels" );	
}

function GetLevelId( $description )
{
   $sql = "SELECT Level_ID
           FROM levels
		   WHERE Level_Description = '$description'";
		   
	$result = RunQuery( $sql, "GetLevelId");
	
	if($row = mysql_fetch_array($result))
  	{
    	return $row[Level_ID];
  	}
    else
    {
       die('<p>Error getting level id.</p>');
    }		
}

function GetPositionId( $position )
{
   $sql = "SELECT ID
           FROM position
		   WHERE Description = '$position'";
		   
	$result = RunQuery( $sql, "GetPostitionId");
	
	if($row = mysql_fetch_array($result))
  	{
    	return $row[ID];
  	}
    else
    {
       die('<p>Error getting position id.</p>');
    }		
}

function GetPositions()
{
	$sql = "SELECT *
	        FROM position";
	        
	return RunQuery( $sql, "GetPostitions" );	
}

function GetPositionDescription( $positionID )
{
  $sql = "SELECT Description FROM position WHERE ID = '$positionID'";

  $result = RunQuery( $sql, "GetPositionDescription" );

  if($row = mysql_fetch_array($result))
  {
      return $row[Description];
  }
  else
  {
     die('<p>Error getting position description.</p>');
  }   
}

function CreatePositionOptions( $previousValue=1 )
{
   $result = GetPositions();
   while( $row = mysql_fetch_array($result) )
   {
        if ( $previousValue == $row[ID])
        {
                $returnPositionOptions .= "<OPTION SELECTED VALUE=$row[ID]]> $row[Description] </OPTION>";
        }
        else
        {
                $returnPositionOptions .= "<OPTION VALUE =$row[ID]]> $row[Description] </OPTION>";
        }
   }

   return $returnPositionOptions;
}

function GetGradeOption( $previousGrade = 9 )
{
	$GradeArray = array(9,10,11,12);
	foreach( $GradeArray as $i)
	{
		if ( $previousGrade == $i)
		{
			$options .= "<OPTION SELECTED> $i </OPTION>";
		}
		else
		{
		 	$options .= "<OPTION> $i </OPTION>";
		}
	}
	
	return $options;
}

function GetGradeFromGradYear( $gradYear )
{
   $CurrentYear = GetCurrentSeasonYear();
   
   $FreshmanGradYear = $CurrentYear+3;
   $SophmoreGradYear = $CurrentYear+2;
   $JuniorGradYear = $CurrentYear+1;
   $SeniorGradYear = $CurrentYear;
	switch ($gradYear) 
	{
	case $FreshmanGradYear:
		$Grade = 9;
		break;
	case $SophmoreGradYear:
		$Grade = 10;
		break;
	case $JuniorGradYear:
		$Grade = 11;
		break;
	case $SeniorGradYear:
		$Grade = 12;
		break;
	default:
      $Grade = NA;
	}
	return $Grade;
	
}

function GetGradYear( $grade )
{
   $CurrentYear = GetCurrentSeasonYear();
	switch ($grade) 
	{
	case 9:
		$GradYear = $CurrentYear+3;
		break;
	case 10:
		$GradYear = $CurrentYear+2;
		break;
	case 11:
		$GradYear = $CurrentYear+1;
		break;
	case 12:
		$GradYear = $CurrentYear;
		break;
	}
	return $GradYear;
}


function AddNewPlayer( $FirstName, $LastName, $Grade, $Height, $Weight, $School, $TeamId)
{
	$GradYear = GetGradYear($Grade);
	$TeamName = GetTeamName($TeamId);
	$DuplicateFound = "false";

    //First check and see if player by the same name and grade already exist in the database.
    $sql = "SELECT *
             FROM Players
             WHERE First_Name = '$FirstName' AND Last_Name = '$LastName' AND Graduation_Year = '$GradYear'";

    $result = RunQuery($sql, "AddNewPlayer - Player Search");

    $row = mysql_fetch_array($result);
    if( $row == 0 )
    {
      $test = mysql_real_escape_string($Height);
    	$sql = "INSERT INTO Players SET
	            Last_Name='$LastName',
	            First_Name='$FirstName',
	            Team_ID='$TeamId',
	            School='$School',
	            Graduation_Year='$GradYear',
					Height='$test',
					Weight='$Weight'";
	            
	    RunQuery($sql, "Add Player");

	    echo('<p>'.$FirstName.' '.$LastName.' has been added to '.$TeamName.' team.</p>');
    }
    else
    {
        $DuplicateFound = "true";

        echo('<p>The player you tried to enter already exisist in the datebase.<br>
		        <b>The player you entered is:</b></p>');

        echo
        ('<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
		  <TR>
			<TD>Name</TD>
			<TD>Grade</TD>
			<TD>Team</TD>
			<TD>School</TD>
         <TD>Action</TD>
		 </TR>
         ');

         $GradeName = GetGradeNameFromGradYear( $GradYear );

	    echo
        ('<TR>
            <TD>'.$FirstName.' '.$LastName.'</TD>
            <TD>'.$GradeName.'</TD>
            <TD>'.$TeamName.'</TD>
            <TD>'.$School.'</TD>
            <TD><form action="'.$_SERVER['PHP_SELF'].'" method="post">
                <INPUT TYPE="hidden" name ="teamid" value='.$TeamId.' >
                <INPUT TYPE="hidden" name ="LastName" value='.$LastName.' >
                <INPUT TYPE="hidden" name ="FirstName" value='.$FirstName.' >
                <INPUT TYPE="hidden" name ="School" value='.$School.' >
                <INPUT TYPE="hidden" name ="Grade" value='.$Grade.' >
	            <input type="submit" name="newplayer" value="NEW PLAYER" >
                </form
            </TD>
          </TR>
          </TABLE>
	    ');

        echo('<p><b>Players already in the database with the same name and grade are:</b></p>');

        //reset pointer so we can use it again
        mysql_data_seek($result, 0);
        while ( $row = mysql_fetch_array($result) )
        {
        	$playerid_database= $row['Player_ID'];
	        $LastName_database = $row['Last_Name'];
	        $FirstName_database = $row['First_Name'];
	        $Height_database = $row['Height'];
	        $Weight_database = $row['Weight'];
	        $School_database = $row['School'];
	        $GraduationYear_database = $row['Graduation_Year'];
	        $Teamid_database = $row['Team_ID'];

	        //Now get the team name from the ID
	        $TeamName_database = GetTeamName( $Teamid_database );

	        echo('<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="100%" border="1">
	          <TR>
	            <TD>Name</TD>
	            <TD>Grade</TD>
	            <TD>Team</TD>
	            <TD>School</TD>
               <TD>Action</TD>
	          </TR>
                 ');

            $Grade_database = GetGradeNameFromGradYear( $GraduationYear_database );
            
	        echo('<TR>
	                <TD>'.$FirstName_database.' '.$LastName_database.'</TD>
	                <TD>'.$Grade_database.'</TD>
	                <TD>'.$TeamName_database.'</TD>
	                <TD>'.$School_database.'</TD>
                    <TD><form action="'.$_SERVER['PHP_SELF'].'" method="post">
	                   <INPUT TYPE="hidden" name ="teamid" value='.$TeamId.' >
                       <INPUT TYPE="hidden" name ="playerid" value='.$playerid_database.' >
                       <INPUT TYPE="hidden" name ="height" value='.$Height.' >
                       <INPUT TYPE="hidden" name ="weight" value='.$Weight.' >
                       <INPUT TYPE="hidden" name ="school" value='.$School.' >
                       <input type="submit" name="ChangeTeams" value="CHANGE TEAMS" >
                       </form>
                    </TD>
	              </TR>
	              </TABLE>
	            ');

        }

        echo('<p>You have 3 Options: </p>');
         echo('<TABLE id="Table1" cellSpacing="1" cellPadding="1" width="100%">
          <TR>
            <TD><b>1)</b></TD>
            <TD>The player I am trying to enter is not the same player in the database. Add this player to my roster.</TD>
          </TR>
          <TR>
            <TD><b>2)</b></TD>
            <TD>This player has transferred schools and is now on my team.</TD>
          </TR>
          <TR>
            <TD><b>3)</b></TD>
            <TD>This player has already been entered once for my roster so cancel this attempt.</TD>
            <TD><form action="ViewTeamRoster.php" method="post">
                <INPUT TYPE="hidden" name ="teamid" value='.$TeamId.' >
                <input type="submit" name="cancel" value="CANCEL"
            </TD>
          </TR>
          </TABLE>');
    }
}

function GetCareerPoints( $playerid )
{
	$sql = "SELECT (SUM(Goals) + SUM(Assists)) as Points
          FROM Points
          WHERE Player_ID=$playerid";
    
   $result = RunQuery( $sql, "GetCareerPoints query.");

   $points = 0;
   if( $row = mysql_fetch_array($result) )
   {
      $points = $row['Points'];	
	}
	
	return $points;
}

function GetCareerSavess( $playerid )
{
	$sql = "SELECT * FROM Saves WHERE Player_ID=$playerid";
    
   $result = RunQuery( $sql, "GetCareerSaves query.");

   $saves = 0;
   if( $row = mysql_fetch_array($result) )
   {
      $saves = $row['Saves'];	
	}
	
	return $saves;
}

function GetPlayerList( $TeamID )
{
	$currentYear = GetCurrentSeasonYear();
	$sql = "SELECT Players.Player_ID, Last_Name, First_Name, Graduation_Year, Rosters.Position, Rosters.Number
				FROM Rosters JOIN Players ON Players.Player_ID = Rosters.player_id 
	         WHERE Rosters.team_id = '$TeamID' AND Rosters.level = 1 AND Year = '$currentYear'
				ORDER BY Number";
	$result = RunQuery( $sql, "Get Player list");
	while ( $row = mysql_fetch_array($result) ) 
	{
		$PlayerID = $row['Player_ID'];
		$Number = $row['Number'];
		$FirstName = $row['First_Name'];
		$LastName = $row['Last_Name'];
		$Options .= "<option value =$PlayerID># $Number $FirstName $LastName </option>";
	}

return $Options;
}

function GetCurrentSeasonYear( ) 
{
	$ReturncurrentYear = date("Y");
	$month = date("m");
	if( $month > 7 )
	{
		$ReturncurrentYear = $ReturncurrentYear + 1;
	}
	return $ReturncurrentYear;
}

function GetIndianaTeams()
{
    $sql = "SELECT *
            FROM Teams LEFT JOIN Leagues on League = Leagues.ID
            Where Member = 1 AND Team_Name != 'TBA' AND Name = 'IHSLA'
			ORDER BY Team_Name ASC";
    $result = RunQuery( $sql, "Get Teams" );
    
    return $result;
}

function GetIndianaYouthTeams()
{
    $sql = "SELECT *
            FROM Teams LEFT JOIN Leagues on League = Leagues.ID
            Where Member = 1 AND Team_Name != 'TBA' AND Name = 'IYLA'
			ORDER BY Team_Name ASC";
    $result = RunQuery( $sql, "Get Teams" );
    
    return $result;
}

function GetYearOptions( $selectedYear )
{
	for ( $counter = GetCurrentSeasonYear(); $counter >= 2005; $counter -= 1) {
		if( $selectedYear == $counter )
		{
			$optionyear .= "<OPTION	SELECTED> $counter </OPTION>";
		}
		else
		{
			$optionyear .= "<OPTION> $counter </OPTION>";
		}
	}

	return $optionyear;
}

function CreateOfficalOptions( $date, $time, $perviousValue = 0 )
{
	$sql = "SELECT Coaches.Coach_ID, ContactInfo.FirstName, ContactInfo.LastName
				FROM Groups, GroupList, Coaches, ContactInfo
				WHERE Groups.GroupName = 'Officials'
				AND GroupList.GID = Groups.GID
				AND Coaches.Coach_ID = GroupList.UID
				AND ContactInfo.pn_uid = Coaches.Coach_ID
				GROUP BY Coaches.Coach_ID
				ORDER BY ContactInfo.LastName";
    $result = RunQuery( $sql, "Get Officals" );

    //Make NA an option 
	$option = "<OPTION SELECTED VALUE=0> NA </OPTION>";

	while ( $row = mysql_fetch_array($result) )
	{
		$firstName = $row['FirstName'];
		$lastName = $row['LastName'];
		$id = $row['Coach_ID'];
		
		if( $perviousValue == $id )
		{
			$option .= "<OPTION SELECTED VALUE=$id> $firstName $lastName </OPTION>";
		}
		else
		{
			if( FALSE == IsOfficialBlocked( $id, $date, $time ) )
			{
				$option .= "<OPTION VALUE=$id> $firstName $lastName </OPTION>";
			}
		}
    }
	return $option;
}

function IsOfficialBlocked( $uid, $date, $time )
{
	$bReturnValue = FALSE;
	$sql = "SELECT *
        FROM Official_Availability
        WHERE UID = '$uid' AND Date = '$date'";
    $result = RunQuery( $sql, "Check Offical Availability" );

    $bBlocked = FALSE;
	while($row = mysql_fetch_array($result))
	{
		//Now check to see if they have a time blocked
		$StartTime = $row['Start_Time'];
		$EndTime = $row['End_Time'];
		if( $StartTime != null && $StartTime != '00:00:00' )
		{
			if( $StartTime < $time && $EndTime > $time )
			{
				$bBlocked = TRUE;
			}
		}
		else
		{
			$bBlocked = TRUE;
		}
	}

	//now check if already scheduled
	$sql = "SELECT *
        FROM Schedule
        WHERE Date = '$date' AND
		      ( Referee = '$uid' OR
			    Umpire = '$uid' OR
				Field_Judge = '$uid')";

	$result2 = RunQuery( $sql, "Check Offical already scheduled" );

	$bScheduled = FALSE;
	while($row = mysql_fetch_array($result2))
	{
		if( $time == $row['Time'] )
		{
			$bScheduled = TRUE;
		}
	}

	if( TRUE == $bBlocked || TRUE == $bScheduled )
	{
		$bReturnValue = TRUE;
	}

	return $bReturnValue;
}


function GetFields()
{
	$sql = "SELECT *
	        FROM Field_Info
            ORDER BY Name";
	        
	return RunQuery( $sql, "GetField_Info" );	
}

function GetFieldName ( $Id )
{
	$sql = "SELECT *
	        FROM Field_Info 
			WHERE Id = '$Id'";

	$results = RunQuery( $sql, "GetField Name" );

	if($row = mysql_fetch_array($results))
	{
		$FildName = $row[Name];
    }
    else
	{
		$FildName = "NA";
    }
    return $FildName;
}

//NOTE: 49 = NA
function CreateFieldOptions( $previousValue=49 )
{  
   $result = GetFields();
   while( $row = mysql_fetch_array($result) )
   {
        if ( $previousValue == $row[ID])
        {
                $returnLocationOptions .= "<OPTION SELECTED VALUE=$row[ID]> $row[Name] </OPTION>";
        }
        else
        {
                $returnLocationOptions .= "<OPTION VALUE =$row[ID]> $row[Name] </OPTION>";
        }
   }

   return $returnLocationOptions;
}

function GetUserLastName( $Id )
{
	$returnName = "NA";
	if( $Id != 0 && $Id != NULL )
	{
		$sql = "SELECT * FROM ContactInfo WHERE pn_uid = '$Id'";
		$result = RunQuery( $sql, "GetUserName failed to get contact info" );
		if($ContactInfo = mysql_fetch_array($result))
		{
		    $returnName = $ContactInfo['FirstName'];
            $returnName .= " ";
			$returnName .= $ContactInfo['LastName'];
		}
		else
		{
			$sql = "SELECT * FROM Coaches WHERE Coach_ID = '$Id'";
			$result2 = RunQuery( $sql, "GetUserName failed to get userid" );
			if($Users = mysql_fetch_array($result2))
			{
				$returnName = $Users['User_Name'];
			}
		}
	}
	return $returnName;

}

function AddNewContact($fContactType,
                       $fTeamId,
                       $fFirstName,
                       $fLastName,
                       $fPhoneHome,
                       $fPhoneWork,
                       $fPhoneCell,
                       $fEmail,
					   $fMainContact,
					   $fpn_uid)
{

   $sql = "INSERT INTO ContactInfo SET
           FirstName = '$fFirstName',
           LastName = '$fLastName',
           PhoneHome = '$fPhoneHome',
           PhoneWork = '$fPhoneWork',
           PhoneCell = '$fPhoneCell',
           Email = '$fEmail',
		   pn_uid = '$fpn_uid'
           ";
   if (@mysql_query($sql))
   {
	  if( $fTeamId != 0 && $fTeamId != NULL )
	  {
		  //First we need to find the Contact ID just entered
		  $sql = "Select * from ContactInfo WHERE FirstName = '$fFirstName' and LastName = '$fLastName' and Email = '$fEmail'";
		  $result = RunQuery($sql, "Find Contact Just entered");

		  if( $row = mysql_fetch_array($result) )
		  {
			  $cid = $row['Id'];
		  
			  $sql = "INSERT INTO ContactInfoTeamsList SET
					  CID = '$cid',
					  TID = '$fTeamId',
					  CTID = '$fContactType',
					  MainContact = '$fMainContact'";
			  if ( @mysql_query($sql) )
			  {
				  Success("Your Contact, $fFirstName $fLastName , has been added.");
			  }
			  else
			  {
				  ErrorSQL("Unable to enter team id into ContactInfoTeamsLists $cid $fTeamId $fContactType $MainConact");
			  }
		  }
		  else
		  {
			  Error("Unable to find newly entered contact info for $fFirstName $fLastName $fEmail");
		  }
	  }
	  else
	  {
		  Success("Your Contact, $fFirstName $fLastName , has been added.");
	  }
   }
   else
   {
      ErrorSQL("Error adding contact: $fFirstName $fLastName.");
   }
} // end AddNewContact


//this is call by both UpdateTeamInfo and login.
function EnterNewContact( $bForce = FALSE )
{
   $contactContactType = $_REQUEST['EditContactType'];
   $teamId = $_REQUEST['EditTeamId'];
   $contactFirstName = $_REQUEST['EditContactFirstName'];
   $contactLastName = $_REQUEST['EditContactLastName'];
   $contactPhoneHome = $_REQUEST['EditPhoneHome'];
   $contactPhoneWork = $_REQUEST['EditPhoneWork'];
   $contactPhoneCell = $_REQUEST['EditPhoneCell'];
   $contactEmail = $_REQUEST['EditEmail'];
   $pn_uid = $_REQUEST['pn_uid'];
   $bMainContact = 0;
   
   if (isset($_REQUEST['MainContact'])) 
   {
	   //if this is set then it must be checked
		$value = $_REQUEST['MainContact'];
		$bMainContact = 1;
   }

   //First check and see if person is already in contact list
   $sql = "SELECT *
          FROM ContactInfo
          WHERE FirstName = '$contactFirstName' AND
                LastName = '$contactLastName'";

   $result = @mysql_query($sql);
   if (!$result)
   {
      die('<p>Error performing contact search query: ' .
       mysql_error() . '</p>');
   }
   $row = mysql_fetch_array($result);
   if( $row == 0 || $bForce == TRUE )
   {
      AddNewContact($contactContactType,
                    $teamId,
                    $contactFirstName,
                    $contactLastName,
                    $contactPhoneHome,
                    $contactPhoneWork,
                    $contactPhoneCell,
                    $contactEmail,
					$bMainContact,
		            $pn_uid);
   }
   else
   {
      echo('<p><B>We found a name or names matching the contact you entered. It is possbile that your contact shares the same name with some already in the database.  Please review the choices below and select the proper option. </B> </p>');

      //reset pointer so we can use it again
      mysql_data_seek($result, 0);

	  echo('<p> test main in add: '.$bMainContact.'</p>');

      echo('<p>List of contacts found mathing the name you entered: </p>');
      echo('<table cellspacing="1" cellpadding="1" border="0">
      <TR>
        <TD></TD>
        <TD></TD>
        <TD></TD>
        <TD></TD>
      </TR>');
      ShowContact($row,MATCH,$teamId,$pn_uid);
      echo('</TABLE>');

      echo('<p><B>Option 1:</B> MATCH - The contact you entered DOES match a name in the contact list above. Click the "Match" link next to the name that your entry matches.</p>');
      echo('<p><B>Option 2:</B> <a href="'.$_SERVER['PHP_SELF'].'?page=ForceNewContact&pn_uid='.$pn_uid.'&EditContactType='.$contactContactType.'&EditTeamId='.$teamId.'&EditContactFirstName='.$contactFirstName.'&EditContactLastName='.$contactLastName.'&EditPhoneHome='.$contactPhoneHome.'&EditPhoneWork='.$contactPhoneWork.'&EditPhoneCell='.$contactPhoneCell.'&EditEmail='.$contactEmail.'&MainContact='.$bMainContact.'"> ADD </a> - The name does not match any of the names in the list. Your contact just happens to share the same name. Click the "Add" link to add your contact.</p>');
      echo('<p><B>Option 3:</B> <a href="'.$_SERVER['PHP_SELF'].'?EditTeamId='.$teamId.'">CANCEL </a> - You made a mistake and want to start over.</p>');
   }
}

//called by UpdateTeamInfo and Login
function EditContactInfo($teamId = 0)
{
   $editContactId = $_POST['EditContactId'];
   $editFistName = $_POST['EditContactFirstName'];
   $editLastName = $_POST['EditContactLastName'];
   $editPhoneHome = $_POST['EditPhoneHome'];
   $editPhoneWork = $_POST['EditPhoneWork'];
   $editPhoneCell = $_POST['EditPhoneCell'];
   $editEmail = $_POST['EditEmail'];
   $edituid = $_POST['pn_uid'];
  

   $sql = "UPDATE ContactInfo SET
            FirstName='$editFistName',
			LastName='$editLastName',
            PhoneHome='$editPhoneHome',
            PhoneWork='$editPhoneWork',
            PhoneCell='$editPhoneCell',
            Email='$editEmail',
			pn_uid='$edituid'
         WHERE Id='$editContactId'";
   if (@mysql_query($sql))
   {
	  if(mysql_affected_rows())
	  {
		echo('<p><strong style="color: green;">The contact '.$editFistName.' '.$editLastName.' has been edited.</strong></p>');
	  }
   }
   else
   {
      echo('<p><strong style="color: red;">Error editing your contact: ' .
         mysql_error() . '</strong></p>');
   }

}

function DisplayEditContactInfo( $Id = nothing, $pn_uid = null, $teamid = 0 )
{
	$bNewContact = TRUE;
	$bTeamUpdate = FALSE;
	$bMainContact = 0;
	if( $teamid != 0 )
	{
		$bTeamUpdate = TRUE;
	}
	$sql = "SELECT * FROM ContactInfo WHERE Id = '$Id'";
    $result = RunQuery( $sql, "Display Edit ContactInfo search" );
	if($ContactInfo = mysql_fetch_array($result))
	{
		$bNewContact = FALSE;
		$contactFirstName = $ContactInfo['FirstName'];
		$contactLastName = $ContactInfo['LastName'];
		$contactType = $ContactInfo['ContactType'];
		$phoneHome = $ContactInfo['PhoneHome'];
		$phoneWork = $ContactInfo['PhoneWork'];
		$phoneCell = $ContactInfo['PhoneCell'];
		$email = $ContactInfo['Email'];
		if( $pn_uid == null )
		{
			$pn_uid = $ContactInfo['pn_uid'];
		}
		if( $teamid == 0 )
		{
			$teamid = $ContactInfo['TeamId'];
		}
		$ContactInfoId = $ContactInfo['Id'];
		$bMainContact = $ContactInfo['MainContact'];
	}
	
	echo('<p>Enter contact info below:</p>');
	echo('
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<table cellspacing="1" cellpadding="1" border="0">
	<TR>
	   <TD>Contact Name: </TD>
	   <TD><INPUT TYPE="text" NAME="EditContactFirstName" VALUE="'.$contactFirstName.'"  size="20"></TD>
	   <TD><INPUT TYPE="text" NAME="EditContactLastName" VALUE="'.$contactLastName.'"  size="20"></TD>
	</TR>');
	if( $bTeamUpdate == TRUE )
	{
		$contactOptions = CreateContactTypeOptions2($contactType);
		echo('<TR>
		   <TD>ContactType: </TD>
		   <TD><SELECT NAME="EditContactType">'.$contactOptions.'</SELECT></TD>
		</TR>');
	}
	echo('
	<TR>
	   <TD>Phone Home: </TD>
	   <TD><INPUT TYPE="text" NAME="EditPhoneHome" VALUE="'.$phoneHome.'"  size="20"></TD>
	</TR>
	<TR>
	   <TD>Phone Work: </TD>
	   <TD><INPUT TYPE="text" NAME="EditPhoneWork" VALUE="'.$phoneWork.'"  size="20"></TD>
	</TR>
	<TR>
	   <TD>Phone Mobile: </TD>
	   <TD><INPUT TYPE="text" NAME="EditPhoneCell" VALUE="'.$phoneCell.'"  size="20"></TD>
	</TR>
	<TR>
	   <TD>email: </TD>
	   <TD><INPUT TYPE="text" NAME="EditEmail" VALUE="'.$email.'"  size="20">
       <TD><INPUT TYPE="hidden" NAME="pn_uid" VALUE="'.$pn_uid.'"></TD>
	   <TD><INPUT TYPE="hidden" NAME="EditTeamId" VALUE="'.$teamid.'"></TD>
	   <TD><INPUT TYPE="hidden" NAME="EditContactId" VALUE="'.$ContactInfoId.'"></TD>');

	if( $bTeamUpdate == TRUE )
	{
		if ( $bMainContact == 1 )
		{
			 echo('
			<TR>
			   <TD>Main Contact: </TD>
			   <TD><INPUT TYPE="checkbox" NAME="MainContact" VALUE=1 checked="checked"  size="20"></TD>
			</TR>
			<TR>');	
		}
		else
		{
			 echo('
			<TR>
			   <TD>Main Contact: </TD>
			   <TD><INPUT TYPE="checkbox" NAME="MainContact" VALUE=0  size="20"></TD>
			</TR>
			<TR>');
			
		}
	}

	if( $bNewContact == FALSE )
	{
		echo('<TD><INPUT TYPE="hidden" NAME="page" VALUE="EditContact" >
		      <INPUT type="submit" name="NewContact" value="SUBMIT"> </TD>');
	}
	else
	{
		echo('<TD><INPUT TYPE="hidden" NAME="page" VALUE="NewContact" >
		      <INPUT type="submit" name="NewContact" value="ENTER"> </TD>');
	}
	echo('</TR></TABLE>');
}

function GetUserName( $UserId )
{
	$returnName = "NA";
	$sql = "SELECT * FROM ContactInfo WHERE pn_uid = '$UserId'";
	$result = RunQuery( $sql, "GetUserName failed to get contact info" );
	if($ContactInfo = mysql_fetch_array($result))
	{
		$returnName = $ContactInfo['FirstName'];
		$returnName .=" ";
		$returnName .= $ContactInfo['LastName'];
	}
	else
	{
		$sql = "SELECT * FROM Coaches WHERE Coach_ID = '$UserId'";
		$result2 = RunQuery( $sql, "GetUserName failed to get userid" );
		if($Users = mysql_fetch_array($result2))
		{
			$returnName = $Users['User_Name'];
		}
	}
	return $returnName;
}

function GetUserEmail( $UserId )
{
	$returnEmail = "NA";
	$sql = "SELECT Email FROM ContactInfo WHERE pn_uid = '$UserId'";
	$result = RunQuery( $sql, "GetUserEmail failed to get email info" );
	if($ContactInfo = mysql_fetch_array($result))
	{
		$returnEmail = $ContactInfo['Email'];
	}
	else
	{
		$sql = "SELECT email FROM Coaches WHERE Coach_ID = '$UserId'";
		$result2 = RunQuery( $sql, "GetUserEmail failed to get email" );
		if($Users = mysql_fetch_array($result2))
		{
			$returnEmail = $Users['email'];
		}
	}
	return $returnEmail;
}

function IsIndianaTeams( $teamid )
{
	$breturn = FALSE;
    $sql = "SELECT State
            FROM Teams
            Where Team_ID = '$teamid'";
    $result = RunQuery( $sql, "Get IsIndianaTeams" );

	if($teams = mysql_fetch_array($result))
	{
		if( "IN" == $teams['State'] )
		{
			$breturn = TRUE;
		}
	}
    
    return $breturn;
}

function UpdateUserInfo()
{
	$pn_uid = $_SESSION['CoachID'];
	$sql = "SELECT * FROM ContactInfo WHERE pn_uid = '$pn_uid'";
	$result = RunQuery( $sql, "Default view ContactInfo search" );
	$email = "";
	if($ContactInfo = mysql_fetch_array($result))
	{
		$_SESSION['ContactID'] = $ContactInfo['Id'];
		$_SESSION['CoachFirstName'] = $ContactInfo['FirstName'];
		$_SESSION['CoachLastName'] = $ContactInfo['LastName'];
		$email = $ContactInfo['Email'];
	}
	if( $email != "" )
	{
		   $sql = "UPDATE Coaches SET
            email='$email' WHERE Coach_ID ='$pn_uid'";
		   if (@mysql_query($sql))
		   {
			  if(mysql_affected_rows())
			  {
				  $_SESSION['CoachEmail'] = $email;  
			  }
		   }
		   else
		   {
			  echo('<p><strong style="color: red;">Error editing your contact: ' .
				 mysql_error() . '</strong></p>');
		   }
	}
}

function CreateLeagueOptions ( $previousValue = 1 )
{
   $sql = "SELECT * FROM Leagues";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding Leagues for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   { 
     $editLeague_ID = $row['ID'];
     $editLeague_Name = $row['Name'];
     if( $editLeague_ID == $previousValue )
     {
        $returnLeagueOptions .= "<option selected value =$editLeague_ID>$editLeague_Name </option>";
     }
     else
     {
        $returnLeagueOptions .= "<option value =$editLeague_ID>$editLeague_Name </option>";
     }
   }	

   return $returnLeagueOptions;

}

function CreateCancelOptions ( $previousValue = 1 )
{
   $sql = "SELECT * FROM CancelOptions";
   $result = @mysql_query($sql);
   if (!$result)
   {
     echo('<p>Error finding CancelOptions for option list: ' . mysql_error() . '</p>');
   }

   while ( $row = mysql_fetch_array($result) )
   { 
     $editCancel_ID = $row['cancelid'];
     $editCancel_Name = $row['cancelname'];
     if( $editLeague_ID == $previousValue )
     {
        $returnCancelOptions .= "<option selected value =$editCancel_ID>$editCancel_Name </option>";
     }
     else
     {
        $returnCancelOptions .= "<option value =$editCancel_ID>$editCancel_Name </option>";
     }
   }	

   return $returnCancelOptions;

}

function GetCancelName( $cancelID )
{
	$sql = "SELECT cancelname FROM CancelOptions WHERE cancelid = '$cancelID'";
	$result = @mysql_query($sql);
	if (!$result)
	{
        die('<p>Error performing query (GetCancelName()): ' .mysql_error() . '</p>');
    }
    if($row = mysql_fetch_array($result))
    {
        $OptionName = $row['cancelname'];
    }
    else
    {
      $OptionName = "NA";
    }
   return $OptionName;
}

function DisplayFieldInfo()
{
	echo('
	<form action='.$_SERVER['PHP_SELF'].' method="post">
	<p>Enter field info here:</p>
	<table cellspacing="1" cellpadding="1" border="0">
	<TR>
	   <TD>Field Name: </TD>
	   <TD><INPUT TYPE="text" NAME="EditName" VALUE="'.$name.'"  size="20"></TD>
	   <TD><INPUT TYPE="hidden" NAME="EditFieldId" VALUE="'.$fieldId.'"></TD>
	   <TD><INPUT TYPE="hidden" NAME="page" VALUE=Enterfield></TD>
	</TR>
	<TR>
	   <TD>Address: </TD>
	   <TD><INPUT TYPE="text" NAME="EditAddress" VALUE="'.$address.'"  size="20"></TD>
	<TR>
	   <TD>&nbsp;</TD>
	   <TD><INPUT TYPE="text" NAME="EditCity" VALUE="'.$city.'"  size="20"></TD>
	   <TD><INPUT TYPE="text" NAME="EditZip" VALUE="'.$zip.'"  size="20"></TD>
	</TR>
	<!--
	<TR>
	   <TD>Directions: </TD>
	   <TD><INPUT TYPE="text" NAME="EditDirections" VALUE="'.$Directions.'"  size="255"></TD>
	</TR>
	-->
	');
	echo('<TD><INPUT type="submit" name="NewField" value="ENTER"> </TD>');
	/*if( $bNewContact == "TRUE" )
	{
	   echo('<TD><INPUT type="submit" name="NewField" value="ENTER"> </TD>');
	}
	else
	{
	   echo('<TD><INPUT type="submit" name="EditFieldInfo" value="EDIT"> </TD>');
	}*/
	echo('</TABLE></FORM>');
}

function EnterFieldInfo()
{
   $fieldId        = $_POST['EditFieldId']; 
   $teamId         = $_POST['EditTeamId'];
   $EditName       = $_POST['EditName'];
   $EditAddress    = $_POST['EditAddress'];
   $EditCity       = $_POST['EditCity'];
   $EditZip        = $_POST['EditZip'];
   $EditPhone      = $_POST['EditDirection'];
   $sql = "Insert into Field_Info SET
            Name='$EditName',
            Address='$EditAddress',
            City='$EditCity',
            Zip='$EditZip',
            Directions='$EditDirections'";
   if (@mysql_query($sql))
   {
      echo('<p><B>Your field information has been updated.</B></p>');
   }
   else
   {
      echo('<p>Error updating your field information: ' .
         mysql_error() . '</p>');
   }
}

function Success( $message )
{
	echo('<p><strong style="color: green;">'.$message.'</strong></p>');
}

function Error( $message )
{
	echo('<p><strong style="color: red;">'.$message.'</strong></p>');
}

function ErrorSQL( $message )
{
	$sqlerror = mysql_error();
	$message .= " SQL ERROR: $sqlerror.";
	Error( $message );
}

function Debug( $message )
{
	echo('<p>DEBUG: '.$message.'</p>');
}

function GetSchedulersEmail()
{
	$ToEmail;
	$sql = "SELECT ContactInfo.Email
				FROM Groups, GroupList, Coaches, ContactInfo
				WHERE Groups.GroupName = 'Schedulers'
				AND GroupList.GID = Groups.GID
				AND Coaches.Coach_ID = GroupList.UID
				AND ContactInfo.pn_uid = Coaches.Coach_ID";

		$results = RunQuery( $sql, "Get schedular email" );

        $bFound = FALSE;
		while ($row = mysql_fetch_array($results))
		{
			$ToEmail .= $row['Email'];
			$ToEmail .= ",";
			$bFound = TRUE;
		}

		if(FALSE == $bFound )
		{
			die('<p>Error finding email address of schedular. Please contact webmaster.</p>');
		}
	return $ToEmail;
}

function GetOfficialEmail( $pn_uid )
{
	$ToEmail;
	if ( $pn_uid != 0 )
	{
		$sql = "SELECT ContactInfo.Email
					FROM  ContactInfo
					WHERE pn_uid = $pn_uid";

		$results = RunQuery( $sql, "Get official email" );

		if ( $row = mysql_fetch_array($results))
		{
			$ToEmail .= $row['Email'];
			$ToEmail .= ",";
		}
		else
		{
			die('<p>Error finding email address of official. Please contact webmaster.</p>');
		}
	}
	return $ToEmail;
}

function CreateContactTypeOptions2( $previousValue = 0 )
{
   $sql = "SELECT * FROM ContactType
           ORDER BY Type";
   $result = RunQuery($sql,"Get Contact Types");

   while ( $row = mysql_fetch_array($result) )
   { 
     $CTID = $row['ID'];
     $Type = $row['Type'];
     if( $CTID == $previousValue )
     {
        $returnTypeOptions .= "<option selected value =$CTID>$Type </option>";
     }
     else
     {
        $returnTypeOptions .= "<option value =$CTID>$Type </option>";
     }
   }	

   return $returnTypeOptions;
}

function CreateContactMainOptions( $previousValue = FALSE )
{
   $test = array('FALSE','TRUE');
   foreach( $test as $i)
   {
	 $value = 0;
	 if( 'TRUE' == $i )
	 {
		 $value = 1;
	 }

     if( $i == $previousValue )
     {
        $returnMainContactOptions .= "<option selected value =$value>$i </option>";
     }
     else
     {
        $returnMainContactOptions .= "<option value =$value>$i </option>";
     }
   }	

   return $returnMainContactOptions;
}

function TeamLeague ( $team )
{
	$league = 0;
	$sql = "SELECT league FROM Teams WHERE Team_ID = '$team'";
	$result = RunQuery($sql,"Find leage from team");
	if ( $row = mysql_fetch_array($result) )
	{
		$league = $row['league'];
	}
	return $league;
}

function CalculateResult($row)
{
	if( 0 == $row['cancelid'] )
	{
		$Result = NA;
	}
	else
	{
		$Result = $row['cancelname'];
	}
	if($row['Game_Level'] == "Varsity"){
			$Score = GetScore($row['Game_ID'], $row['homeid'], $row['awayid']);
			$HomeScore = $Score['Home'];
			$AwayScore = $Score['Away'];
			if( $HomeScore != NA && $AwayScore != NA ){
				$Result = "<A href=GameSummary.php?a=$GameId>$HomeScore - $AwayScore</a>";
			}
	}

	return $Result;
}

function CreateOccuranceOptions( $previousValue='None' ){
    //TODO: Why does remove not show up?
    $test = array('Remove','None','Week','Saturday');
    foreach( $test as $i){
        if ( $previousValue == $i){
            $returnOccuranceOptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else{
            $returnOccuranceOptions .= "<OPTION> $i </OPTION>";;
        }
    }
    
    return $returnOccuranceOptions;
}

function findday($day, $start, $end) {
    $list = array();
    $endtimestamp = strtotime($end);
    $iterator = strtotime($day, strtotime($start)); 
    echo ('<p>Start Date: '.date("m d Y", $iterator).'</p>');
    while($iterator <= $endtimestamp) { 
        $list[] = date("m d Y", $iterator);
        $iterator = strtotime("+1 weeks", $iterator); 
    }

    return $list;
}


/*function GetOfficalAssignerEmail()
{
	$sql = "SELECT *
	        FROM Coaches 
			WHERE Id = '$Id'";

	$results = RunQuery( $sql, "GetField Name" );

	if($row = mysql_fetch_array($results))
	{

	}

}*/

?>
