<?php
require_once ('row.php');

class OfficialEvaluations_Row extends Row
{
    protected $idofficialevaluations;
    protected $idschedule;
    protected $idcontactinfo;
    protected $Team_ID;
    protected $locationcheck;
    protected $locationcheckcomments;
    protected $certified;
    protected $certifiedcomments;
    protected $providecard;
    protected $providecardcomments;
    protected $comheadcoachonly;
    protected $comheadcoachonlycomments;
    protected $consistent;
    protected $consistentcomments;
    protected $professional;
    protected $professionalcomments;
    protected $concerns;
    protected $concernscomments;
    protected $rating;
    protected $additionalcomments;
    
    protected $_schedule;
    protected $_teamObject;
    protected $_contactInfoObject;
    function __construct($array = null){
        
        $this->idofficialevaluations = $array['idofficialevaluations'];
        $this->idschedule = $array['idschedule'];
        $this->idcontactinfo = $array['idcontactinfo'];
        $this->Team_ID = $array['Team_ID'];
        $this->locationcheck = $array['locationcheck'];
        $this->locationcheckcomments = $array['locationcheckcomments'];
        $this->certified = $array['certified'];
        $this->certifiedcomments = $array['certifiedcomments'];
        $this->providecard = $array['providecard'];
        $this->providecardcomments = $array['providecardcomments'];
        $this->comheadcoachonly = $array['comheadcoachonly'];
        $this->comheadcoachonlycomments = $array['comheadcoachonlycomments'];
        $this->consistent = $array['consistent'];
        $this->consistentcomments = $array['consistentcomments'];
        $this->professional = $array ['professional'];
        $this->professionalcomments = $array['professionalcomments'];
        $this->concerns = $array ['concerns'];
        $this->concernscomments = $array['concernscomments'];
        $this->rating = $array ['rating'];
        $this->additionalcomments = $array['additionalcomments'];
        
        $this->_schedule = new Schedule_Row($array);
        //TODO: Make sure to fill in the reset of the team object and not jsut the name. 
        $this->_teamObject = new Teams_Row(array( Team_Name => $array['Eval_Team_Name']));
        
        $this->_contactInfoObject = new ContactInfo_Row($array);
    }
    
  function getExsistingRow($database){
    $sql_Statement = "SELECT *
				FROM OfficialEvaluations
				WHERE idcontactinfo = '$this->idcontactinfo' AND idschedule = '$this->idschedule' AND Team_ID = '$this->Team_ID'";
        $database->query($sql_Statement);
        $row = $database->fetchNextArray();  
        return $row != NULL ? new OfficialEvaluations_Row ($row) : NULL ;
  }
  
  function getAllExsistingRow($database){
    $sql_Statement = "SELECT *
				FROM OfficialEvaluations
				WHERE idcontactinfo = '$this->idcontactinfo' AND idschedule = '$this->idschedule'";
        $database->query($sql_Statement);
        $row = $database->fetchNextArray();  
        return $row != NULL ? new OfficialEvaluations_Row ($row) : NULL ;
  }
  
  static function GetSelectStatement(){
        //TODO: Add all columns needed for a schedule
        return "SELECT *, home.Team_ID as Home_Team_ID, 
                          home.Team_Name as Home_Team_Name,
                          home.Address as Home_Address,
                          home.City as Home_City,
                          home.State as Home_State,
                          home.ZIP as Home_ZIP,
                          home.Phone as Home_Phone,
                          home.Fax as Home_Fax,
                          home.Home_Colors as Home_Home_Colors,
                          home.Away_Colors as Home_Away_Colors,
                          home.Mascot as Home_Mascot,
                          home.Member as Home_Member,
                          home.League as Home_League,
                          away.Team_ID as Away_Team_ID, 
                          away.Team_Name as Away_Team_Name,
                          away.Address as Away_Address,
                          away.City as Away_City,
                          away.State as Away_State,
                          away.ZIP as Away_ZIP,
                          away.Phone as Away_Phone,
                          away.Fax as Away_Fax,
                          away.Home_Colors as Away_Home_Colors,
                          away.Away_Colors as Away_Away_Colors,
                          away.Mascot as Away_Mascot,
                          eval.Team_Name as Eval_Team_Name";
  }
  
  function whereStatement(){
    $sql_Statement = "
        Left Join Schedule on Game_ID = idschedule
        LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
        LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
        LEFT JOIN `Teams` AS eval ON OfficialEvaluations.Team_ID = eval.Team_ID
        WHERE idcontactinfo = '$this->idcontactinfo' AND idschedule = '$this->idcontactinfo'";  
    return $sql_Statement;
  }
  
  function whereStatementForAllEvals(){
    $sql_Statement = "
        Left Join Schedule on Game_ID = idschedule
        LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
        LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
        LEFT JOIN `Teams` AS eval ON OfficialEvaluations.Team_ID = eval.Team_ID
        LEFT JOIN `ContactInfo` ON Id = idcontactinfo";  
    return $sql_Statement;
  }
  
  function whereStatementAllEvalsForOnePerson(){
    $sql_Statement = "
        Left Join Schedule on Game_ID = idschedule
        LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
        LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
        LEFT JOIN `Teams` AS eval ON OfficialEvaluations.Team_ID = eval.Team_ID
        WHERE idcontactinfo = '$this->idcontactinfo'";  
    return $sql_Statement;
  }
  
  function CreateNumberOptions( $previousValue=1 ){
    $arrayofnumbers = array(0,1,2,3,4,5,6,7,8,9,10);
    foreach( $arrayofnumbers as $i){
        if ( $previousValue == $i){
            $returnumberoptions .= "<OPTION SELECTED> $i </OPTION>";
        }
        else{
            $returnumberoptions .= "<OPTION> $i </OPTION>";;
        }
    }
    
    return $returnumberoptions;
  }
  
  function CreateYesNoOptions( $previousValue = 0 ){
   $previousValue = $previousValue == null ? 1 : $previousValue;
   $yesNoArray = array('Foo' => 3, 'Yes' => 1, 'No' => 0);
   foreach ($yesNoArray as $name => $value) {
      if($previousValue == $value) {
         $returnYesNoOptions .= "<option selected value = $value >$name </option>";
      } else {
         $returnYesNoOptions .= "<option value = $value >$name </option>";
      }
   }
   
   return $returnYesNoOptions;
  }
  
  function DoYouWantToEditDisplay($main){
    $tpl = new Template('../templates/');
    $tpl->set("Game_ID",$this->idschedule);
    $tpl->set("Team_ID",$this->Team_ID);
    $main->set('content', $tpl->fetch('OfficialsEvaluationDoYouWantToEdit.form.tpl.php'));
    echo $main->fetch('../templates/pages/main.tpl.php');
    
  }
    
}
?>