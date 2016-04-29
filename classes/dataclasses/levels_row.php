<?
require_once('row.php');
class Levels_Row extends Row{
   protected $Level_ID;
   protected $Level_Description;
   
   function __construct( $array = null){
          	$this->Level_ID = $array['Level_ID'];
          	$this->Level_Description = $array['Level_Description'];
   }

   //NOTE: Currenlty the Game_Level column does not use the ID from this table.
   static function GetOptions( $database, $previousValue = NULL){
        $sql_Statement = "SELECT * 
                          FROM Levels";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            //$Level_ID = $row->Level_ID;
            $Level_Description = $row->Level_Description;
            if( $Level_Description == $previousValue)
            {
                $options .= "<option selected value = $Level_Description>$Level_Description</OPTION>";
            }
            else
            {
                $options .= "<option value = $Level_Description>$Level_Description</OPTION>";
            }
        }       
        return $options;
    }
}
?>