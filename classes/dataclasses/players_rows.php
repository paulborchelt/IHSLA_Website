<?php
require_once('row.php');
require_once('teams_row.php');
require_once('position_row.php');
require_once ('../classes/duplicateplayerexception.php');
class Players_Row extends Row{
    protected $Player_ID;
    protected $First_Name;
    protected $Last_Name;
    protected $Team_ID;
    protected $Position; //old
    protected $Graduation_Year;
    protected $Number;  //old
    protected $Height;
    protected $Weight;
    protected $School; //old
    protected $School_ID;
    protected $UsLacrosseNumber;
    
    protected $_teamObject;
    
    protected $_schoolObject;
    
    
    function __construct( $array = null){
         $this->Player_ID = $array['Player_ID'];
      	$this->First_Name = $array['First_Name'];
        $this->Last_Name = $array['Last_Name'];
        $this->Team_ID = $array['Team_ID'];
        
        //these columns need to be removed. They are not used any more.
        $this->Position = 0;
        $this->Number = 0;
        
        if( isset($array['Graduation_Year'])){
            $this->Graduation_Year = $array['Graduation_Year'];
        }
        else if( isset($array['Grade_Year'])){
            $this->Graduation_Year = Players_Row::GetGradYearFromGradeYear($array['Grade_Year']);
        }
        
        if( isset($array['Height'])){
            $this->Height = addslashes($array['Height']);
        }
        else{
            $this->Height = 0;
        }
        
        if(null != $array['Weight']){
            $this->Weight = $array['Weight'];
        }
        else{
            $this->Weight = 0;
        }      

        $this->School = $array['School'];
        $this->School_ID = $array['School_ID'];
        $this->UsLacrosseNumber = $array['UsLacrosseNumber'];
        $this->_teamObject = new Teams_Row(array(  Team_ID => $array['Team_Team_ID'], 
                                                     Team_Name => $array['Team_Team_Name'],
                                                     Address => $array ['Team_Address'],
                                                     City => $array['Team_City'],
                                                     State => $array['Team_State'],
                                                     ZIP => $array['Team_ZIP'],
                                                     Phone => $array['Team_Phone'],
                                                     Fax => $array['Team_Fax'],
                                                     Home_Colors => $array['Team_Home_Colors'],
                                                     Away_Colors => $array['Team_Away_Colors'],
                                                     Mascot => $array['Team_Mascot'],
                                                     OutOfState => $array['Team_OutOfState'],
                                                     Member => $array['Team_Member'],
                                                     League => $array['Team_League'],
                                                     Club => $array['Team_Club'] ));
        
        $this->_schoolObject = new Teams_Row(array(  Team_ID => $array['School_Team_ID'], 
                                                     Team_Name => $array['School_Team_Name'],
                                                     Address => $array ['School_Address'],
                                                     City => $array['School_City'],
                                                     State => $array['School_State'],
                                                     ZIP => $array['School_ZIP'],
                                                     Phone => $array['School_Phone'],
                                                     Fax => $array['School_Fax'],
                                                     Home_Colors => $array['School_Home_Colors'],
                                                     Away_Colors => $array['School_Away_Colors'],
                                                     Mascot => $array['School_Mascot'],
                                                     OutOfState => $array['School_OutOfState'],
                                                     Member => $array['School_Member'],
                                                     League => $array['School_League'],
                                                     Club => $array['School_Club'] ));
   }
   
   function ValidateDelete( $database ){
      
     $currentSeason = MyDateTime::GetCurrentSeasonYear();
     if( 0 != $database->countOf("Rosters","player_id = $this->Player_ID && $currentSeason = Year")){
        throw new Exception("A value exists in the Rosters table for the current season.");
     }
     
     if( 0 != $database->countOf("Rosters","player_id = $this->Player_ID")){
        throw new Exception("A value exists in the Rosters table.");
     }
     
   
     if( 0 != $database->countOf("Points","Player_ID = $this->Player_ID")){
        throw new Exception("A value exists in the Points table.");
     }
     
     if( 0 != $database->countOf("Saves","Player_ID = $this->Player_ID")){
        throw new Exception("A value exists in the saves table.");
     }
     
     if( 0 != $database->countOf("Allstate_Nominations","Player_ID = $this->Player_ID")){
        throw new Exception("A value exists in the allstate_nominations table.");
     }
     
     if( 0 != $database->countOf("AllState_Votes","Player_ID = $this->Player_ID")){
        throw new Exception("A value exists in the allstate_votes table.");
     }
     
     return;
   }
   
   public function CheckForDuplicates ($database){
        if( 0 != $database->countOf("Players","First_Name = '$this->First_Name' and Last_Name = '$this->Last_Name' and Graduation_Year = '$this->Graduation_Year'")){
            $database->query($this->getStateToFindSpecificPlayer());
            throw new DuplicatePlayerException($database);
     }
   }
   
