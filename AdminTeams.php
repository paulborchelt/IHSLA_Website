<?php
require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/dataclasses/teams_row.php');
require_once ('classes/dataclasses/contactinfo_row.php');
require_once ('classes/dataclasses/users_row.php');
require_once ('classes/sqlexecutor.php');

function DefaultDisplay($main, $sqlExecutorTeams, $db, $league, $link, $user, $sqlEdit = null ){
    $sqlExecutorTeams->Search(Teams_row::GetWhereStatement($league));
    $main->set('content', Teams_Row::getAdminForm($db, $sqlExecutorTeams->fetch(array(user => $user)), $sqlEdit, $league, $user, $link));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

$db = new db();
$main = new TemplateLogger($db,'./');
$user = Users_Row::Authentication($db);

$league = 1; //default to IHSLA (1).
if( ($_SESSION['Permisions'] & AdministratorsYouth ) ){
	$league = 2;  //Youth (IYLA) is 2
}
else{
    //NOTE:  The database uses big L so the Teams.form.tpl.php must pass submit a big L. 
    //So check for that here and us the big L else use small l
    if( isset($_REQUEST['League'] ) ){
        $league = $_REQUEST['League'];
    }
    else{
       if( isset($_REQUEST['league'] ) ){
        $league = $_REQUEST['league'];
        }    
    }
}  

try{
    $sql_Executor_Teams = new SqlExecutor( $db, new Teams_Row($_REQUEST) );   
}
catch(Exception $e){
    $main->error($e);
}

$link = null;
if( isset($_REQUEST['link'] ) ){
		$link = $_REQUEST['link'];
}

$action = $_REQUEST['action'];
switch ($action){ 
    case Enter:
        try{
           $sql_Executor_Teams->insertAutoIncrement();
           $main->success("team has been added.");
        }
        catch( Exception $e ){
            $main->error("Failed to enter team. ". $e->getMessage());
        }
        DefaultDisplay($main,$sql_Executor_Teams,$db, $league, $link, $user);
    	break;
     case Delete:
        try{
            $sql_Executor_Teams->Delete();
            $main->success("team has been deleted.");
        }
        catch( Exception $e ){
            $main->error("Failed to delete team. ", $e->getMessage());
        }
        DefaultDisplay($main,$sql_Executor_Teams, $db, $league, $link, $user);
        break;
     case Edit:
        DefaultDisplay($main,$sql_Executor_Teams,$db, $league, $link, $user, $sql_Executor_Teams->GetValueById());
        break;
     case SubmitEdit:
        try{
            $sql_Executor_Teams->Update();
            $main->success("team has been edited.");
        }
        catch( Exception $e ){
            $main->error("Failed to edit game. ". $e->getMessage());
        }
    default :
        DefaultDisplay($main,$sql_Executor_Teams, $db, $league, $link, $user);
    
}
?>