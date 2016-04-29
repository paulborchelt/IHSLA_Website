<?php

require_once ('row.php');
require_once ('players_rows.php');
require_once ('teams_row.php');
require_once ('position_row.php');
require_once ('rosters_row.php');
require_once ('../classes/mydatetime.php');
class Points_Row extends Row {
   protected $Game_ID;
   protected $Player_ID;
   protected $StatTime;
   protected $Quarter;
   protected $Team_ID;
   protected $Goals;
   protected $Assists;
   protected $GroundBalls;
   protected $Shots;
   protected $Turnovers;
   protected $CausedTurnovers;
   
   protected $_PlayersObject;
   protected $_TeamsObject;
   protected $_RostersObject;
   
   private $Sort;
   private $Year;

   function __construct($array = null) {
      $this->Game_ID = $array['Game_ID'];
      $this->Player_ID = $array['Player_ID'];
      $this->Quarter = $array['Quarter'];
      $this->Team_ID = $array['Team_ID'];
      $this->Goals = $array['Goals'];
      $this->Assists = $array['Assists'];
      $this->GroundBalls = $array['GroundBalls'];
      $this->Shots = $array['Shots'];
      $this->Turnovers = $array['Turnovers'];
      $this->CausedTurnovers = $array['CausedTurnovers'];
      $this->_PlayersObject = new Players_Row($array);
      $this->_TeamsObject = new Teams_Row($array);
      $this->_RostersObject = new Rosters_Row($array);
      
      if( isset($array['Sort'])){
         $this->Sort = $array['Sort'];
      }
      else{
         $this->Sort = "Goals";
      }
      
      if( isset($array['Year'])){
         $this->Year = $array['Year'];
      }
      else{
         $this->Year = MyDateTime::GetCurrentSeasonYear();
      }
      if( isset($array['StatTime'])){
         $this->StatTime = $array['StatTime'];
      }
      else{
         $this->StatTime = NULL;
      }
      
      
            
   }
   
   function getPoints(){
      return $this->Goals + $this->Assists;
   }
   
   function selectStatement(){
      return "SELECT *, 
              SUM(Goals) as Goals, SUM(Assists) as Assists, 
              SUM(GroundBalls) as GroundBalls, SUM(Shots) as Shots, 
              SUM(CausedTurnovers) as CausedTurnovers, SUM(Turnovers) as Turnovers,
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
   
   function GetPointsByYearAndTeam(){  
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Points.Team_ID = '$this->Team_ID' AND Year(Date) = '$this->Year' AND NOT ( Points.Goals = 0 AND Points.Assists = 0 )
             GROUP BY Players.Player_ID";
    }
    
    function GetStatsByYearAndTeam(){  
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Points.Team_ID = '$this->Team_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID";
    }
    
    function GetPointsByYear(){       
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Year(Date) = '$this->Year' AND team.Member = 1 AND NOT ( Points.Goals = 0 AND Points.Assists = 0 )
             GROUP BY Players.Player_ID";
    }
    
    function GetStatsByYear(){       
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Year(Date) = '$this->Year' AND team.Member = 1
             GROUP BY Players.Player_ID";
    }
    
    function GetPointsByYearAndGame(){       
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Points.Game_ID = '$this->Game_ID' AND Year(Date) = '$this->Year' AND NOT ( Points.Goals = 0 AND Points.Assists = 0 )
             GROUP BY Players.Player_ID";
    }
    
    function GetStatsByYearAndGamePerQuarter(){       
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Points.Game_ID = '$this->Game_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID, Quarter";
    }
    
    function GetStatsByYearAndGame(){       
     return "LEFT JOIN `Players` ON Points.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` as team ON Points.Team_ID = team.Team_ID
             LEFT JOIN `Schedule` ON Points.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Points.Game_ID = '$this->Game_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID";
    }
    
    function getStatsForm( $database, $teamId, $teamname, $gameId, $editpoints ){
      $tpl = new Template('../templates/');
      $tpl->set('playeroptions', Players_Row::getOptions( $database, $teamId, $editpoints != NULL ? $editpoints->Player_ID : NULL ));
      $tpl->set('quarteroptions', Points_Row::getQuarterOptions( $editpoints != NULL ? $editpoints->Quarter : NULL ));
      $tpl->set('Team_ID', $teamId);
      $tpl->set('Game_ID',$gameId);
      $tpl->set('teamname', $teamname);
      $tpl->set('Goals',$editpoints->Goals);
      $tpl->set('Assists',$editpoints->Assists);
      $tpl->set('GroundBalls',$editpoints->GroundBalls);
      $tpl->set('Shots',$editpoints->Shots);
      $tpl->set('Turnovers',$editpoints->Turnovers);
      $tpl->set('CausedTurnovers',$editpoints->CausedTurnovers);
      $tpl->set('Edit', $editpoints != NULL ? TRUE : FALSE);
		return $tpl->fetch('StatsAdd.form.tpl.php');
    }
    
    static function getQuarterOptions( $previousQuarter = 1 ){
    	$quarters = array(1 => "1", 2 => "2", 3 => "3",4 => "4",5 => "OT",6 => "OT 2",7 => "OT 3",8 =>"OT 4",9 => "OT 5",10 => "OT 6");
    	foreach( $quarters as $quarter => $quarterName)
    	{
    		if ( $previousQuarter == $quarter)
    		{
    			$options .= "<OPTION SELECTED value =$quarter > $quarterName </OPTION>";
    		}
    		else
    		{
    		 	$options .= "<OPTION value =$quarter > $quarterName </OPTION>";
    		}
    	}
    	
    	return $options;
    }
    
    static function getQuarterName( $quarterNumber ){
         $returnQuarterName = $quarterNumber;
         switch ( $quarterNumber ){ 
         	case 5:
               $returnQuarterName = "OT";
         	break;
         
         	case 6:
               $returnQuarterName = "OT2";
         	break;
         
         	case 7:
               $returnQuarterName = "OT3";
         	break;
            
            case 8:
               $returnQuarterName = "OT4";
         	break;
            
            case 9:
               $returnQuarterName = "OT5";
         	break;
            
            case 9:
               $returnQuarterName = "OT6";
         	break;
         
         	default :
            $returnQuarterName = $quarterNumber;
         }
         
         return $returnQuarterName;
    }
    
    public function CheckForDuplicates ($database){
        if( 0 != $database->countOf("Points","Game_ID = '$this->Game_ID' and Player_ID = '$this->Player_ID' and Quarter = '$this->Quarter'")){
            throw new Exception("Player already has stat entry for this quarter. Please select a different quarter or edit his current quarter stat.");
     }
   }
}
?>