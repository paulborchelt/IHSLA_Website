<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/templatelogger.php');;
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/allstate_votes_row.php');
require_once ('../classes/dataclasses/allstate_nominations_row.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/teams_row.php');

function DefaultDisplay($db, $main, $team, $sqlExecutorVotes, $position, $Team_Level ){
   $nextPosition = Allstate_Nominations_Row::getNextPosition(clone $db, $position->Position_ID);
   if( null == $nextPosition ){
      $sqlExecutorVotes->Search(Allstate_Votes_Row::getWhereStatement($team->Team_ID, $Team_Level, null));
   }
   else{
      $sqlExecutorVotes->Search(Allstate_Votes_Row::getWhereStatement($team->Team_ID, $Team_Level, $position->Position_ID));
   }
   if ( $sqlExecutorVotes->numRows() < Allstate_Votes_Row::getNominationLimit( $position->Position_ID) ){
      $main->set('content', $sqlExecutorVotes->fetch(array(nextposition => $nextPosition, team => $team, voteform => Allstate_Votes_Row::getVotesForm(clone $db, $team->Team_ID, $position->Position_ID, $Team_Level), position => $position, Team_Level => $Team_Level, Team_Level_Description => Allstate_Votes_Row::getTeamLevelDescription( $Team_Level) )));
   }
   else{
      $main->set('content', $sqlExecutorVotes->fetch(array(nextposition => $nextPosition, team => $team, position => $position, Team_Level => $Team_Level, Team_Level => $Team_Level, Team_Level_Description => Allstate_Votes_Row::getTeamLevelDescription( $Team_Level) )));
   }
   
   echo $main->fetch('../templates/pages/main.tpl.php');    
}

function SummaryDisplay($db, $main, $team, $sqlExecutorVotes, $Team_Level ){
   $sqlExecutorVotes->Search(Allstate_Votes_Row::getWhereStatement($team->Team_ID, $Team_Level, null));
   $main->set('content', $sqlExecutorVotes->fetch(array(team => $team, summary => TRUE, Team_Level => $Team_Level, Team_Level => $Team_Level, Team_Level_Description => Allstate_Votes_Row::getTeamLevelDescription( $Team_Level) )));
   
   echo $main->fetch('../templates/pages/main.tpl.php');    
}

$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");
Users_Row::Authentication($db);

$sql_Executor_Teams = new SqlExecutor( $db, new Teams_Row($_REQUEST ));
$sql_Executor_AllState_Votes = new SqlExecutor( $db, new AllState_Votes_Row($_REQUEST ));
$team = $sql_Executor_Teams->GetValueById();

$sql_Executor_Position = new SqlExecutor( $db, new Position_Row($_REQUEST ));
$position = $sql_Executor_Position->GetValueById();

$Team_Level = $_REQUEST['Team_Level'];

$main = new TemplateLogger('./');

$action = $_REQUEST['action'];
switch ($action){ 
    case Enter:
      try{
         $sql_Executor_AllState_Votes->insertAutoIncrement();
         $main->success("Player has been added.");
      }
      catch( Exception $e ){
         $main->error("Failed to add player. $e->getMessage()");
      }
      DefaultDisplay($db, $main, $team, $sql_Executor_AllState_Votes, $position, $Team_Level);
      break;
      case Delete:
      try{
         $sql_Executor_AllState_Votes->Delete();
         $main->success("Player has been removed.");
      }
      catch( Exception $e ){
         $main->error("Failed to remove player. $e->getMessage()");
      }
      DefaultDisplay($db, $main, $team, $sql_Executor_AllState_Votes, $position, $Team_Level);
      break;
    case Summary:
      SummaryDisplay($db, $main, $team, $sql_Executor_AllState_Votes, $Team_Level);
      break;
    default:
		DefaultDisplay($db, $main, $team, $sql_Executor_AllState_Votes, $position, $Team_Level);
}
?>