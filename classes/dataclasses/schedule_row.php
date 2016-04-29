<?

require_once ('row.php');
require_once ('teams_row.php');
require_once ('fieldinfo_row.php');
require_once ('contactinfo_row.php');
require_once ('users_row.php');
require_once ('levels_row.php');
require_once ('gametype_row.php');
require_once ('canceloptions_row.php');
require_once ('leagues_row.php');
require_once ('../classes/mydatetime.php');
require_once ('../classes/score.php');
require_once ('../classes/mail.php');
class Schedule_Row extends Row
{
    protected $Game_ID;
    protected $HomeTeam_ID;
    protected $AwayTeam_ID;
    protected $Date;
    protected $Time;
    protected $Site;
    protected $Game_Level;
    protected $Game_Type;
    protected $Referee;
    protected $Umpire;
    protected $Field_Judge;
    protected $Site_ID;
    protected $Referee_Accepted;
    protected $Umpire_Accepted;
    protected $Field_Judge_Accepted;
    protected $Cancel;
    
    //Joined tables
    protected $_HomeTeamObject;
    protected $_AwayTeamObject;
    protected $_SiteObject;
    protected $_CancelOptionsObject;
    protected $_RefereeObject;
    protected $_UmpireObject;
    protected $_FieldJudgeObject;
    protected $_DateObject;
    protected $_TimeObject;
    protected $_Score;
    
    private $_scheduleObject;

    function __construct($array = null)
    {
        $this->Game_ID = $array['Game_ID'];
        $this->HomeTeam_ID = $array['HomeTeam_ID'];
        $this->AwayTeam_ID = $array['AwayTeam_ID'];
        $timestamp = strtotime($array['Date']);
        $this->Date = date('Y-m-d', $timestamp);
        if(isset($array['Time'])){
         $this->Time = $array['Time'];
        }
        else{
         $hour = isset($array['Hour']) ? $array['Hour'] : 0;
         $minutes = isset($array['Minutes']) ? $array['Minutes'] : 0;
         $period = isset($array['Period']) ? $array['Period'] : 'AM';
         $this->Time = Schedule_Row::convertTime($hour,$minutes , $period);
        }
        $this->Game_Level = $array['Game_Level'];
        $this->Site = $array['Site'];
        $this->Game_Level = $array['Game_Level'];
        $this->Game_Type = $array['Game_Type'];
        $this->Referee = isset($array['Referee']) ? $array['Referee'] : 0 ;
        $this->Umpire = isset($array['Umpire']) ? $array['Umpire'] : 0 ;
        $this->Field_Judge = isset($array['Field_Judge']) ? $array['Field_Judge'] : 0 ;
        $this->Site_ID = $array['Site_ID'];
        $this->Referee_Accepted = isset($array['Referee_Accepted']) ? $array['Referee_Accepted'] : 0 ;
        $this->Umpire_Accepted = isset($array['Umpire_Accepted']) ? $array['Umpire_Accepted'] : 0 ;
        $this->Field_Judge_Accepted = isset($array['Field_Judge_Accepted']) ? $array['Field_Judge_Accepted'] : 0 ;
        $this->Cancel = isset($array['Cancel']) ? $array['Cancel'] : 0 ;
        
        $this->_CancelOptionsObject = new CancelOptions_Row($array);
        
        $this->_DateObject =  new MyDateTime($this->Date, new DateTimeZone('America/New_York'));
        $this->_TimeObject =  new MyDateTime($array['Time'], new DateTimeZone('America/New_York'));
        
        $this->_HomeTeamObject = new Teams_Row(array( Team_ID => $array['Home_Team_ID'], 
                                                     Team_Name => $array['Home_Team_Name'],
                                                     Address => $array ['Home_Address'],
                                                     City => $array['Home_City'],
                                                     State => $array['Home_State'],
                                                     ZIP => $array['Home_ZIP'],
                                                     Phone => $array['Home_Phone'],
                                                     Fax => $array['Home_Fax'],
                                                     Home_Colors => $array['Home_Home_Colors'],
                                                     Away_Colors => $array['Home_Away_Colors'],
                                                     Mascot => $array['Home_Mascot'],
                                                     OutOfState => $array['Home_OutOfState'],
                                                     Member => $array['Home_Member'],
                                                     League => $array['Home_League'] ));
                                                     
        $this->_AwayTeamObject = new Teams_Row(array( Team_ID => $array['Away_Team_ID'], 
                                                     Team_Name => $array['Away_Team_Name'],
                                                     Address => $array ['Away_Address'],
                                                     City => $array['Away_City'],
                                                     State => $array['Away_State'],
                                                     ZIP => $array['Away_ZIP'],
                                                     Phone => $array['Away_Phone'],
                                                     Fax => $array['Away_Fax'],
                                                     Home_Colors => $array['Away_Home_Colors'],
                                                     Away_Colors => $array['Away_Away_Colors'],
                                                     Mascot => $array['Away_Mascot'],
                                                     OutOfState => $array['Away_OutOfState'],
                                                     Member => $array['Away_Member'],
                                                     League => $array['AWay_League'] ));
                                                     
        $this->_SiteObject = new Field_Info_Row($array);
        $this->_RefereeObject = new ContactInfo_row(array( Id => $array['referee_Id'],
                                                          FirstName => $array['referee_FirstName'],
                                                          LastName => $array['referee_LastName'],
                                                          PhoneHome => $array['referee_PhoneHome'],
                                                          PhoneWork => $array['referee_PhoneWork'],
                                                          PhoneCell => $array['referee_PhoneCell'],
                                                          Email => $array['referee_Email'] ));
                                                          
        $this->_UmpireObject = new ContactInfo_row(array(  Id => $array['umpire_Id'],
                                                          FirstName => $array['umpire_FirstName'],
                                                          LastName => $array['umpire_LastName'],
                                                          PhoneHome => $array['umpire_PhoneHome'],
                                                          PhoneWork => $array['umpire_PhoneWork'],
                                                          PhoneCell => $array['umpire_PhoneCell'],
                                                          Email => $array['umpire_Email'] ));
                                                       
        $this->_FieldJudgeObject = new ContactInfo_row(array( Id => $array['fieldjudge_Id'],
                                                              FirstName => $array['fieldjudge_FirstName'],
                                                              LastName => $array['fieldjudge_LastName'],
                                                              PhoneHome => $array['fieldjudge_PhoneHome'],
                                                              PhoneWork => $array['fieldjudge_PhoneWork'],
                                                              PhoneCell => $array['fieldjudge_PhoneCell'],
                                                              Email => $array['fieldjudge_Email'] ));
        $this->_Score = new Score($array);
        
                          
    }
    
