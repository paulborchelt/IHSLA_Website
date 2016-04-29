
<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/contactinfo_row.php');

$db = new db();

$user = Users_Row::Authentication($db);

$main = new TemplateLogger($db,'./');  

try{
    $contactInfo = new ContactInfo_Row($_REQUEST);
    $sql_ContactInfo_Executor = new SqlExecutor( $db, $contactInfo );   
}
catch(Exception $e){
    $main->error($e);
}

$action = $_REQUEST['action'];
switch ($action){
   case sendemail:
         $test = $_REQUEST['message'];
         $message = "<html><p>$test</p></html>";
         $subject = $_REQUEST['subject'];
         $contactInfo->setEmailLists($db);
         $to = $contactInfo->getEmailList();
         $to .= ";";
         $to .= $user->_contactInfoObject->Email;
         $mail = new mail($message, $subject,$to, "ihsla@indianalacrosse.org");
         $mail->Send();
         $main->set('content', "<p>Your messsage has been sent to $to.</p>");
         break;
   default :
        $contactInfo->setEmailLists($db);
        $tpl = new Template('../templates/');
        $tpl->set('mailtolinks', $contactInfo->getEmailList());
        $main->set('content', $tpl->fetch("../templates/EmailContacts.tpl.php"));
   
}

echo $main->fetch('../templates/pages/main.tpl.php');  

?>