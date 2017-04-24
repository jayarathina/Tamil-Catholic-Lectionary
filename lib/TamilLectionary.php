<?php
/**
 * RomanLectionary 1.0
 * @author Br. Jayarathina Madharasan SDR
 */
require_once 'mods/Medoo.php';
include_once 'lib/includeExternal.php';
include_once 'lib/FeastNameFramer.php';
class TamilLectionary {

	public $rcy;

	private $database;
	
	// Sunday A, B or C; Ordinary Week 1 or 2
	private $sundayType, $sundayType_After_Advent, $OWType;

	function __construct($year = null, $calcConfig) {
		$this->database = new medoo ( array (
				'database_type' => 'mysql',
				'database_name' => 'liturgy_lectionary',
				'server' => 'localhost',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8' 
		) );
		
		$rc = new RomanCalendar ( $year, $calcConfig );
		
		$setNames = new FeastNameFramer ( $this->database );
		$this->rcy = $setNames->setDayNames ( $rc->rcy );
		
		$this->sundayType = chr ( (($this->rcy->currentYear - 1) % 3) + 65 );
		$this->sundayType_After_Advent = chr ( ($this->rcy->currentYear % 3) + 65 );
		$this->OWType = ($this->rcy->currentYear % 2) == 0 ? 2 : 1;
		
		$this->getReadings ();

		file_put_contents($this->rcy->calcConfig ['feastsListLoc'] . $this->rcy->currentYear . '.TXT', var_export($this->rcy, true));
		
		/*
		 $content = serialize($my_variable);
file_put_contents($file, $content);
$content = unserialize(file_get_contents($file));
		 */
		
		/*
		// Retrieve cache
		$myDataArray = unserialize(file_get_contents($cachePath));
		
		//$txtCnt = file_get_contents ( $fileName ); */
	}

	function getReadings() {
		foreach ( $this->rcy->fullYear as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				foreach ( $feasts as $feastCount => $fet ) {
					
					$append_to_dayID = '';
					$temp_SundayType = $this->sundayType;
					
					if (preg_match ( '/^OW\d{2}\-[1-6][a-zA-Z]{3}/', $fet ['code'] ) === 1) { // If weekday in ordinary season
						$append_to_dayID = $this->OWType;
					} elseif (preg_match ( '/^AW\d{2}/', $fet ['code'] ) === 1 || preg_match ( '/CW01\-HolyFamily/', $fet ['code'] ) === 1) { // If advent or holy family
						$temp_SundayType = $append_to_dayID = $this->sundayType_After_Advent;
					}
					
					$ReadingList = $this->database->select ( 'readings__list', '*', array (
							'OR' => array (
									'dayID' => $fet ['code'],
									'dayID#1' => $fet ['code'] . ' ' . $append_to_dayID,
									'dayID#2' => $fet ['code'] . ' ' . $temp_SundayType 
							) 
					) );
					
					if ($ReadingList) { // If you have reading...
						for($i = 1; $i < sizeof ( $ReadingList ); $i ++) {
							$ReadingList [0] = array_merge ( $ReadingList [0], array_filter ( $ReadingList [$i] ) ); // merge all arrays to get the final reading list
						}
						
						$ReadingList = $ReadingList [0];
						
						if (sizeof ( array_filter ( $ReadingList ) ) > 1) { // Only dayID will be remaining if saints do not have proper readings
							unset ( $ReadingList ['dayID'] );
							$this->rcy->fullYear [$month] [$days] [$feastCount] ['readingList'] = $ReadingList;
						}
					}
					
					$saintsProper = array (
							'common' => 'தூய கன்னி மரியா',
							'proper' => 'gospel' 
					);
					
					foreach ( $this->rcy->calcConfig ['calendars'] as $calName ) {
						// Immaculate heart of mary has gospel proper; Only this is set here manually because date varies every year
						if ($this->rcy->fullYear [$month] [$days] [$feastCount] ['code'] !== 'OW00-ImmaculateHeart') {
							// Get proper reading for saints from DB as no recomended readings are listed in the lectionary
							$saintsProper = $this->database->get ( 'general' . $calName, array (
									'common',
									'proper' 
							), array (
									'feast_code' => $fet ['code'] 
							) );
						}
						
						if ($saintsProper) {
							$saintsProper = array_filter ( $saintsProper ); // Remove empty elements
							if (sizeof ( $saintsProper ) > 0)
								$this->rcy->fullYear [$month] [$days] [$feastCount] ['readingList_Proper'] = $saintsProper;
							
							if (isset ( $saintsProper ['proper'] )) {
								if (strcasecmp ( 'All', $saintsProper ['proper'] ) === 0) {
									$this->rcy->fullYear [$month] [$days] [0] ['readingList'] ['reading1'] = $ReadingList ['reading1'];
									$this->rcy->fullYear [$month] [$days] [0] ['readingList'] ['gospel'] = $ReadingList ['gospel'];
									$this->rcy->fullYear [$month] [$days] [0] ['readingList'] ['alleluia'] = $ReadingList ['alleluia'];
								} else {
									$this->rcy->fullYear [$month] [$days] [0] ['readingList'] [$saintsProper ['proper']] = $ReadingList [$saintsProper ['proper']];
								}
								
								// Add some reference tags to the week day readings to know what has been replaced
								$this->rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['dayID'] = $this->rcy->fullYear [$month] [$days] [$feastCount] ['code'];
								$this->rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['name'] = $this->rcy->fullYear [$month] [$days] [$feastCount] ['name'];
								$this->rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['type'] = $this->rcy->fullYear [$month] [$days] [$feastCount] ['type'];
								$this->rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['proper'] = $saintsProper ['proper'];
							}
							break; // One event will be available only in one table, so we can skip the rest
						}
					}
					
					// Checking for Vigil Readings or multiple readings for same feast like christmas
					$ReadingList_Multiple = $this->database->select ( 'readings__list_multiple', '*', array (
							'dayID[~]' => $fet ['code'] . '%' 
					) );
					
					if ($ReadingList_Multiple) {
						$this->rcy->fullYear [$month] [$days] [$feastCount] ['readingList_multiple'] = $ReadingList_Multiple;
					}
					// TODO Get sequence text here
					// TODO Set easter vigil and palm sunday seperately
				}
			}
		}
	}
}