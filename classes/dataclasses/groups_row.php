<?php
require_once('row.php');

class Groups_Row extends Row{
   
   const Administrators = 1;
   const TeamAdmin = 2;
   const Officials = 4;
   const Scheduler = 8;
   const News = 16;
   const TeamAdminYouth = 32;
   const AdministratorsYouth = 64;
   const IndianaUSL = 64;
   protected $GID;
   protected $GroupName;
   
   function __construct( $array = null){
   	$this->GID = $array['GID'];
   	$this->GroupName = $array['GroupName'];
   }
   
   static function setflag(&$var, $flag, $set=ON ) {
      if (($set == ON)) $var = ($var | $flag);
      if (($set == OFF)) $var = ($var & ~$flag);
      return;
   }
   
   static function getOptions($database, $sql_Executor_GroupList){
      $permissions;
      while ( $row = $sql_Executor_GroupList->fetchNextObject() ){
   	  Groups_Row::setflag($permissions,$row->GID);
   	}
  	   $sql_Statement = "SELECT * FROM Groups";   
   	$database->query($sql_Statement);
      while ( $row = $database->fetchNextObject() ){
         //NOTE: this does not work
   		if( $permissions | $row->GID)
   		{
   			$GroupOptions .= "<option value =$row->GID> $row->GroupName </OPTION>";
   		}
   	}
      return $GroupOptions;
   }
}
?>