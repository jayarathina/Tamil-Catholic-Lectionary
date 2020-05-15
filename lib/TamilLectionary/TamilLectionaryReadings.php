<?php
/**
 * Tamil-Catholic-Lectionary 1.0
 * @author Br. Jayarathina Madharasan SDR
 * 
 */
use Medoo\Medoo;
include_once 'lib/dbConfig.php';
include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
/**
 * Class that set readings for all event in a particular day
 */
class TamilLectionaryReadings {
	private $database, $sundayType, $sundayType_From_Advent, $OWType;
	function __construct() {
		$this->database = new Medoo ( array (
				'database_type' => DB_TYPE,
				'server' => DB_HOST,
				'charset' => DB_CHARSET,
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'database_name' => DB_NAME 
		) );
	}
	
	/**
	 *
	 * @param RomanCalendarYear $rcy
	 * @return RomanCalendarYear
	 */
	function setReadings(RomanCalendarYear $rcy) {
		$this->setSundayCode ( $rcy->currentYear );
		
		foreach ( $rcy->fullYear as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				foreach ( $feasts as $key => $feast ) {
					$rcy->fullYear [$month] [$days] [$key] ['readings'] = $this->setSingleReading ( $feast ['code'], $rcy->calcConfig ['calendars'] );
					
					if ('LW06-4Thu' === $feast ['code']) // Add alternative chrism mass on holy thuresday
						$rcy->fullYear [$month] [$days] [1] = $this->getChrismMass ();
				}
				
				// For moving readings proper of memory to ferial day. [வாசகம் இந்த நினைவுக்கு உரியது]
				foreach ( $feasts as $key => $feast ) {
					
					// Skip the first entry which will be a ferial day.
					if ($key === 0)
						continue;
					
					// traverse through the reading of remaining entries and find
					// memories which have proper readings to be used today
					$readings_to_replace = array_filter ( $rcy->fullYear [$month] [$days] [$key] ['readings'], function ($readingsType) {
						return preg_match ( "/^\d\.\d\d[19]/", $readingsType );
					}, ARRAY_FILTER_USE_KEY );
					
					$firstKey = array_key_first ( $readings_to_replace );
					if (intval ( $firstKey ) == 6) { // If Gospel is changed, then alleluia should also follow
						$readings_alleluia = array_filter ( $rcy->fullYear [$month] [$days] [$key] ['readings'], function ($readingsType) {
							return preg_match ( "/^5/", $readingsType );
						}, ARRAY_FILTER_USE_KEY );
						
						// Don't use array_merge, numeric keys will be renumbered; See phpDoc
						$readings_to_replace = $readings_to_replace + $readings_alleluia;
					}
					
					foreach ( $readings_to_replace as $type => $ref ) {
						foreach ( $rcy->fullYear [$month] [$days] [0] ['readings'] as $type_0 => $ref_0 ) {
							// Remove reading type (gospel or first reading) from current day
							if (intval ( $type ) === intval ( $type_0 )) {
								unset ( $rcy->fullYear [$month] [$days] [0] ['readings'] [$type_0] );
							}
						}
					}
					
					if (! empty ( $readings_to_replace )) {
						$rcy->fullYear [$month] [$days] [0] ['readings'] = $rcy->fullYear [$month] [$days] [0] ['readings'] + $readings_to_replace;
						ksort ( $rcy->fullYear [$month] [$days] [0] ['readings'] ); // to resort the array
						$rcy->fullYear [$month] [$days] [0] ['readings_proper_feast_key'] = $key; // Set the key of envent from where the readings are taken.
					}
				}
			}
		}
		return $rcy;
	}
	
	/**
	 * Sets the variables of Sunday Type (A, B or C) and Ordinary Week (1 or 2) value.
	 * To be used to retrive readings suitable to current year.
	 *
	 * @param int $year
	 */
	private function setSundayCode($year) {
		//
		$this->sundayType = chr ( (($year - 1) % 3) + 65 );
		$this->sundayType_From_Advent = chr ( ($year % 3) + 65 );
		$this->OWType = ($year % 2) === 0 ? 2 : 1;
	}
	
	/**
	 * Returns readings for the given day Code
	 *
	 * @param string $dayCode
	 *        	- Day Code
	 * @param array $calendars
	 *        	- Calendar names from settings.ini
	 * @return array reading list for the given day code.
	 */
	function setSingleReading($dayCode, $calendars = []) {
		$redings_val = [ ];
		
		if ($dayCode === 'Nativity of the Lord') {
			$redings_val = $this->setChristmasDayReadings ();
		}
		
		$append_to_dayID = '';
		$temp_SundayType = $this->sundayType;
		
		if (preg_match ( '/^OW\d{2}\-[1-6][a-zA-Z]{3}/', $dayCode ) === 1) { // If weekday in ordinary season
			$append_to_dayID = $this->OWType;
		} elseif (preg_match ( '/^AW\d{2}/', $dayCode ) === 1 || preg_match ( '/CW01\-HolyFamily/', $dayCode ) === 1) { // If advent sunday or holy family sunday
			$temp_SundayType = $append_to_dayID = $this->sundayType_From_Advent;
		}
		
		$ReadingList = $this->database->select ( 'readings__list', '*', [ 
				'OR' => [ 
						'dayID' => $dayCode,
						'dayID#1' => $dayCode . ' ' . $append_to_dayID,
						'dayID#2' => $dayCode . ' ' . $temp_SundayType 
				] 
		
		] );
		
		foreach ( $ReadingList as $val ) {
			$redings_val [$val ['type']] = $val ['ref'];
		}
		
		if (empty ( $redings_val )) {
			die ( 'FATAL ERROR: NO READINGS SET FOR ' . $dayCode );
		}
		
		$return_val = [ ];
		
		// Check for vigil masses
		$vigilMass = $this->getVigilMass ( $dayCode );
		
		if (! empty ( $vigilMass )) {
			$return_val ['Day'] = $redings_val;
			$return_val ['Vigil'] = $vigilMass;
		} else {
			$return_val = $redings_val;
		}
		
		return $return_val;
	}
	
	/**
	 * Returns readings for Vigil Masses if any
	 *
	 * @return array of readings
	 */
	function getVigilMass($dayCode) {
		$ReadingList = $this->database->select ( 'readings__list', '*', [ 
				'dayID' => $dayCode . ' - Vigil' 
		] );
		
		$ReadingList_ = [ ];
		foreach ( $ReadingList as $val ) {
			$ReadingList_ [$val ['type']] = $val ['ref'];
		}
		return $ReadingList_;
	}
	
	/**
	 * Returns readings for Chrism Mass
	 *
	 * @return array of readings
	 */
	function getChrismMass() {
		$return_val = [ 
				'code' => 'LW06-4Thu~Chrism',
				'rank' => 1.2, // Shouls be less than 1.1
				'color' => 'white',
				'ta_name' => 'திருத்தைலத் திருப்பலி' 
		];
		
		$ReadingList = $this->database->select ( 'readings__list', '*', [ 
				'dayID[~]' => 'LW06-4Thu~Chrism' 
		] );
		
		$ReadingList_ = [ ];
		foreach ( $ReadingList as $val ) {
			$ReadingList_ [$val ['type']] = $val ['ref'];
		}
		$return_val ['readings'] = $ReadingList_;
		return $return_val;
	}
	
	/**
	 * Returns readings for Christmas Day
	 *
	 * @return array of readings
	 */
	function setChristmasDayReadings() {
		$return_val = [ ];
		$ReadingList = $this->database->select ( 'readings__list', '*', [ 
				'dayID[~]' => 'Nativity of the Lord ' 
		] );
		
		foreach ( $ReadingList as $val ) {
			$return_val [$val ['dayID']] [$val ['type']] = $val ['ref'];
		}
		return $return_val;
	}
}