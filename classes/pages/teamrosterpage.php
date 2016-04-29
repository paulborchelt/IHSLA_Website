<?php
require_once('row.php');
class TeamRosterPage{
   private $Team_ID;
   private $level;
   private $year;
   
   function __construct( $request ){
        $this->Team_ID = $request['Team_ID'];
        $this->level = $request['level'];
        $this->year = $request['year'];
   }
   
   function displayRoster(){
      
   }
}
?>