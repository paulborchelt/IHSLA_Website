<?
class mail {
   private $message;
   private $subject;
   private $to;
   private $from;
   
   function __construct($message, $subject, $to, $from){
      $this->message = $message;
      $this->subject = $subject;
      $this->to = $to;
      $this->from = $from;
   }
   
   static function getPresidentEmail( $db ){
         $email = "pborchelt@gmail.com";
      	/*$sql = "SELECT ContactInfo.Email
      				FROM Groups, GroupList, Users, ContactInfo
      				WHERE Groups.GroupName = 'Schedulers'
      				AND GroupList.GID = Groups.GID
      				AND Users.userid = GroupList.UID
      				AND ContactInfo.Id = Users.contactinfo_id";
      
   		$database->query($sql);
         $bFound = FALSE;
         while ( $row = $database->fetchNextObject() ){
            $email .= $row->Email;
       		$email .= ",";
         }*/
      	return $email;
   }
   
   function Send(){
   	// To send HTML mail, the Content-type header must be set
   	$header  = "From: $this->from \r\n";
      $header .= "MIME-Version: 1.0 \r\n";
   	$header .= "Content-type: text/html; charset=iso-8859-1 \r\n";
   	
   
   	//mail($this->to,"$this->subject","$this->message","$header");
      TemplateLogger::Debug("Mail $this->subject to $this->to " );
      TemplateLogger::Debug($this->subject);
      TemplateLogger::Debug($this->message);
      TemplateLogger::Debug($this->header);
   }
}
?>