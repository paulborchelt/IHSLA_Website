<?php
require_once('row.php');
class GroupList_Row extends Row{
   protected $UID;
   protected $GID;
   
   protected $_Groups;
   protected $_Users;
   
   function __construct( $array = null){
   	$this->GID = $array['GID'];
   	$this->UID = $array['UID'];
      
      $this->_Groups = new Groups_Row($array);
      $this->_Users = new Users_Row($array);
   }
}
?>