    function ValidateDelete( $database ){
   
         if( 0 != $database->countOf("Points","Game_ID = $this->Game_ID")){
            throw new Exception("A value exists in the Points table.");
         }
         
         if( 0 != $database->countOf("Saves","Game_ID = $this->Game_ID")){
            throw new Exception("A value exists in the Saves table.");
         }
         
         if( 0 != $database->countOf("GameReport","gid = $this->Game_ID")){
            throw new Exception("A value exists in the game report table.");
         }
     }
     
    function SendEmail( $database ){
      	$message = "<p>Game Added:</p>";
         $message .= "<html><table><tr><td>Date</td><td>";
      	$message .= "<b>{$this->_DateObject->getMonthDayYearFormat()}</b>";
      	$message .= "</td></tr><tr><td>Time</td><td>";
         $timeNew = new MyDateTime($this->Time);
          $message .= "<b>{$timeNew->getTime()}</b>";
      	$message .= "</td></tr><tr><td>Level</td><td>";
          $message .= "<b>{$this->Game_Level}</b>";
      	$message .= "</td></tr><tr><td>Site</td><td>";
         $fieldObject = Field_Info_Row::findFieldInfo($database, $this->Site_ID);
         $message .= "<b>{$fieldObject->field_name}</b>";
      	$message .= "</td></tr><tr><td>home</td><td>";
         $homeTeamName = Teams_Row::findTeamName($database, $this->HomeTeam_ID);
      	$message .= "<b>{$homeTeamName}</b>";
      	$message .= "</td></tr><tr><td>away</td><td>";
         $awayTeamName = Teams_Row::findTeamName($database, $this->AwayTeam_ID);
      	$message .= "<b>{$awayTeamName}</b>";
         $message .= "</td></tr></table></html>";
         
         $user = Users_Row::getUser($database);
         if( $user != null ){
            $message .= "<p>Changed by {$user->_contactInfoObject->GetFullName()}</p>";
         }
         else {
            $message .= "<p>Changed by unkown }</p>";
         }
         
         
         $to = $this->getSchedulersEmails($database);
         $to .= $this->getCoachesEmails($database);
         $mail = new mail($message, "IHSLA Game Added",$to, "assigner@indianalacrosse.org");
         $mail->Send();
    }
    
