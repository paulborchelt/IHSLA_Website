<?php
require_once('row.php');
require_once('contactinfo_row.php');
require_once('teams_row.php');
require_once('contacttype_row.php');
require_once ('classes/mydatetime.php');
define('All_RECORDS', 1);
define('CONTACT_RECORDS', 0);
class ContactRecord_Row extends row{
    

   protected $idcontactrecord;
   protected $idcontactinfo;
   protected $Date;
   protected $info;
   
   protected $_ContactInfoObject;
   protected $_DateObject;
   
   function __construct( $array = null ){
      //if( null != $array ){
      	$this->idcontactrecord = $array['idcontactrecord'];
      	$this->idcontactinfo = $array['idcontactinfo'];
      	$this->Date = $array['Date'];
      	$this->info = $array['info'];    
        $this->_ContactInfoObject = new ContactInfo_Row($array);
        $this->_DateObject =  new MyDateTime($array['Date'], new DateTimeZone('America/New_York'));
      	
      //}

   }
   
   function getSearchStatement( $type ){
     if( All_RECORDS == $type ){
        //show all contact records
        return "left join ContactInfo ON Id = idcontactinfo";
     }
     else if ( CONTACT_RECORDS == $type ){
        //show all contacts records for a give contact info id.
        return "left join ContactInfo ON Id = idcontactinfo WHERE idcontactinfo = $this->idcontactinfo ";
     }
     else{
        throw new exception("Invalid type used for ContactRecord_Row::getSearchStatement $type ."); 
     }
     
   }
   
   function getSelectStateForNewContacts(){
     return "Select DISTINCT idcontactinfo, FirstName, LastName, PhoneHome, PhoneWork, PhoneCell, Email";
   }
   
   static function fetchContactRecordView( $sqlExecutorContacted ){
    $tpl = new Template('templates/');
    $tpl->set('result', $sqlExecutorContacted );
    return $tpl->fetch('ContactRecord.tpl.php');
   }
   
   static function fetchContactRecordForm( $id ){
    $tpl = new Template('templates/');
    $tpl->set("calendar", MyDateTime::getCalander(AllOW_PREVIOUS_DATES));
    $tpl->set("contactid", $id );
    return $tpl->fetch('ContactRecord.form.tpl.php');
   }
   
   static function fetchNewContacts( $sqlExecutorContacted, $contactypeoptions, $teamoptions){
    $tpl = new Template('templates/');
    $tpl->set('list_of_newcontacts', $sqlExecutorContacted );
    $tpl->set('submittype',Submit);
    $tpl->set('contacttypeoptions', $contactypeoptions);
    $tpl->set('teams',$teamoptions);
    return $tpl->fetch('NewContacts.tpl.php');
   }
}
?>