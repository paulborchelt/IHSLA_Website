<?php
require_once ('accessprotected.php');
class Navigation extends AccessProtected{
   protected $subpage;
   protected $Team_ID; //Id of active team page. 
   
    function __construct($array = null, $default){
      $this->subpage = $array['subpage'];
      if( $this->subpage == null){
         $this->subpage = $default;
      }
      $this->Team_ID = $array['Team_ID'];
    }
}
?>