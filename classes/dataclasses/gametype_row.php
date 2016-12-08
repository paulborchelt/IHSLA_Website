<?php
require_once('row.php');
class GameType_Row extends Row{
   protected $id_gametype;
   protected $name_gametype;
   
   function __construct( $array = null){
          	$this->id_gametype = $array['id_gametype'];
          	$this->name_gametype = $array['name_gametype'];
   }
   
   //NOTE: Currenlty the Game_Type column does not use the ID from this table.
   static function GetOptions( $database, $previousValue = NULL){
        $sql_Statement = "SELECT * 
                          FROM gametype";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
           // $id_gametype = $row->id_gametype;
            $name_gametype = $row->name_gametype;
            if( $name_gametype == $previousValue)
            {
                $options .= "<option selected value = $name_gametype>$name_gametype</OPTION>";
            }
            else
            {
                $options .= "<option value = $name_gametype>$name_gametype</OPTION>";
            }
        }       
        return $options;
    }
}
?>