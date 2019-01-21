<?php

class managefile{
    private $filename;
    
    function __construct( $filename ) {
        $this->filename = $filename;
    }
    
    function download (){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($this->filename).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->filename));
        readfile($this->filename);
    }
}
?>