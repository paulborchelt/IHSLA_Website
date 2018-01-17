<?php
require_once ('classes/templateengine/template.php');

$globaldebugmsg;
$globaldebugcount = 0;
class TemplateLogger extends Template {
   
    const error  = 0;
    const success = 1;
    const info = 3;
    const debug = 4;
   
    private $logs = null;
    private $logcount = 0;
    
    function __construct( $database, $path ){
         parent::Template($path);
         $this->set('db',$database);
    }
    
    //TODO: Fix multiple messages so it dispaly one under each other instead of a straight line. 
    function success( $message ){
        $this->logs[$this->logcount++] = array(TemplateLogger::success => $message);
    }
    
    function error( $message ){
        $this->logs[$this->logcount++] = array(TemplateLogger::error => $message);
    }
    
    function info( $message ){
        $this->logs[$this->logcount++] = array(TemplateLogger::info => $message);
    }
    
    function debugmsg( $message ){
        $this->logs[$this->logcount++] = array(TemplateLogger::debug => $message);
    }
    
    static function Debug ( $message ){
         global  $globaldebugmsg;
         global $globaldebugcount;
         $globaldebugmsg[$globaldebugcount++] = $message;
    }
    
    //Use this function if you just want to view the execption meesage. 
    function exceptionError( $message, $exception ){
        $message .= $exception;
        $this->logs[$this->logcount++] = array(TemplateLogger::error => $message);
    }
    
    //Ust this if you want to view more information about the exception. 
    function exceptionErrorFull( $message, $exception ){
        $message .= " ";
        $message .= $exception->getMessage();
        $stacktrace = " Stack Trace: ";
        $stacktrace .= $exception->getTraceAsString();
        $this->logs[$this->logcount++] = array(TemplateLogger::error => $message);
        $this->logs[$this->logcount++] = array(TemplateLogger::info => $stacktrace);
    }
    
    function processDebugMessages(){
      global $globaldebugmsg;
      $localdebugmsg = $globaldebugmsg;
      if( null != $localdebugmsg ){
         foreach ( $localdebugmsg as $message){
            $this->debugmsg($message);
         }
      }
    }
    
    function fetch($file){
        $this->processDebugMessages();
        if( null != $this->logs ){
         $tpl =  new Template('templates/');
         $tpl->set('logs',$this->logs);
         parent::set('logging',$tpl->fetch('logging.tpl.php'));
        }
        return parent::fetch($file);
    }
}
?>