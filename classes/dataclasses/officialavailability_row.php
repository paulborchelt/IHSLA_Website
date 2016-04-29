<?
require_once('row.php');
class Official_Availability_Row extends Row{
   protected $UID;
   protected $Date;
   protected $Start_Time;
   protected $End_Time;
   protected $Recurrence;
   protected $End_Date;
   
   function __construct( $array = null){
      	$this->UID = $array['UID'];
      	$this->Date = $array['Date'];
      	$this->Start_Time = $array['Start_Time'];
        $this->End_Time = $array['End_Time'];
        $this->Recurrence = $array['Recurrence'];
        $this->End_Date = $array['End_Date'];
   }
}
?>