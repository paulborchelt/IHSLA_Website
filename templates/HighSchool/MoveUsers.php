<?php
   require_once ('../classes/database.php');
   require_once ('../classes/templateengine/templatelogger.php');
	$sql = "Select * from ContactInfo";
   $db = new db();
   $db2 = new db();
   $db->query($sql);
   while ( $contacinfo = $db->fetchNextObject() ){
      if( $contacinfo->pn_uid != NULL ){
         $sql2 = "Update Users set contactinfo_id = $contacinfo->Id where $contacinfo->pn_uid = userid";
         $db2->query($sql2);
      }
   }
?>