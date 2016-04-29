<?

require_once ('row.php');
require_once ('leagues_row.php');
require_once ('userteamlist_row.php');
class Teams_Row extends Row {
   protected $Team_ID;
   protected $Team_Name;
   protected $Address;
   protected $City;
   protected $State;
   protected $ZIP;
   protected $Phone;
   protected $Home_Colors;
   protected $Away_Colors;
   protected $Mascot;
   protected $Member;
   protected $League;
   protected $Club;


   protected $_LeagueObject;

   function __construct($array = null) {
      $this->Team_ID = $array['Team_ID'];
      $this->Team_Name = $array['Team_Name'];
      $this->Address = $array['Address'];
      $this->City = $array['City'];
      $this->State = $array['State'];
      $this->ZIP = $array['ZIP'];
      $this->Phone = $array['Phone'];
      $this->Home_Colors = $array['Home_Colors'];
      $this->Away_Colors = $array['Away_Colors'];
      $this->Mascot = $array['Mascot'];
      $this->Member = $array['Member'];
      $this->League = $array['League'];
      $this->Club = $array['Club'];
      $this->_LeagueObject = new Leagues_Row($array);
      if( null == $this->Team_ID){
         $this->Team_ID = 3; //Default if to Bishop Chatard because alphabeicly first. 
      }
   }

   function ValidateValues() {
      if(!is_numeric($this->ZIP)) {
         if($this->ZIP == "") {
            $this->ZIP = 0;
         } else {
            throw new Exception("The value entered for ZIP code, " . $this->ZIP .
               ", is not an integer.");
         }

      }

      if(!is_numeric($this->Member)) {
         throw new Exception("The value entered for Member, " . $this->Member .
            ", is not an integer.");
      }

      if(!is_numeric($this->League)) {
         throw new Exception("The value entered for League, " . $this->League .
            ", is not an integer.");
      }

      if($this->League == 1 && $this->Member == 1 && $this->State != "IN") {
         throw new Exception("A member team must be from the state of Indiana.");
      }
   }

   function ValidateDelete($database) {

      if(0 != $database->countOf("Team_Associations", "idhostteam = $this->Team_ID or idlinkedteam = $this->Team_ID")) {
         throw new Exception("A value exists in the team associations table.");
      }

      if(0 != $database->countOf("Schedule", "HomeTeam_ID = $this->Team_ID or AwayTeam_ID = $this->Team_ID")) {
         throw new Exception("A value exists in the schedule table.");
      }

      if(0 != $database->countOf("Field_Info", "field_teamid = $this->Team_ID")) {
         throw new Exception("A value exists in the field info table.");
      }

      if(0 != $database->countOf("AllState_Votes", "Team_ID = $this->Team_ID")) {
         throw new Exception("A value exists in the all state votes table.");
      }

      if(0 != $database->countOf("ContactInfoTeamsList", "TID = $this->Team_ID")) {
         throw new Exception("A value exists in the contact info teams list table.");
      }

      if(0 != $database->countOf("Issues_Teams", "teams_id = $this->Team_ID")) {
         throw new Exception("A value exists in the issues teams table.");
      }

      if(0 != $database->countOf("News", "team_id = $this->Team_ID")) {
         throw new Exception("A value exists in the news table.");
      }

      if(0 != $database->countOf("Players", "Team_ID = $this->Team_ID")) {
         throw new Exception("A value exists in the players table.");
      }


      if(0 != $database->countOf("Points", "Team_ID = $this->Team_ID")) {
         throw new Exception("A value exists in the Points table.");
      }

      if(0 != $database->countOf("Rosters", "team_id = $this->Team_ID")) {
         throw new Exception("A value exists in the Rosters table.");
      }

      if(0 != $database->countOf("Saves", "Team_ID = $this->Team_ID")) {
         throw new Exception("A value exists in the saves table.");
      }

      if(0 != $database->countOf("UserTeamList", "TID = $this->Team_ID")) {
         throw new Exception("A value exists in the user team list table.");
      }

      return;
   }

   static function GetWhereStatement($league) {
      return "Teams LEFT JOIN `Leagues` ON `ID` = `League`
            WHERE League = '$league'";
   }
   
