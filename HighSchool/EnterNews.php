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

$action = $_REQUEST['action'];
switch ($action){
	case Enter:
        try{
            $sql_News->insertAutoIncrement();
            $main->success("News Entered.");
        }
        catch( Exception $e ){
            $main->error("Failed to enter team. ". $e->getMessage());
        }
 	    header('Location: index.php');
		break;
	default:
      echo $main->fetch('../templates/News.form.tpl.php');  

}

?>