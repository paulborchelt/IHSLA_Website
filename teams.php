<?php

require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/validateException.php');
require_once ('classes/dataclasses/contactinfo_row.php');
require_once ('classes/dataclasses/contactinfoteamslist_row.php');
require_once ('classes/dataclasses/rosters_row.php');
require_once ('classes/dataclasses/points_row.php');
require_once ('classes/dataclasses/saves_row.php');
require_once ('classes/dataclasses/schedule_row.php');
require_once ('classes/selectYear.php');
require_once ('classes/mydatetime.php');
require_once ('classes/navigation.php');


function DefaultDisplay($teams, $sqlExecutorTeams, $sqlExecutorContacts, $navbar, $edit ){
    $team = $sqlExecutorTeams->GetValueById();
    $sqlExecutorContacts->SearchWithOwnSelect(ContactInfo_Row::GetSelectStatement(),ContactInfo_Row::GetWhereStatement($team->Team_ID));
    $tpl = new Template('templates/');
    $tpl->set('team',$team->getTeamView(Test));
    $tpl->set('teamcontacts',ContactInfo_Row::fetchTeamView($sqlExecutorContacts, $team->Team_ID, $edit));
    $tpl->set('navbarteam', $navbar->fetch('templates/pages/teamnavbar.tpl.php'));
    $teams->set('content', $tpl->fetch('TeamInfo.tpl.php'));
    echo $teams->fetch('templates/pages/teams.tpl.php');    
}

function DisplayTeamMessages($teams, $navbar){
   $tpl = new Template('templates/');
   $tpl->set('navbarteam', $navbar->fetch('templates/pages/teamnavbar.tpl.php'));
   $teams->set('content', $tpl->fetch('TeamInfo.tpl.php'));
   echo $teams->fetch('templates/pages/teams.tpl.php');  
}

function DisplayRoster($teams, $sqlExecutorRosters, $navbar){
   $tpl = new Template('templates/');
   $tpl->set('navbarteam', $navbar->fetch('templates/pages/teamnavbar.tpl.php'));
   $tpl->set('roster', $sqlExecutorRosters->fetch( array( showSchool => $_REQUEST['showSchool'] )));
   $teams->set('content', $tpl->fetch('TeamRoster.tpl.php'));
   echo $teams->fetch('templates/pages/teams.tpl.php');    
}

function DisplayPiontsOrSaves($teams, $sqlExecutorTeams, $sqlExecutorPointsOrSaves, $navbar, $navigation){   
   $team = $sqlExecutorTeams->GetValueById();
   $selectYear = new selectYear($team->Team_ID);
   $tpl = new Template('templates/');
   $tpl->set('navbarteam', $navbar->fetch('templates/pages/teamnavbar.tpl.php'));
   $tpl->set('selectYear', $selectYear->fetchYearOptions($_REQUEST['Year'],$navigation->subpage));
   $tpl->set('stats', $sqlExecutorPointsOrSaves->fetch());
   $teams->set('content', $tpl->fetch('TeamStats.tpl.php'));
   echo $teams->fetch('templates/pages/teams.tpl.php');    
}

function DisplayStats($teams, $sqlExecutorTeams, $sqlPoints, $navbar){   
   $team = $sqlExecutorTeams->GetValueById();
   $selectYear = new selectYear($team->Team_ID);
   $tpl = new Template('templates/');
   $tpl->set('navbarteam', $navbar->fetch('templates/pages/teamnavbar.tpl.php'));
   $tpl->set('selectYear', $selectYear->fetchYearOptions($_REQUEST['Year'],"Stats"));
   $tpl->set('stats', $sqlPoints->fetchThisTemplate("Stats.tpl.php"));
   $teams->set('content', $tpl->fetch('TeamStats.tpl.php'));
   echo $teams->fetch('templates/pages/teams.tpl.php');    
}

function DisplaySchedule($teams, $sqlExecutorTeams, $sqlExecutorSchedule, $navbar){ 
   $team = $sqlExecutorTeams->GetValueById();
   $sqlExecutorSchedule->SearchWithOwnSelect(Schedule_Row::GetSelectStatement(),Schedule_Row::GetCurrentYearForTeam(1, $team->Team_ID));
   $teams->set('content', $sqlExecutorSchedule->fetchThisTemplate("TeamSchedule.tpl.php",array( Team_ID => $team->Team_ID, 
                                                                                                             navbarteam => $navbar->fetch('templates/pages/teamnavbar.tpl.php'))));
   echo $teams->fetch('templates/pages/teams.tpl.php');    
}

