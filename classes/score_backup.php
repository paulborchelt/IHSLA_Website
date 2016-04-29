<?php
require_once ('accessprotected.php');
class Score extends AccessProtected{
   
   protected $homeScore;
   protected $awayScore;
   protected $quarters;
   protected $_HomeTeamObject;
   protected $_AwayTeamObject;
   protected $scoreSetHome;
   protected $scoreSetAway;   
   private $count;
   protected $homeQuarterScore;
   protected $awayQuarterScore;
   
   function __construct( $array = NULL){
      if( isset($array['homeScore'])){
         $this->scoreSetHome = TRUE;
      }
      else{
         $this->scoreSetHome = FALSE;
      }
      if( isset($array['awayScore'])){
         $this->scoreSetAway = TRUE;
      }
      else{
         $this->scoreSetAway = FALSE;
      }      
      $this->homeScore = $array['homeScore'];
      $this->awayScore = $array['awayScore'];
      $this->count = 0;
      
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
   
   function setQuarters( $Quarters){
      $this->quarters = $Quarters;
   }
   
   function fetchNextQuarter(){
      while( $this->count < $this->quarters){
         $this->count = $this->count + 1;
         return $this->count;
      }
      return null;
   }
   
   function resetQuarter(){
      $this->count = 0;
   }
   
   function setHomeScoreQuarter ( $quarter, $score ){
      $this->homeQuarterScore[$quarter] = $score; 
   }
   
   function setAwayScoreQuarter ( $quarter, $score ){
      $this->awayQuarterScore[$quarter] = $score; 
   }
}
?>