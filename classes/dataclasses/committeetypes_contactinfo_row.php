<?
require_once('row.php');
require_once('contactinfo_row.php');
class CommitteeTypes_ContactInfo_Row extends Row{
   protected $contactinfo_id;
   protected $committeetypes_id;
   protected $startyear;
   protected $endyear;
   
   //Joined with ContactInfo
   protected $_ContactInfo;
   protected $_CommitteeTypes;
   
   
   function __construct( $array = null){
      	$this->contactinfo_id = $array['contactinfo_id'];
      	$this->committeetypes_id = $array['committeetypes_id'];
        $this->startyear = $array['startyear'];
        $this->endyear = $array['endyear'];
        
        //Joined tables:
        $this->_ContactInfo = new contactinfo_row($array);
        $this->_CommitteeTypes = new CommitteeTypes_Row($array);
   }
   
   static function GetBoardOfDirectors(){
    return  "LEFT JOIN ContactInfo on Id = id
             LEFT JOIN CommitteeTypes on committeetypes_id = CommitteeTypes.id
             WHERE contactinfo_id = ContactInfo.Id AND CommitteeTypes.name = 'Board of Directors'";
   }
   
}
?>