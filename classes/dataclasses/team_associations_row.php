<?php
require_once('row.php');
require_once ('teams_row.php');
class Team_Associations_Row extends Row{
    protected $idlinkedteam;
    protected $idhostteam;
    protected $_HostTeam;
    protected $_LinkedTeam;
    
    function __construct( $array = null){
      	$this->idhostteam = $array['idhostteam'];
      	$this->idlinkedteam = $array['idlinkedteam'];
        $this->_HostTeam = new Teams_Row(array( Team_ID => $array['Host_Team_ID'], 
                                                     Team_Name => $array['Host_Team_Name'],
                                                     Address => $array ['Host_Address'],
                                                     City => $array['Host_City'],
                                                     State => $array['Host_State'],
                                                     ZIP => $array['Host_ZIP'],
                                                     Phone => $array['Host_Phone'],
                                                     Fax => $array['Host_Fax'],
                                                     Home_Colors => $array['Host_Home_Colors'],
                                                     Away_Colors => $array['Host_Away_Colors'],
                                                     Mascot => $array['Host_Mascot'],
                                                     OutOfState => $array['Host_OutOfState'],
                                                     Member => $array['Host_Member'],
                                                     League => $array['Host_League'] ));
                                                     
        $this->_LinkedTeam = new Teams_Row(array( Team_ID => $array['Link_Team_ID'], 
                                                     Team_Name => $array['Link_Team_Name'],
                                                     Address => $array ['Link_Address'],
                                                     City => $array['Link_City'],
                                                     State => $array['Link_State'],
                                                     ZIP => $array['Link_ZIP'],
                                                     Phone => $array['Link_Phone'],
                                                     Fax => $array['Link_Fax'],
                                                     Home_Colors => $array['Link_Home_Colors'],
                                                     Away_Colors => $array['Link_Away_Colors'],
                                                     Mascot => $array['Link_Mascot'],
                                                     OutOfState => $array['Link_OutOfState'],
                                                     Member => $array['Link_Member'],
                                                     League => $array['Link_League'] ));
    }
    
    static function GetSelectStatement(){
        return "SELECT *, host.Team_ID as Host_Team_ID, 
                          host.Team_Name as Host_Team_Name,
                          host.Address as Host_Address,
                          host.City as Host_City,
                          host.State as Host_State,
                          host.ZIP as Host_ZIP,
                          host.Phone as Host_Phone,
                          host.Fax as host_Fax,
                          host.Home_Colors as Host_Home_Colors,
                          host.Away_Colors as Host_Away_Colors,
                          host.Mascot as host_Mascot,
                          host.OutOfState as host_OutOfState,
                          host.Member as host_Member,
                          host.League as host_League,
                          link.Team_ID as Link_Team_ID, 
                          link.Team_Name as Link_Team_Name,
                          link.Address as Link_Address,
                          link.City as Link_City,
                          link.State as Link_State,
                          link.ZIP as Link_ZIP,
                          link.Phone as Link_Phone,
                          link.Fax as Link_Fax,
                          link.Home_Colors as Link_Home_Colors,
                          link.Away_Colors as Link_Away_Colors,
                          link.Mascot as Link_Mascot,
                          link.OutOfState as Link_OutOfState,
                          link.Member as Link_Member,
                          link.League as Link_League";
    }
    
    static function GetWhere(){
        return "LEFT JOIN `Teams` AS host ON `idhostteam` = host.Team_ID
                LEFT JOIN `Teams` AS link ON `idlinkedteam` = link.Team_ID";
    }
    
    static function getAdminForm($db, $listOfTeamAssociations, $sqlEdit){
        $tpl = new Template('templates/');
        $tpl->set('list_of_team_associations', $listOfTeamAssociations );
        $tpl->set('hostteamoptions',Teams_Row::GetIhslaOptions($db,90,$sqlEdit != NULL ? $sqlEdit->idhostteam : NULL));
        $tpl->set('linkteamoptions',Teams_Row::GetNonIhslaTeamInIndianaOptions($db,90,$sqlEdit != NULL ? $sqlEdit->idlinkedteam : NULL));
        $tpl->set('submittype',$sqlEdit != NULL ? "Edit" : "Submit");
		return $tpl->fetch('TeamAssociations.form.tpl.php');
    }
  }

?>