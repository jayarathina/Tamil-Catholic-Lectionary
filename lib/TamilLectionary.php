<?php
/**
 * RomanLectionary 1.0
 * This function get the year and settings and creates a json file to generate a calendar
 * @author Br. Jayarathina Madharasan SDR
 */
require_once 'mods/Medoo.php';
include_once 'lib/dbConfig.php';
include_once 'lib/includeExternal.php';

include_once 'lib/FeastNameFramer.php';
class TamilLectionary {

	/**
	 * Cmputers reading for the given year (current year if null) and saves it to a file.
	 *
	 * @param unknown $year        	
	 * @param unknown $calcConfig
	 *        	- Clendar configurations to pass to RomanCalendar to compute feast days
	 * @return string - Name of the file where readings are stored.
	 */
	function computeReadings($year = null, $calcConfig) {
		$currentYear = is_numeric ( $year ) ? $year : date ( "Y" );
		$dirName = $calcConfig ['feastsListLoc'] . $currentYear;
		if (! is_dir ( $dirName )) {
			mkdir ( $dirName, 0644 );
		}
		$filename = $dirName . '/' . 'year.json';
		if (! file_exists ( $filename )) {
			
			
			$database = new Medoo( array(
					'database_type' => 'mysql',
					'server' => 'localhost',
					'charset' => 'utf8',
					
					'username' => DB_USER,
					'password' => DB_PASSWORD,
					'database_name' => DB_NAME,
					'prefix' => DB_TBL_PREFIX,
			) );
			
			$rc = new RomanCalendar ( $year, $calcConfig );
			$setNames = new FeastNameFramer ( $database );
			$rcy = $setNames->setDayNames ( $rc->rcy );
			$this->getReadings ( $rcy, $database );

			file_put_contents ( $filename, json_encode ( $rcy, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK ) );
		}
		return $filename;
	}

	private function getReadings(RomanCalendarYear $rcy, medoo $database) {
		// Sunday A, B or C; Ordinary Week 1 or 2
		$sundayType = chr ( (($rcy->currentYear - 1) % 3) + 65 );
		$sundayType_After_Advent = chr ( ($rcy->currentYear % 3) + 65 );
		$OWType = ($rcy->currentYear % 2) == 0 ? 2 : 1;
		
		foreach ( $rcy->fullYear as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				foreach ( $feasts as $feastCount => $fet ) {
					
					$append_to_dayID = '';
					$temp_SundayType = $sundayType;
					
					if (preg_match ( '/^OW\d{2}\-[1-6][a-zA-Z]{3}/', $fet ['code'] ) === 1) { // If weekday in ordinary season
						$append_to_dayID = $OWType;
					} elseif (preg_match ( '/^AW\d{2}/', $fet ['code'] ) === 1 || preg_match ( '/CW01\-HolyFamily/', $fet ['code'] ) === 1) { // If advent or holy family
						$temp_SundayType = $append_to_dayID = $sundayType_After_Advent;
					}
					
					$ReadingList = $database->select ( 'readings__list', '*', array (
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
							$rcy->fullYear [$month] [$days] [$feastCount] ['readingList'] = $ReadingList;
						}
					}
					
					$saintsProper = array (
							'common' => 'தூய கன்னி மரியா',
							'proper' => 'gospel' 
					);
					
					foreach ( $rcy->calcConfig ['calendars'] as $calName ) {
						// Immaculate heart of mary has gospel proper; Only this is set here manually because date varies every year
						if ($rcy->fullYear [$month] [$days] [$feastCount] ['code'] !== 'OW00-ImmaculateHeart') {
							// Get proper reading for saints from DB as no recomended readings are listed in the lectionary
							$saintsProper = $database->get ( 'general' . $calName, array (
									'common',
									'proper' 
							), array (
									'feast_code' => $fet ['code'] 
							) );
						}
						
						if ($rcy->fullYear [$month] [$days] [$feastCount] ['code'] !== 'OW00-MaryMotherofChurch') {
							// Get proper reading for saints from DB as no recomended readings are listed in the lectionary
							$saintsProper = $database->get ( 'general' . $calName, array (
									'common',
									'proper' 
							), array (
									'feast_code' => $fet ['code'] 
							) );
						}
						
						if ($saintsProper) {
							$saintsProper = array_filter ( $saintsProper ); // Remove empty elements
							if (sizeof ( $saintsProper ) > 0)
								$rcy->fullYear [$month] [$days] [$feastCount] ['readingList_Proper'] = $saintsProper;
							
							if (isset ( $saintsProper ['proper'] )) {
								if (strcasecmp ( 'All', $saintsProper ['proper'] ) === 0) {
									$rcy->fullYear [$month] [$days] [0] ['readingList'] ['reading1'] = $ReadingList ['reading1'];
									$rcy->fullYear [$month] [$days] [0] ['readingList'] ['gospel'] = $ReadingList ['gospel'];
									$rcy->fullYear [$month] [$days] [0] ['readingList'] ['alleluia'] = $ReadingList ['alleluia'];
								} else {
									$rcy->fullYear [$month] [$days] [0] ['readingList'] [$saintsProper ['proper']] = $ReadingList [$saintsProper ['proper']];
								}
								
								// Add some reference tags to the week day readings to know what has been replaced
								$rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['dayID'] = $rcy->fullYear [$month] [$days] [$feastCount] ['code'];
								$rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['name'] = $rcy->fullYear [$month] [$days] [$feastCount] ['name'];
								$rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['type'] = $rcy->fullYear [$month] [$days] [$feastCount] ['type'];
								$rcy->fullYear [$month] [$days] [0] ['readingList_replacement'] ['proper'] = $saintsProper ['proper'];
							}
							break; // One event will be available only in one table, so we can skip the rest
						}
					}
					
					// Checking for Vigil Readings or multiple readings for same feast like christmas
					$ReadingList_Multiple = $database->select ( 'readings__list_multiple', '*', array (
							'dayID[~]' => $fet ['code'] . '%' 
					) );
					
					if ($ReadingList_Multiple) {
						$rcy->fullYear [$month] [$days] [$feastCount] ['readingList_multiple'] = $ReadingList_Multiple;
					}
					// TODO Get sequence text here
					// TODO Set easter vigil and palm sunday seperately
				}
			}
		}
	}
}