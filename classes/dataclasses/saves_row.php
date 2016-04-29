<?php

require_once ('row.php');
require_once ('players_rows.php');
require_once ('teams_row.php');
require_once ('position_row.php');
require_once ('rosters_row.php');
require_once ('../classes/mydatetime.php');
class Saves_Row extends Row {
   protected $Game_ID;
   protected $Player_ID;
   protected $Team_ID;
   protected $Quarter;
   protected $Saves;
   protected $Goals_Against;
   
   protected $_PlayersObject;
   protected $_TeamsObject;
   protected $_RostersObject;
   
   private $Sort;
   private $Year;

   function __construct($array = null) {
      $this->Game_ID = $array['Game_ID'];
      $this->Player_ID = $array['Player_ID'];
      $this->Team_ID = $array['Team_ID'];
      $this->Quarter = $array['Quarter'];
      $this->Saves = $array['Saves'];
      $this->Goals_Against = $array['Goals_Against'];
      
      $this->_PlayersObject = new Players_Row($array);
      $this->_TeamsObject = new Teams_Row($array);
      $this->_RostersObject = new Rosters_Row($array);
      
      if( isset($array['Sort'])){
         $this->Sort = $array['Sort'];
      }
      else{
         $this->Sort = "Saves";
      }
      
      if( isset($array['Year'])){
         $this->Year = $array['Year'];
      }
      else{
         $this->Year = MyDateTime::GetCurrentSeasonYear();
      }
   }
   
   function getAverage(){
      $shotsongoal = $this->Goals_Against + $this->Saves;
      $average = 0;
      if( $shotsongoal != 0 ){
         $average = round(($this->Saves / $shotsongoal) * 100, 2);
      }
      return $average;
   }
   
   function selectStatement(){
      return "SELECT *, SUM(Saves) as Saves, SUM(Goals_Against) as Goals_Against";
   }
   
   function GetSavesByYearAndTeam(){  
     return "LEFT JOIN `Players` ON Saves.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` ON Saves.Team_ID = Teams.Team_ID
             LEFT JOIN `Schedule` ON Saves.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Saves.Team_ID = '$this->Team_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID";
    }
    
    function GetSavesByYear(){       
     return "LEFT JOIN `Players` ON Saves.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` ON Saves.Team_ID = Teams.Team_ID
             LEFT JOIN `Schedule` ON Saves.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID";
    }
    
    function GetSavesByYearAndGame(){       
     return "LEFT JOIN `Players` ON Saves.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` ON Saves.Team_ID = Teams.Team_ID
             LEFT JOIN `Schedule` ON Saves.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Saves.Game_ID = '$this->Game_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID";
     }
             
     function GetSavesByYearAndGamePerQuarter(){       
     return "LEFT JOIN `Players` ON Saves.Player_ID = Players.Player_ID
             LEFT JOIN `Teams` ON Saves.Team_ID = Teams.Team_ID
             LEFT JOIN `Schedule` ON Saves.Game_ID = Schedule.Game_ID
             LEFT JOIN Rosters ON Players.Player_ID = Rosters.Player_ID AND Rosters.level = 1 AND Rosters.Year = '$this->Year'
             LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
             WHERE Saves.Game_ID = '$this->Game_ID' AND Year(Date) = '$this->Year'
             GROUP BY Players.Player_ID, Quarter";
             
    }
    
    function getSavesForm( $database, $teamId, $teamname, $gameId, $editsaves ){
      $tpl = new Template('../templates/');
      $tpl->set('playeroptions', Players_Row::getOptions( $database, $teamId, $editsaves != NULL ? $editsaves->Player_ID : NULL ));
      $tpl->set('Team_ID', $teamId);
      $tpl->set('Game_ID',$gameId);
      $tpl->set('teamname', $teamname);
      $tpl->set('quarteroptions', Points_Row::getQuarterOptions( $editsaves != NULL ? $editsaves->Quarter : NULL ));
      $tpl->set('Saves',$editsaves->Saves);
      $tpl->set('Goals_Against',$editsaves->Goals_Against);
      $tpl->set('Edit', $editsaves != NULL ? TRUE : FALSE);
		return $tpl->fetch('SavesAdd.form.tpl.php');
    }
    
    public function CheckForDuplicates ($database){
        if( 0 != $database->countOf("Saves","Game_ID = '$this->Game_ID' and Player_ID = '$this->Player_ID' and Quarter = '$this->Quarter'")){
            throw new Exception("Player already has stat entry for this quarter. Please select a different quarter or edit his current quarter stat.");
     }
   }
}
?>