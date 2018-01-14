<?php
class selectGame {
   
   protected $Team_ID;
   protected $datebase;
   
   function __construct( $db, $Team_ID ){
      	$this->Team_ID = $Team_ID;
         $this->datebase = $db;
   }
        
   function getGameOptions( $selectedYear ){
      $sql = "SELECT Game_ID, Date, h.Team_Name as home, h.Team_ID as homeid, a.Team_Name as away, a.Team_ID as awayid
				FROM Schedule LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
				LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
				WHERE (HomeTeam_ID = $this->Team_ID OR AwayTeam_ID = $this->Team_ID) AND Year(Date) = MyDateTime::GetCurrentSeasonYear() AND Game_Type != 'Scrimmage' AND Game_Level = 'Varsity' AND Cancel = 0
				ORDER BY Date";
            
      $this->database->query($sql_Statement);
      
      for ( $counter = MyDateTime::GetCurrentSeasonYear(); $counter >= 2005; $counter -= 1) {
      	if( $selectedYear == $counter ){
      		$optionyear .= "<OPTION	SELECTED> $counter </OPTION>";
      	}
      	else{
      		$optionyear .= "<OPTION> $counter </OPTION>";
      	}
      }
      
      return $optionyear;
}
     
   function fetchGameOptions( $select = 0 ){
      $tpl = new Template('./');
      $test = getGameOptions($select);
      $tpl->set('gameOptions', $test);
      $tpl->set('Team_ID', $this->Team_ID);
      $tpl->set('page',"Stats");
      return $tpl->fetch('templates/SelectGame.tpl.php');   
   }
}
?>