<?
require_once('row.php');
class Field_Info_Row extends Row{
    protected $field_id;
    protected $field_teamid;
    protected $field_name;
    protected $field_address;
    protected $field_city;
    protected $field_zip;
    protected $field_directions;
    
   function __construct( $array = null){
        $this->field_id = $array['field_id'];
        $this->field_teamid = $array['field_teamid'];
        $this->field_name = $array['field_name'];
        $this->field_address = $array['field_address'];
        $this->field_city = $array['field_city'];
        $this->field_zip = $array['field_zip'];
        $this->field_directions = $array['field_directions'];
    }
    
   static function GetOptions( $database, $previousValue = NULL ){
        $sql_Statement = "SELECT * 
                          FROM Field_Info";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $ID = $row->field_id;
            $Name = $row->field_name;
            if( $ID == $previousValue)
            {
                $options .= "<option selected value = $ID>$Name</OPTION>";
            }
            else
            {
                $options .= "<option value = $ID>$Name</OPTION>";
            }
        }       
        return $options;
    }
    
    static function findFieldInfo($db, $field_id){
      $sql = "Select * FROM Field_Info WHERE $field_id = field_id";
      $db->query($sql);
      $fieldInfo = new Field_Info_Row($db->fetchNextArray());
      return $fieldInfo;
   }
}
?>