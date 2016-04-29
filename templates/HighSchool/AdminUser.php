<?

require_once ('../classes/database.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/dataclasses/grouplist_row.php');
require_once ('../classes/dataclasses/teams_row.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');



function DefaultDisplay($main, $db, $user, $sqlExecutorUser ){
    $sqlExecutorUser->Search($user->GetWhereStatement());
    $main->set('content', $sqlExecutorUser->fetch(array(newuserform => Users_Row::getUserNewForm())));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

function AddUserDisplay($main ){
    $main->set('content', Users_Row::getUserNewForm());
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

function EditDisplay($main, $sqlUsers ){
    $user = $sqlUsers->GetValueById();
    $main->set('content', Users_Row::getUserNewForm($user));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

function DefaultPermissions($main, $db, $sqlExecutorUser ){
    $user = $sqlExecutorUser->GetValueById();
    $tpl = new Template('../templates/');
    $grouplist = new GroupList_Row();
    $sql_Executor_GroupList = new SqlExecutor($db, $grouplist);
    $sql_Executor_GroupList->Search($user->getPermissionWhereStatement());
    $tpl->set("user",$user);
    $tpl->set("groupoptions",Groups_Row::getOptions(clone $db, clone $sql_Executor_GroupList));
    $sql_Executor_GroupList->resetFetch();
    $tpl->set('grouplist', $sql_Executor_GroupList->fetch());
    $tpl->set('teamassociation', Teams_Row::getEditUserTeamList($db,$user));
    $main->set('content', $tpl->fetch("../templates/EditPermissions.form.tpl.php"));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

function DisplayDuplicate($main, $sqlExecutor, $contactInfo, $username ){
    $main->set('content', ContactInfo_Row::getDuplicateFormUser($sqlExecutor, $contactInfo, $username));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

try{
   $db = new db();
   $main = new TemplateLogger($db,'./');
   $userLogin = Users_Row::Authentication($db);
   $user = new Users_Row($_REQUEST);
   $contactinfo = new ContactInfo_Row($_REQUEST);
   $sql_Executor_ContactInfo = new SqlExecutor( $db, $contactinfo ); 
   $sql_Executor_User = new SqlExecutor( $db, $user ); 
}
catch(Exception $e){
    $main->error($e);
}

$action = $_REQUEST['action'];
switch ($action){
    case new_user:
        try{
            AddUserDisplay($main);
        }
        catch( Exception $e ){
            $main->error("Failed to enter user. ". $e->getMessage());
            DefaultDisplay($main, $db, $user, $sql_Executor_User);
        }
   	break;
    case edit_user:
         EditDisplay($main, $sql_Executor_User);
         break;
    case insert_user:
        try{
            try{
               $Id = $sql_Executor_ContactInfo->insertAutoIncrement($_REQUEST['Force']);
            }
            catch( DuplicateContactInfoException $e ){
               //If we find a duplicate contact info just use that instead of the one we entered. 
               //$Id = $e->getSQLExecutor()->fetchNextObject()->Id;
              // $main->success("Duplicate Contact Found and Used.");
               DisplayDuplicate($main, $e->getSQLExecutor(), $contactinfo, $user->username);
               break;
            }
         $user->generateNewPassword();
         $sqlExecutorUser = new SqlExecutor($db, new users_row( array( username => $user->username, contactinfo_id => $Id, password => $user->password)));
         $sqlExecutorUser->insertAutoIncrement();
         $main->success("User has been added.");
        }
        catch( Exception $e ){
            $main->exceptionError("Failed to enter user. ", $e->getMessage());
        }
        DefaultDisplay($main, $db, $user, $sql_Executor_User);
    	break;
    case AddExistingContact:
         try{
            $user->generateNewPassword();
            $sqlExecutorUser = new SqlExecutor($db, new users_row( array( username => $user->username, contactinfo_id => $contactinfo->Id, password => $user->password)));
            $sqlExecutorUser->insertAutoIncrement();
            $main->success("Exsiting Contact now has a user account.");
        }
        catch( Exception $e ){
            $main->exceptionError("Failed to enter user. ", $e->getMessage());
        }
        DefaultDisplay($main, $db, $user, $sql_Executor_User);
        break;
    case update_user:
        try{
            $sql_Executor_User->Update();
            $main->success("User updated.");
        }
        catch( Exception $e ){
            $main->error("Failed to update user. ". $e->getMessage());
        }
        try{
            $sql_Executor_ContactInfo->Update();
            $main->success("Contact Info for user updated.");
        }
        catch( Exception $e ){
            $main->error("Failed to update contact info for user. ". $e->getMessage());
        }
        DefaultDisplay($main, $db, $user, $sql_Executor_User);
    	break;
    case delete_user:
        try{
         $sql_Executor_User->Delete();
         $deleteContact = TRUE;
         $main->success("User has been deleted.");
        }
        catch( Exception $e ){
            $main->error("Failed to delete user. ". $e->getMessage());
        }
        if(  TRUE == $deleteContact){
             try{
                $sql_Executor_ContactInfo->Delete();
                $main->success("Contact has been deleted.");
            }
            catch (validateException $e){
               $main->info("Contact will remain in the database." . $e->getMessage());
            }
            catch( Exception $e ){
                $main->error("Failed to delete contact. " . $e->getMessage());
            }
            
        }
        DefaultDisplay($main, $db, $user, $sql_Executor_User);
    	break;
    case Permissions:
        DefaultPermissions($main, $db, $sql_Executor_User);
    	break;
    case add_permissions:
      try{
         $grouplist = new GroupList_Row($_REQUEST);
         $sql_Executor_GroupList = new SqlExecutor($db, $grouplist);
         $sql_Executor_GroupList->insertAll();
      }
      catch( Exception $e ){
         $main->exceptionError("Failed to add permissions from user. ", $e->getMessage());
      }
      DefaultPermissions($main, $db, $sql_Executor_User);
      break;
    case delete_permissions:
      try{
         $grouplist = new GroupList_Row($_REQUEST);
         $sql_Executor_GroupList = new SqlExecutor($db, $grouplist);
         $sql_Executor_GroupList->DeleteWithOwnWhereStatement("Where UID = '$grouplist->UID' AND GID = '$grouplist->GID'");
      }
      catch( Exception $e ){
          $main->exceptionError("Failed to delete permissions from user. ", $e->getMessage());
      }
      DefaultPermissions($main, $db, $sql_Executor_User);
      break;
    case add_team:
      try{
         $userteamlist = new UserTeamList_Row($_REQUEST);
         $sql_Executor_UserTeamList = new SqlExecutor($db, $userteamlist);
         $sql_Executor_UserTeamList->insertAll();
      }
      catch( Exception $e ){
         $main->exceptionError("Failed to add team to user. ", $e->getMessage());
      }
      DefaultPermissions($main, $db, $sql_Executor_User);
      break;
    case delete_team:
      try{
         $userteamlist = new UserTeamList_Row($_REQUEST);
         $sql_Executor_UserTeamList = new SqlExecutor($db, $userteamlist);
         $sql_Executor_UserTeamList->DeleteWithOwnWhereStatement("Where TID = '$userteamlist->TID' AND teamlist_userid = '$userteamlist->teamlist_userid'");
      }
      catch( Exception $e ){
          $main->exceptionError("Failed to delete team from user. ", $e->getMessage());
      }
      DefaultPermissions($main, $db, $sql_Executor_User);
      break;
    default :
        DefaultDisplay($main, $db, $user, $sql_Executor_User);
    
}

?>