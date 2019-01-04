<?php
/**
 * Tamil-Catholic-Lectionary 1.0
 * Formats the day code to name for the day
 * @author Br. Jayarathina Madharasan SDR
 */
use Medoo\Medoo;
include_once ('lib/dbConfig.php');
include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
class FeastNameFramer {
	/**
	 * Converts day codes to full names.
	 * Weekday codes names are set here. Feast names are taken from the database.
	 * 
	 */
	public static function getSingleTitle($dayCode, $isEpiphanySunday, $calList) {
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
		
		$fTitle = '';
		
		$wkNo = intval ( substr ( $dayCode, 2, 2 ) );
		$wkDay = substr ( $dayCode, - 4, 1 );
		
		switch (substr ( $dayCode, 0, 2 )) {
			case 'AW' :
				if ($wkNo == 5)
					$fTitle = 'திருவருகைக் கால வார நாள்கள் - டிசம்பர் ' . substr ( $dayCode, - 2 );
				else
					$fTitle = 'திருவருகைக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
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
							$fTitle = 'திருக்காட்சி விழாவுக்குப் பின் ' . TamilLectionaryUtil::$tamilDayFull [substr ( $dayCode, - 1 )];
						} else {
							$fTitle = 'சனவரி ' . (6 + substr ( $dayCode, - 1 ));
						}
						break;
				}
				break;
			case 'LW' :
				switch ($wkNo) {
					case 0 :
						$fTitle = 'திருநீற்றுப் புதனுக்குப் பின் வரும் ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
						break;
					case 6 :
						$fTitle = 'புனித வாரம் - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
						break;
					default :
						$fTitle = 'தவக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
						break;
				}
				break;
			case 'EW' :
				if ($wkNo == 1)
					$fTitle = 'பாஸ்கா எண்கிழமை - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
				else
					$fTitle = 'பாஸ்கா ' . $wkNo . 'ஆம் வாரம் - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
				break;
			case 'OW' :
				$fTitle = 'பொதுக்காலம் ' . $wkNo . 'ஆம் வாரம் - ' . TamilLectionaryUtil::$tamilDayFull [$wkDay];
				break;
		}
		
		$fTitle = str_replace ( ' 1ஆம்', ' முதல்', $fTitle );

		if( empty($fTitle) ){
			$database = new Medoo ( array (
					'database_type' => 'mysql',
					'server' => 'localhost',
					'charset' => 'utf8',
					'username' => DB_USER,
					'password' => DB_PASSWORD,
					'database_name' => DB_NAME
			) );
			foreach ( $calList as $calName ) { // $rcy->calcConfig ['calendars']
				$res = $database->get ( 'general' . $calName, 'feast_ta', array (
						'feast_code' => $dayCode
				) );
				if (! empty ( $res )) {
					$fTitle = $res;
				}
			}
		}
		if (! $fTitle) // should never happen
			die ( 'ERROR: Name for code: ' . $dayCode . 'not in database' );
		return $fTitle;
	}
}