   static function GetWhereStatementforIHSLAOnly() {
      return "Teams LEFT JOIN Leagues on League = Leagues.ID
              WHERE Member = 1 AND Team_Name != 'TBA' AND Name = 'IHSLA'
              ORDER BY Team_Name ASC";
   }
   
   static function GetWhereStatementforIHSLAVarsityOnly() {
      return "Teams LEFT JOIN Leagues on League = Leagues.ID
              WHERE Member = 1 AND Team_Name != 'TBA' AND Name = 'IHSLA' AND Club = 0
              ORDER BY Team_Name ASC";
   }
   
   static function GetWhereStatementforIHSLAClubOnly() {
      return "Teams LEFT JOIN Leagues on League = Leagues.ID
              WHERE Member = 1 AND Team_Name != 'TBA' AND Name = 'IHSLA' AND Club = 1
              ORDER BY Team_Name ASC";
   }

   private static function GetOptions($database, $sql_Statement, $previousValue = NULL, $league = 1) {
      $database->query($sql_Statement);
      while ($row = $database->fetchNextObject()) {
         $id = $row->Team_ID;
         $name = $row->Team_Name;
         if($id == $previousValue) {
            $options .= "<option selected value = $id>$name</OPTION>";
         } else {
            $options .= "<option value = $id>$name</OPTION>";
         }
      }
      return $options;
   }

   static function GetIhslaOptions($database, $excludeTeam, $previousValue = null, $league = 1) {
      $sql_Statement = "SELECT * 
                          FROM Teams 
                          LEFT JOIN Leagues on League = Leagues.ID 
                          WHERE Team_ID != '$excludeTeam' && State='IN' && ID = '$league' && member='1'";

      return Teams_Row::GetOptions($database, $sql_Statement, $previousValue, $league);
   }

   static function GetIndianaOptions($database) {
      $sql_Statement = "SELECT * 
                          FROM Teams 
                          LEFT JOIN Leagues on League = Leagues.ID 
                          WHERE State='IN' ";

      return Teams_Row::GetOptions($database, $sql_Statement);
   }

   static function GetNonIhslaTeamInIndianaOptions($database, $includeTeam, $previousValue = NULL, $league = 1) {
      $sql_Statement = "SELECT * 
                          FROM Teams 
                          LEFT JOIN Leagues on League = Leagues.ID 
                          WHERE (State='IN' AND ID = '$league' && Member='0' AND
                                 Team_Name != 'TBA' AND Name = 'IHSLA') 
                                 OR Team_ID = '$includeTeam'
                                 ORDER BY Team_Name ASC";

      $options = Teams_Row::GetOptions($database, $sql_Statement, $previousValue != NULL ? $previousValue : $includeTeam, $league);

      return $options;
   }
   
   static function GetNonIhslaTeamsOptions($database, $excludeTeam, $previousValue=NULL, $league =1){
      $sql_Statement = "SELECT * FROM Teams LEFT JOIN Leagues on League = Leagues.ID
           WHERE Team_ID != '$excludeTeam' && member != 1 && ID = '$league'
           ORDER BY State,Team_Name";
           
      $options = Teams_Row::GetOptions($database, $sql_Statement, $previousValue != NULL ? $previousValue : $includeTeam, $league);

      return $options;
   }
   
   static function GetTeamScheduleOptions ($database, $includeTeam, $previousValue = NULL, $league = 1){
      $options = Teams_Row::GetIhslaOptions($database,$includeTeam,$previousValue,$league);
      $options .= Teams_Row::GetNonIhslaTeamsOptions($database,$includeTeam,$previousValue,$league);
      return $options;
      
   }


   static function GetStateOptions($previousValue = 'OH') {
      $stateArray = array('AL', 'AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC',
         'FL', 'GA', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA',
         'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC', 'ND',
         'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VA', 'WA',
         'WV', 'WI', 'WY');
      foreach ($stateArray as $i) {
         if($previousValue == $i) {
            $returnStateOptions .= "<option selected >$i </option>";
         } else {
            $returnStateOptions .= "<option >$i </option>";
         }
      }

      return $returnStateOptions;
   }
   
