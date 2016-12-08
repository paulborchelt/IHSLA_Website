<?php
require_once('row.php');
require_once('contacttype_row.php');
require_once('contactinfoteamslist_row.php');
require_once ('../classes/duplicatecontactinfoexception.php');
require_once ('../classes/validateException.php');
class ContactInfo_Row extends row{
   protected $Id;
   protected $FirstName;
   protected $LastName;
   protected $PhoneHome;
   protected $PhoneWork;
   protected $PhoneCell;
   protected $Email;
   protected $pn_uid;
   
   protected $_ContactTypeObject;
   protected $_MainContactObject;
   protected $_ContactInfoTeamsListObject;
   
   private $maincontactemaillist;
   private $maincontactmailtolist;
   
   function __construct( $array = null ){
      //if( null != $array ){
         $this->pn_uid = 0;
      	$this->Id = $array['Id'];
      	$this->FirstName = $array['FirstName'];
      	$this->LastName = $array['LastName'];
      	$this->PhoneHome = $array['PhoneHome']; 
      	$this->PhoneWork = $array['PhoneWork']; 
      	$this->PhoneCell = $array['PhoneCell'];   
      	$this->Email = $array['Email'];
         if( isset( $array['pn_uid'] ))  {
            $this->pn_uid = $array['pn_uid'];
         }
         else{
            $this->pn_uid = 0;
         }
          
        $this->_ContactTypeObject = new ContactType_Row($array);
        $this->_ContactInfoTeamsListObject = new ContactInfoTeamsList_Row(array( contactinfoteamslistid => $array['contactinfoteamslistid'], 
                                                     CID => $array['CID'],
                                                     TID => $array ['TID'],
                                                     CTID => $array['CTID'],
                                                     MainContact => $array['MainContact'],
                                                     NewContact => $array['NewContact'],
                                                     Team_ID => $array['TID'],
                                                     Team_Name => $array['Team_Name'],
                                                     Address => $array['Address'],
                                                     City => $array['City'],
                                                     State => $array['State'],
                                                     ZIP => $array['ZIP'],
                                                     Phone => $array['Phone'],
                                                     Home_Colors => $array['Home_Colors'],
                                                     Away_Colors => $array['Away_Colors'],
                                                     Mascot => $array['Mascot'],
                                                     Member => $array['Member'],
                                                     League => $array['League']));
      	
      //}

   }
   
   function ValidateDelete( $database ){
   
         if( 0 != $database->countOf("ContactRecord","idcontactinfo = $this->Id")){
            throw new validateException("A value exists in the ContactRecord table.");
         }
         
         if( 0 != $database->countOf("ContactInfoTeamsList","CID = $this->Id")){
            throw new validateException("A value exists in the ContactInfoTeamList table.");
         }
         
         if( 0 != $database->countOf("Users","contactinfo_id = $this->Id")){
            throw new validateException("A value exists in the Users table.");
         }
     
     }
   
   function getStatementToFindSpecificContactInfo(){
      return "SELECT * From ContactInfo Where First_Name = '$this->First_Name' and Last_Name = '$this->Last_Name' and Graduation_Year = '$this->Graduation_Year'";
   }
     
   
   static function getForm($db, $sqlEdit, $teamID, $newcontact ){
        $tpl = new Template('../templates/');
        //$tpl->set('Type',ContactInfo_Row::GetTypeOptions($sqlEdit != NULL ? $sqlEdit->Type : NULL));
        $tpl->set('FirstName',$sqlEdit != NULL ? $sqlEdit->FirstName : NULL);
        $tpl->set('LastName',$sqlEdit != NULL ? $sqlEdit->LastName : NULL);
        $tpl->set('PhoneHome',$sqlEdit != NULL ? $sqlEdit->PhoneHome : NULL);
        $tpl->set('PhoneWork',$sqlEdit != NULL ? $sqlEdit->PhoneWork : NULL);
        $tpl->set('PhoneCell',$sqlEdit != NULL ? $sqlEdit->PhoneCell : NULL);
        $tpl->set('Email',$sqlEdit != NULL ? $sqlEdit->Email : NULL);
        $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
        $tpl->set('teamid',$teamID);
        $tpl->set('Id',$sqlEdit != NULL ? $sqlEdit->Id : NULL);
        $tpl->set('contactinfoteamslistid',$sqlEdit != NULL ? $sqlEdit->_ContactInfoTeamsListObject->contactinfoteamslistid : NULL);
        $tpl->set('contacttypeoptions',ContactType_Row::GetOptions($db, $sqlEdit != NULL ? $sqlEdit->_ContactInfoTeamsListObject->CTID : NULL));
        $tpl->set('maincontactoptions',ContactType_Row::GetMainConactOptions($db, $sqlEdit != NULL ? $sqlEdit->_ContactInfoTeamsListObject->MainContact : NULL));
        $tpl->set('newcontact',$newcontact);
		return $tpl->fetch('ContactInfo.form.tpl.php');
    }
    
