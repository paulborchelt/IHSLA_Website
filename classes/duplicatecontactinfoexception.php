<?php
/**
 * Define a custom exception class
 */
class DuplicateContactInfoException extends Exception
{
    private $_database;

    public function __construct( $database ) {
        $this->_database = $database;
    }
    
    public function getSQLExecutor(){
        return new SqlExecutor( $this->_database, new ContactInfo_Row() );   
    }
}
?>