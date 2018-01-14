<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/points_row.php');
require_once ('../classes/dataclasses/saves_row.php');
require_once ('../classes/selectYear.php');
require_once ('../classes/navigation.php');
$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");

$main = new TemplateLogger($db,'./');  
$navbar = new TemplateLogger($db,'./');
$navigation = new Navigation($_REQUEST, Scoring);
$navbar->set(navigation, $navigation);

function displayScoring( $main, $db, $navbar ){
   $points = new Points_Row($_REQUEST);
   $sql_Executor_Points = new SqlExecutor( $db, $points ); 
   $sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetPointsByYear());
   $selectYear = new selectYear($team->Team_ID);
   $main->set('content', $sql_Executor_Points->fetch(array(navbarstats => $navbar->fetch('../templates/pages/statsnavbar.tpl.php'), selectYear => $selectYear->fetchYearOptions($_REQUEST['Year'],"Scoring"))));
   echo $main->fetch('../templates/pages/main.tpl.php'); 
   
}

function displayGoalie( $main, $db, $navbar ){
   $saves = new Saves_Row($_REQUEST);
   $sql_Executor_Saves = new SqlExecutor( $db, $saves ); 
   $sql_Executor_Saves->SearchWithOwnSelect($saves->selectStatement(), $saves->GetSavesByYear());
   $selectYear = new selectYear($team->Team_ID);
   $main->set('content', $sql_Executor_Saves->fetch(array(navbarstats => $navbar->fetch('../templates/pages/statsnavbar.tpl.php'), selectYear => $selectYear->fetchYearOptions($_REQUEST['Year'], "Goalie") )));
   echo $main->fetch('../templates/pages/main.tpl.php'); 
}

function displayStats( $main, $db, $navbar ){
   $points = new Points_Row($_REQUEST);
   $sql_Executor_Points = new SqlExecutor( $db, $points ); 
   $sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetStatsByYear());
   $selectYear = new selectYear($team->Team_ID);
   $main->set('content', $sql_Executor_Points->fetchThisTemplate("../templates/Stats.tpl.php",array(navbarstats => $navbar->fetch('../templates/pages/statsnavbar.tpl.php'), selectYear => $selectYear->fetchYearOptions($_REQUEST['Year'], "Stats"))));
   echo $main->fetch('../templates/pages/main.tpl.php'); 
   
}
 
 switch($navigation->subpage){
   case Scoring:
      displayScoring($main, $db, $navbar);
      break;
   case Goalie:
      displayGoalie($main, $db, $navbar);
      break;
   case Stats:
      displayStats($main, $db, $navbar);
      break;
   default:
      displayScoring($main, $db, $navbar);
      
 }


?>