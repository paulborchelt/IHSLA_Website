<?
class selectYear {
   
   protected $Team_ID;
   
   function __construct( $Team_ID ){
      	$this->Team_ID = $Team_ID;
   }
        
   static function getYearOptions( $selectedYear ){
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
     
   function fetchYearOptions( $select = 0, $page ){
      $tpl = new Template('./');
      $test = selectYear::getYearOptions($select);
      $tpl->set('yearOptions', $test);
      $tpl->set('Team_ID', $this->Team_ID);
      $tpl->set('subpage',$page);
      return $tpl->fetch('../templates/SelectYear.tpl.php');   
   }
}
?>