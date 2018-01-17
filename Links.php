<?php

require_once ('classes/database.php');
require_once ('classes/templateengine/template.php');
require_once ('classes/templateengine/templatelogger.php');
require_once ('classes/sqlexecutor.php');
require_once ('classes/dataclasses/news_row.php');

$db = new db();

$main = new TemplateLogger($db,'./');  

echo $main->fetch('templates/pages/links.tpl.php');  

?>