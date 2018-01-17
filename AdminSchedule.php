<?php
require('Security.php');
require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/dataclasses/schedule_row.php');
require_once ('classes/sqlexecutor.php');
require_once ('calendar/tc_calendar.php');

function DefaultDisplay($main, $sqlExecutorSchedule, $db, $league, $sqlEdit = null ){
    $sqlExecutorSchedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYear($league));
    $main->set('content', Schedule_Row::getAdminForm($db, $sqlExecutorSchedule->fetchThisTemplate("templates/ScheduleAdmin.tpl.php"), $sqlEdit, $league));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

//Authentication();

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

$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");

$sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );

$main = new TemplateLogger($db, './');

$action = $_REQUEST['action'];
switch ($action){ 
    case Enter:
        try{
           $sql_Executor_Schedule->insertAutoIncrement(); 
           Success("game has been added.");
        }
        catch( Exception $e ){
            Error("Failed to enter game. $e->getMessage()");
        }
        DefaultDisplay($main,$sql_Executor_Schedule,$db, $league);
    	break;
     case Edit:
        DefaultDisplay($main,$sql_Executor_Schedule,$db, $league, $sql_Executor_Schedule->GetValueById());
        break;
     case Delete:
        try{
            $sql_Executor_Schedule->Delete();
            Success("game has been deleted.");
        }
        catch( Exception $e ){
            $main->exceptionError("Failed to delete game. ", $e->getMessage());
        }
        DefaultDisplay($main,$sql_Executor_Schedule, $db, $league);
        break;
     case SubmitEdit:
        try{
            $sql_Executor_Schedule->Update();
            Success("game has been edited.");
        }
        catch( Exception $e ){
            $message = "Failed to edit game. ";
            $message .= $e->getMessage();
            Error($message);
            //Error($message);
        }
    default :
        DefaultDisplay($main,$sql_Executor_Schedule, $db, $league);
    
}




?>