    function SendDeleteEmail( $database ){
         $message = "<p>Game Deleted:</p>";
      	$message .= "<html><table><tr><td>Date</td><td>";
      	$message .= "<b>{$this->_scheduleObject->_DateObject->getMonthDayYearFormat()}</b>";
      	$message .= "</td></tr><tr><td>Time</td><td>";
         $timeNew = new MyDateTime($this->_scheduleObject->Time);
         $message .= "<b>{$timeNew->getTime()}</b>";
      	$message .= "</td></tr><tr><td>Level</td><td>";
         $message .= "<b>{$this->_scheduleObject->Game_Level}</b>";
      	$message .= "</td></tr><tr><td>Site</td><td>";
         $message .= "<b>{$this->_scheduleObject->_SiteObject->field_name}</b>";
      	$message .= "</td></tr><tr><td>home</td><td>";
      	$message .= "<b>{$this->_scheduleObject->_HomeTeamObject->Team_Name}</b>";
      	$message .= "</td></tr><tr><td>away</td><td>";
      	$message .= "<b>{$this->_scheduleObject->_AwayTeamObject->Team_Name}</b>";
         
         $message .= "</td></tr></table></html>";
         
         $user = Users_Row::getUser($database);
         if( $user != null ){
            $message .= "<p>Changed by {$user->_contactInfoObject->GetFullName()}</p>";
         }
         else {
            $message .= "<p>Changed by unkown }</p>";
         }
         
         $to = $this->_scheduleObject->getSchedulersEmails($database);
         $to .= $this->_scheduleObject->getCoachesEmails($database);
         $mail = new mail($message, "IHSLA game {$this->_scheduleObject->Game_ID} has been removed.",$to, "assigner@indianalacrosse.org");
         $mail->Send();
    }
    
    function PrepUpdateEmail( $database ){
      	$sql = "select * From Schedule " . $this->GetGame();
         $database->query($sql);
         $this->_scheduleObject = new Schedule_Row ($database->fetchNextArray());
         $this->SetInternalObjects($database);
         $this->_scheduleObject->SetInternalObjects( $database );
    }
    
    function PrepDeleteEmail( $database ){
      	$sql = "select * From Schedule " . $this->GetGame();
         $database->query($sql);
         $this->_scheduleObject = new Schedule_Row ($database->fetchNextArray());
         $this->_scheduleObject->SetInternalObjects( $database );
    }
    