function EditDisplay($db, $main, $sqlExecutorContacts, $sqlExecutorTeamContactInfoList, $sqlExecutorTeams ){
    $teamContactInfoList = $sqlExecutorTeamContactInfoList->GetValueById();
    $team = $sqlExecutorTeams->GetValueById();
    $contact = $sqlExecutorContacts->GetValueById();
    $contact->setInfoTeamsListObject($teamContactInfoList);
    $main->set('content', ContactInfo_Row::getForm($db, $contact, $team->Team_ID, 0));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

function NewContactDisplay($db, $main, $sqlExecutorTeams, $newcontact = false ){
    $team = $sqlExecutorTeams->GetValueById();
    $main->set('content', ContactInfo_Row::getForm($db, null, $team->Team_ID, $newcontact));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

function DisplayDuplicate($main, $sqlExecutor, $contactInfo, $Team_ID, $CTID, $MainContact ){
    $main->set('content', ContactInfo_Row::getDuplicateForm($sqlExecutor, $contactInfo, $Team_ID, $CTID, $MainContact));
    echo $main->fetch('templates/pages/main.tpl.php');    
}

$db = new db();

$teams = new TemplateLogger($db,'./');
$navbar = new TemplateLogger($db,'./');
$navigation = new Navigation($_REQUEST, ContactInfo);
$navbar->set(navigation, $navigation);
$navbar->set(Team_ID, Teams_Row::getTeamIdRequest(3));



$user = Users_Row::getUser($db);

try{
    $team = new Teams_Row($_REQUEST);
    $sql_Executor_Teams = new SqlExecutor( $db, $team );
    if( NULL == $user ){
      $edit = false;
    }
    else{
      $edit = $user->hasEditContactPermisions($team->Team_ID);
    }
    $sql_Executor_TeamsClub = new SqlExecutor( clone $db, new Teams_Row($_REQUEST) );
    $contactInfo = new ContactInfo_Row($_REQUEST);
    $sql_Executor_Contacts = new SqlExecutor( $db, $contactInfo ); 
    $sql_Executor_TeamContactInfoList = new SqlExecutor( $db, new ContactInfoTeamsList_Row($_REQUEST) );  
    $sql_Executor_Teams->Search(Teams_Row::GetWhereStatementforIHSLAVarsityOnly());
    $sql_Executor_TeamsClub->Search(Teams_Row::GetWhereStatementforIHSLAClubOnly());
    $teams->set('sidebar',$sql_Executor_Teams->fetchThisTemplate('TeamSideBar.tpl.php', array(navigation => $navigation, clubResults => $sql_Executor_TeamsClub))); 
}
catch(Exception $e){
    $teams->error($e);
}


switch ($navigation->subpage){ 
	case TeamMessages:
      DisplayTeamMessages($teams,$navbar); 
	break;

	case Roster:
      $rosters = new Rosters_Row($_REQUEST);
      $sql_Executor_Rosters = new SqlExecutor( $db, $rosters ); 
      $sql_Executor_Rosters->Search($rosters->GetRosterByYear());
      DisplayRoster($teams, $sql_Executor_Rosters, $navbar);
	break;
   case Scoring:
      $points = new Points_Row($_REQUEST);
      $sql_Executor_Points = new SqlExecutor( $db, $points ); 
      $sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetPointsByYearAndTeam());
      DisplayPiontsOrSaves($teams, clone $sql_Executor_Teams, $sql_Executor_Points,$navbar, $navigation);
   break;
   case Goalie:
      $saves = new Saves_Row($_REQUEST);
      $sql_Executor_Saves = new SqlExecutor( $db, $saves ); 
      $sql_Executor_Saves->SearchWithOwnSelect($saves->selectStatement(), $saves->GetSavesByYearAndTeam());
      DisplayPiontsOrSaves($teams, clone $sql_Executor_Teams, $sql_Executor_Saves,$navbar, $navigation);
   break;
   case Stats:
      $points = new Points_Row($_REQUEST);
      $sql_Executor_Points = new SqlExecutor( $db, $points ); 
      $sql_Executor_Points->SearchWithOwnSelect($points->selectStatement(), $points->GetStatsByYearAndTeam());
      DisplayStats($teams, clone $sql_Executor_Teams, $sql_Executor_Points,$navbar);
   break;
   case Schedule:
      $sql_Executor_Schedule = new SqlExecutor( $db, new Schedule_Row($_REQUEST));
      DisplaySchedule($teams, clone $sql_Executor_Teams, $sql_Executor_Schedule, $navbar);
   break;
   
	default :
      $action = $_REQUEST['action'];
      switch ($action){ 
         case Enter:
           try{
              $sql_Executor_Teams->insertAutoIncrement();
              $teams->success("team has been added.");
           }
           catch( Exception $e ){
               $teams->error("Failed to enter team. ". $e->getMessage());
           }
           DefaultDisplay($teams,$sql_Executor_Teams,$db, $league, $link, $navbar, $edit);
       	break;
        case Delete:
           $deleteContact = FALSE;
           try{
               $sql_Executor_TeamContactInfoList->Delete();
               $deleteContact = TRUE;
               $teams->success("Contact has been removed from your team.");
           }
           catch (Exception $e ){
               $teams->error("Failed to remove contact from your team. " . $e->getMessage());
           }
           if(  TRUE == $deleteContact){
                try{
                   $sql_Executor_Contacts->Delete();
                   $teams->success("Contact has been deleted.");
               }
               catch (validateException $e){
                  $teams->info("Contact will remain in the database." . $e->getMessage());
               }
               catch( Exception $e ){
                   $teams->error("Failed to delete contact. " . $e->getMessage());
               }
               
           }
           DefaultDisplay($teams,$sql_Executor_Teams, $sql_Executor_Contacts, $navbar, $edit);
           break;
        case Edit:
           EditDisplay($db, $teams,$sql_Executor_Contacts,$sql_Executor_TeamContactInfoList, $sql_Executor_Teams);
           break;
        case SubmitEdit:
           try{
               $sql_Executor_Contacts->Update();
               $team = $sql_Executor_Teams->GetValueById();
               //NOTE: using the REQUEST here because we know the values we want will be posted by the form. 
               //These REQUEST will also get populated into the corrisponding object but how do we get to those objects from here.
               //Might want to find a better way to do this in the future. 
               $sql_Executor_ContactInfoTeamsList = new SqlExecutor( $db, new ContactInfoTeamsList_Row( array(contactinfoteamslistid => $_REQUEST['contactinfoteamslistid'], CID => $_REQUEST['Id'], TID => $team->Team_ID, CTID => $_REQUEST['CTID'], MainContact => $_REQUEST['MainContact'])) );
               $sql_Executor_ContactInfoTeamsList->Update();
               $teams->success("Contact has been updated.");
           }
           catch( Exception $e ){
               $teams->error("Failed to edit contact. ". $e->getMessage());
           }
           DefaultDisplay($teams,$sql_Executor_Teams, $sql_Executor_Contacts, $navbar, $edit);
           break;
        case AddContact:
           NewContactDisplay($db, $teams, clone $sql_Executor_Teams);
           break;
        case EnterContact:
           $team = $sql_Executor_Teams->GetValueById();
           try{
              $contactID = $sql_Executor_Contacts->insertAutoIncrement($_REQUEST['Force']);
              //Now add them to this team. 
              $sql_Executor_ContactInfoTeamsList = new SqlExecutor( $db, new ContactInfoTeamsList_Row( array(CID => $contactID, TID => $team->Team_ID, CTID => $_REQUEST['CTID'], MainContact => $_REQUEST['MainContact'])) );
              $sql_Executor_ContactInfoTeamsList->insertAutoIncrement();
              $teams->success("Contact has been created and added to your team.");
           }
           catch( DuplicateContactInfoException $e ){
               DisplayDuplicate($teams, $e->getSQLExecutor(), $contactInfo, $team->Team_ID, $_REQUEST['CTID'], $_REQUEST['MainContact']);
               break;
           }
           catch( Exception $e ){
               $teams->error("Failed to create contact. ". $e->getMessage());
           }
           DefaultDisplay($teams,$sql_Executor_Teams,$sql_Executor_Contacts, $navbar, $edit);
           break;
        case AddExistingContact:
            try{
              $team = $sql_Executor_Teams->GetValueById();
              $sql_Executor_ContactInfoTeamsList = new SqlExecutor( $db, new ContactInfoTeamsList_Row( array(CID => $contactInfo->Id, TID => $team->Team_ID, CTID => $_REQUEST['CTID'], MainContact => $_REQUEST['MainContact'])) );
              $sql_Executor_ContactInfoTeamsList->insertAutoIncrement();
              $teams->success("The exsisting contact has been added to your team.");
           }
           catch( Exception $e ){
               $teams->error("Failed to add the exsisting contact to your team. ". $e->getMessage());
           }
           DefaultDisplay($teams,$sql_Executor_Teams,$sql_Executor_Contacts, $navbar, $edit);
           break;
        default:
           DefaultDisplay($teams,clone $sql_Executor_Teams,$sql_Executor_Contacts, $navbar, $edit); 
      }
      
}

 

?>