<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/dataclasses/users_row.php');

$db = new db();

$main = new TemplateLogger($db,'./'); 


try{
    $sql_News = new SqlExecutor( $db, new News_Row($_REQUEST) );   
}
catch(Exception $e){
    $main->error($e);
}

$sql_News->Search("WHERE remove != 1 ORDER BY timestamp DESC LIMIT 7");
$tpl = new Template();
$tpl->set('result', $sql_News);
$main->set('newscards', $tpl->fetch('../templates/NewsCards.tpl.php'));
echo $main->fetch('../templates/pages/index.tpl.php');  

?>