<?PHP

class Options {
    static function GetGroupOptions( $database ){
        $sql_Statement = "SELECT * FROM Groups";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $gid = $row->GID;
            $name = $row->GroupName;
            //if( $permissions | $gid)  //TODO: Add this line back. What does it do?
            {
                $GroupOptions .= "<option value = test>$name</OPTION>";
            }
        }       
        return $GroupOptions;
    }
    
    static function CreateMonthOptions ( $previousValue='March' ){
        $monthArray = array('January','February','March','April','May','June','July','August','Septemper','October','November','December');
        foreach( $monthArray as $i ){
            if( $previousValue == $i ){
                $returnMonthOptions .= "<option selected >$i </option>";
            }
            else{
                $returnMonthOptions .= "<option >$i </option>";
            }
        }
        return $returnMonthOptions;
    }
    
    static function CreateRecurrenceDeleteOptions ( $previousValue='One' ){
        //TODO: Why do I need to add test??
        $array = array('Test','One','All');
        foreach( $array as $i ){
            if( $previousValue == $i ){
                $returnOptions .= "<option selected >$i </option>";
            }
            else{
                $returnOptions .= "<option >$i </option>";
            }
        }
        return $returnOptions;
    }
    
    static function CreateRecurrenceOptions( $previousValue='None' ){
        //TODO: Why does remove not show up?
        $array = array('Remove','None','Week','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        foreach( $array as $i){
            if ( $previousValue == $i){
                $returnOptions .= "<OPTION SELECTED> $i </OPTION>";
            }
            else{
                $returnOptions .= "<OPTION> $i </OPTION>";;
            }
        }
        
        return $returnOptions;
    }
    
    static function GetSiteOptions( $database ){
        $sql_Statement = "SELECT * FROM Groups";
        $database->query($sql_Statement);
        while ( $row = $database->fetchNextObject() ){
            $gid = $row->GID;
            $name = $row->GroupName;
            //if( $permissions | $gid)  //TODO: Add this line back. What does it do?
            {
                $GroupOptions .= "<option value = test>$name</OPTION>";
            }
        }       
        return $GroupOptions;
    }
}
    
?>