   static function getMemberOptions($previousValue = 0) {
      $memberArray = array('Yes' => 1, 'No' => 0);
      foreach ($memberArray as $name => $value) {
         if($previousValue == $value) {
            $returnMemberOptions .= "<option selected value = $value >$name </option>";
         } else {
            $returnMemberOptions .= "<option value = $value >$name </option>";
         }
      }

      return $returnMemberOptions;
   }
   
   static function getClubOptions($previousValue = 0) {
      $clubArray = array('Yes' => 1, 'No' => 0);
      foreach ($clubArray as $name => $value) {
         if($previousValue == $value) {
            $returnClubOptions .= "<option selected value = $value >$name </option>";
         } else {
            $returnClubOptions .= "<option value = $value >$name </option>";
         }
      }

      return $returnClubOptions;
   }

   static function getAdminForm($db, $listOfTeams, $sqlEdit, $league, $user, $link ) {
      $tpl = new Template('../templates/');
      $tpl->set('list_of_teams', $listOfTeams);
      $tpl->set('Team_Name', $sqlEdit != null ? $sqlEdit->Team_Name : null);
      $tpl->set('City', $sqlEdit != null ? $sqlEdit->City : null);
      $tpl->set('stateoptions', Teams_Row::GetStateOptions($sqlEdit != null ? $sqlEdit->State : null));
      $tpl->set('ZIP', $sqlEdit != null ? $sqlEdit->ZIP : null);
      $tpl->set('Phone', $sqlEdit != null ? $sqlEdit->Phone : null);
      $tpl->set('Home_Colors', $sqlEdit != null ? $sqlEdit->Home_Colors : null);
      $tpl->set('Away_Colors', $sqlEdit != null ? $sqlEdit->Away_Colors : null);
      $tpl->set('Mascot', $sqlEdit != null ? $sqlEdit->Mascot : null);
      $tpl->set('Member', Teams_Row::getMemberOptions($sqlEdit != null ? $sqlEdit->Member : null));
      $tpl->set('Club', Teams_Row::getClubOptions($sqlEdit != null ? $sqlEdit->Club : null));
      $tpl->set('leagueoptions', Leagues_Row::GetOptions($db, $sqlEdit != null ? $sqlEdit->League : null));
      $tpl->set('submittype', $sqlEdit != null ? "Edit" : "Submit");
      $tpl->set('teamid', $sqlEdit != null ? $sqlEdit->Team_ID : null);
      $tpl->set('leagueSort', Leagues_Row::getForm($db, $league));
      $tpl->set('league', $league);
      $tpl->set('returnlink', $link);
      $tpl->set('user', $user);
      return $tpl->fetch('Teams.form.tpl.php');
   }

   function memberYesOrNo() {
      if($this->Member == 1) {
         return Yes;
      } else {
         return No;
      }
   }

   static function getTeamIdRequest($default = null) {
      if(isset($_REQUEST['Team_ID'])) {
         return $_REQUEST['Team_ID'];
      } else if ( null != $default) {
         return $default;
      } else {
         throw new exception("No team selected.");
      }
   }

   function getTeamView($edit) {
      $tpl = new Template('../templates/');
      $tpl->set('team', $this);
      $tpl->set('edit', $edit);
      return $tpl->fetch('Team.tpl.php');
   }
   
   static function getEditUserTeamList($db, $user){
      $tpl = new Template('../templates/');
      $tpl->set('teamoptions', Teams_Row::GetIhslaOptions($db,null));
      $tpl->set('userid',$user->userid);
      $teamuserlist = new SqlExecutor($db, new UserTeamList_Row());
      $teamuserlist->Search(UserTeamList_Row::GetWhereStatement($user->userid));
      $tpl->set('userteamlist', $teamuserlist->fetch(array(userid => $user->userid)));
      return $tpl->fetch('EditUserTeamList.tpl.php');
   }
   
   static function findTeamName($db, $Team_ID){
      $sql = "Select Team_Name FROM Teams WHERE $Team_ID = Team_ID";
      $db->query($sql);
      $teamName = $db->fetchNextObject()->Team_Name;
      return $teamName;
   }
   
   function getClassName(){
      if( 1 == $this->Club ){
         return "Club";
      }
      else{
         return "Varsity";
      }
   }
}

?>