<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/news_row.php');
require_once ('../classes/navigation.php');
require_once ('../classes/dataclasses/users_row.php');

$db = new db();

$main = new TemplateLogger($db,'./'); 
$page = new TemplateLogger($db,'./');
$navbar = new TemplateLogger($db,'./');

$navigation = new Navigation($_REQUEST, About);
$navbar->set(navigation, $navigation);
$page->set(leagueinfonavbar,$navbar->fetch('../templates/pages/leagueinfonavbar.tpl.php')); 

switch ($navigation->subpage){ 
 case Board:
   $main->set(content,$page->fetch('../templates/pages/leageinfo.tpl.php'));
   break;
 case ByLaws:
   $main->set(content,$page->fetch('../templates/pages/bylaws.tpl.php'));
   break;
 case History:
   $main->set(content,$page->fetch('../templates/pages/history.tpl.php'));
   break;
 case Officials:
   $main->set(content,$page->fetch('../templates/pages/officials.tpl.php'));
   break;
 case About:
   $main->set(content,$page->fetch('../templates/pages/aboutandmission.tpl.php'));
   break;
 case Dates:
   $main->set(content,$page->fetch('../templates/pages/leaguedates.tpl.php'));
   break;
 case Join:
   $main->set(content,$page->fetch('../templates/pages/leaguejoin.tpl.php'));
   break;
 default:
   $main->set(content,$page->fetch('../templates/pages/aboutandmission.tpl.php'));  
}
 
echo $main->fetch('../templates/pages/main.tpl.php');  

?>









