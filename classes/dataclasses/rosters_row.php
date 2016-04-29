<?php

require_once ('row.php');
require_once ('players_rows.php');
require_once ('levels_row.php');
require_once ('teams_row.php');
require_once ('position_row.php');
require_once ('../classes/mydatetime.php');
require_once ('../classes/rostermanager.php');
class Rosters_Row extends Row {
   protected $id;
   protected $player_id;
   protected $team_id;
   protected $level;
   protected $position;
   protected $number;
   protected $Year;

   protected $_PlayersObject;
   protected $_LevelsObject;
   protected $_PositionObject;
   protected $_TeamsObject;

   function __construct($array = null) {
      $this->id = $array['id'];
      $this->player_id = $array['player_id'];
      $this->team_id = $array['team_id'];
      $this->level = $array['level'];
      $this->position = $array['position'];
      $this->number = $array['number'];
      $this->Year = $array['Year'];
      
      $this->_PlayersObject = new Players_Row($array);
      $this->_LevelsObject = new Levels_Row($array);
      $this->_PositionObject = new Position_Row($array);
      $this->_TeamsObject = new Teams_Row($array);
      
      //It is possible that the team id might come in this form.
      if(isset($array['Team_ID']) ){
         $this->team_id = $array['Team_ID'];
      }
      
      if(!isset($array['Year']) ){
         $this->Year = MyDateTime::GetCurrentSeasonYear();
      }
   }
   
   function GetRosterByYear(){
        if( null == $this->Year){
         $year = MyDateTime::GetCurrentSeasonYear();
        }
        else{
         $year = $this->Year;
        }
        
        return "LEFT JOIN `Players` ON Rosters.player_id = Players.Player_ID
                LEFT JOIN `Levels` ON level = Level_ID
                LEFT JOIN `Position` ON Rosters.position = Position.Position_ID
                LEFT JOIN `Teams` ON Rosters.team_id = Teams.Team_ID
                WHERE Year = $year AND Rosters.team_id = $this->team_id";
    }
    
    static function getRosterManagerForm($db, $team){
      $rosterManager = new RosterManager( $db, $team);
      $tpl = new Template('../templates/');
      $tpl->set('rostermanager', $rosterManager);
      return $tpl->fetch('RosterManager.form.tpl.php');
    }
    
}
?>