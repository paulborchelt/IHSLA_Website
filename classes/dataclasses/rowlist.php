<?
class RowList{
    private $_sqlExecutorObject;
    
    function __construct( $sqlExecutorObject ){
        $this->_sqlExecutorObject = $sqlExecutorObject;
    }
    
    //TODO: Write unit test
    public function fetchNextObject(){
        return $this->_sqlExecutorObject->fetchNextObject();
    }
}
?>