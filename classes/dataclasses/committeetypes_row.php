<?
require_once('row.php');
class CommitteeTypes_Row extends Row{
   protected $id;
   protected $name;
   
   function __construct( $array = null){
      	$this->id = $array['id'];
      	$this->name = $array['name'];
   }
   
   static function GetOptions( $database ){
        $sql_Statement = "SELECT * FROM CommitteeTypes";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $id = $row->id;
            $name = $row->name;
            {
                $options .= "<option value = $id>$name</OPTION>";
            }
        }       
        return $options;
    }
}
?>