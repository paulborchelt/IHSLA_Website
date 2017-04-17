<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/dataclasses/users_row.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/scheduleSorter.php');


$db = new db();

$main = new TemplateLogger($db,'./'); 


try{
    $sql_News = new SqlExecutor( $db, new News_Row($_REQUEST) );  
    $sql_Executor_Schedule = new SqlExecutor( clone $db, new Schedule_Row($_REQUEST)); 
}
catch(Exception $e){
    $main->error($e);
}

$sql_News->Search("WHERE remove != 1 ORDER BY timestamp DESC LIMIT 7");
$scheduleSorter = new scheduleSorter(array(level => Varsity, daterange => Today ));
$sql_Executor_Schedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYear(1, $scheduleSorter));
$tpl = new Template();
$tpl->set('resultnews', $sql_News);
$tpl->set('resultschedule', $sql_Executor_Schedule);
$main->set('newscards', $tpl->fetch('../templates/GamesTodayCard.tpl.php'));
echo $main->fetch('../templates/pages/index.tpl.php'); 

?>