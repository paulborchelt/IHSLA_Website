<?php
require_once('row.php');
class OfficialRegistration_Row extends Row{
   protected $idofficialregistration;
   protected $firstname;
   protected $lastname;
   protected $address;
   protected $city;
   protected $state;
   protected $zip;
   protected $email;
   protected $age;
   protected $schoolattending;
   protected $gradeinschool;
   protected $currentlycertified;
   protected $uslacrossenumber;
   protected $date;
   protected $carmeldadsclub;
   
   function __construct( $array = null){
      	$this->idofficialregistration = $array['idofficialregistration'];
        $this->firstname = $array['firstname'];
        $this->lastname = $array['lastname'];
        $this->address = $array['address'];
        $this->city = $array['city'];
        $this->state = $array['state'];
        $this->zip= $array['zip'];
        $this->email = $array['email'];
        $this->age = $array['age'];
        $this->schoolattending = $array['schoolattending'];
        $this->gradeinschool = $array['gradeinschool'];
        $this->currentlycertified = $array['currentlycertified'];
        $this->uslacrossenumber = $array['uslacrossenumber'];
        $this->date = $array['date'];
        $this->carmeldadsclub = $array['carmeldadsclub'];
   }
   
   function certifiedYesOrNo(){
        if ( $this->currentlycertified == 1 ) {
            return Yes;
        }
        else{
            return No;
        }
   }
   
   function carmeldadsclubYesOrNo(){
        if ( $this->carmeldadsclub == 1 ) {
            return Yes;
        }
        else{
            return No;
        }
   }
   
   static function getForm(){
        $tpl =  new Template('templates/');
        return $tpl->fetch('OfficialRegistration.form.tpl.php');
   }
}
?>