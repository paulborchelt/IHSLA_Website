<?php
require_once('row.php');
require_once('teams_row.php');
require_once('users_row.php');
class UserTeamList_Row extends Row{
   protected $teamlist_userid;
   protected $TID;
   
   protected $_teamObject;
   protected $_userObject;
   
   function __construct( $array = null){
          	$this->teamlist_userid = $array['teamlist_userid'];
          	$this->TID = $array['TID'];
            
            $this->_teamObject = new Teams_Row($array);
            $this->_userObject = new Users_Row($array);
   }

   static function getWhereStatement($userid){
     $sql_Statement = "LEFT JOIN Teams on Team_ID = TID 
                       LEFT JOIN Users on userid = teamlist_userid
                       WHERE teamlist_userid = $userid";
     
     return $sql_Statement;
   }
}
?>