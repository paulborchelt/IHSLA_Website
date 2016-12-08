<?php
class Row {

   public function __get($var){
      return $this->$var;
   }
   
   public function ValidateDelete( $database ) {
      return;
   }
   
   public function ValidateValues(){
        return;
   }
   
   public function CheckForDuplicates ($database){
        return;
   }
   
   public function SendEmail ($database){
        return;
   }
   
   public function PrepUpdateEmail ($database){
        return;
   }
   
   public function PrepDeleteEmail ($database){
        return;
   }
   
   public function SendUpdateEmail ($database){
        return;
   }
   
   public function SendDeleteEmail ($database){
        return;
   }
   
   public function SetInternalObjects($database){
      return;
   }   
   public function toArray(){
      $reflect = new ReflectionClass($this);
      $properties  = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
      foreach ($properties as $property) { 
        $property_name = $property->getName();
        $array[$property_name] = $this->$property_name;
      }
      
      return $array;
   }
}

?>