    function SendUpdateEmail( $database ){
      
      $message = "<p>Game Changed. Changes are in bold.</p>";
      $message .= "<html><table><tr><td>Date</td><td>";
   
		if ( $this->Date != $this->_scheduleObject->Date )
		{
         $dateOld = new MyDateTime($this->_scheduleObject->Date);
         $dateNew = new MyDateTime($this->Date);
         $message .= "<b>{$dateOld->getMonthDayYearFormat()} changed to {$dateNew->getMonthDayYearFormat()}</b>";
		}
		else
		{
			$message .= "{$this->_DateObject->getMonthDayYearFormat()}";
		}
      
      $message .= "</td></tr><tr><td>Time</td><td>";

		if ( $this->_scheduleObject->Time != $this->Time )
		{
         $timeOld = new MyDateTime($this->_scheduleObject->Time);
         $timeNew = new MyDateTime($this->Time);
			$message .= "<b>{$timeOld->getTime()} changed to {$timeNew->getTime()}</b>";
		}
		else
		{
         $time = new MyDateTime($this->Time);
			$message .= "{$time->getTime()}";
		}

		$message .= "</td></tr><tr><td>Level</td><td>";

		if ( $this->_scheduleObject->Game_Level != $this->Game_Level )
		{
			$message .= "<b>{$this->_scheduleObject->Game_Level} changed to {$this->Game_Level}</b>";
		}
		else
		{
			$message .= "{$this->Game_Level}";
		}

		$message .= "</td></tr><tr><td>Site</td><td>";

		if ( $this->_scheduleObject->Site_ID  != $this->Site_ID )
		{
			$message .= "<b>{$this->_scheduleObject->_SiteObject->field_name} changed to {$this->_SiteObject->field_name}</b>";
		}
		else
		{
			$message .= "{$this->_SiteObject->field_name}";
		}

		$message .= "</td></tr><tr><td>home</td><td>";

		if ($this->_scheduleObject->HomeTeam_ID != $this->HomeTeam_ID )
		{
			$message .= "<b>{$this->_scheduleObject->_HomeTeamObject->Team_Name} changed to {$this->_HomeTeamObject->Team_Name}</b>";
		}
		else
		{
			$message .= "{$this->_HomeTeamObject->Team_Name}";
		}

		$message .= "</td></tr><tr><td>away</td><td>";

		if ($this->_scheduleObject->AwayTeam_ID != $this->AwayTeam_ID)
		{
			$message .= "<b>{$this->_scheduleObject->_AwayTeamObject->Team_Name} changed to {$this->_AwayTeamObject->Team_Name}</b>";
		}
		else
		{
			$message .= "{$this->_AwayTeamObject->Team_Name}";
		}
      
      $message .= "</td></tr></table></html>";
      
      $user = Users_Row::getUser($database);
      if( $user != null ){
         $message .= "<p>Changed by {$user->_contactInfoObject->GetFullName()}</p>";
      }
      else {
         $message .= "<p>Changed by unkown }</p>";
      }
         
      $to = $this->getSchedulersEmails($database);
      $to .= $this->getCoachesEmails($database);
      $mail = new mail($message, "Schedule change for Game ID {$this->_scheduleObject->Game_ID}",$to, "assigner@indianalacrosse.org");
      $mail->Send();
    }
    
    function getCoachesEmails ($database){
      $sql = "SELECT Email from ContactInfo,ContactInfoTeamsList where (TID = $this->HomeTeam_ID or TID = $this->AwayTeam_ID) AND MainContact =1 AND Id = CID";
      $database->query($sql);
      $email;
      while ( $row = $database->fetchNextObject() ){
         $email .= $row->Email;
    		$email .= ",";
      }
      return $email;
    }
    
    function getSchedulersEmails ($database){
      	$email;
      	$sql = "SELECT ContactInfo.Email
      				FROM Groups, GroupList, Users, ContactInfo
      				WHERE Groups.GroupName = 'Schedulers'
      				AND GroupList.GID = Groups.GID
      				AND Users.userid = GroupList.UID
      				AND ContactInfo.Id = Users.contactinfo_id";
      
   		$database->query($sql);
         $bFound = FALSE;
         while ( $row = $database->fetchNextObject() ){
            $email .= $row->Email;
       		$email .= ",";
         }
      	return $email;
    }
    
    public function SetInternalObjects ($database){
      
      $sql = "SELECT * FROM Teams WHERE Team_ID = '$this->HomeTeam_ID'";
      $database->query($sql);
      if ($row = $database->queryUniqueArray($sql) ){
         $this->_HomeTeamObject = new Teams_Row($row);
      }
      else{
         throw new Exception("Unable to set Internal Home Team Object for schedule_row class");
      }
      
      $sql = "SELECT * FROM Field_Info WHERE field_id = '$this->Site_ID'";
      $database->query($sql);
      if ($row = $database->queryUniqueArray($sql) ){

         $this->_SiteObject = new Field_Info_Row($row);
      }
      else{
         throw new Excption("Unable to set Internal Away Team Object for schedule_row class");
      }
      
      $sql = "SELECT * FROM Teams WHERE Team_ID = '$this->HomeTeam_ID'";
      $database->query($sql);
      if ($row = $database->queryUniqueArray($sql) ){
         $this->_HomeTeamObject = new Teams_Row($row);
      }
      else{
         throw new Excption("Unable to set Internal Home Team Object for schedule_row class");
      }
      
      $sql = "SELECT * FROM Teams WHERE Team_ID = '$this->AwayTeam_ID'";
      $database->query($sql);
      if ($row = $database->queryUniqueArray($sql) ){
         $this->_AwayTeamObject = new Teams_Row($row);
      }
      else{
         throw new Excption("Unable to set Internal Away Team Object for schedule_row class");
      }
      
      $sql_Statement = "SELECT *, SUM(Goals) as Score, MAX(Quarter) as Quarters
                        FROM Points LEFT JOIN Teams
                        ON Points.Team_ID = Teams.Team_ID
                        WHERE Game_ID = $this->Game_ID
                        GROUP BY Quarter, Points.Team_ID";

        $database->query($sql_Statement);
        $this->_Score = new Score();
        while ( $row = $database->fetchNextArray()){
                if( $this->_HomeTeamObject->Team_ID == $row['Team_ID'] ){
                        $this->_Score->setHomeTeam($this->_HomeTeamObject);
                        $this->_Score->setHomeScoreQuarter($row['Quarters'], $row['Score']);
                }
                else{
                        $this->_Score->setAwayTeam($this->_AwayTeamObject);
                        $this->_Score->setAwayScoreQuarter($row['Quarters'],$row['Score']);
                }
        }
   }

