<?php
session_start();
require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/dataclasses/users_row.php');

function defaultDisplay($main, $sql_News, $edit){
    $sql_News->Search("Where remove != 1 ORDER BY timestamp DESC");
    $tpl = new Template('../templates/');
    $tpl->set('results',$sql_News);
    $tpl->set('edit', $edit);
    $main->set('content', $tpl->fetch('../templates/pages/NewsArchives.tpl.php'));
    echo $main->fetch('../templates/pages/main.tpl.php');
}

function formDisplay($main, $sqlEdit = NULL ){
    $tpl = new Template('../templates/');
    $tpl->set('headline', $sqlEdit != NULL ? $sqlEdit->headline : NULL);
    $tpl->set('message', $sqlEdit != NULL ? $sqlEdit->message : NULL);
    $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
    $main->set('content',$tpl->fetch('../templates/News.form.tpl.php'));  
    echo $main->fetch('../templates/pages/main.tpl.php');
}

$db = new db();

$main = new TemplateLogger($db,'./');

$user = Users_Row::getUser($db);

try{
    $sql_News = new SqlExecutor( $db, new News_Row($_REQUEST) );   
    if( NULL == $user ){
      $edit = false;
    }
    else{
      $edit = $user->hasEditContactPermisions($team->Team_ID);
    }
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
            $main->error("Failed to enter news story. ". $e->getMessage());
        }
        defaultDisplay($main,$sql_News, $user);
		break;
    case Archive:
        defaultDisplay($main,$sql_News, $edit);
        break;
    case delete_news:
        try{
            $sql_News->UpdateValue( array (remove => 1 ) );
            $main->success("News items has been removed.");
        }
        catch (Exception $e ){
            $main->error("Failed to update news story. ". $e->getMessage());
        }
        defaultDisplay($main,$sql_News,$user);
        break;
    case edit_news:
        $news = $sql_News->GetValueById();
        formDisplay($main, $sql_News->GetValueById());
        break;
    case SubmitEdit:
        try{
            $sql_News->Update();
            $main->success("News has been updated.");
        }
        catch( Exception $e ){
            $main->exceptionError("Failed update news. ", $e->getMessage() );
        }
        defaultDisplay($main,$sql_News, $edit);
        break;
	default:
        formDisplay($main);
      break;

}

?>