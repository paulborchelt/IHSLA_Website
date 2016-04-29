<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/schedule_row.php');

$db = new db();

$main = new TemplateLogger($db,'./');  

$sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST));
$sql_Executor_Schedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYearVarsityOnly(1));
$main->set('content', $sql_Executor_Schedule->fetchThisTemplate("../templates/LaxPower.tpl.php"));
echo $main->fetch('../templates/pages/main.tpl.php');  

?>