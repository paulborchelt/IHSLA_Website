<?php
require_once('row.php');
class Issues_Row extends Row{
   protected $id;
   protected $title;
   protected $description;
   
   function __construct( $array = null){
      	$this->id = $array['id'];
      	$this->title = $array['title'];
        $this->description = $array['description'];
   }
   
   function getForm($listOfIssues){
		$tpl = new Template('templates/');
		$tpl->set('list_of_issues', $listOfIssues );
		return $tpl->fetch('Issues.form.tpl.php');
   }
   
   //Edit form should exclude the list of issue but allow 
   //user to enter teams invovled with the issue. 
   function getEditForm($listOfTeams){
        $tpl =  new Template('templates/');
        $tpl->set('issue',$this);
        $tpl->set('list_of_teams',$listOfTeams);
		return $tpl->fetch('Issues.form.tpl.php');
   }
    
}
?>