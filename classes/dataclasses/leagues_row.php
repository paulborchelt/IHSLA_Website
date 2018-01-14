<?php
require_once('row.php');
class Leagues_Row extends Row{
    protected $ID;
    protected $Name;


    function __construct( $array = null){
          	$this->ID = $array['ID'];
          	$this->Name = $array['Name'];
    }
    
    static function GetOptions( $database, $previousValue = NULL){
        $sql_Statement = "SELECT * 
                          FROM Leagues";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $ID = $row->ID;
            $Name = $row->Name;
            if( $ID == $previousValue)
            {
                $options .= "<option selected value = $ID>$Name</OPTION>";
            }
            else
            {
                $options .= "<option value = $ID>$Name</OPTION>";
            }
        }       
        return $options;
    }
    
    static function getForm($db, $league){
        
        $tpl = new Template('templates/');
        $tpl->set('leagueoptions',Leagues_Row::GetOptions($db,$league));
   
		return $tpl->fetch('LeagueOptions.form.tpl.php');
    }
}
?>