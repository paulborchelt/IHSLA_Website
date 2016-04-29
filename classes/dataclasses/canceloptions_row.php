<?php
require_once ('row.php');
class CancelOptions_Row extends Row{
    protected $cancelid;
    protected $cancelname;
    
    function __construct($array = null){
        $this->cancelid = $array['cancelid'];
        $this->cancelname = $array['cancelname'];
    }
}

	
?>