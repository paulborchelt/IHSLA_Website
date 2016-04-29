<?php
require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/points_row.php');
require_once ('../classes/dataclasses/saves_row.php');
require_once ('../classes/dataclasses/teams_row.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/selectYear.php');

function DefaultDisplay($main, $sqlExecutorSchedule, $db, $team, $sqlEdit = null ){
    $main->set('content', Schedule_Row::fetchGameOptions($db, $team->Team_ID));
    echo $main->fetch('../templates/pages/main.tpl.php');    
}

function DisplayPoints($main, $db, $points, $sqlExecutorPoints, $schedule, $editpointshome = NULL, $editpointsaway = NULL){   
   $sqlExecutorPoints->SearchWithOwnSelect($points->selectStatement(), $points->GetStatsByYearAndGamePerQuarter());
   $main->set('content', $sqlExecutorPoints->fetchThisTemplate( "../templates/PointsEnterStats.tpl.php", 
                                                               array( Game_ID => $schedule->Game_ID,
                                                                      score => $schedule->fetchScore(),
                                                                      statsenterformhome => $points->getStatsForm(clone $db, $schedule->HomeTeam_ID, $schedule->_HomeTeamObject->Team_Name, $schedule->Game_ID, $editpointshome), 
                                                                      statsenterformaway => $points->getStatsForm(clone $db, $schedule->AwayTeam_ID, $schedule->_AwayTeamObject->Team_Name, $schedule->Game_ID, $editpointsaway) )));
   echo $main->fetch('../templates/pages/main.tpl.php');
}

function DisplaySaves($main, $db, $saves, $sqlExecutorSaves, $schedule, $editsaveshome = NULL, $editsavesaway = NULL){   
   $sqlExecutorSaves->SearchWithOwnSelect($saves->selectStatement(), $saves->GetSavesByYearAndGamePerQuarter());
   $main->set('content', $sqlExecutorSaves->fetchThisTemplate( "../templates/SavesEnterStats.tpl.php", 
                                                               array( Game_ID => $schedule->Game_ID,
                                                                      savesenterformhome => $saves->getSavesForm(clone $db, $schedule->HomeTeam_ID, $schedule->_HomeTeamObject->Team_Name, $schedule->Game_ID, $editsaveshome), 
                                                                      savesenterformaway => $saves->getSavesForm(clone $db, $schedule->AwayTeam_ID, $schedule->_AwayTeamObject->Team_Name, $schedule->Game_ID, $editsavesaway) )));
   echo $main->fetch('../templates/pages/main.tpl.php');
}


function DisplaySummary($main, $db, $points, $saves, $sqlExecutorPoints, $sqlExecutorSaves, $schedule){   
   $tpl = new Template('../templates/');
   $sqlExecutorPoints->SearchWithOwnSelect($points->selectStatement(), $points->GetPointsByYearAndGame());
   $sqlExecutorSaves->SearchWithOwnSelect($saves->selectStatement(), $saves->GetSavesByYearAndGame());
   $tpl->set('Score',$schedule->fetchScore());
   $tpl->set('Stats',$sqlExecutorPoints->fetchThisTemplate( "../templates/GameSummaryStats.tpl.php"));
   $tpl->set('Saves',$sqlExecutorSaves->fetchThisTemplate( "../templates/GameSummarySaves.php"));
   $sqlExecutorPoints->SearchWithOwnSelect($points->selectStatement(), $points->GetStatsByYearAndGame());
   $tpl->set('AllStats',$sqlExecutorPoints->fetchThisTemplate( "../templates/GameSummaryAllStats.tpl.php"));
   $main->set('content',$tpl->fetch('../templates/GameSummary.tpl.php'));
   echo $main->fetch('../templates/pages/main.tpl.php');
}


