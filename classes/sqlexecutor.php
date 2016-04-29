<?PHP
require_once('sqlstringcreator.php');
require_once('dataclasses/rowlist.php');
//require_once('../HighSchool/functions.php');
class SqlExecutor{
    
    private $_dataObject;
    private $_database;
    function __construct( $database ,$dataObject ){
        if( null == $database){
            throw new Exception('SqlExecutor constructor passed null database.');
        }
        
        if( null == $dataObject){
            throw new Exception('SqlExecutor constructor passed null dataObject.');
        }
        
        $this->_database = $database;
        $this->_dataObject = $dataObject;
    }
    
    public function insertAll(){
        return $this->Insert("All");
    }
    
    public function insertAutoIncrement( $force = null){
        return $this->Insert("Auto", $force);
    }
	
    private function Insert($type = "Auto", $force = null ){
        $this->_dataObject->ValidateValues();
        if( "Force" != $force){
          $this->_dataObject->CheckForDuplicates($this->_database);
        }
        
        
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $property_count = 0;
        foreach ($properties as $property) { 
            $property_count = $property_count + 1;
            //The first propery will always be the primary - so skip it
            if( 1 != $property_count || "All" == $type){
                $property_name = $property->getName();
                //skip any property with a _ because it is a joined property that does not need to be entered.
                //TODO: Add unit test for below.
                if( 0 !== strrpos($property_name, "_")){
                    $Sql_String_Creator->addValue($property_name,$this->_dataObject->$property_name);
                }            
            }
        }
        
        $this->_database->execute($Sql_String_Creator->getInsertStatement());
        //add unit test for this return
        $value = $this->_database->lastInsertedId();
        $this->_dataObject->SendEmail($this->_database);
        return $value;
    }
    
    public function Update(){
        $this->_dataObject->PrepUpdateEmail($this->_database);
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $property_count = 0;
        $primary_property_name = null;
        foreach ($properties as $property) { 
            $property_count = $property_count + 1;
            //The first propery will always be the primary - so set it so
            if( 1 == $property_count ){
                $primary_property_name = $property->getName();
            }
            else{
                $property_name = $property->getName();
                //skip any property with a _ because it is a joined property that does not need to be entered.
                //TODO: Add unit test for below.
                if( 0 !== strrpos($property_name, "_")){
                    
                    $Sql_String_Creator->addValue($property_name,$this->_dataObject->$property_name);
                }
            }
        }
        
        $Sql_String_Creator->addSearchValue($primary_property_name,$this->_dataObject->$primary_property_name);
        
        $this->_database->execute($Sql_String_Creator->getUpdateStatement());
        $this->_dataObject->SendUpdateEmail($this->_database);
    }
    
    public function UpdateValue( $updateArray ){
        
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $primary_property_name = null;
        foreach($updateArray as $key => $value ){
            $bFound = 0;
            foreach ($properties as $property) { 
                $property_count = $property_count + 1;
                //The first propery will always be the primary - so set it so
                if( 1 == $property_count ){
                    $primary_property_name = $property->getName();
                }
                else{
                    $property_name = $property->getName(); 
                }
                if( $property_name == $key){
                    $bFound = 1;
                    break;
                }
            }
            if( $bFound == 0 ){
                throw new Exception("The key " . $key . " was not found in the data class.");
            }else{
                $Sql_String_Creator->addValue($property_name,$value);
            } 
        }
        
        $Sql_String_Creator->addSearchValue($primary_property_name,$this->_dataObject->$primary_property_name);
        
        $this->_database->execute($Sql_String_Creator->getUpdateStatement());
    }
    
    public function UpdateWithOwnSearchStatement($statement){
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $property_count = 0;
        $primary_property_name = null;
        foreach ($properties as $property) { 
            $property_count = $property_count + 1;
            //The first propery will always be the primary - so set it so
            if( 1 == $property_count ){
                $primary_property_name = $property->getName();
            }
            else{
                $property_name = $property->getName();
                //skip any property with a _ because it is a joined property that does not need to be entered.
                //TODO: Add unit test for below.
                if( 0 !== strrpos($property_name, "_")){
                    
                    $Sql_String_Creator->addValue($property_name,$this->_dataObject->$property_name);
                }
            }
        }
        $Sql_String_Creator->addSearchStatement($statement);
        $this->_database->execute($Sql_String_Creator->getUpdateStatement());
    }
    
    public function Search($where = null){
        $sql_Statement = "SELECT * FROM ";
        $sql_Statement .= SqlStringCreator::GetTableName($this->_dataObject);
        if( null != $where ){
            $sql_Statement .= " ";
            $sql_Statement .= $where;  
        }
        $this->_database->query($sql_Statement);
    }
    