    static function GetCurrentYear($league, $sort)
    {
        $currentSeason = Schedule_Row::GetCurrentSeasonYear();
        $wherestatement = $sort->getWhereStatement();
        return "LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
                LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
                LEFT JOIN `Field_Info` on Site_ID = Field_Info.field_id
                LEFT JOIN  `CancelOptions` ON Cancel = CancelOptions.cancelid
                LEFT JOIN  ContactInfo as referee ON referee.pn_uid = Referee and referee.pn_uid != 0 and referee.pn_uid is not null
                LEFT JOIN  ContactInfo as umpire ON umpire.pn_uid = Umpire and umpire.pn_uid != 0 and umpire.pn_uid is not null
                LEFT JOIN  ContactInfo as fieldjudge ON fieldjudge.pn_uid = Field_Judge and fieldjudge.pn_uid != 0 and fieldjudge.pn_uid is not null
                LEFT JOIN Leagues as lh ON away.League = lh.ID
	            LEFT JOIN Leagues as la ON home.League = la.ID
                $wherestatement
                Group by Schedule.Game_ID
                Order by Date";
    }
    
    static function GetCurrentYearVarsityOnly($league)
    {
        $currentSeason = Schedule_Row::GetCurrentSeasonYear();
        return "LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
                LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
                LEFT JOIN `Field_Info` on Site_ID = Field_Info.field_id
                LEFT JOIN  `CancelOptions` ON Cancel = CancelOptions.cancelid
                LEFT JOIN  ContactInfo as referee ON referee.pn_uid = Referee and referee.pn_uid != 0 and referee.pn_uid is not null
                LEFT JOIN  ContactInfo as umpire ON umpire.pn_uid = Umpire and umpire.pn_uid != 0 and umpire.pn_uid is not null
                LEFT JOIN  ContactInfo as fieldjudge ON fieldjudge.pn_uid = Field_Judge and fieldjudge.pn_uid != 0 and fieldjudge.pn_uid is not null
                LEFT JOIN Leagues as lh ON away.League = lh.ID
	            LEFT JOIN Leagues as la ON home.League = la.ID
                WHERE Year( Date )= $currentSeason AND Game_Level = 'Varsity' AND (Game_Type = 'Regular' OR Game_Type = 'Tournament') AND (la.ID = '$league' or lh.ID = '$league')
                Group by Schedule.Game_ID
                Order by Date";
    }
    
