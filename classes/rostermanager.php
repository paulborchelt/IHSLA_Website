<?php
   require_once ('../classes/sqlexecutor.php');
   require_once ('../classes/dataclasses/players_rows.php');
   require_once ('../classes/dataclasses/levels_row.php');
	class RosterManager{
	  private $database;
     private $sqlplayers;
     private $sqlLevel;
     
     private $teamObject;
     function __construct( $db, $teamObject ){
      $this->database = $db;
      $this->sqlplayers = new SqlExecutor( $this->database, new Players_Row() ); 
      $year = MyDateTime::GetCurrentSeasonYear(); 
      $this->sqlplayers->Search(Players_Row::GetWhereStatement($teamObject->Team_ID, $year));
      
      $this->sqlLevel = new SqlExecutor( clone $this->database, new Levels_Row() );
      $this->sqlLevel->Search();
      
      $this->teamObject = $teamObject;
      }
      
      static function getWhereStatement( $TeamID ){
         return "WHERE Team_ID = '$TeamID'
                     ORDER BY Last_Name";
      }
      
      function fetchNextPlayerObject(){
         return $this->sqlplayers->fetchNextObject();
      }
      
      function fetchNextLevelObject(){
         return $this->sqlLevel->fetchNextObject();
      }
      
      function resetNextLevelObject(){
         $this->sqlLevel->resetFetch();
      }
      
      function getTeam_ID(){
         return $this->teamObject->Team_ID;
      }
      
      function getTeamName(){
         return $this->teamObject->Team_Name;
      }
      
      function PlayerIsRostered( $Player_ID, $Level_ID){
         $year = MyDateTime::GetCurrentSeasonYear(); 
         $sql = "SELECT *
	              FROM Rosters 
                 WHERE Player_ID = '$Player_ID' AND level = '$Level_ID' AND Year = '$year'";
         $databaseCopy = clone $this->database;
         $databaseCopy->query($sql);
         if( 0 == $databaseCopy->numRows() )
         {
            return FALSE;
         }
         else
         {
            return TRUE;
         }
      }
      
      
      
      
     
     
	}
?>