   //NOTE: This is NOT a overloaded function. 
   function ValidateMove( $database ){     
     if( 0 != $database->countOf("Rosters","player_id = $this->Player_ID")){
        //NOTE: We want to throw duplicate player 
        //because we want to go to that page if we get this error.
        $database->query($this->getStateToFindSpecificPlayer());
        throw new DuplicatePlayerException($database);
     }
     
     return;
   }
   
   public function SetInternalObjects ($database){
      if( 0 != $this->Team_ID AND NULL != $this->Team_ID ){
         $sql = "SELECT * FROM Teams WHERE Team_ID = '$this->Team_ID'";
         if ($row = $database->queryUniqueArray($sql) ){
            $this->_teamObject = new Teams_Row($row);
         }
         else{
            throw new Exception("Unable to set Internal Team Object for player_row class");
         }
      }
   }
   
   static function getAdminForm($db, $listOfPlayers, $sqlEdit, $team){
        $tpl = new Template('../templates/');
        $tpl->set('list_of_players', $listOfPlayers );
        $tpl->set('First_Name', $sqlEdit != NULL ? $sqlEdit->First_Name : NULL);
        $tpl->set('Last_Name',$sqlEdit != NULL ? $sqlEdit->Last_Name : NULL);
        $tpl->set('team',$team);
        $tpl->set('Position',$sqlEdit != NULL ? $sqlEdit->Position : NULL);
        $tpl->set('gradeoptions',Players_Row::GetGradeOption($sqlEdit != NULL ? $sqlEdit->getGradeNumber() : NULL));
        $tpl->set('Number',$sqlEdit != NULL ? $sqlEdit->Number : NULL);
        $tpl->set('Height',$sqlEdit != NULL ? $sqlEdit->Height : NULL);
        $tpl->set('Weight',$sqlEdit != NULL ? $sqlEdit->Weight : NULL);
        $tpl->set('School',$sqlEdit != NULL ? $sqlEdit->School : NULL);
        $tpl->set('schooloptions',Teams_Row::GetNonIhslaTeamInIndianaOptions($db, $team->Team_ID, $sqlEdit != NULL ? $sqlEdit->School_ID : NULL));
        $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
        $tpl->set('Player_ID',$sqlEdit != NULL ? $sqlEdit->Player_ID : NULL);
        $tpl->set('UsLacrosseNumber',$sqlEdit != NULL ? $sqlEdit->UsLacrosseNumber : NULL);
        
		return $tpl->fetch('Players.form.tpl.php');
    }
    
  static function GetFourYearLow($year){
        return $year + 3;
  }
  