    static function GetOptions( $database ){
        $sql_Statement = "SELECT * FROM ContactInfo";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $id = $row->Id;
            $firstName = $row->FirstName;
            $lastName = $row->LastName;
            {
                $options .= "<option value = $id>$firstName $lastName</OPTION>";
            }
        }       
        return $options;
    }
    
    function GetFullName(){
        if( $this->FirstName != NULL ){
            $returnName = $this->FirstName;
            $returnName .= " ";
            $returnName .= $this->LastName; 
            return $returnName;
        }
        
        return "NA"; 
    }
    
    static function GetWhereStatement( $Team_ID ){
    return "as CI, ContactInfoTeamsList, ContactType as CT
        WHERE CI.Id = CID  AND CT.ID = CTID AND TID = '$Team_ID'";
   }
   
   static function GetNewContactsWhereStatement( ){
    return " as CI, ContactInfoTeamsList , ContactType as CT, Teams
        WHERE CI.Id = CID  AND CT.ID = CTID AND Team_ID = TID AND NewContact = 1";
   }
   
   static function GetSelectStatement(){
        return "SELECT *,CT.ID as CT_ID";
   }
   
   function MainContactYesOrNo(){
       if ( $this->_ContactInfoTeamsListObject->MainContact == 1 ) {
            return Yes;
       }
       else{
            return No;
       }
   }
   
   static public function fetchTeamView( $sqlExecutor, $teamID, $edit ){
      $tpl = new Template('../templates/');
      $tpl->set('result', new RowList($sqlExecutor) ); 
      $tpl->set('teamid',$teamID); 
      $tpl->set('edit', $edit);  
		return $tpl->fetch("ContactInfoTeamView.tpl.php");
   }
   
   public function setInfoTeamsListObject( $object ){
        $this->_ContactInfoTeamsListObject = NULL;
        $this->_ContactInfoTeamsListObject = new ContactInfoTeamsList_Row( array(contactinfoteamslistid => $object->contactinfoteamslistid, 
                                                                                 CID => $object->CID, 
                                                                                 TID => $object->TID, 
                                                                                 CTID => $object->CTID,
                                                                                 MainContact => $object->MainContact));
   }
   
   public function CheckForDuplicates ($database){
        if( 0 != $database->countOf("ContactInfo","FirstName = '$this->FirstName' and LastName = '$this->LastName'")){
            $database->query("SELECT * From ContactInfo Where FirstName = '$this->FirstName' and LastName = '$this->LastName'");
            throw new DuplicateContactInfoException($database);
     }
   }
   
   static function getDuplicateForm($sqlExecutor, $contactInfo, $Team_ID, $CTID, $MainContact ){
        $tpl = new Template('../templates/');
        $tpl->set('result',$sqlExecutor);
        $tpl->set('Team_ID', $Team_ID);
        $tpl->set('CTID', $CTID);
        $tpl->set('MainContact', $MainContact);
        $tpl->set('newContactInfo', $contactInfo);
		return $tpl->fetch('DuplicateContactInfo.form.tpl.php');
    }
    
    static function getDuplicateFormUser($sqlExecutor, $contactInfo, $username ){
        $tpl = new Template('../templates/');
        $tpl->set('result',$sqlExecutor);
        $tpl->set('username', $username);
        $tpl->set('newContactInfo', $contactInfo);
		return $tpl->fetch('DuplicateUser.form.tpl.php');
    }
    
  function getPhoneHome(){
    if( null == $this->PhoneHome ){
        return "NA";
    }
    else{
        return $this->PhoneHome;
    }
  }
  
  function getPhoneCell(){
    if( null == $this->PhoneCell ){
        return "NA";
    }
    else{
        return $this->PhoneCell;
    }
  }
  
  function getPhoneWork(){
    if( null == $this->PhoneWork ){
        return "NA";
    }
    else{
        return $this->PhoneWork;
    }
  }
  
  function setEmailLists( $db ){
     //See if we can combine this with the call in ContactInfoList.php
     $sql_Statement = "SELECT * FROM ContactInfo LEFT JOIN ContactInfoTeamsList on CID = id
                                LEFT JOIN ContactType on ContactType.ID = CTID
                                LEFT JOIN Teams on TID = Team_ID WHERE MainContact = 1 AND League = 1 ";
     $db->query($sql_Statement);
     while ( $row = $db->fetchNextObject() ){
         $this->maincontactemaillist .= $row->Email;
         $this->maincontactemaillist .= "; ";
     }       
  }
  
  function getEmailList(){
   return $this->maincontactemaillist;
  }
  
  function getEmailToList(){
   return $this->maincontactmailtolist;
  }
}
?>