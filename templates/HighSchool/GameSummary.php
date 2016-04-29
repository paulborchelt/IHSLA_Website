<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/points_row.php');
require_once ('../classes/dataclasses/saves_row.php');

$db = new db();

$main = new TemplateLogger($db,'./');  

$sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST) );
$schedule = $sql_Executor_Schedule->GetValueById();
$saves = new Saves_Row(array( Game_ID => $_REQUEST['Game_ID']));
$sql_Executor_Saves = new SqlExecutor( clone $db, $saves );
$points = new Points_Row(array( Game_ID => $_REQUEST['Game_ID']));
$sql_Executor_Points = new SqlExecutor( clone $db, $points );
$tpl = new Template('../templates/');
$sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetPointsByYearAndGame());
$sql_Executor_Saves->SearchWithOwnSelect($saves->selectStatement(), $saves->GetSavesByYearAndGame());
$tpl->set('Score',$schedule->fetchScore());
$tpl->set('Stats',$sql_Executor_Points->fetchThisTemplate( "../templates/GameSummaryStats.tpl.php"));
$tpl->set('Saves',$sql_Executor_Saves->fetchThisTemplate( "../templates/GameSummarySaves.php"));
$sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetStatsByYearAndGame());
$tpl->set('AllStats',$sql_Executor_Points->fetchThisTemplate( "../templates/GameSummaryAllStats.tpl.php"));
$main->set('content',$tpl->fetch('../templates/GameSummary.tpl.php'));
echo $main->fetch('../templates/pages/main.tpl.php');  

?>

