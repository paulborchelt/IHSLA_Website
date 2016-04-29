<?php

require_once ('row.php');
class Position_Row extends Row {
   protected $Position_ID;
   protected $Description;

   function __construct($array = null) {
      $this->Position_ID = $array['Position_ID'];
      $this->Description = $array['Description'];      
   }
   
   static function GetOptions( $database, $previousValue = NULL){
        $sql_Statement = "SELECT * 
                          FROM Position";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $Description = $row->Description;
            if( $Description == $previousValue)
            {
                $options .= "<option selected value = $row->Position_ID>$Description</OPTION>";
            }
            else
            {
                $options .= "<option value = $row->Position_ID>$Description</OPTION>";
            }
        }       
        return $options;
    }
}
?>