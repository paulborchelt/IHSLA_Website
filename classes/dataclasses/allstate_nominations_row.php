<?
require_once('row.php');
require_once('players_rows.php');

class Allstate_Nominations_Row extends row{
   protected $allstatenom_id;
   protected $Player_ID;
   protected $Position_ID;
   protected $Text;
   protected $Year;
   
   protected $_PlayersObject;
   protected $_PositionObject;
   
   function __construct( $array = null ){
         $this->allstatenom_id = $array['allstatenom_id'];
         $this->Player_ID = $array['Player_ID'];
         $this->Position_ID = $array['Position_ID'];
         $this->Text = $array['Text'];
         $this->Year = $array['Year'];
         
         $this->_PlayersObject = new Players_Row($array);
         $this->_PositionObject = new Position_Row($array);
   }
   
   static function getWhereStatement($Team_ID, $Position_ID ){
      if( null == $Position_ID ){
        $positionQuery;
      }
   	else{
  		  $postionQuery = "and allstate.Position_ID = '$Position_ID'";
   	}
      $currentSeason = Schedule_Row::GetCurrentSeasonYear();
      return "as allstate LEFT JOIN Players ON allstate.Player_ID = Players.Player_ID
              LEFT JOIN Position on Position.Position_ID = allstate.Position_ID WHERE Team_ID = $Team_ID and Year = $currentSeason $postionQuery
			 ORDER BY allstate.Position_ID";
   }
   
   static function getNominationForm($db, $Team_ID, $Position_ID){
      $tpl = new Template('./');
      $tpl->set(playeroptions, Players_Row::getOptions($db,$Team_ID));
      $tpl->set(Team_ID, $Team_ID);
      $tpl->set(Position_ID, $Position_ID);
      $tpl->set(Year, MyDateTime::GetCurrentSeasonYear());
      return $tpl->fetch('../templates/Allstate_Nominations.form.tpl.php');
   }
   
   static function getNextPosition($db, $position){
      $nextPosition;
      switch ($position){ 
   	case 1: 
         $nextPosition = new Position_Row(array(Position_ID => 2));
         break;
   	case 2:
         $nextPosition = new Position_Row(array(Position_ID => 3));
         break;
   	case 3:
         $nextPosition = new Position_Row(array(Position_ID => 4));
         break;
      case 4:
         $nextPosition = new Position_Row(array(Position_ID => 5));
  	      break;
      case 5:
         $nextPosition = new Position_Row(array(Position_ID => 6));
  	      break;
      case 6:
         $nextPosition = new Position_Row(array(Position_ID => 7));
         break;
   	default :
         $nextPosition = null;
      }
      
      if( 7 == $nextPosition->Position_ID){
         return $nextPosition;
      }
      else{
         $sqlexecutor = new SqlExecutor($db,$nextPosition);
         return $sqlexecutor->GetValueById();
      }
      
   }
   
   static function getNominationLimit( $Posistion_ID ) {
      switch ($Posistion_ID){
      case 1:
         $limit = 3;
         break;
      case 2:
         $limit = 6;
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
      default: 
         $limit = 0;
      }
      return $limit;
   }
   
   static function getNominationTeamLimit( $db, $teamid ) {
      $sql = "SELECT ranking from laxpower_ranking where teamid = $teamid";
     	$row = $database->queryUniqueArray($sql);
      
      if ( $row->ranking < 9 ){
         $limit = 13;
      }
      else if ( $row->ranking > 8 && $row->ranking < 17 ){
         $limit = 7;
      }
      else if ( $row->ranking > 17 && $row->ranking < 27 ){
         $limit = 3;
      }
      else{
         $limit = 1;
      }
            
      return $limit;
   }
   
   static function getTotalNominations ( $db, $teamid ){
      $currentSeason = Schedule_Row::GetCurrentSeasonYear();
      $sql = "SELECT * from allstate_nominations as allstate
              LEFT JOIN Players ON allstate.Player_ID = Players.Player_ID
              WHERE Team_ID = $teamid and Year = $currentSeason ";
      $db->query($sql);
      return $db->numRows();
   }
   
}

?>