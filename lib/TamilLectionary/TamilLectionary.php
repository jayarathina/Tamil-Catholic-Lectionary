<?php
include_once ('lib/RomanCalendar/RomanCalendar.php');
include_once ('lib/RomanCalendar/RomanCalendarRenderHTML.php');
include_once ('lib/TamilLectionary/TamilLectionaryFeastNameFramer.php');
include_once ('lib/TamilLectionary/TamilLectionaryReadings.php');

class TamilLectionary {
    
	public $fullYear;
	public $curYear;
    
    function __construct($year = null, $calcConfig){
    	$this->curYear = is_numeric ( $year ) ? $year : date ( "Y" );
    	
    	$dirName = $calcConfig ['feastsListLoc'] . $this->curYear;
        $fileName= $dirName . '/readings.json';
        
        if (! file_exists ( $fileName)) { // If the does not exist in the specified path, then create it from DB
        	$CalcGen = new RomanCalendar ($this->curYear, $calcConfig);
        	$rcy = TamilLectionaryFeastNameFramer::setName($CalcGen->rcy);
        	
        	$tlReadings = new TamilLectionaryReadings ();
        	$rcy = $tlReadings->setReadings($CalcGen->rcy);

        	$t = json_encode ( $rcy->fullYear, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK );
        	/**/
        	$ret = file_put_contents ( $fileName, $t );

        	if ($ret === FALSE) {
        		die ( 'Error in writing JSON file' );
        	}
        	/* */
        	$this->fullYear = $rcy->fullYear;
        }else{
        	$txtCnt = file_get_contents ( $fileName );
        	$this->fullYear = json_decode ( $txtCnt, true );
        }
        

    }
}