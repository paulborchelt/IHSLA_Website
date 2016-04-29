<?php
    class RecurringDates {
        private $_startDate;
        private $_endDate;
        private $_recurrences;
        private $_iterator;
        private $_dayCount;
        
        function __construct($startDate, $endDate, $recurrences) {
            $this->_startDate = $startDate;
            $this->_endDate = $endDate;
            $this->_recurrences = $recurrences;
            $this->_dayCount = 0;
            
            if( $this->_endDate < $this->_startDate ){
                throw new exception("End date set before start date.");
            }
            
            if( $this->_recurrences != "Week"){
                $this->_iterator = strtotime($recurrences, $this->_startDate->getTimestamp());
            }
            else{
                $this->_iterator = strtotime("Monday", $this->_startDate->getTimestamp());
            }
    
        }

        private function advanceToNextDate(){
            if( $this->_recurrences != "Week"){
                $this->_iterator = strtotime("+1 weeks", $this->_iterator); 
            }
            else{
                $this->_iterator = strtotime("next day", $this->_iterator);     
                $this->incrementDayCount();
            }
            
        } 
        
        private function incrementDayCount(){
            if( 4 != $this->_dayCount ){
                $this->_dayCount = $this->_dayCount + 1;
            }
            else{
                $this->_dayCount = 0;
                $this->_iterator = strtotime("Monday", $this->_iterator);
            }        
        }
        
        function fectchNextDate(){
            if( $this->_iterator <= $this->_endDate->getTimestamp() ){
                $date = new MyDateTime(date("y-m-d", $this->_iterator));//Todo: Is a better way to create MyDateTime?
                $this->advanceToNextDate();
                return $date;
            }
            else{
                return false;
            }
        }
        
    }

?>