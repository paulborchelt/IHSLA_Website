
<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');

$db = new db();

$main = new TemplateLogger($db,'./');  

try{
    $sql_News = new SqlExecutor( $db, new News_Row($_REQUEST) );   
}
catch(Exception $e){
    $main->error($e);
}

$test = $sql_News->GetValueById();
$tpl = new Template('../templates/');
$tpl->set('news', $test );
$main->set('content', $tpl->fetch("../templates/content/ViewNews.tpl.php"));
echo $main->fetch('../templates/pages/main.tpl.php');  

?>