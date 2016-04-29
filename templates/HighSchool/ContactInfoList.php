
<?php

require_once ('../classes/database.php');
require_once ('../classes/templateengine/template.php');
require_once ('../classes/templateengine/templatelogger.php');
require_once ('../classes/sqlexecutor.php');
require_once ('../classes/dataclasses/contactinfo_row.php');

$db = new db();

$main = new TemplateLogger($db, './');  

try{
    $sql_ContactInfo = new SqlExecutor( $db, new ContactInfo_Row($_REQUEST) );   
}
catch(Exception $e){
    $main->error($e);
}

$sql_ContactInfo->Search( "LEFT JOIN ContactInfoTeamsList on CID = id
                           LEFT JOIN ContactType on ContactType.ID = CTID
                           LEFT JOIN Teams on TID = Team_ID WHERE MainContact = 1 AND League = 1 ");
$main->set('content', $sql_ContactInfo->fetchThisTemplate("../templates/ContactInfoList.tpl.php"));
echo $main->fetch('../templates/pages/main.tpl.php');  

?>