<?php
	class AccessProtected {
      public function __get($var){
         return $this->$var;
      }
   }
?>