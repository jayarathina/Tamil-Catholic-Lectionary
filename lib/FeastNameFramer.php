<?php

/**
 * RomanLectionary 1.0
 * @author Br. Jayarathina Madharasan SDR
 * Formats the day code to name for the day
 */
include_once 'lib/TamilLectionaryUtil.php';
class FeastNameFramer {

	private $database;

	function __construct($database) {
		$this->database = $database;
	}

	/**
	 * Converts day codes to proper names.
	 * This has to be language specific. Here an english language example is given.
	 * For feast names, one has to derive it from the database. For weekday codes names can be set here.
	 */
	function setDayNames(RomanCalendarYear $rcy) {
		foreach ( $rcy->fullYear as $monthVal => $dateList ) {
			foreach ( $dateList as $datVal => $dayFeastList ) {
				
				foreach ( $dayFeastList as $feastIndex => $singleFeast ) {
					if (preg_match ( "/^[C|L|E|O|A]W\d{2}-/", $singleFeast ['code'] ) === 1) {
						$rcy->fullYear [$monthVal] [$datVal] [$feastIndex] ['name'] = $this->getSingleTitle ( $singleFeast ['code'], $rcy->calcConfig ['feastSettings'] ['EPIPHANY_ON_A_SUNDAY'] );
					} else {
						$nameSet = false;
						// Get from database if different language
						foreach ( $rcy->calcConfig ['calendars'] as $calName ) {
							
							$res = $this->database->get ( 'general' . $calName, 'feast_ta', array (
									'feast_code' => $singleFeast ['code'] 
							) );
							
							if (! empty ( $res )) {
								$rcy->fullYear [$monthVal] [$datVal] [$feastIndex] ['name'] = $res;
								if (! empty ( $rcy->calcConfig ['calendarSuffix'] [$calName] ))
									$rcy->fullYear [$monthVal] [$datVal] [$feastIndex] ['calendar'] = $calName;
								$nameSet = true;
								break;
							}
						}
						
						if (! $nameSet) // should never happen
							die ( 'ERROR: Name for code: ' . $singleFeast ['code'] . 'not in database' );
					}
				}
			}
		}
		return $rcy;
	}

	function getSingleTitle($dayCode, $isEpiphanySunday) {
		$TLUtil = new TamilLectionaryUtil ();
		
		$RomanCalendarDayException = array (
				'CW02-0Sun' => 'கிறிஸ்து பிறப்பு விழாவுக்குப் பின் 2ம் ஞாயிறு',
				'CW03-Epiphany' => 'ஆண்டவரின் திருக்காட்சி',
				'CW04-Baptism' => 'ஆண்டவரின் திருமுழுக்கு',
				'CW01-HolyFamily' => 'இயேசு, மரியா, யோசேப்பின் திருக்குடும்பம்',
				
				'LW00-3Wed' => 'திருநீற்றுப் புதன்',
				'LW06-0Sun' => 'ஆண்டவருடைய திருப்பாடுகளின் குருத்து ஞாயிறு',
				'LW06-4Thu' => 'ஆண்டவரின் இராவுணவுத் திருப்பலி',
				'LW06-5Fri' => 'திருப்பாடுகளின் வெள்ளி',
				'LW06-6Sat' => 'பாஸ்கா  திருவிழிப்பு',
				
				'EW01-0Sun' => 'ஆண்டவருடைய உயிர்ப்பின் பாஸ்கா ஞாயிறு',
				'EW07-Ascension' => 'ஆண்டவரின் விண்ணேற்றம்',
				'EW08-Pentecost' => 'தூய ஆவி ஞாயிறு',
				
				'OW00-Trinity' => 'மூவொரு கடவுள்',
				'OW00-CorpusChristi' => 'கிறிஸ்துவின் திருவுடல், திருஇரத்தம்',
				'OW00-SacredHeart' => 'இயேசுவின் திருஇதயம்',
				'OW00-ImmaculateHeart' => 'தூய கன்னி மரியாவின் மாசற்ற இதயம்',
				'OW00-MaryMotherofChurch' => 'தூய கன்னி மரியா திரு அவையின் அன்னை',
				
				'OW34-0Sun' => 'இயேசு கிறிஸ்து அனைத்துலக அரசர்' 
		);
		
		if (isset ( $RomanCalendarDayException [$dayCode] ))
			return $RomanCalendarDayException [$dayCode];
		
		$fTitle = 'ERROR';
		
		$wkNo = intval ( substr ( $dayCode, 2, 2 ) );
		$wkDay = substr ( $dayCode, - 4, 1 );
		
		switch (substr ( $dayCode, 0, 2 )) {
			case 'AW' :
				if ($wkNo == 5)
					$fTitle = 'திருவருகைக் கால வார நாள்கள் - டிசம்பர் ' . substr ( $dayCode, - 2 );
				else
					$fTitle = 'திருவருகைக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . $TLUtil->tamilDayFull [$wkDay];
				break;
			case 'CW' :
				switch ($wkNo) {
					case 1 : // Christmas Octave
						$fTitle = ' கிறிஸ்து பிறப்பின் எண்கிழமையில் ' . intval ( substr ( $dayCode, - 2 ) - 24 ) . 'ஆம் நாள் - டிசம்பர் ' . substr ( $dayCode, - 2 );
						break;
					case 2 : // Before Epiphany
						$fTitle = 'சனவரி ' . substr ( $dayCode, - 1 );
						break;
					case 3 : // After Epiphany
						if ($isEpiphanySunday) {
							$fTitle = 'திருக்காட்சி விழாவுக்குப் பின் ' . $TLUtil->tamilDayFull [substr ( $dayCode, - 1 )];
						} else {
							$fTitle = 'சனவரி ' . (6 + substr ( $dayCode, - 1 ));
						}
						break;
				}
				break;
			case 'LW' :
				switch ($wkNo) {
					case 0 :
						$fTitle = 'திருநீற்றுப் புதனுக்குப் பின் வரும் ' . $TLUtil->tamilDayFull [$wkDay];
						break;
					case 6 :
						$fTitle = 'புனித வாரம் - ' . $TLUtil->tamilDayFull [$wkDay];
						break;
					default :
						$fTitle = 'தவக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . $TLUtil->tamilDayFull [$wkDay];
						break;
				}
				break;
			case 'EW' :
				if ($wkNo == 1)
					$fTitle = 'பாஸ்கா எண்கிழமை - ' . $TLUtil->tamilDayFull [$wkDay];
				else
					$fTitle = 'பாஸ்கா ' . $wkNo . 'ஆம் வாரம் - ' . $TLUtil->tamilDayFull [$wkDay];
				break;
			case 'OW' :
				$fTitle = 'பொதுக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . $TLUtil->tamilDayFull [$wkDay];
				break;
		}
		
		$fTitle = str_replace ( '1ஆம்', 'முதல்', $fTitle );
		
		return $fTitle;
	}
}