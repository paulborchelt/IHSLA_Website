<?PHP
class SqlStringCreator{
    //This is the string that will be added the end of our data objects.
    static public $sTableSuffix = "_Row";
    
    private $_fieldValueString;
    private $_tableName;
    private $_searchValueString;
    
    function SqlStringCreator( $tableName ){
        if( null == $tableName){
            throw new Exception('SqlStringCreator constructor passed null table.');
        }
        $this->_tableName = $tableName;
        $this->_fieldValueString = "";  
    }
    
    static function GetTableName( $object ){
        if( null == $object ){
            throw new Exception ('SqlStringCreator GetTableName passed a null object.');
        }
        
        $table_Name = get_class($object);
        if ( false === strpos($table_Name, SqlStringCreator::$sTableSuffix) ) {
            throw new Exception ("SqlStringCreator GetTableName object missing proper suffix (" .SqlStringCreator::$sTableSuffix .").");
        }
        
        return str_replace(SqlStringCreator::$sTableSuffix,"",$table_Name);
    } 
    
    //function addValue( $field, $value){
//        //TODO: Need to add unit test for this if statement
//        if( "" != $this->_fieldValueString){
//            $this->_fieldValueString .= ",";
//        }
//        $this->_fieldValueString .= $field;
//        $this->_fieldValueString .= "=";
//        
//        if($value == null){
//            $this->_fieldValueString = null;
//        }
//        else{
//           $this->_fieldValueString .= "'";
//           $this->_fieldValueString .= $value;
//           $this->_fieldValueString .= "'"; 
//        }
//    }
    
    function addValue( $field, $value){
        //TODO: Need to add unit test for this if statement
        if( "" != $this->_fieldValueString){
            $this->_fieldValueString .= ",";
        }
        $this->_fieldValueString .= $field;
        $this->_fieldValueString .= "=";
        
    
       $this->_fieldValueString .= "'";
       $this->_fieldValueString .= $value;
       $this->_fieldValueString .= "'"; 
    }
    
    function getInsertStatement(){
        if( "" == $this->_fieldValueString){
            throw new Exception("No values added to SqlStringCreator to use to create statement.");
        }
        $sql = "INSERT INTO $this->_tableName SET $this->_fieldValueString";
        return $sql;
    }
    
    function getUpdateStatement(){
        if( "" == $this->_fieldValueString){
            throw new Exception("No values added to SqlStringCreator to use for the update statement.");
        }
        
        if( "" == $this->_searchValueString){
            throw new Exception("No search values added to SqlStringCreator to use for the update statement.");
        }
        $sql = "UPDATE $this->_tableName SET $this->_fieldValueString $this->_searchValueString";
        return $sql;
    }
    
    function addSearchValue( $field, $value){
        if( "" == $value || null == $value || " " == $value ){
            throw new Exception("Search value null or empty.");
        }
        
        $this->_searchValueString = "WHERE ";
        $this->_searchValueString .= $field;
        $this->_searchValueString .= "=";
        $this->_searchValueString .= "'";
        $this->_searchValueString .= $value;
        $this->_searchValueString .= "'";
    }
    
    function addSearchStatement( $statement ){        
        $this->_searchValueString = $statement;
    }
    
    //TODO: Add unit test
    function getDeleteStatement(){       
        if( "" == $this->_searchValueString){
            throw new Exception("No search values added to SqlStringCreator to use for the delete statement.");
        }
        $sql = "DELETE FROM $this->_tableName $this->_searchValueString";
        return $sql;
    }
	
}
?>