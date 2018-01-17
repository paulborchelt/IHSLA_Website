<?php
require_once('row.php');
require_once('players_rows.php');
require_once('schedule_row.php');

class AllState_Votes_Row extends row{
   protected $ID;
   protected $Position_ID;
   protected $Team_ID;
   protected $Year;
   protected $Player_ID;
   protected $Team_Level;
   protected $Points;
   
   protected $_PlayersObject;
   protected $_PositionObject;
   
   function __construct( $array = null ){
         $this->ID = $array['ID'];
         $this->Position_ID = $array['Position_ID'];
         $this->Team_ID = $array['Team_ID'];
         $this->Year = $array['Year'];
         $this->Player_ID = $array['Player_ID'];
         $this->Team_Level = $array['Team_Level'];
         if( isset($array['Points'])){
            $this->Points = $array['Points'];
         }
         else{
            if( $this->Team_Level == 1 ){
               $this->Points = 3;
            }
            elseif ( $this->Team_Level = 2 ){
               $this->Points =1;
            }
         }
         
         $this->_PlayersObject = new Players_Row($array);
         $this->_PositionObject = new Position_Row($array);
   }
   
   static function getVotesForm($db, $Team_ID, $Position_ID, $Team_Level){
      $tpl = new Template('./');
      $tpl->set(playeroptions, AllState_Votes_Row::getOptions($db,$Team_ID, $Position_ID));
      $tpl->set(Team_ID, $Team_ID);
      $tpl->set(Position_ID, $Position_ID);
      $tpl->set(Year, MyDateTime::GetCurrentSeasonYear());
      $tpl->set(Team_Level, $Team_Level);
      return $tpl->fetch('templates/AllState_Votes.form.tpl.php');
   }
   
   static function getWhereStatement($Team_ID, $Team_Level, $Position_ID ){
      if( null == $Position_ID ){
        $positionQuery;
      }
   	else{
  		  $postionQuery = "and allstate.Position_ID = '$Position_ID'";
   	}
      $currentSeason = Schedule_Row::GetCurrentSeasonYear();
      return "as allstate LEFT JOIN Players ON allstate.Player_ID = Players.Player_ID
              LEFT JOIN Position on Position.Position_ID = allstate.Position_ID 
              WHERE allstate.Team_ID = $Team_ID and $Team_Level = Team_Level and Year = $currentSeason $postionQuery
			 ORDER BY allstate.Position_ID";
   }
   
   static function getSelectStatementForAllStateVotes(){
      return "SELECT allstate.ID, allstate.Player_ID, First_Name, Last_Name, Team_Name, Rosters.number, SUM(allstate.Points) as Points, allstate.Team_ID, Position.Description,
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
   
   static function getWhereStatementForAllStateVotes($Position_ID, $year = null ){
    if( null == $year ){
        $year = Schedule_Row::GetCurrentSeasonYear();  
    }
    if( null == $Position_ID ){
        $positionQuery;
      }
   	else{
  		  $postionQuery = "and allstate.Position_ID = '$Position_ID'";
   	}
      
      return "as allstate LEFT JOIN Players ON allstate.Player_ID = Players.Player_ID
                                 LEFT JOIN Position on Position.Position_ID = allstate.Position_ID
                                 LEFT JOIN Rosters on allstate.Player_ID = Rosters.player_id AND Rosters.level = 1 AND Rosters.Year = '$year'
                                 LEFT JOIN Teams as team ON Players.Team_ID = team.Team_ID
			                        WHERE allstate.Year = '$year' $postionQuery
			                        GROUP BY allstate.Player_ID 
			                        ORDER BY Points DESC";
   }
   
   static function getOptions( $database, $teamId, $Position_ID){
        $currentYear = MyDateTime::GetCurrentSeasonYear();
                  
          $sql = "SELECT allstate.allstatenom_id, First_Name, Last_Name, Team_Name, Rosters.number, allstate.Player_ID, Position.Description
         FROM Players LEFT JOIN Allstate_Nominations as allstate ON allstate.Player_ID = Players.Player_ID
                      LEFT JOIN Position ON Position.Position_ID = allstate.Position_ID
                      LEFT JOIN Rosters ON allstate.Player_ID = Rosters.player_id AND Rosters.level = 1 AND Rosters.Year = '$currentYear'
			             LEFT JOIN Teams ON Players.Team_ID = Teams.Team_ID
		   WHERE allstate.Year = '$currentYear' 
               and Position.Position_ID = $Position_ID 
               and Players.Team_ID != '$teamId'";
      	$database->query($sql);
         if( $database->numRows() == 0 ){
            $Options .= "<option selected value =0>NA</option>";
         }
         else{
         	while ( $row = $database->fetchNextObject() ){ 
         		$PlayerID = $row->Player_ID;
         		$Number = $row->number;
         		$FirstName = $row->First_Name;
         		$LastName = $row->Last_Name;
               $TeamName = $row->Team_Name;
               if(  0 == $database->countOf("AllState_Votes","Player_ID = $PlayerID AND Position_ID = $Position_ID and Team_ID = $teamId and Year = $currentYear" ) ) {
                 $Options .= "<option value =$PlayerID># $Number $FirstName $LastName ($TeamName) </option>"; 
               }
         	}
         }
      
         return $Options;
    }
    
    static function getTeamLevelDescription ( $Team_Level ){
      if( 1 == $Team_Level){
         return "First Team";
      }
      elseif (2 == $Team_Level){
         return "Second Team";
      }
      else{
         throw new exception("Missing Team Level");
      }
    }
    
     static function getNominationLimit( $Posistion_ID ) {
      switch ($Posistion_ID){
      case 1:
         $limit = 3;
         break;
      case 2:
         $limit = 3;
         break;
      case 3: 
         $limit =3;
         break;
      case 4:
         $limit = 1;
         break;
      case 5:
         $limit = 1;
         break;
      case 6:
         $limit = 1;
         break;
      case 7:
         $limit = 1;
         break;
      default: 
         $limit = 0;
      }
      return $limit;
   }
   
   static function getPositionLimit( $Posistion_ID ) {
      switch ($Posistion_ID){
      case 1:
         $limit = 2;
         break;
      case 2:
         $limit = 2;
         break;
      case 3: 
         $limit =2;
         break;
      case 4:
         $limit = 0;
         break;
      case 5:
         $limit = 0;
         break;
      case 6:
         $limit = 0;
         break;
      case 7:
         $limit = 0;
         break;
      default: 
         $limit = -1;
      }
      return $limit;
   }
}
?>