    static function GetCurrentYearForTeam($league, $TeamId )
    {
        $currentSeason = Schedule_Row::GetCurrentSeasonYear();
        return "LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
                LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
                LEFT JOIN `Field_Info` on Site_ID = Field_Info.field_id
                LEFT JOIN  `CancelOptions` ON Cancel = CancelOptions.cancelid
                LEFT JOIN  ContactInfo as referee ON referee.pn_uid = Referee and referee.pn_uid != 0 and referee.pn_uid is not null
                LEFT JOIN  ContactInfo as umpire ON umpire.pn_uid = Umpire and umpire.pn_uid != 0 and umpire.pn_uid is not null
                LEFT JOIN  ContactInfo as fieldjudge ON fieldjudge.pn_uid = Field_Judge and fieldjudge.pn_uid != 0 and fieldjudge.pn_uid is not null
                LEFT JOIN Leagues as lh ON away.League = lh.ID
	            LEFT JOIN Leagues as la ON home.League = la.ID
                WHERE Year( Date )= $currentSeason AND ( $TeamId = HomeTeam_ID OR $TeamId = AwayTeam_ID) AND (la.ID = '$league' or lh.ID = '$league')
                GROUP BY Schedule.Game_ID";
    }
    
    
    function GetGame()
    {
        $currentSeason = Schedule_Row::GetCurrentSeasonYear();
        return "LEFT JOIN `Teams` AS home ON `HomeTeam_ID` = home.Team_ID
                LEFT JOIN `Teams` AS away ON `AwayTeam_ID` = away.Team_ID
                LEFT JOIN `Field_Info` on Site_ID = Field_Info.field_id
                LEFT JOIN  `CancelOptions` ON Cancel = CancelOptions.cancelid
                LEFT JOIN  ContactInfo as referee ON referee.Id = Referee
                LEFT JOIN  ContactInfo as umpire ON umpire.Id = Umpire
                LEFT JOIN  ContactInfo as fieldjudge ON fieldjudge.Id = Field_Judge
                LEFT JOIN Leagues as lh ON away.League = lh.ID
	            LEFT JOIN Leagues as la ON home.League = la.ID
                WHERE Game_ID = $this->Game_ID";
    }
        