    //TODO: Create unit test
    public function SearchWithOwnSelect($select, $where){
        $sql_Statement = $select;
        $sql_Statement .= " FROM ";
        $sql_Statement .= SqlStringCreator::GetTableName($this->_dataObject);
        if( null != $where ){
            $sql_Statement .= " ";
            $sql_Statement .= $where;  
        }
        $this->_database->query($sql_Statement);
        
    }
    
    //TODO: Create unit test
    public function fetchNextObject(){
        $className = SqlStringCreator::GetTableName($this->_dataObject);
        $className .= "_Row";  //TODO: use static or  figure better way to get name
        if ($row = $this->_database->fetchNextArray() ){
            return new $className($row);
        }
        else{
            return false;
        }
    }
    
    //TODO: Write unit test
    public function fetch($values = null){
      $tpl = new Template('../templates/');
		$tpl->set('result', new RowList($this) );
      if(null != $values){
            foreach( $values as $variable => $value ){
                $tpl->set($variable,$value);
            }
      }
      $template_Name = SqlStringCreator::GetTableName($this->_dataObject);
      $template_Name .= ".tpl.php";        
		return $tpl->fetch($template_Name);
   }
   
   //TODO: Create Unit Test for this function. 
   public function fetchThisTemplate($template_Name, $values = null){
        $tpl = new Template('../templates/');
		$tpl->set('result', new RowList($this) );
        if(null != $values){
            foreach( $values as $variable => $value ){
                $tpl->set($variable,$value);
            }
        }       
		return $tpl->fetch($template_Name);
   }
   
   
   //Could Throw:
   //queryUniqueObject
   public function GetValueById(){
    
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $property_count = 0;
        $primary_property_name = null;
        foreach ($properties as $property) { 
            $property_count = $property_count + 1;
            //The first propery will always be the primary - so set it so
            if( 1 == $property_count ){
                $primary_property_name = $property->getName();
            }
            else{
                break;
            }
        }
        
        //TODO: add to sqlstringcreator
        $sql_Statement = "SELECT * FROM ";
        $sql_Statement .= SqlStringCreator::GetTableName($this->_dataObject);
        $sql_Statement .= " WHERE ";
        $sql_Statement .= $primary_property_name;
        $sql_Statement .= " = ";
        $sql_Statement .= $this->_dataObject->$primary_property_name;      
        $className = SqlStringCreator::GetTableName($this->_dataObject);
        $className .= "_Row";  //TODO: use static or  figure better way to get name
        
        if ($row = $this->_database->queryUniqueArray($sql_Statement) ){
            $class = new $className($row);
            $class->SetInternalObjects($this->_database);
            return $class;
        }
        else{
            return false;
        }
   }
   
   public function Delete(){
    
        //this will throw if we cannot delete the object.
        $this->_dataObject->ValidateDelete( $this->_database );
        
        $this->_dataObject->PrepDeleteEmail($this->_database);
        
        $Sql_String_Creator = new SqlStringCreator(SqlStringCreator::GetTableName($this->_dataObject)); 
        
        $reflect = new ReflectionClass($this->_dataObject);
        $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        $property_count = 0;
        $primary_property_name = null;
        foreach ($properties as $property) { 
            $property_count = $property_count + 1;
            //The first propery will always be the primary - so set it so
            if( 1 == $property_count ){
                $primary_property_name = $property->getName();
            }
            else{
                break;
            }
        }
        
        $Sql_String_Creator->addSearchValue($primary_property_name,$this->_dataObject->$primary_property_name);
        $this->_database->execute($Sql_String_Creator->getDeleteStatement());
        
        $this->_dataObject->SendDeleteEmail( $this->_database );
        
   }
   
   public function DeleteWithOwnWhereStatement($where){   
        //this will throw if we cannot delete the object.
        $this->_dataObject->ValidateDelete( $this->_database );
        
        $this->_dataObject->PrepDeleteEmail($this->_database);
        
        $sql_Statement = "Delete";
        $sql_Statement .= " FROM ";
        $sql_Statement .= SqlStringCreator::GetTableName($this->_dataObject);
        if( null != $where ){
            $sql_Statement .= " ";
            $sql_Statement .= $where;  
        }
        $this->_database->query($sql_Statement);
        
        $this->_dataObject->SendDeleteEmail( $this->_database );
    }
   
   public function resetFetch(){
      $this->_database->resetFetchWithLastResult();
   }
   
   public function numRows(){
      return $this->_database->numRows();
   }
}
?>