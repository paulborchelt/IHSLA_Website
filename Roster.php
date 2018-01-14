<?PHP

require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/dataclasses/rosters_row.php');

function DefaultView($db, $main, $team ){
   $main->set('content', Rosters_Row::getRosterManagerForm($db, $team));
   echo $main->fetch('templates/pages/main.tpl.php'); 
}

function AddView($db, $main, $roster ){
   $playerSql = new SqlExecutor($db, new Players_Row($_REQUEST));
   $player = $playerSql->GetValueById();
   $main->set('content', $player->getRosterAddForm($db, $roster));
   echo $main->fetch('templates/pages/main.tpl.php'); 
}

$db = new db();
$main = new TemplateLogger($db,'./'); 
Users_Row::Authentication($db);

try{
   $roster = new Rosters_Row($_REQUEST);
   $sql_Roster = new SqlExecutor( $db, $roster );   
   $sql_Team  = new SqlExecutor( $db, new Teams_Row($_REQUEST));
   $team = $sql_Team->GetValueById();
}
catch(Exception $e){
    $main->error($e);
}

$action = $_REQUEST['action'];
switch ($action){
   case Add:
      AddView($db, $main, $roster);
      break;
   case addplayer:
      try{
         $sql_Roster->insertAutoIncrement();
         $main->success("Player has been added to the roster.");
      }
      catch( Exception $e ){
          $main->exceptionError("Failed to enter player to the roster. ", $e->getMessage());
      }
      DefaultView($db, $main, $team);
      break;
   case removeplayer:
      try{
         $sql_Roster->DeleteWithOwnWhereStatement("Where player_id = $roster->player_id and team_id = $roster->team_id and level = $roster->level");
         $main->success("Player has been deleted from the roster.");
      }
      catch( Exception $e ){
          $main->exceptionError("Failed to delete player from the roster. ", $e->getMessage());
      }
      DefaultView($db, $main, $team);
      break;
   case delete:
      //in the future call a class that handles both delete for EditPlayerInfo and here.
   default :
      DefaultView($db, $main, $team);
}
?>