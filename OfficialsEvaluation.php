<?php
require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/dataclasses/schedule_row.php');
require_once ('classes/dataclasses/officialevaluations_row.php');

function DefaultDisplay($main, $db, $sqlExecutorTeams ){
    try{
        $team = $sqlExecutorTeams->GetValueById();
        $tpl = new Template('templates/');
        $tpl->set('selectteamoptionsform', Schedule_Row::GetSelectGameOptions($db,$team->Team_ID));
        $tpl->set('Team_ID', $team->Team_ID);
        $main->set('content', $tpl->fetch('OfficialsEvaluationSelectTeam.form.tpl.php'));
        echo $main->fetch('templates/pages/main.tpl.php');   
    }
    catch(Exception $e){
        $main->error($e);
    }
      
}

function ChooseOfficalDisplay($main, $db, $sqlExecutorSchedule, $schedule, $team_ID ){
    try{
            $sqlExecutorSchedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),$schedule->GetGame()); 
        }
        catch(Exception $e){
            $main->error($e);
        }
    $schedule = $sqlExecutorSchedule->fetchNextObject();
    $tpl = new Template('templates/');
    $tpl->set("refereeinfo", $schedule->_RefereeObject);
    $tpl->set("umpireinfo", $schedule->_UmpireObject);
    $tpl->set("fieldjudgeinfo", $schedule->_FieldJudgeObject);
    $tpl->set("Team_ID",$team_ID);
    $tpl->set("Game_ID",$schedule->Game_ID);
    $main->set('content', $tpl->fetch('OfficialsEvaluationSelectOfficial.form.tpl.php'));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

