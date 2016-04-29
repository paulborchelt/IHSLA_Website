<?php
/**
 * Define a custom exception class
 */
class validateException extends Exception
{
    private $_database;

    public function __construct( $message ) {
      parent::__construct($message);
       
    }
}
?>