<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/templatelogger.php');;
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/allstate_nominations_row.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/teams_row.php');

function DefaultDisplay($db, $main, $team, $sqlExecutorNominations, $position ){
   $nextPosition = Allstate_Nominations_Row::getNextPosition(clone $db, $position->Position_ID);
   $totalnominations = Allstate_Nominations_Row::getTotalNominations(clone $db, $team->Team_ID);
   if( null == $nextPosition ){
      $sqlExecutorNominations->Search(Allstate_Nominations_Row::getWhereStatement($team->Team_ID, null));
   }
   else{
      $sqlExecutorNominations->Search(Allstate_Nominations_Row::getWhereStatement($team->Team_ID, $position->Position_ID));
   }
   if ( $sqlExecutorNominations->numRows() < Allstate_Nominations_Row::getNominationLimit( $position->Position_ID) && $totalnominations < Allstate_Nominations_Row::getNominationLimit( clone $db, $team->Team_ID  )){
      $main->set('content', $sqlExecutorNominations->fetch(array(nextposition => Allstate_Nominations_Row::getNextPosition(clone $db, $position->Position_ID), team => $team, nominationform => Allstate_Nominations_Row::getNominationForm(clone $db, $team->Team_ID, $position->Position_ID), position => $position )));
   }
   else{
      $main->set('content', $sqlExecutorNominations->fetch(array(nextposition => Allstate_Nominations_Row::getNextPosition(clone $db, $position->Position_ID), team => $team, position => $position )));
   }
   
   echo $main->fetch('../templates/pages/main.tpl.php');    
}

function SummaryDisplay($db, $main, $team, $sqlExecutorNominations ){
   $sqlExecutorNominations->Search(Allstate_Nominations_Row::getWhereStatement($team->Team_ID, null));
   $main->set('content', $sqlExecutorNominations->fetch(array(team => $team, summary => TRUE )));
   
   echo $main->fetch('../templates/pages/main.tpl.php');    
}

$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");
Users_Row::Authentication($db);

$sql_Executor_Teams = new SqlExecutor( $db, new Teams_Row($_REQUEST ));
$sql_Executor_Allstate_Nominations = new SqlExecutor( $db, new Allstate_Nominations_Row($_REQUEST ));
$team = $sql_Executor_Teams->GetValueById();

$sql_Executor_Position = new SqlExecutor( $db, new Position_Row($_REQUEST ));
$position = $sql_Executor_Position->GetValueById();

$main = new TemplateLogger($db,'./');

$action = $_REQUEST['action'];
switch ($action){ 
    case Enter:
      try{
         $sql_Executor_Allstate_Nominations->insertAutoIncrement();
         $main->success("Player has been added.");
      }
      catch( Exception $e ){
         $main->error("Failed to add player. $e->getMessage()");
      }
      DefaultDisplay($db, $main, $team, $sql_Executor_Allstate_Nominations, $position);
      break;
      case Delete:
      try{
         $sql_Executor_Allstate_Nominations->Delete();
         $main->success("Player has been removed.");
      }
      catch( Exception $e ){
         $main->error("Failed to remove player. $e->getMessage()");
      }
      DefaultDisplay($db, $main, $team, $sql_Executor_Allstate_Nominations, $position);
      break;
    case Summary:
      SummaryDisplay($db, $main, $team, $sql_Executor_Allstate_Nominations);
      break;
    default:
		DefaultDisplay($db, $main, $team, $sql_Executor_Allstate_Nominations, $position);
}
?>