  static function GetGradeOption( $previousGrade = 9 ){
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
    
  static function GetWhereStatement( $Team_ID, $year ){
        $fourYearLow = Players_Row::GetFourYearLow($year);
        return "LEFT JOIN `Teams` AS school ON `School_ID` = school.Team_ID
                LEFT JOIN `Teams` AS team ON  Players.Team_ID = team.Team_ID
                WHERE Players.Team_ID = '$Team_ID' and ( Graduation_Year >= $year and Graduation_Year <=  $fourYearLow )";
   }
   
       static function GetSelectStatement()
    {
        //TODO: Add all columns needed for a schedule
        return "SELECT *, school.Team_ID as School_Team_ID, 
                          school.Team_Name as School_Team_Name,
                          school.Address as School_Address,
                          school.City as School_City,
                          school.State as School_State,
                          school.ZIP as School_ZIP,
                          school.Phone as School_Phone,
                          school.Fax as School_Fax,
                          school.Home_Colors as School_Home_Colors,
                          school.Away_Colors as School_Away_Colors,
                          school.Mascot as School_Mascot,
                          school.Member as School_Member,
                          school.League as School_League,
                          school.Club as School_Club,
                          team.Team_ID as Team_Team_ID, 
                          team.Team_Name as Team_Team_Name,
                          team.Address as Team_Address,
                          team.City as Team_City,
                          team.State as Team_State,
                          team.ZIP as Team_ZIP,
                          team.Phone as Team_Phone,
                          team.Fax as Team_Fax,
                          team.Home_Colors as Team_Home_Colors,
                          team.Away_Colors as Team_Away_Colors,
                          team.Mascot as Team_Mascot,
                          team.Member as Team_Member,
                          team.League as Team_League,
                          team.Club as Team_Club";
                           
    }
   
   function getStateToFindSpecificPlayer(){
      return "SELECT * From Players LEFT JOIN Teams on Players.Team_ID = Teams.Team_ID Where First_Name = '$this->First_Name' and Last_Name = '$this->Last_Name' and Graduation_Year = '$this->Graduation_Year'";
   }
   
   function getHeight(){
        return $this->Height != NULL && $this->Height != " " ? stripcslashes($this->Height) : "NA";
   }
   
   function getWeight(){
        return $this->Weight != NULL && $this->Weight != " " && $this->Weight != 0 ? $this->Weight : "NA";
   }
   
   function getGradeName(){
        return Players_Row::GetGradeNameFromGradYear($this->Graduation_Year);
   }
   
   function getGradeNumber(){
        return Players_Row::GetGradeNumberFromGradYear($this->Graduation_Year);
   }
   
   static function GetGradeNameFromGradYear( $GraduationYear ){
       $currentYear = MyDateTime::GetCurrentSeasonYear();
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
    
    static function GetGradeNumberFromGradYear( $GraduationYear ){
       $currentYear = MyDateTime::GetCurrentSeasonYear();
       switch( $GraduationYear - $currentYear )
            {
    		   case 0:
                   $Grade = 12;
                   break;
               case 1:
                   $Grade = 11;
                   break;
               case 2:
                   $Grade = 10;
                   break;
               case 3:
                   $Grade = 9;
                   break;
               default:
                   $Grade = NA;
                   break;
            }
    
        return $Grade;
    }
    
    static function GetGradYearFromGradeYear( $GradeYear ){
       $currentYear = MyDateTime::GetCurrentSeasonYear();
       switch( $GradeYear )
            {
    		   case 12:
                   $Grade = $currentYear;
                   break;
               case 11:
                   $Grade = $currentYear + 1;
                   break;
               case 10:
                   $Grade = $currentYear + 2;
                   break;
               case 9:
                   $Grade = $currentYear + 3;
                   break;
               default:
                   throw new Exception("Invalid grade.");
                   break;
            }
    
        return $Grade;
    }
    
    function getFullName(){
      return "$this->First_Name $this->Last_Name";
    }
    
    function getRosterAddForm($db, $roster){
      $tpl = new Template('../templates/');
      $tpl->set('player', $this);
      $tpl->set('roster', $roster);
      $tpl->set('positionoptions', Position_Row::GetOptions($db));
      return $tpl->fetch('RosterAdd.form.tpl.php');
    }
    
    static function getOptions( $database, $teamId, $previousValue = NULL){
        $currentYear = MyDateTime::GetCurrentSeasonYear();
      	$sql = "SELECT Players.Player_ID, Last_Name, First_Name, Graduation_Year, Rosters.Position, Rosters.Number
      				FROM Rosters JOIN Players ON Players.Player_ID = Rosters.player_id 
      	         WHERE Rosters.team_id = '$teamId' AND Rosters.level = 1 AND Year = '$currentYear'
      				ORDER BY Number";
      	$database->query($sql);
         if( $database->numRows() == 0 ){
            $Options .= "<option selected value =0>NA</option>";
         }
         else{
         	while ( $row = $database->fetchNextObject() ){ 
         		$PlayerID = $row->Player_ID;
         		$Number = $row->Number;
         		$FirstName = $row->First_Name;
         		$LastName = $row->Last_Name;
               if( $PlayerID == $previousValue){
                   $Options .= "<option selected value =$PlayerID># $Number $FirstName $LastName </option>";
               }
               else{
                   $Options .= "<option value =$PlayerID># $Number $FirstName $LastName </option>";
               }
         	}
         }
      
         return $Options;
    }
    static function getOptionsForPositoin( $database, $teamId, $Position_ID, $previousValue = NULL){
        $currentYear = MyDateTime::GetCurrentSeasonYear();
      	$sql = "SELECT Players.Player_ID, Last_Name, First_Name, Graduation_Year, Rosters.Position, Rosters.Number
      				FROM Rosters JOIN Players ON Players.Player_ID = Rosters.player_id 
                               JOIN Position ON Rosters.position = Position.Position_ID
      	         WHERE Rosters.team_id = '$teamId' AND Rosters.level = 1 AND Year = '$currentYear' AND Position.Position_ID = '$Position_ID'
      				ORDER BY Number";
      	$database->query($sql);
         if( $database->numRows() == 0 ){
            $Options .= "<option selected value =0>NA</option>";
         }
         else{
         	while ( $row = $database->fetchNextObject() ){ 
         		$PlayerID = $row->Player_ID;
         		$Number = $row->Number;
         		$FirstName = $row->First_Name;
         		$LastName = $row->Last_Name;
               if( $PlayerID == $previousValue){
                   $Options .= "<option selected value =$PlayerID># $Number $FirstName $LastName </option>";
               }
               else{
                   $Options .= "<option value =$PlayerID># $Number $FirstName $LastName </option>";
               }
         	}
         }
      
         return $Options;
    }
    
    static function getDuplicateForm($sqlExecutor, $player, $Team_ID ){
        $tpl = new Template('../templates/');
        $tpl->set('result',$sqlExecutor);
        $tpl->set('Team_ID', $Team_ID);
        $tpl->set('playerObject',$player);
		return $tpl->fetch('DuplicatePlayer.form.tpl.php');
    }
    
    function isSchool_IDNonMember($database){
      if( NULL != $this->School_ID && 0 != $database->countOf("Teams","$this->School_ID = Team_ID AND Member = 0")){
        return TRUE;
      }
      else{
         return FALSE;
      }
    }
}

?>