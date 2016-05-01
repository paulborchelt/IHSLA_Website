<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/dataclasses/users_row.php');

$db = new db();

$main = new TemplateLogger($db,'./'); 
$page = new TemplateLogger($db,'./') ;

$action = $_REQUEST['action'];
switch ($action){ 
    case play:
      $main->set(content,$page->fetch('../templates/pages/playlacrosse.tpl.php')); 
      break;
    case coach:
      $main->set(content,$page->fetch('../templates/pages/coachlacrosse.tpl.php')); 
      break;
    case offiiciate:
      $main->set(content,$page->fetch('../templates/pages/officiatelacrosse.tpl.php'));
      break;
    case donate:
      $main->set(content,$page->fetch('../templates/pages/donatelacrosse.tpl.php'));
      break;
    case start:
      $main->set(content,$page->fetch('../templates/pages/startteamlacrosse.tpl.php'));
      break;
    case awards:
      $main->set(content,$page->fetch('../templates/pages/leagueAwards.php'));
      break;
    case hclc:
      $main->set(content,$page->fetch('../templates/pages/HCLCAwards.php'));
      break;
    case nihsla:
      $main->set(content,$page->fetch('../templates/pages/NIHSLA.tpl.php'));
      break;
    case uslaxspeaker:
      $main->set(content,$page->fetch('../templates/pages/USLaxSpeaker.tpl.php'));
      break;
    case fallmeeting:
      $main->set(content,$page->fetch('../templates/pages/fallmeeting.tpl.php'));
      break;
    case uslmeeting:
      $main->set(content,$page->fetch('../templates/pages/USLGeneralMeeting.tpl.php'));
      break;
    case uslaxclinic:
      $main->set(content,$page->fetch('../templates/pages/USLaxClinic.tpl.php'));
      break;
    case uslaxclinic2016:
      $main->set(content,$page->fetch('../templates/pages/USLaxClinic2016.tpl.php'));
      break;
    default:
       $main->set(content,$page->fetch('../templates/pages/playlacrosse.tpl.php')); 
}

echo $main->fetch('../templates/pages/main.tpl.php');

?>