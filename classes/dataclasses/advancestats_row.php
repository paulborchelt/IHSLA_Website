
<?php
require_once('row.php');
class AdvaceStats_Row extends Row{
   protected $Game_ID;
   protected $Player_ID;
   protected $shots;
   protected $groundballs;
   protected $turnovers;
   protected $causedturnovers;
   protected $faceoffwins;
   protected $faceoffattempts;
   
   //Joined with Scheulde and Players
   protected $_Schedule;
   protected $_Players;
   
   function __construct( $array = null){
        $this->Game_ID = $array['Game_ID'];
        $this->Player_ID = $array['Player_ID'];
        $this->shots = $array['shots'];
        $this->groundballs = $array['groundballs'];
        $this->turnovers = $array['turnovers'];
        $this->causedturnovers = $array['causedturnovers'];
        $this->faceoffwins = $array['faceoffwins'];
        $this->faceoffattempts = $array['faceoffattempts'];
        
        //Joined tables:
        $this->_ContactInfo = new contactinfo_row($array);
        $this->_CommitteeTypes = new CommitteeTypes_Row($array);
   }
}
?>