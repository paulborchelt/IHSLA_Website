<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/schedule_row.php');
require_once ('../classes/dataclasses/points_row.php');
require_once ('../classes/dataclasses/saves_row.php');

$db = new db();

$main = new TemplateLogger($db,'./');  

$sql = "Select * from Schedule ";
$db->query($sql,1);
while ( $schedule = $db->fetchNextObject()){
   $sqlref = "Select * from ContactInfo Where $schedule->Referee = pn_uid";
   $db->query($sqlref);
}
  

?>