    static function GetSelectStatement()
    {
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
                          away.Member as Away_Member,
                          away.League as Away_League,
                          referee.Id as referee_Id,
                          referee.FirstName as referee_FirstName,
                          referee.LastName as referee_LastName,
                          referee.PhoneHome as referee_PhoneHome,
                          referee.PhoneWork as referee_PhoneWork,
                          referee.PhoneCell as referee_PhoneCell,
                          referee.Email as referee_Email,
                          umpire.Id as umpire_Id,
                          umpire.FirstName as umpire_FirstName,
                          umpire.LastName as umpire_LastName,
                          umpire.PhoneHome as umpire_PhoneHome,
                          umpire.PhoneWork as umpire_PhoneWork,
                          umpire.PhoneCell as umpire_PhoneCell,
                          umpire.Email as umpire_Email,
                          fieldjudge.Id as fieldjudge_Id,
                          fieldjudge.FirstName as fieldjudge_FirstName,
                          fieldjudge.LastName as fieldjudge_LastName,
                          fieldjudge.PhoneHome as fieldjudge_PhoneHome,
                          fieldjudge.PhoneWork as fieldjudge_PhoneWork,
                          fieldjudge.PhoneCell as fieldjudge_PhoneCell,
                          fieldjudge.Email as fieldjudge_Email,
                          (select SUM(p.Goals)
                          from Points p
                          where p.Team_ID = Schedule.HomeTeam_ID
                             and p.Game_ID = Schedule.Game_ID) homeScore,
                          (select SUM(p.Goals)
                          from Points p
                          where p.Team_ID = Schedule.AwayTeam_ID
                             and p.Game_ID = Schedule.Game_ID) awayScore";
                           
    }
    
    
    static function getAdminForm($db, $listOfSchedule, $sqlEdit, $league){
		$tpl = new Template('../templates/');
        $tpl->set('leagueoptionsform', Leagues_Row::getForm($db,$league));
		$tpl->set('list_of_schedule', $listOfSchedule );
        $tpl->set('hometeamoptions',Teams_Row::GetIhslaOptions($db,90,$sqlEdit != NULL ? $sqlEdit->HomeTeam_ID : NULL));
        $tpl->set('awayteamoptions',Teams_Row::GetIhslaOptions($db,90,$sqlEdit != NULL ? $sqlEdit->AwayTeam_ID : NULL));
        $tpl->set('siteidoptions',Field_Info_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Site_ID : NULL));
        $tpl->set('leveloptions',Levels_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Game_Level : NULL));
        $tpl->set('gametypeoptions',GameType_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Game_Type : NULL));
        $tpl->set('houroptions',MyDateTime::GetHourOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getHour() : NULL));
        $tpl->set('minuteoptions',MyDateTime::GetMinuteOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getMinutes() : NULL));
        $tpl->set('periodoptions',MyDateTime::GetPeriodOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getPeriod() : NULL));
        $tpl->set('gameid',$sqlEdit != NULL ? $sqlEdit->Game_ID : NULL);
        $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
        $tpl->set('league' ,$league);
		return $tpl->fetch('AdminSchedule.form.tpl.php');
    }
    
    static function getTeamForm($db, $listOfSchedule, $sqlEdit, $team, $league){
		$tpl = new Template('../templates/');
		$tpl->set('list_of_schedule', $listOfSchedule );
        if ( NULL != $sqlEdit ){
            $location = $sqlEdit->getLocation($team->Team_ID);
            $tpl->set('locationoptions',Schedule_Row::getLocationOpptions($location));
            if( "HOME" == $location ){
               $tpl->set('opponentoptions',Teams_Row::GetTeamScheduleOptions($db, $team->Team_ID, $sqlEdit->AwayTeam_ID ));
            }
            else{
               $tpl->set('opponentoptions',Teams_Row::GetTeamScheduleOptions($db, $team->Team_ID, $sqlEdit->HomeTeam_ID ));   
            }
        }else
        {
            $tpl->set('locationoptions',Schedule_Row::getLocationOpptions(NULL));
            $tpl->set('opponentoptions',Teams_Row::GetTeamScheduleOptions($db, $team->Team_ID ));
        }
        $tpl->set('Date',$sqlEdit != NULL ? $sqlEdit->_DateObject->getDatepickerFormat() : NULL);
        $tpl->set('siteidoptions',Field_Info_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Site_ID : NULL));
        $tpl->set('leveloptions',Levels_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Game_Level : NULL));
        $tpl->set('gametypeoptions',GameType_Row::GetOptions($db,$sqlEdit != NULL ? $sqlEdit->Game_Type : NULL));
        $tpl->set('houroptions',MyDateTime::GetHourOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getHour() : 5));
        $tpl->set('minuteoptions',MyDateTime::GetMinuteOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getMinutes() : 30));
        $tpl->set('periodoptions',MyDateTime::GetPeriodOptions($sqlEdit != NULL ? $sqlEdit->_TimeObject->getPeriod() : PM));
        $tpl->set('gameid',$sqlEdit != NULL ? $sqlEdit->Game_ID : NULL);
        $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
        $tpl->set('league' ,$league);
        $tpl->set('team',$team);
		return $tpl->fetch('TeamSchedule.form.tpl.php');
    }
    
    static function fetchGameOptions( $database, $teamId ){
      $tpl = new Template('./');
      $test = Schedule_Row::GetSelectGameOptions($database, $teamId);
      $tpl->set('gameOptions', $test);
      $tpl->set('Team_ID', $teamId);
      $tpl->set('action',"EnterStats");
      return $tpl->fetch('../templates/SelectGame.tpl.php');   
   }
    
    static function convertTime( $hour, $minutes, $period){
        $returnValue = date("H:i", strtotime("$hour:$minutes $period"));
        return $returnValue;
    }
    
    static function GetCurrentSeasonYear( ) 
    {
    	$ReturncurrentYear = date("Y");
    	$month = date("m");
    	if( $month > 7 )
    	{
    		$ReturncurrentYear = $ReturncurrentYear + 1;
    	}
    	return $ReturncurrentYear;
    }
    
    static function GetSelectGameOptions($database, $teamId){
        $currentSeason = Schedule_Row::GetCurrentSeasonYear();
        $sql_Statement = "SELECT Game_ID, Date, h.Team_Name as home, h.Team_ID as homeid, a.Team_Name as away, a.Team_ID as awayid
				FROM Schedule LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
				LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
				WHERE (HomeTeam_ID = '$teamId' OR AwayTeam_ID = '$teamId') AND Year(Date) = $currentSeason AND Game_Type != 'Scrimmage' AND Game_Level = 'Varsity' AND Cancel = 0
				ORDER BY Date";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
        $Date= new MyDateTime($row->Date); // date_convert($row->Date,10);
			if ( $row->homeid != $teamId )
			{
				$Opponent = "@ ";
				$Opponent .= $row->home;
			}
			else if ( $row->awayid != $teamId )
			{
				$Opponent = "vs ";
				$Opponent .= $row->away;
			};
			$GameID = $row->Game_ID;
         $DateFormated = $Date->getOldScheduleFormat();
			$options .= "<option value =$GameID> $DateFormated $Opponent </option>";
        }       
        return $options;
        
    }
    
    static function GetOptions( $database, $teamId){
        
        
        $sql_Statement = "SELECT Game_ID, Date, h.Team_Name as home, h.Team_ID as homeid, a.Team_Name as away, a.Team_ID as awayid
				FROM Schedule LEFT JOIN Teams as h ON h.Team_ID = HomeTeam_ID
				LEFT JOIN Teams as a ON a.Team_ID = AwayTeam_ID
				WHERE (HomeTeam_ID = '$teamId' OR AwayTeam_ID = '$teamId') AND Year(Date) = 2012 AND Game_Type != 'Scrimmage' AND Game_Level = 'Varsity' AND Cancel = 0
				ORDER BY Date";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $Date=  MyDateTime($row->Date); // date_convert($row->Date,10);
			if ( $row->homeid != $teamId )
			{
				$Opponent = "@ ";
				$Opponent .= $row->home;
			}
			else if ( $row->awayid != $teamId )
			{
				$Opponent = "vs ";
				$Opponent .= $row->away;
			};
			$GameID = $row->Game_ID;
         $DateFormated = $Date->getOldScheduleFormat();
			$options .= "<option value =$GameID> $DateFormated $Opponent </option>";
        }       
        return $options;
    }
    
    function GetAllOfficialOptions( $database, $perviousValue = 0 )
    {
    	$sql = "SELECT ContactInfo.Id, Users.userid, ContactInfo.FirstName, ContactInfo.LastName
    				FROM Groups, GroupList, Users, ContactInfo
    				WHERE Groups.GroupName = 'Officials'
    				AND GroupList.GID = Groups.GID
    				AND Users.userid = GroupList.UID
    				AND ContactInfo.Id = Users.contactinfo_id
    				GROUP BY Users.userid
    				ORDER BY ContactInfo.LastName";
        
        $database->query($sql);
    
    	while ( $row = $database->fetchNextObject() ){
    		$firstName = $row->FirstName;
    		$lastName = $row->LastName;
    		$id = $row->Id;

    		if( $perviousValue == $id ){
    			$option .= "<OPTION SELECTED VALUE=$id> $firstName $lastName </OPTION>";
    		}
    		else{
                $option .= "<OPTION VALUE=$id> $firstName $lastName </OPTION>";
    		}
        }
    	return $option;
    }
    
    function getLocation($Team_ID){
      if( $Team_ID == $this->AwayTeam_ID ){
         return "away";
      }
      else if ( $Team_ID == $this->HomeTeam_ID ){
         return "HOME";
      }
      else{
         return "NA";
      }
    }
    
    static function getLocationOpptions($previousValue = null){
      $locationArray = array('HOME', 'away');
      foreach ($locationArray as $i) {
         if($previousValue == $i) {
            $returnLocationOptions .= "<option selected >$i </option>";
         } else {
            $returnLocationOptions .= "<option >$i </option>";
         }
      }

      return $returnLocationOptions;
    }
    
    function getOpponent($Team_ID){
      if( $Team_ID == $this->AwayTeam_ID ){
         return $this->_HomeTeamObject->Team_Name;
      }
      else if ( $Team_ID == $this->HomeTeam_ID ){
         return $this->_AwayTeamObject->Team_Name;
      }
      else{
         return "NA";
      }
    }
    
    function getResults( $showLink = FALSE ){
      if (FALSE != $this->_Score->scoreSetHome && FALSE != $this->_Score->scoreSetAway){
         if( TRUE == $showLink){
            $returnString = "<a href='GameSummary.php?Game_ID=$this->Game_ID'>";
         }
         $returnString .= $this->_Score->homeScore;
         $returnString .= " - ";
         $returnString .= $this->_Score->awayScore;
         if(TRUE == $showLink){
            $returnString .= "</a>";
         }
         
      }
      else{
         $returnString = "NA";
      }
      return $returnString;
    }
    function setSchedule($location, $team, $opponent){
      if( 'HOME' == $location ){
         $this->AwayTeam_ID = $opponent;
         $this->HomeTeam_ID = $team;
      }
      else{
         $this->AwayTeam_ID = $team;
         $this->HomeTeam_ID = $opponent;
      }
      
      
    }
    
    function getScore( $database ){
        
        return $this->_Score;
    }
    
    function fetchScore( ){
        $tpl = new Template('../templates/');
        $tpl->set(Score, $this->_Score);
        return $tpl->fetch('Score.tpl.php');
    }

}

?>