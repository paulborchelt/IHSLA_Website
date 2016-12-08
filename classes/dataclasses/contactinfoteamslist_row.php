<?php
require_once('row.php');
require_once('teams_row.php');
class ContactInfoTeamsList_Row extends row{
   protected $contactinfoteamslistid;
   protected $CID;
   protected $TID;
   protected $CTID;
   protected $MainContact;
   protected $NewContact;
   
   protected $_TeamObject;
   function __construct( $array ){
      //if( null != $array ){
      	$this->contactinfoteamslistid = $array['contactinfoteamslistid'];
      	$this->CID = $array['CID'];  
        $this->TID = $array['TID'];  
        $this->CTID = $array['CTID']; 
        $this->MainContact = $array['MainContact']; 
        if( isset($array['NewContact'])){
            $this->NewContact = $array['NewContact'];
        }
        else{
            $this->NewContact = 0;
        }
        
        $this->_TeamObject = new Teams_Row($array);
      //}

   }
   
   function ValidateDelete( $database ){
     if( 0 != $database->countOf("ContactRecord","idcontactinfo = $this->CID")){
        throw new Exception("A value exists in the ContactRecord table.");
     }
 
 }
   
}
?>