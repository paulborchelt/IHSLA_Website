<?php
require_once ('accessprotected.php');
class Score extends AccessProtected{
   
   protected $homeScore;
   protected $awayScore;
   protected $_HomeTeamObject;
   protected $_AwayTeamObject;
   protected $scoreSetHome;
   protected $scoreSetAway;   
   protected $homeQuarterScore;
   protected $awayQuarterScore;

   
   function __construct( $array = NULL){
      if( isset($array['homeScore'])){
         $this->homeScore = $array['homeScore'];
         $this->scoreSetHome = TRUE;
      }
      else{
         $this->homeScore = 0;
         $this->scoreSetHome = FALSE;
      }
      if( isset($array['awayScore'])){
         $this->awayScore = $array['awayScore'];
         $this->scoreSetAway = TRUE;
      }
      else{
         $this->awayScore = 
         $this->scoreSetAway = FALSE;
      } 
      
      $this->homeQuarterScore[1] = 0;  
      $this->homeQuarterScore[2] = 0;  
      $this->homeQuarterScore[3] = 0;  
      $this->homeQuarterScore[4] = 0; 
      
      $this->awayQuarterScore[1] = 0;  
      $this->awayQuarterScore[2] = 0;  
      $this->awayQuarterScore[3] = 0;  
      $this->awayQuarterScore[4] = 0;           
   }
	function setHomeScore( $score ){
	  $this->scoreSetHome = TRUE;
	  $this->homeScore = $score;
   }
   function setHomeTeam( $object ){
     
	  $this->_HomeTeamObject = $object;
   }
   function setAwayScore( $score ){
     $this->scoreSetAway = TRUE;      
	  $this->awayScore = $score;
   }
   function setAwayTeam( $object ){
	  $this->_AwayTeamObject = $object;
   }
   
   function setHomeScoreQuarter ( $quarter, $score ){
      
      //account for overtime scores:
      if( $quarter > 4 ){
         //add missing overtimes 
         while ( sizeof($this->homeQuarterScore) !=  $quarter - 1){
            $this->homeQuarterScore[sizeof($this->homeQuarterScore) + 1] = 0;
            $this->awayQuarterScore[sizeof($this->homeQuarterScore) + 1] = 0;
         }
         $this->awayQuarterScore[sizeof($this->homeQuarterScore) + 2] = 0; 
      }
      
      $this->homeQuarterScore[$quarter] = $score; 
      $this->homeScore = $this->homeScore + $score;
   }
   
   function setAwayScoreQuarter ( $quarter, $score ){
      
      //account for overtime scores:
      if( $quarter > 4 ){
         //add missing overtimes 
         while ( sizeof($this->awayQuarterScore) !=  $quarter - 1){
            $this->awayQuarterScore[sizeof($this->awayQuarterScore) + 1] = 0;
            $this->homeQuarterScore[sizeof($this->awayQuarterScore) + 1] = 0;
         }
         $this->homeQuarterScore[sizeof($this->awayQuarterScore) + 2] = 0;
      }
      
      $this->awayQuarterScore[$quarter] = $score; 
      $this->awayScore = $this->awayScore + $score;
   }
}
?>