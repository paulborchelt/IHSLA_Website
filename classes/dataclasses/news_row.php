<?
require_once('row.php');
class News_Row extends Row{
   protected $id;
   protected $headline;
   protected $message;
   protected $author_id;
   protected $team_id;
   protected $timestamp;
   
   function __construct( $array = null){
          	$this->id = $array['id'];
          	$this->headline = $array['headline'];
            $this->message = $array['message'];
            $this->author_id = $array['author_id'];
            $this->team_id = $array['team_id'];
            $this->timestamp = $array['timestamp'];
   }
}
?>