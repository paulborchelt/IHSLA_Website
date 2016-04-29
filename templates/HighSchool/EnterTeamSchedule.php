<?php
require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/sqlexecutor.php');

function DefaultDisplay($main, $sqlExecutorSchedule, $db, $team, $sqlEdit = null ){
    $sqlExecutorSchedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYearForTeam(1, $team->Team_ID));
    $main->set('content', Schedule_Row::getTeamForm($db, $sqlExecutorSchedule->fetchThisTemplate("../templates/TeamSchedule.tpl.php", array( Team_ID => $team->Team_ID, enterschedule => "yes")), $sqlEdit, $team, 1));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}




$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");
Users_Row::Authentication($db);

$sql_Executor_Teams = new SqlExecutor( $db, new Teams_Row($_REQUEST ));
$team = $sql_Executor_Teams->GetValueById();
$schedule = new Schedule_Row($_REQUEST);
$schedule->setSchedule($_REQUEST['location'],$_REQUEST['Team_ID'],$_REQUEST['opponent']);
$sql_Executor_Schedule = new SqlExecutor( $db, $schedule );

$main = new TemplateLogger($db,'./');

$action = $_REQUEST['action'];
switch ($action){ 
    case Enter:
        try{
           $sql_Executor_Schedule->insertAutoIncrement(); 
           $main->success("game has been added.");
        }
        catch( Exception $e ){
             $main->exceptionError("Failed to enter game. ", $e->getMessage());
        }
        DefaultDisplay($main,$sql_Executor_Schedule,$db, $team);
    	break;
     case Edit:
        DefaultDisplay($main,$sql_Executor_Schedule, $db, $team, $sql_Executor_Schedule->GetValueById());
        break;
     case Delete:
        try{
            $sql_Executor_Schedule->Delete();
             $main->success("game has been deleted.");
        }
        catch( Exception $e ){
            $main->exceptionError("Failed to delete game. ", $e->getMessage());
        }
        DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
        break;
     case SubmitEdit:
        try{
            $sql_Executor_Schedule->Update();
             $main->success("game has been edited.");
        }
        catch( Exception $e ){
            $message = "Failed to edit game. ";
            $message .= $e->getMessage();
             $main->error($message);
        }
    default :
        DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
    
}