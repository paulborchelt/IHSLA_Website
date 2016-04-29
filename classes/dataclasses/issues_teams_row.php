<?
require_once('row.php');
require_once('teams_row.php');
require_once('issues_row.php');
class Issues_Teams_Row extends Row{
   protected $issues_id;
   protected $teams_id;
   
   //Joined with Issues and Teams
   protected $_issues;
   protected $_teams;
   
   
   function __construct( $array = null){
      	$this->issues_id = $array['issues_id'];
      	$this->teams_id = $array['teams_id'];
        
        //Joined tables:
        $this->_issues = new Issues_Row($array);
        $this->_teams = new Teams_Row($array);
   }
   
   static function TeamsInvolved(){
    return  "LEFT JOIN ContactInfo on Id = id
             LEFT JOIN CommitteeTypes on committeetypes_id = CommitteeTypes.id
             WHERE contactinfo_id = ContactInfo.Id AND CommitteeTypes.name = 'Board of Directors'";
   }
   
}
?>