<?php
require_once('row.php');
require_once('contactinfo_row.php');
require_once('groups_row.php');
require_once ('classes/mail.php');
class Users_Row extends row{
    protected $userid;
    protected $username;
    protected $password;
    protected $contactinfo_id;
    
    protected $_contactInfoObject;
    protected $_teamArrayObjects;
    
    private $permisions;
    
    private $fetchIndex = 0;
    
    function __construct( $array = null ){
        $this->userid = $array['userid'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->contactinfo_id = $array['contactinfo_id'];
        
        $this->_contactInfoObject = new ContactInfo_Row($array);
    }
    
    public function SetInternalObjects ($database){
      $sql = "SELECT * FROM ContactInfo WHERE Id = '$this->contactinfo_id'";
      $database->query($sql);
      if ($row = $database->queryUniqueObject($sql) ){
         $this->_contactInfoObject = new ContactInfo_Row($row);
      }
      else{
         throw new Exception("Unable to set Internal Contact Info Object for users_row class");
      }
      
      $sql = "SELECT * FROM UserTeamList LEFT JOIN Teams on TID = Team_ID WHERE teamlist_userid = '$this->userid'";
      $database->query($sql);
      $count = 0;
      while ( $teamObject = $database->fetchNextObject() ){
         $this->_teamArrayObjects[$count] = $teamObject;
         $count = $count +1;
      }
      
      //Now figure out permissions 
		$sql = "SELECT * FROM GroupList WHERE UID = '$this->userid'";
		$database->query($sql);
		while ( $row = $database->fetchNextObject() ) 
		{
			Groups_Row::setflag($this->permisions,$row->GID);
		}
   }
    
    function login( $database ){
      $sql = "SELECT * FROM Users LEFT JOIN ContactInfo on contactinfo_id = id  WHERE username = '$this->username' AND password = '$this->password'";
      $database->query($sql);
      if ( NULL == $user = $database->fetchNextArray() ){
         throw new Exception("A value exists in the ContactInfoTeamList table.");
      }
      else{
         $this->userid = $user['userid'];
         $this->_contactInfoObject = new ContactInfo_Row($user);
      }
      $sql = "SELECT * FROM UserTeamList LEFT JOIN Teams on TID = Team_ID WHERE teamlist_userid = '$this->userid'";
      $database->query($sql);
      $count = 0;
      while ( $teamObject = $database->fetchNextObject() ){
         $this->_teamArrayObjects[$count] = $teamObject;
         $count = $count +1;
      }
    }
    
    function fetchNextTeamObject(){
      $returnObject = $this->_teamArrayObjects[$this->fetchIndex];
      $this->fetchIndex = $this->fetchIndex + 1;
      return $returnObject;
      
    }
    
    static function getLoginForm(){
      $tpl = new Template('templates/');
      return $tpl->fetch('DisplayLogin.form.tpl.php');
    }
    
    static function getChangePasswordForm(){
      $tpl = new Template('templates/');
      return $tpl->fetch('DisplayChangePassword.form.tpl.php');
    }
    
   static function Authentication($db){
      session_start();
      if( NULL == $_SESSION['userid'] ){
      	header('Location: login.php');
      }
      else{
         $user = new Users_Row($_SESSION);
         $user_sql_executor = new SqlExecutor($db,$user);
         $user = $user_sql_executor->GetValueById();
         return $user;
      }
   }
   
   function hasPermisions($Permisions){
      return $this->permisions & $Permisions;
   }
   
   function GetWhereStatement( ){
        return "LEFT JOIN ContactInfo ON contactinfo_id = id 
               ORDER BY LastName";
   }
   
   function getPermissionWhereStatement(){
      return "LEFT JOIN Users on UID = userid 
              LEFT JOIN Groups on Groups.GID = GroupList.GID
              WHERE UID = $this->userid";
   }
   
   function getUserNewForm($edit=null){
      $tpl = new Template('templates/');
      return $tpl->fetch('UserNew.form.tpl.php');
   }
   
   function generateNewPassword(){
      $this->password = Users_Row::genRandStr(5,10);
   }
   
   function SendEmail( $database ){
   	$message = "<html><p>A new account at indianalacrose.org/HighSchool/ has been created for you. Below you will find your user name and password. Please go to www.indianalacrosse.org/HighSchool/login.php to login. Once logged in you can change your password.</p>";
						$message .="<p><table><tr><td>user name</td><td>$this->username</td></tr><tr><td>password</td><td>$this->password</td></tr></table></p></html>";
      
      $to = $this->getUsersEmail($database);
      $mail = new mail($message, "IHSLA new user account",$to, "ihsla@indianalacrosse.org");
      $mail->Send();
    }
    
    function getUsersEmail( $database ){
      $sql = "Select Email from ContactInfo Where Id = $this->contactinfo_id";
      return $database->queryUniqueObject($sql)->Email;
    }
    
    static function genRandStr($minLen, $maxLen, $alphaLower = 1, $alphaUpper = 1, $num = 1, $batch = 1) {
    
    $alphaLowerArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    $alphaUpperArray = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $numArray = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    
    if (isset($minLen) && isset($maxLen)) {
        if ($minLen == $maxLen) {
            $strLen = $minLen;
        } else {
            $strLen = rand($minLen, $maxLen);
        }
        $merged = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
        
        if ($alphaLower == 1 && $alphaUpper == 1 && $num == 1) {
            $finalArray = array_merge($alphaLowerArray, $alphaUpperArray, $numArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 1 && $num == 0) {
            $finalArray = array_merge($alphaLowerArray, $alphaUpperArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 1) {
            $finalArray = array_merge($alphaLowerArray, $numArray);
        } elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 1) {
            $finalArray = array_merge($alphaUpperArray, $numArray);
        } elseif ($alphaLower == 1 && $alphaUpper == 0 && $num == 0) {
            $finalArray = $alphaLowerArray;
        } elseif ($alphaLower == 0 && $alphaUpper == 1 && $num == 0) {
            $finalArray = $alphaUpperArray;                        
        } elseif ($alphaLower == 0 && $alphaUpper == 0 && $num == 1) {
            $finalArray = $numArray;
        } else {
            return FALSE;
        }
        
        $count = count($finalArray);
        
        if ($batch == 1) {
            $str = '';
            $i = 1;
            while ($i <= $strLen) {
                $rand = rand(0, $count);
                $newChar = $finalArray[$rand];
                $str .= $newChar;
                $i++;
            }
            $result = $str;
        } else {
            $j = 1;
            $result = array();
            while ($j <= $batch) { 
                $str = '';
                $i = 1;
                while ($i <= $strLen) {
                    $rand = rand(0, $count);
                    $newChar = $finalArray[$rand];
                    $str .= $newChar;
                    $i++;
                }
                $result[] = $str;
                $j++;
            }
        }
        
        return $result;
    }
}
}
?>