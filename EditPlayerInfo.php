<?php
require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/dataclasses/players_rows.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/mydatetime.php');

function DefaultDisplay($main, $sqlExecutorPlayers, $db, $team, $sqlEdit = null ){
    $year = MyDateTime::GetCurrentSeasonYear();
    $sqlExecutorPlayers->SearchWithOwnSelect(Players_Row::GetSelectStatement(), Players_Row::GetWhereStatement($team->Team_ID, $year));
    $main->set('content', Players_Row::getAdminForm($db, $sqlExecutorPlayers->fetch( array( team => $team )), $sqlEdit, $team));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

function DisplayDuplicate($main, $sqlExecutor, $player, $Team_ID ){
    $main->set('content', Players_Row::getDuplicateForm($sqlExecutor, $player, $Team_ID));
    echo $main->fetch('templates/pages/main.tpl.php');    
}      

try{
    $db = new db();
    Users_Row::Authentication($db);
    $main = new TemplateLogger($db,'./');
    
    if ( isset( $_REQUEST[link] ) == true ){
      $_SESSION[Return_Link] = $_REQUEST[link];
    }
    
    $player = new Players_Row($_REQUEST);
    $sql_Executor_Players = new SqlExecutor( $db, $player );
    
    Teams_Row::getTeamIdRequest();
    $sql_Executor_Teams = new SqlExecutor($db, new Teams_Row($_REQUEST));
    $team = $sql_Executor_Teams->GetValueById();
        
    $action = $_REQUEST['action'];
    switch ($action){ 
        case Enter:
            try{
               $sql_Executor_Players->insertAutoIncrement($_REQUEST['Force']); 
               $main->success("Player has been added.");
            }
            catch( DuplicatePlayerException $e ){
            DisplayDuplicate($main, $e->getSQLExecutor(), $player, $team->Team_ID);
            break;
            }
            catch( Exception $e ){
                $main->error("Failed to enter player. $e->getMessage()");
            }
            DefaultDisplay($main,$sql_Executor_Players,$db, $team);
        	break;
         case Delete:
            try{
                $sql_Executor_Players->Delete();
                $main->success("Player has been deleted.");
            }
            catch( Exception $e ){
                if( $e->getMessage() != "A value exists in the Rosters table for the current season."){
                   $players = $sql_Executor_Players->GetValueById();
                   $players_Executor = new SqlExecutor( $db, $players );
                   try{
                       $players_Executor->UpdateValue(array(Team_ID => 0));
                       $message = "Unable to delete player. ";
                       $message .= $e->getMessage();
                       $main->info($message);
                       $main->success("Player has been removed from team.");
                   }
                   catch( Exception $e ){
                       $message = "Failed to remove player from team. ";
                       $message .= $e->getMessage();
                       $main->error($message);
                   }
                }
                else{
                  $main->Error("Failed to delete player because he is listed on your current roster. Please remove him from your roster then try the delete again." );
                }
            }
            DefaultDisplay($main,$sql_Executor_Players, $db, $team);
            break;
         case Edit:
            DefaultDisplay($main,$sql_Executor_Players,$db, $team, $sql_Executor_Players->GetValueById());
            break;
         case Move:
            try{
               $player = $sql_Executor_Players->GetValueById();
               $player->ValidateMove($db);
               if( TRUE == $player->isSchool_IDNonMember($db)){
                  //If the current school id is a non member team keep it. 
                  $sql_Executor_Players->UpdateValue(array(Team_ID => $team->Team_ID));
               }
               else{
                  //If it is a member school than change it to the new team.
                  $sql_Executor_Players->UpdateValue(array(Team_ID => $team->Team_ID, School_ID => $team->Team_ID));
               }
               $main->success("Player has been moved.");
            }
            catch( DuplicatePlayerException $e ){
               $main->error("Unable to move player to your team because players is still rostered on another team. Have the other coach un-roster the player so you can move him.");
               DisplayDuplicate($main, $e->getSQLExecutor(), $player, $team->Team_ID);
               break;
            }
            catch( Exception $e ){
                $main->exceptionError("Failed to move player. ", $e->getMessage());
            }
            DefaultDisplay($main,$sql_Executor_Players,$db, $team );
            break;
         case SubmitEdit:
            try{
                $sql_Executor_Players->Update();
                $main->success("Player has been edited.");
            }
            catch( Exception $e ){
                $main->exceptionError("Failed to edit player. ", $e->getMessage() );
            }
        default :
            DefaultDisplay($main,$sql_Executor_Players, $db, $team);
    }
}
catch ( Exception $e ) {
    $main->exceptionErrorFull("Failed to load pgae. ", $e);
    echo $main->fetch('templates/pages/main.tpl.php');  
}
        
?>