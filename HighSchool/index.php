<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/scheduleSorter.php');
/*
$db = new db();

$main = new TemplateLogger($db,'./'); 


try{
    $sql_News = new SqlExecutor( $db, new News_Row($_REQUEST) );   
}
catch(Exception $e){
    $main->error($e);
}

$sql_News->Search("ORDER BY timestamp ASC LIMIT 7");
$tpl = new Template();
$tpl->set('result', $sql_News);
$main->set('newscards', $tpl->fetch('../templates/NewsCards.tpl.php'));
echo $main->fetch('../templates/pages/index.tpl.php');  */

$db = new db();

$main = new TemplateLogger($db,'./');  

$sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST));
$scheduleSorter = new scheduleSorter($_REQUEST);
$sql_Executor_Schedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYear(1, $scheduleSorter));
$tpl = new Template();
$tpl->set('result', $sql_Executor_Schedule);
$main->set('newscards', $tpl->fetch('../templates/GamesTodayCard.tpl.php'));
echo $main->fetch('../templates/pages/index.tpl.php');

?>