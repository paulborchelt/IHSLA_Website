<?php

require_once ('classes/database.php');
require_once ('classes/templateengine/templatelogger.php');;
require_once ('classes/sqlexecutor.php');
require_once ('classes/dataclasses/allstate_votes_row.php');


$db = new db();
$db->query("SET SESSION SQL_BIG_SELECTS=1");

$sql_Executor_AllState_Votes = new SqlExecutor( $db, new AllState_Votes_Row($_REQUEST ));

$sql_Executor_Position = new SqlExecutor( $db, new Position_Row($_REQUEST ));
$position = $sql_Executor_Position->GetValueById();


$main = new TemplateLogger($db,'./');

$sql_Executor_AllState_Votes->SearchWithOwnSelect(AllState_Votes_Row::getSelectStatementForAllStateVotes(),AllState_Votes_Row::getWhereStatementForAllStateVotes($position->Position_ID, $_REQUEST['year']));

$main->set('content', $sql_Executor_AllState_Votes->fetchThisTemplate("AllState_View.tpl.php",array(Position => $position, year =>$_REQUEST['year']  )));

echo $main->fetch('templates/pages/main.tpl.php');  
?>