function AddOfficalDisplay($main, $db, $Game_ID, $Team_ID, $officialtype, $iduser = 0 ){
    $tpl = new Template('templates/');
    $tpl->set("officialoptions", Schedule_Row::GetAllOfficialOptions($db, $iduser));
    $tpl->set("Game_ID",$Game_ID);
    $tpl->set("Team_ID",$Team_ID);
    $tpl->set("officialtype",$officialtype);
    $main->set('content', $tpl->fetch('OfficialsEvaluationAddOfficial.form.tpl.php'));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

function DisplayEvaluationForm($main,$teamId, $idschedule, $idcontactinfo, $officialevaluation, $view = false ){
    $tpl = new Template('templates/');
    $tpl->set("idschedule",$idschedule);
    $tpl->set("idcontactinfo",$idcontactinfo);
    $tpl->set("Team_ID",$teamId);
    $tpl->set("selectlocationcheckoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->locationcheck : NULL) );
    $tpl->set("locationcheckcomments",$officialevaluation != NULL ? $officialevaluation->locationcheckcomments : NULL );
    $tpl->set("selectcertifiedoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->certified : NULL) );
    $tpl->set("certifiedcomments",$officialevaluation != NULL ? $officialevaluation->certifiedcomments : NULL );
    $tpl->set("selectprovidecardoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->providecard : NULL) );
    $tpl->set("providecardcomments",$officialevaluation != NULL ? $officialevaluation->providecardcomments : NULL );
    $tpl->set("selectcomheadcoachonlyoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->comheadcoachonly : NULL) );
    $tpl->set("comheadcoachonlycomments",$officialevaluation != NULL ? $officialevaluation->comheadcoachonlycomments : NULL );
    $tpl->set("selectconsistentoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->consistent : NULL) );
    $tpl->set("consistentcomments",$officialevaluation != NULL ? $officialevaluation->consistentcomments : NULL );
    $tpl->set("selectprofessionaloptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->professional : NULL) );
    $tpl->set("professionalcomments",$officialevaluation != NULL ? $officialevaluation->professionalcomments : NULL );
    $tpl->set("selectconcernsoptionsform",OfficialEvaluations_Row::CreateYesNoOptions($officialevaluation != NULL ? $officialevaluation->concerns : NULL) );
    $tpl->set("concernscomments",$officialevaluation != NULL ? $officialevaluation->concernscomments : NULL );
    $tpl->set("selectratingoptionsform",OfficialEvaluations_Row::CreateNumberOptions($officialevaluation != NULL ? $officialevaluation->rating : NULL) );
    $tpl->set("additionalcomments",$officialevaluation != NULL ? $officialevaluation->additionalcomments : NULL );
    $tpl->set("idofficialevaluations",$officialevaluation != NULL ? $officialevaluation->idofficialevaluations : NULL );
    $tpl->set('submittype',$officialevaluation != NULL ? "Edit" : "Submit");
    $tpl->set('view',$view);
    $main->set('content', $tpl->fetch('OfficialsEvaluationAddEvaluation.form.tpl.php'));
    echo $main->fetch('templates/pages/main.tpl.php');
} 

function DisplayEvaluationList($main, $sqlExecutorOfficialEvaluations, $officialevaluation ){
    $main->set('content', $sqlExecutorOfficialEvaluations->fetch(array(UID => $officialevaluation->iduser)));
    echo $main->fetch('templates/pages/main.tpl.php');
}

$db = new db();
Users_Row::Authentication($db);
$db->query("SET SESSION SQL_BIG_SELECTS=1");

$main = new TemplateLogger($db,'./');

try{
    $team = new Teams_Row($_REQUEST);
    $sql_Executor_Teams = new SqlExecutor( $db, $team ); 
    $schedule = new Schedule_Row($_REQUEST);
    $sql_Executor_Schedule = new SqlExecutor( $db, $schedule  );  
}
catch(Exception $e){
    $main->error($e);
}


$action = $_REQUEST['action'];
switch ($action){ 
    case selectGame:
        ChooseOfficalDisplay($main,$db, $sql_Executor_Schedule, $schedule, $team->Team_ID);
    	break;
     case AddOfficialDisplay:
        $officialType = $_REQUEST['officialtype'];
        AddOfficalDisplay($main, $db, $schedule->Game_ID, $team->Team_ID, $officialType );
        break;
     case AddOfficial:
        $officialType = $_REQUEST['officialtype'];
        try{
            $acceptType = $officialType;
            $acceptType .= "_Accepted";
            $sql_Executor_Schedule->UpdateValue(array($officialType => $_REQUEST['Id'], $acceptType => 1));
            $main->success("Official has been added.");
        }
            catch( Exception $e ){
                $message = "Failed to add official to schedule. ";
                $message .= $e->getMessage();
                $main->error($message);
        }
        ChooseOfficalDisplay($main,$db, $sql_Executor_Schedule, $schedule, $team->Team_ID);
        break;
     case DisplayEvaluation:
        $officialevaluation = new OfficialEvaluations_Row(array (idschedule => $schedule->Game_ID, idcontactinfo => $_REQUEST['official'], Team_ID => $team->Team_ID ));
        DisplayEvaluationForm($main,$team->Team_ID, $schedule->Game_ID,$_REQUEST['official'], $officialevaluation->getExsistingRow($db), isset($_REQUEST['view']) == true ? $_REQUEST['view'] : "false" );
        break;
     case AddEvaluation:
        $sql_Executor_OfficialEvaluations = new SqlExecutor( $db, new OfficialEvaluations_Row($_REQUEST) ); 
        try{
            $sql_Executor_OfficialEvaluations->insertAutoIncrement();
            $main->success("Your evaluation has been saved.");
        }
            catch( Exception $e ){
                $message = "Failed to add official Evaluation. ";
                $message .= $e->getMessage();
                $main->error($message);
        }
        ChooseOfficalDisplay($main,$db, $sql_Executor_Schedule, $schedule, $team->Team_ID);
        break;
     case EditEvaluation:
        $sql_Executor_OfficialEvaluations = new SqlExecutor( $db, new OfficialEvaluations_Row($_REQUEST) ); 
        try{
            $sql_Executor_OfficialEvaluations->Update();
            $main->success("Evaluation has been edited.");
        }
        catch( Exception $e ){
            $message = "Failed to edit evaluation. ";
            $message .= $e->getMessage();
            $main->error($message);
        }
        ChooseOfficalDisplay($main,$db, $sql_Executor_Schedule, $schedule, $team->Team_ID);
        break;
    case EditOfficial:
        $officialType = $_REQUEST['officialtype'];
        $idcontactinfo = $_REQUEST['idcontactinfo'];
        $forceedit = $_REQUEST['forceedit'];
        $officialevaluation = new OfficialEvaluations_Row(array (idschedule => $schedule->Game_ID, idcontactinfo => $_REQUEST['idcontactinfo'], Team_ID => $team->Team_ID ));
        $row = $officialevaluation->getAllExsistingRow($db);
        if ( NULL != $row  ){
            if( Yes == $forceedit){
                try{ 
                    $sql_Executor_OfficialEvaluations = new SqlExecutor( $db, $row );
                    $sql_Executor_OfficialEvaluations->Delete();
                    $main->success("Official evaluation has been deleted.");
                    //Try again in case there are two
                    //TODO: This needs to be improved on. we should just loop thru all the one we find rather than blindly trying again.
                    $rowtest = $officialevaluation->getAllExsistingRow($db);
                    if ( NULL != $rowtest){
                        $sql_Executor_OfficialEvaluations = new SqlExecutor( $db, $rowtest );
                        $sql_Executor_OfficialEvaluations->Delete();
                        $main->success("Official evaluation has been deleted.");   
                    }
                }
                catch( Exception $e ){
                    $message = "Failed to remove evaluation. ";
                    $message .= $e->getMessage();
                    $main->error($message);
                }
                AddOfficalDisplay($main, $db, $schedule->Game_ID, $team->Team_ID, $officialType, $idcontactinfo );
            }
            else if ( No == $forceedit ){
                ChooseOfficalDisplay($main,$db, $sql_Executor_Schedule, $schedule, $team->Team_ID);
            }
            else{
              $officialevaluation->DoYouWantToEditDisplay($main, $schedule->Game_ID, $team->Team_ID);  
            }
        }
        else{
            AddOfficalDisplay($main, $db, $schedule->Game_ID, $team->Team_ID, $officialType, $idcontactinfo );
        }
        
        break;
    case EvalList:
        $officialevaluation = new OfficialEvaluations_Row();
        $sql_Executor_OfficialEvaluations = new SqlExecutor($db, $officialevaluation);
        $sql_Executor_OfficialEvaluations->SearchWithOwnSelect( OfficialEvaluations_Row::GetSelectStatement(), $officialevaluation->whereStatementForAllEvals());
        DisplayEvaluationList($main, $sql_Executor_OfficialEvaluations,$officialevaluation);
        break;
    default :
        DefaultDisplay($main,$db, $sql_Executor_Teams);
}

?>
