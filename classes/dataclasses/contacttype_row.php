<?php
require_once('row.php');
class ContactType_Row extends row{
   protected $ID;
   protected $Type;
   
   function __construct( $array ){
      //if( null != $array ){
      	$this->ID = $array['ID'];
      	$this->Type = $array['Type'];    
      	
      //}

   }
   
   static function GetOptions( $database, $previousValue = NULL ){       
        $sql_Statement = "SELECT * 
                          FROM ContactType";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $ID = $row->ID;
            $Type = $row->Type;
            if( $ID == $previousValue)
            {
                $options .= "<option selected value = $ID>$Type</OPTION>";
            }
            else
            {
                $options .= "<option value = $ID>$Type</OPTION>";
            }
        }       
        return $options;
    }
    
    static function GetMainConactOptions( $database, $previousValue = 0 ){       
        if( 0 == $previousValue){
            $options .= "<option selected value = 0 >No</OPTION>";
            $options .= "<option value = 1 >Yes</OPTION>";
        }
        else{
            $options .= "<option selected value = 1>Yes</OPTION>";
            $options .= "<option value = 0 >No</OPTION>";
        }     
        return $options;
    }
}
?>