<?PHP

require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/dataclasses/players_rows.php');
require_once ('classes/mydatetime.php');


function DefaultView($db, $main, $sqlExecutorPlayers, $team ){
    $year = MyDateTime::GetCurrentSeasonYear();
    $sqlExecutorPlayers->SearchWithOwnSelect(Players_Row::GetSelectStatement(), Players_Row::GetWhereStatement($team->Team_ID, $year));
    $main->set('content', $sqlExecutorPlayers->fetchThisTemplate('templates/ProgramMembers.form.tpl.php',array( team => $team)) );
    echo $main->fetch('templates/pages/main.tpl.php');  
}

$db = new db();
$main = new TemplateLogger($db,'./'); 
Users_Row::Authentication($db);

try{
   $player = new Players_Row($_REQUEST);
   $sql_Executor_Players = new SqlExecutor( $db, $player );   
   Teams_Row::getTeamIdRequest();
   $sql_Team  = new SqlExecutor( $db, new Teams_Row($_REQUEST));
   $team = $sql_Team->GetValueById();
}
catch(Exception $e){
    $main->exceptionErrorFull("Error Loading SubmitProgramMembers page.", $e);
}

$action = $_REQUEST['action'];
switch ($action){
   case Submit:
      $year = MyDateTime::GetCurrentSeasonYear();
      $date = new MyDateTime();
      $sql_Executor_Players->SearchWithOwnSelect(Players_Row::GetSelectStatement() ,Players_Row::GetWhereStatement($team->Team_ID, $year));
      $message = "<p>{$team->Team_Name} {$date->getMonthDayYearFormat()}</p>";
      $message .="<html><table>
         <thead>
            <tr>
            	<th>First Name:</th>
            	<th>Last Name:</th>
               <th>Graduation Year:</th>
               <th>Us Lacrosse Number</th>";
      if( 1 == $team->Club ){
         $message .= "<th>School</th>";
      }
      $message .= "</tr>
         </thead>
         <tbody>";
      while ( $result = $sql_Executor_Players->fetchNextObject() ){
        $message .= "<tr>
            	<td>{$result->First_Name}</td>
            	<td>{$result->Last_Name}</td>
                <td>{$result->getGradeName()}</td>
            	 <td>{$result->UsLacrosseNumber}</td>";
        if( 1 == $team->Club ){
           $message .= "<td>{$result->_schoolObject->Team_Name}</td>";
        }
        $message .= "</tr>";
      }
             
      $message .=  "</tbody>
      </table>";
      
      $to = mail::getPresidentEmail($db);
      //$to .= $this->getCoachesEmails($database);
      $subject = "IHSLA Player List for ";
      $subject .= $team->Team_Name;
      $mail = new mail($message, $subject ,$to, "assigner@indianalacrosse.org");
      $mail->Send();
      $main->success("Message has been sent.");
      DefaultView($db, $main, $sql_Executor_Players, $team);
      break;
   default :
      DefaultView($db, $main, $sql_Executor_Players, $team);
}
?>