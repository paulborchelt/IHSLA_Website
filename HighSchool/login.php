<?php
session_start();
require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/users_row.php');



function menuView($main, $user ){
   $tpl = new Template('./');
   $tpl->set('user', $user);
   $main->set('content', $tpl->fetch('../templates/menu.tpl.php'));
   echo $main->fetch('../templates/pages/main.tpl.php');
}

function DefaultView($main ){
   $main->set('content', Users_Row::getLoginForm());
   echo $main->fetch('../templates/pages/main.tpl.php');
}

function ChangePasswordView($main ){
   $main->set('content', Users_Row::getChangePasswordForm());
   echo $main->fetch('../templates/pages/main.tpl.php');
}


function getUser($db){
   $user = new Users_Row($_SESSION);
   $user_sql_executor = new SqlExecutor($db,$user);
   $user = $user_sql_executor->GetValueById();
   return $user;
}

$db = new db();

$main = new TemplateLogger($db,'./');


$action = $_REQUEST['action'];
switch ($action){
    case Logout:
		session_unset();
		session_destroy();
		DefaultView($main);
      break;
    case login:
      try{
         $user = new Users_Row($_REQUEST,$db);
         $user->login($db);
         //NOTE: To prevent a Session Fixation attact figure out how to use session_regenerate_id()
         $_SESSION[userid] = $user->userid;
      }
      catch(Exception $e){
         $main->error("User name or password was wrong.");
         DefaultView($main, $user);
         break;
      }
      menuView($main, $user);
      break;
    case viewchangepassword:
      ChangePasswordView($main);
      break;
    case changepassword:
      $user = getUser($db);
      if( $_REQUEST['currentpassword'] != $user->password){
         $main->error("Cannot change password. Current Password does not match.");
         ChangePasswordView($main);
      }
      else{
         $sqlUser = new SqlExecutor($db,$user);
         try{
            $sqlUser->UpdateValue(array(password => $_REQUEST['newpassword']));
            $main->success("Your password was changed.");
            menuView($main, $user);
         }
         catch (Exception $e){
            $main->exceptionError("Failed to set new password.", $e);
            ChangePasswordView($main);
         }
      }
      break;
    default:
        $userid = $_SESSION['userid'];
        if( NULL == $userid ){
         DefaultView($main);
        }
        else{
         $user = getUser($db);
         menuView($main, $user);
        }


}



?>
