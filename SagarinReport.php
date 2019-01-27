<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/scheduleSorter.php');
require_once ('../classes/managefile.php');

function DefaultDisplay($main, $sqlExecutorSchedule, $user ){
    $main->set('content', $sqlExecutorSchedule->fetchThisTemplate("SagarinReport.tpl.php", array( user => $user )));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

$db = new db();
$user = Users_Row::Authentication($db);
$main = new TemplateLogger($db,'./');  

$sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST));
$sql_Executor_Schedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYearSagarin());

$action = $_REQUEST['action'];
switch ($action){ 
    case File:
      $file = "leagueuploads/sagarin report.txt";
      $myfile = fopen($file, "w") or die("Unable to open file!");
      while ( $schedule = $sql_Executor_Schedule->fetchNextObject() ){
        fwrite ($myfile, $schedule->Game_ID);
        fwrite ($myfile, " ");
   	    fwrite ($myfile, $schedule->_HomeTeamObject->Team_Name);
        fwrite ($myfile, " ");
   	    fwrite ($myfile, $schedule->_AwayTeamObject->Team_Name );
        fwrite ($myfile, " ");
   	    fwrite ($myfile, $schedule->_HomeTeamObject->Team_ID);
        fwrite ($myfile, " ");
   	    fwrite ($myfile, $schedule->_AwayTeamObject->Team_ID );
        fwrite ($myfile, " ");
        fwrite ($myfile, $schedule->getResults(FALSE));
        fwrite ($myfile, "\r\n");
      }
      fclose($myfile); 
      $managefile = new managefile($file);
      $managefile->download();
      break;
    default:
        DefaultDisplay($main,$sql_Executor_Schedule, $user);    
} 

?>