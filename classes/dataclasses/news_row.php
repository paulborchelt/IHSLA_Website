<?php
require_once('row.php');
require_once ('classes/mydatetime.php');

class News_Row extends Row{
   protected $id;
   protected $headline;
   protected $message;
   protected $author_id;
   protected $team_id;
   protected $timestamp;
   protected $remove;
   
   protected $_DateObject;
   
   function __construct( $array = null){
          	$this->id = $array['id'];
          	$this->headline = $array['headline'];
            $this->message = $array['message'];
            $this->author_id = $array['author_id'];
            $this->team_id = $array['team_id'];
            $this->timestamp = $array['timestamp'];
            $this->remove = $array['remove'];
            $this->_DateObject =  new MyDateTime($this->timestamp, new DateTimeZone('America/New_York'));
   }
   
   function formatmessage (){
    return nl2br($this->message);
   }
   
   function teaser (){
    $string = nl2br($this->message);
    return substr($string,0,300);
   }
}
?>