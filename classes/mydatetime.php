<?php
    define('AllOW_CURRENT_DATES', 0);
    define('AllOW_PREVIOUS_DATES', 1);
	class MyDateTime Extends DateTime{
	   
       /*
	   function __construct($month, $day, $year) {
	       parent::__construct( $this->CreateDateString($month, $day, $year)); 
	   }*/
       
       function getTimestamp() {
           return $this->format('U');
       }
       
       function getDatabaseFormat(){
           return $this->format('Y-m-d');
       }
       
       function getMonthName(){
            return $this->format('F');
       }
       
       function getDay(){
            return $this->format('d');
       }
       
       function getMonth(){
            return $this->format('m');
       }
       
       function getYear(){
            return $this->format('Y');
       }
       
       function getScheduleFormat(){
            return $this->format('M jS, D');
       }
       
       function getScheduleSortFormat(){
            return $this->format('Ymd');
       }
       //this is the old format used on the old website. 
       function getOldScheduleFormat(){
            return $this->format('D, M jS');
       }
       function getMonthDayYearFormat(){
            return $this->format('F j, Y');
       }
       
       function getDatepickerFormat(){
            return $this->format('m/j/Y');
       }
       
       function getTime(){
            return $this->format('g:i A');
       }
       
       function getHour(){
            return $this->format('g');
       }
       
       function getMinutes(){
            return $this->format('i');
       }
       
       function getPeriod(){
            return $this->format('A');
       }
       
       static function CreateDateString( $month, $day, $year ){
           if( $month == 'January' )
           {
                $returnDate = $year."-01-".$day;
           }
           else if( $month == 'February' )
           {
                $returnDate = $year."-02-".$day;
           }
           else if( $month == 'March' )
           {
                $returnDate = $year."-03-".$day;
           }
           else if ( $month == 'April' )
           {
                $returnDate = $year."-04-".$day;
           }
           else if ( $month == 'May' )
           {
                $returnDate = $year."-05-".$day;
           }
           else if ( $month == 'June' )
           {
        	    $returnDate = $year."-06-".$day;
           }
           else if ( $month == 'July' )
           {
        	    $returnDate = $year."-07-".$day;
           }
           else if ( $month == 'August' )
           {
        	    $returnDate = $year."-08-".$day;
           }
           else if ( $month == 'September' )
           {
        	    $returnDate = $year."-09-".$day;
           }
           else if ( $month == 'October' )
           {
        	    $returnDate = $year."-10-".$day;
           }
           else if ( $month == 'November' )
           {
        	    $returnDate = $year."-11-".$day;
           }
           else if ( $month == 'December' )
           {
        	    $returnDate = $year."-12-".$day;
           }
           else
           {
                throw new exception("Invalid month $month .");
           }
        
           return $returnDate;
        }
        
        static function GetHourOptions( $previousValue = NULL ){
            $hourarray = array('1','2','3','4','5','6','7','8','9','10','11','12');
            foreach( $hourarray as $i ){
                if( $previousValue == $i )
                {
                    $returnHourOptions .= "<option selected value =$i>$i</option>";
                }
                else
                {
                    $returnHourOptions .= "<option value =$i>$i</option>";
                }
            }
            return $returnHourOptions;
        }
        
        static function GetMinuteOptions( $previousValue = NULL ){

            $minutesarray = array('00','01','02','03','04','05','06','07','08','09',
                                  '10','11','12','13','14','15','16','17','18','19',
                                  '20','21','22','23','24','25','26','27','28','29',
                                  '30','31','32','33','34','35','36','37','38','39',
                                  '40','41','42','43','44','45','46','47','48','49',
                                  '50','51','52','53','54','55','56','57','58','59');            
            foreach( $minutesarray as $i ){
                if( $previousValue == $i )
                {
                    $returnMinuteOptions .= "<option selected value =$i>$i</option>";
                }
                else
                {
                    $returnMinuteOptions .= "<option value =$i>$i</option>";
                }
                
            }
            return $returnMinuteOptions;
        }
        
        static function GetPeriodOptions( $previousValue = NULL ){
            $periodarray =  array('AM','PM');
            foreach( $periodarray as $i ){
                if( $previousValue == $i )
                {
                    $returnPeriodOptions .= "<option selected value =$i>$i</option>";
                }
                else
                {
                    $returnPeriodOptions .= "<option value =$i>$i</option>";
                }
            }
            return $returnPeriodOptions;
        }
        
        static function GetCurrentSeasonYear( ) {
        	$ReturncurrentYear = date("Y");
        	$month = date("m");
        	if( $month > 7 )
        	{
        		$ReturncurrentYear = $ReturncurrentYear + 1;
        	}
        	return $ReturncurrentYear;
        }
        
        //static function getCalander( $allowType = AllOW_CURRENT_DATES, $sqlEdit = NULL ){
//            $day = $sqlEdit != NULL ? $sqlEdit->_DateObject->getDay() : date('d');
//            $month = $sqlEdit != NULL ? $sqlEdit->_DateObject->getMonth() : date('m');
//            $year = $sqlEdit != NULL ? $sqlEdit->_DateObject->getYear() : date('y');
//            $nextYear = (date("Y")+1);
//            $myCalendar = new tc_calendar("Date", true, false);
//            $myCalendar->setIcon("../calendar/images/iconCalendar.gif");
//            $myCalendar->setDate($day, $month, $year);
//            $myCalendar->setPath("../calendar/");
//            $myCalendar->setYearInterval(date('Y'),date('Y') + date('Y') );
//            if( AllOW_PREVIOUS_DATES == $allowType ){
//                $myCalendar->dateAllow(date('Y-m-d') - date('Y')  , date('Y-m-d')+ date('Y') );
//            }
//            else{
//                $myCalendar->dateAllow(date('Y-m-d') , date('Y-m-d')+ date('Y') );
//            }
//            $myCalendar->setAlignment('left', 'bottom');
//            return $myCalendar;
//        }
	}
?>