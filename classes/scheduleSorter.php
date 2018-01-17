<?php
require_once ('accessprotected.php');
require_once ('classes/dataclasses/schedule_row.php');
class ScheduleSorter extends AccessProtected{
   protected $level;
   protected $type;
   protected $daterange;
   
    function __construct($array = null){
      $this->level = $array['level'];
      $this->type = $array['type'];
      $this->daterange = $array['daterange'];
    }
    
    function getWhereStatement(){
      
      $currentSeason = Schedule_Row::GetCurrentSeasonYear();
      //initialize
      $Search = " ";
      
      switch($this->level)
      {
      	case ALL:
      		$Search = " ";
      	  break;
      	case Varsity:
      		$Search = "WHERE Game_Level = 'Varsity'";
      	  break;
      	case JV:
      		$Search = "WHERE Game_Level = 'JV'";
      		break;
          case Freshmen:
          	$Search = "WHERE Game_Level = 'Freshmen'";
            break;
      }
      
      switch($this->daterange)
      {
         
      	case Today:
  	         $TodayDate = date("Y-m-d");
      		if( $Search == " " ){
      		   $Search = $Search . " WHERE Date = '$TodayDate'";
      		}
      		else{
      		   $Search = $Search . " AND Date = '$TodayDate'";
      		} 
      	  break;
      	case Yesterday:
      		$Yesterday = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-1,date("Y")));
      		if( $Search == " " ){
      		   $Search = $Search . " WHERE Date = '$Yesterday'";
      		}
      		else{
      		   $Search = $Search . " AND Date = '$Yesterday'";
      		} 
      		break;
      	case Week:
  	         $TodayDate = date("Y-m-d");
      		$Weekend = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")+7,date("Y")));
      		if( $Search == " " ){
      		   $Search = $Search . " WHERE Date >= '$TodayDate' AND Date <= '$Weekend'";
      		}
      		else{
      		   $Search = $Search . " AND Date >= '$TodayDate' AND Date <= '$Weekend'";
      		} 
      		break;
      	case LastWeek:
      	    $TodayDate = date("Y-m-d");
      		$Weekend = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-7,date("Y")));
      		if( $Search == " " ){
      		   $Search = $Search . " WHERE Date <= '$TodayDate' AND Date >= '$Weekend'";
      		}
      		else{
      		   $Search = $Search . " AND Date <= '$TodayDate' AND Date >= '$Weekend'";
      		} 
      		break;	
      	case All:
      		if( $Search == " " ){
      		   $Search = $Search . " WHERE Year(Date) = '$currentSeason'";
      		}
      		else{
      		   $Search = $Search . " AND Year(Date) = '$currentSeason'";
      		} 
      		break;
         default:
            $this->daterange = "Week";
            $TodayDate = date("Y-m-d");
            $Weekend = date("Y-m-d",mktime(0,0,0,date("m") ,date("d")+7,date("Y")));
            if( $Search == " " ){
               $Search = $Search . " WHERE Date >= '$TodayDate' AND Date <= '$Weekend'";
            }
            else{
               $Search = $Search . " AND Date >= '$TodayDate' AND Date <= '$Weekend'";
            } 
            break;	
      }
      
      switch($this->type)
      {
      	case All:
      	  
      	  break;
      	case Regular:
      	    if( $Search == " " )
              {
      		   $Search = $Search . " WHERE (Game_Type = 'Regular' OR Game_Type = 'Tournament')";
      		}
      		else
      		{
      		   $Search = $Search . " AND (Game_Type = 'Regular' OR Game_Type = 'Tournament')";
      		}   
      	  break;
      	case Scrimmage:
      	    if( $Search == " " )
              {
                 $Search = $Search . " WHERE Game_Type = 'Scrimmage'";
      	    }
      	    else
      	    {
      	       $Search = $Search . " AND Game_Type = 'Scrimmage'";  
      	    }
      		break;
          case Tournament:
              if( $Search == " " )
              {
          	   $Search = $Search . " WHERE Game_Type = 'Tournament'";
          	}
          	else
          	{
          	   $Search = $Search . " AND Game_Type = 'Tournament'";
          	}
              break;
      	default:
      	  break;
      }
      return $Search;
    }
}
?>