try{
   $db = new db();
   $db->query("SET SESSION SQL_BIG_SELECTS=1");
   $main = new TemplateLogger($db,'./');
   Users_Row::Authentication($db);

   $team = new Teams_Row($_REQUEST);
   $sql_Executor_Teams = new SqlExecutor( $db, $team );





   $action = $_REQUEST['action'];
   switch ($action){ 
       case Insert:
           try{
              $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
              $schedule = $sql_Executor_Schedule->GetValueById();
              $points = new Points_Row($_REQUEST);
              $sql_Executor_Points = new SqlExecutor( $db, $points );
              $points->CheckForDuplicates($db);
              $sql_Executor_Points->insertAll(); 
              $main->success("Stat has been added.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to enter stats. ", $e->getMessage());
           }
           DisplayPoints($main, $db, $points, $sql_Executor_Points, $schedule);
       	break;
        case EnterStats:
            try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $points = new Points_Row(array( Game_ID => $_REQUEST['Game_ID']));
               $sql_Executor_Points = new SqlExecutor( $db, $points );
               DisplayPoints($main, $db, $points, $sql_Executor_Points, $schedule);
            }
            catch( Exception $e ){
               $main->exceptionError("Failed to display stats entry page. ", $e->getMessage());
               DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
           }
        break;
        case Edit:
            try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $points = new Points_Row($_REQUEST);
               $sql_Executor_Points = new SqlExecutor( $db, $points );
               $editpointshome = NULL;
               $editpointsaway = NULL;
               if( $points->Team_ID == $schedule->HomeTeam_ID ){
                  $editpointshome = $points;  
               }
               else{
                  $editpointsaway = $points;
               }
              DisplayPoints($main, $db, $points, $sql_Executor_Points, $schedule, $editpointshome, $editpointsaway);
            }
            catch( Exception $e ){
               $main->exceptionError("Failed to display edit stats page. ", $e->getMessage());
               DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
           }
           break;
        case Delete:
           try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $points = new Points_Row($_REQUEST);
               $sql_Executor_Points = new SqlExecutor( $db, $points );
               $sql_Executor_Points->DeleteWithOwnWhereStatement("Where Game_ID = $points->Game_ID and Player_ID = $points->Player_ID and Quarter = $points->Quarter ");
               $main->success("Stat entry has been deleted.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to delete stats entry. ", $e->getMessage());
           }
           DisplayPoints($main, $db, $points, $sql_Executor_Points, $schedule);
           break;
        case StatsUpdate:
           try{
              $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
              $schedule = $sql_Executor_Schedule->GetValueById();
              $points = new Points_Row($_REQUEST);
              $sql_Executor_Points = new SqlExecutor( $db, $points );
              $sql_Executor_Points->UpdateWithOwnSearchStatement("Where Game_ID = '$points->Game_ID' AND Player_ID = '$points->Player_ID' and Quarter = $points->Quarter "); 
              $main->success("Stat has been updated.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to edit stats entry. ", $e->getMessage());
           }
           DisplayPoints($main, $db, $points, $sql_Executor_Points, $schedule);
           break;
       case GoalieEnter:
            try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $saves = new Saves_Row(array( Game_ID => $_REQUEST['Game_ID']));
               $sql_Executor_Saves = new SqlExecutor( $db, $saves );
               DisplaySaves($main, $db, $saves, $sql_Executor_Saves, $schedule);
            }
            catch( Exception $e ){
               $main->exceptionError("Failed to display goalie stats entry page. ", $e->getMessage());
               DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
           }
           break;
        case SavesInsert:
           try{
              $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
              $schedule = $sql_Executor_Schedule->GetValueById();
              $saves = new Saves_Row($_REQUEST);
              $sql_Executor_Saves = new SqlExecutor( $db, $saves );
              $saves->CheckForDuplicates($db);
              $sql_Executor_Saves->insertAll(); 
              $main->success("Saves have been added.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to enter saves. ", $e->getMessage());
           }
           DisplaySaves($main, $db, $saves, $sql_Executor_Saves, $schedule);
       	break;
         case SavesEdit:
            try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $saves = new Saves_Row($_REQUEST);
               $sql_Executor_Saves = new SqlExecutor( $db, $saves );
               $editsaveshome = NULL;
               $editsavesaway = NULL;
               if( $saves->Team_ID == $schedule->HomeTeam_ID ){
                  $editsaveshome = $saves;  
               }
               else{
                  $editsavesaway = $saves;
               }
              DisplaySaves($main, $db, $saves, $sql_Executor_Saves, $schedule, $editsaveshome, $editsavesaway);
            }
            catch( Exception $e ){
               $main->exceptionError("Failed to display edit stats page. ", $e->getMessage());
               DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
           }
           break;
         case SavesUpdate:
           try{
              $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
              $schedule = $sql_Executor_Schedule->GetValueById();
              $saves = new Saves_Row($_REQUEST);
              $sql_Executor_Saves = new SqlExecutor( $db, $saves );
              $sql_Executor_Saves->UpdateWithOwnSearchStatement("Where Game_ID = '$saves->Game_ID' AND Player_ID = '$saves->Player_ID' AND Quarter = '$saves->Quarter'"); 
              $main->success("Saves have been updated.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to edit stats entry. ", $e->getMessage());
           }
           DisplaySaves($main, $db, $saves, $sql_Executor_Saves, $schedule);
           break;
         case SavesDelete:
           try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $saves = new Saves_Row($_REQUEST);
               $sql_Executor_Saves = new SqlExecutor( $db, $saves );
               $sql_Executor_Saves->DeleteWithOwnWhereStatement("Where Game_ID = $saves->Game_ID and Player_ID = $saves->Player_ID AND Quarter = '$saves->Quarter'");
               $main->success("Saves entry has been deleted.");
           }
           catch( Exception $e ){
               $main->exceptionError("Failed to delete saves entry. ", $e->getMessage());
           }
           DisplaySaves($main, $db, $saves, $sql_Executor_Saves, $schedule);
           break;
       case GameSummary:
            try{
               $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
               $schedule = $sql_Executor_Schedule->GetValueById();
               $saves = new Saves_Row(array( Game_ID => $_REQUEST['Game_ID']));
               $sql_Executor_Saves = new SqlExecutor( clone $db, $saves );
               $points = new Points_Row(array( Game_ID => $_REQUEST['Game_ID']));
               $sql_Executor_Points = new SqlExecutor( clone $db, $points );
               DisplaySummary($main, $db, $points, $saves, $sql_Executor_Points, $sql_Executor_Saves, $schedule);
            }
            catch( Exception $e ){
               $main->exceptionError("Failed to display summary page. ", $e->getMessage());
               DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
           }
           break;
       default :
           DefaultDisplay($main,$sql_Executor_Schedule, $db, $team);
       
      }
}
catch( Exception $e ){
   $main->exceptionError("Unknown error occured on page EnterTeamStats.php. ", $e->getMessage());
}
