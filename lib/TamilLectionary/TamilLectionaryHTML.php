<?php

/**
 * Displayes a day with all the readings properly formatted.
 *
 * @author Br. Jayarathina Madharasan SDR
 *
 */
use Medoo\Medoo;

include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
class TamilLectionaryHTML {
	public $fullYear;
	public $currYear;
	private $readingType = [ 
			'0' => 'குருத்தோலைப் பவனி நற்செய்தி வாசகம்',
			'1' => 'முதல் வாசகம்',
			'2' => 'பதிலுரைப் பாடல்',
			'3' => 'இரண்டாம் வாசகம்',
			'4' => 'தொடர்பாடல்',
			'5' => 'நற்செய்திக்கு முன் வாழ்த்தொலி',
			'51' => 'நற்செய்திக்கு முன் வசனம்',
			'6' => 'நற்செய்தி வாசகம்',
			'7' => '',
			'8' => '',
			'9' => '' 
	];
	private $database;
	private $replaceFrom_code = '';
	function __construct($fullYear, $currYear) {
		$this->fullYear = $fullYear;
		$this->currYear = $currYear;
		$this->database = new Medoo ( [ 
				'database_type' => 'mysql',
				'database_name' => DB_NAME,
				'server' => 'localhost',
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'charset' => 'utf8' 
		] );
	}
	/**
	 * Get the readings for the current day.
	 *
	 * @param string $date
	 *        	- Date of the day
	 * @param string $month
	 *        	- Month of the Day
	 * @param int $evtID
	 *        	- ID of the event you want readings of.
	 *        	ID is 0 for the default readings.
	 *        	Other memories and optional memories are numbered consecutively.
	 * @param int $altReadings
	 *        	- other alternatives of the same feast. (Eg., Vigil masses, Day masses, Evening masses etc.,)
	 * @return string - HTML formated day's readings (of specified $evtID)
	 */
	function getDay($date, $month, $evtID = 0, $altReadings = 0) {
		// For safety, if improper numbers are passsed on
		if (! isset ( $this->fullYear [$month] [$date] [$evtID] )) {
			return '';
		}
		$rt = '';
		$notice = '';
		$currtDay = $this->fullYear [$month] [$date] [$evtID];
		
		switch ($currtDay ['code']) {
			case 'LW06-6Sat' : // Easter Vigil has special formating
				return $this->getEasterVigil ( $currtDay );
				break;
			case 'Nativity of the Lord' : // Easter Vigil has special formating
				return $this->getChristmas ( $currtDay, $altReadings + 1 );
				break;
		}
		
		// For ferial days where redings are replaced, a note is displayed saying so.
		$notice .= $this->getReadingsReplacedNotice ( $this->fullYear [$month] [$date], $evtID );
		
		// alternative readings - Vigil?
		if (isset ( $currtDay ['readings'] ['Day'] )) {
			if ($altReadings == 0) {
				$currtDay ['readings'] = $currtDay ['readings'] ['Day'];
				$currtDay ['ta_name'] = $currtDay ['ta_name'] . ' <br/><small>பெருவிழாத் திருப்பலி</small>';
				$rt .= "<br/> <a class='altMass' href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'l', 1 ) . "'>திருவிழிப்புத் திருப்பலி</a>";
			} else {
				$currtDay ['readings'] = $currtDay ['readings'] ['Vigil'];
				$currtDay ['ta_name'] = $currtDay ['ta_name'] . ' <br/><small>திருவிழிப்புத் திருப்பலி</small>';
				$rt .= "<br/> <a class='altMass' href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'l', 0 ) . "'>பெருவிழாத் திருப்பலி</a>";
			}
		}
		$rt .= $this->getSingleEvent ( $currtDay, TamilLectionaryUtil::isItInLent ( $this->currYear, $month, $date ), $notice );
		
		return $rt;
	}
	
	/**
	 * Get HTML formated day's readings for a single day
	 *
	 * @param array $currtDay
	 *        	- current day settings
	 * @param boolean $isLent
	 *        	- whether this days falls withing lent. (For displaying Alleluia)
	 * @param string $notice
	 *        	- Any notice to display (probably from getReadingsReplacedNotice())
	 * @return string - HTML formated day's readings
	 */
	function getSingleEvent($currtDay, $isLent = false, $notice = '') {
		/*
		 * There is a doubt whether Alleluia is sung during lent on Solemnities
		 * Some websites mention that we do not sing,
		 * Currently we follow Tamil Lectionary, so we sing it on solemnities.
		 */
		if (isset ( $currtDay ['type'] ) && $currtDay ['type'] == 'Solemnity')
			$isLent = false;
		
		/**
		 * Notes to be displayed
		 */
		$notices = $this->database->select ( 'readings__notes', '*', [ 
				'dayID' => $currtDay ['code'] 
		] );
		
		$notices_collection = [ ];
		
		foreach ( $notices as $key => $value ) {
			$notices_collection [$value ['notesPos']] = $value ['Content'];
		}
		
		// By default 0 notification will be displayed at the begining
		if (isset ( $notices_collection [0] ) && ! isset ( $currtDay ['readings'] [0] /*Palm Sunday*/ ))
			$notice .= $notices_collection [0];
		
		/**
		 * Readiings
		 */
		$allReadings = '';
		
		for($i = 0; $i <= 9; $i ++) {
			// Filter readings of a single type
			$readings = array_filter ( $currtDay ['readings'], function ($readingsType) use ($i) {
				return preg_match ( "/^$i\.*/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (empty ( $readings ))
				continue;
			$currReadings = '';
			
			switch ($i) {
				case 0 : // Palm Sunday Procession Reading
				case 1 : // First Reading
				case 3 : // Second Reading
				case 6 : // Gospel Reading
					$currReadings .= $this->getReadingsTxt ( $readings, $currtDay ['code'] );
					// For Palm Sunday and Good Friday style for Gospel is different
					if ($i == 6 && ($currtDay ['code'] == 'LW06-0Sun' || $currtDay ['code'] == 'LW06-5Fri')) {
						$currReadings = str_replace ( "<span class='clrDay'>✠</span>", '', $currReadings );
						$currReadings = str_replace ( 'எழுதிய நற்செய்தியிலிருந்து வாசகம்', 'எழுதியபடி நம் ஆண்டவராகிய இயேசு கிறிஸ்துவின் திருப்பாடுகள் ', $currReadings );
						$currReadings = str_replace ( 'ஆண்டவரின் அருள்வாக்கு.', '', $currReadings );
					}
					break;
				case 2 : // Responsorial
					$currReadings .= $this->getResponsorialTxt ( $readings, $currtDay ['code'] );
					break;
				case 4 : // Sequence
					$currReadings .= $this->getSequenceTxt ( $readings );
					break;
				case 5 : // Alleluia
					$currReadings .= $this->getAlleluiaTxt ( $readings, $currtDay ['code'], $isLent );
					break;
				case 9 : // Notice
					$notice .= $this->getCommonsNotice ( $readings [9] );
					break;
				default :
					// print_r ( $readings );
					break;
			}
			// If notice ID is negative, it is to be displayed before else after
			$noticeBefore = isset ( $notices_collection [$i * - 1] ) ? $this->formatNotice ( $notices_collection [$i * - 1] ) : '';
			$noticeAfter = isset ( $notices_collection [$i] ) ? $this->formatNotice ( $notices_collection [$i] ) : '';
			
			if (! empty ( $currReadings )) {
				// For Alleluia title will change during lent
				$SecTitle = ($i == 5) ? $this->readingType [$i . $isLent] : $this->readingType [$i];
				
				// Add Heading for readings
				$currReadings = "<p class='clrDay readingsTitle'>$SecTitle</p>$currReadings";
				$allReadings .= "<div class='readings' data-readingName='$SecTitle' id='read$i'>$noticeBefore $currReadings</div>" . $noticeAfter;
			}
		}
		
		// Add Day Title
		$DayTitle = $currtDay ['ta_name'];
		$DayTitle = "<h4 class='dayTitle clrDay'>$DayTitle</h4>";
		
		$DayType = TamilLectionaryUtil::$tamilFeastType [$currtDay ['type']];
		// TODO Add option to add other local calendars
		if (strpos ( $currtDay ['code'], 'IN ' ) === 0) {
			$DayType = "இந்தியாவில் $DayType";
		}
		
		$DayType = isset ( $currtDay ['type'] ) ? "<div class='daySubTitle clrDay'>$DayType</div>" : '';
		
		$allReadings = $DayTitle . $DayType . $this->formatNotice ( $notice ) . $allReadings;
		
		// Replace Colour Value
		$allReadings = str_replace ( 'clrDay', 'clr' . $currtDay ['color'], $allReadings );
		
		return $allReadings;
	}
	
	/**
	 * Returns HTML formated texts for First, Ssecond and Gospel readings
	 *
	 * @param array $readings
	 *        	- Readings list
	 * @param string $usedBy
	 *        	- Which event is using the current text. This should be removed in the future.
	 * @return string - HTML formated readings
	 */
	function getReadingsTxt($readings, $usedBy = null) {
		$rt = '';
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => [ 
							$usedBy,
							$this->replaceFrom_code 
					] 
			] );
			$rdCnt = '';
			$refExpanded = TamilLectionaryUtil::expandBibleRef ( $value );
			
			$rdCnt .= "<p class='readingIntro'>{$readingTxt['introRes']}</p>";
			$rdCnt .= '<p>' . str_replace ( '✠', "<span class='clrDay'>✠</span>", $refExpanded ) . '</p>'; // Gosepl
			$rdCnt .= "<p class='readingTxt'>" . str_replace ( '§', '</p><p class="readingTxt">', $readingTxt ['Content'] ) . "</p>";
			$rdCnt .= "<p class='readingTxt'>ஆண்டவரின் அருள்வாக்கு.</p>";
			
			// find out if alternative readings are available, and make them so
			if (isset ( $readngType [3] ) && intval ( $readngType [3] ) == 1) // Short alternative
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது குறுகிய வாசகம்</h4>" . $rdCnt;
			elseif (isset ( $readngType [2] ) && intval ( $readngType [2] ) > 1) // Different alternative
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
			
			$rt .= $rdCnt;
		}
		return $rt;
	}
	
	/**
	 * Returns HTML formated texts for Responsorial
	 *
	 * @param array $readings
	 *        	- Readings list
	 * @param string $usedBy
	 *        	- Which event is using the current text. This should be removed in the future.
	 * @return string - Returns HTML formated texts for Responsorial Psalm
	 */
	function getResponsorialTxt($readings, $usedBy = null) {
		$rt = '';
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => [ 
							$usedBy,
							$this->replaceFrom_code 
					] 
			] );
			
			// Give spaing to verses
			$refTxt = TamilLectionaryUtil::formatVerseToPrint ( $value );
			
			// If alternative response is set (அல்லது:...), then extract it.
			$altResponse = '';
			preg_match ( '/(.*)\( *அல்லது *:?(.*?)\)/', $readingTxt ['introRes'], $matches );
			if (! empty ( $matches )) {
				$readingTxt ['introRes'] = $matches [1];
				$altResponse = "<br/><span class='clrDay'>அல்லது :</span>" . $matches [2];
			}
			
			// Seperate the response verse ref from responce text.
			$responseTxt = $readingTxt ['introRes'];
			$responseRef = '';
			preg_match ( '/(.*)§(.*)/', $readingTxt ['introRes'], $matches );
			if (! empty ( $matches )) {
				$responseTxt = $matches [1];
				$responseRef = " (பல்லவி: $matches[2])";
			}
			
			$rdCnt = '';
			$rdCnt .= "<span class='clrDay italics'>$refTxt . $responseRef </span>";
			$rdCnt .= "<p><span class='clrDay italics' >பல்லவி:</span> $responseTxt $altResponse</p>";
			
			// Format individual Verses
			$rdCnt_temp = str_replace ( '℟', " - <span class='clrDay'>பல்லவி</span><br/><br/>§", $readingTxt ['Content'] );
			$rdCnt_temp = explode ( '§', $rdCnt_temp );
			$rdCnt_temp = array_filter ( $rdCnt_temp ); // remove empty values
			foreach ( $rdCnt_temp as &$value ) { // seperate the first numeric into a different div from the rest of the verse
				$value = trim ( $value );
				$t = explode ( ' ', $value, 2 );
				$value = '<div>' . $t [0] . '</div><div>' . $t [1] . '</div>';
			}
			$rdCnt_temp = implode ( '', $rdCnt_temp );
			
			// Enclose the formated veses into psalmText class
			$rdCnt .= '<div class="psalmText">' . $rdCnt_temp . '</div>';
			
			// find out if this is an alternative, and make them so
			if (isset ( $readngType [2] ) && intval ( $readngType [2] ) > 1) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
			}
			
			$rt .= $rdCnt;
		}
		return $rt;
	}
	/**
	 *
	 * Returns HTML formated texts for Alleluia
	 *
	 * @param array $readings
	 *        	- Readings list
	 * @param string $usedBy
	 *        	- Which event is using the current text. This should be removed in the future.
	 * @param boolean $isLent
	 *        	- Specifies whether Alleluia can be sung on this day
	 * @return string - Returns HTML formated texts for Alleluia Psalm
	 */
	function getAlleluiaTxt($readings, $usedBy = null, $isLent = false) {
		$rt = '';
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => [ 
							$usedBy,
							$this->replaceFrom_code 
					] 
			] );
			
			$rdCnt = '';
			// We use TamilLectionaryUtil::expandBibleRef to test whether given reference is from bible or from tradition.
			if (TamilLectionaryUtil::expandBibleRef ( $value ) !== false)
				$rdCnt = '<span>' . TamilLectionaryUtil::formatVerseToPrint ( $value ) . '</span>';
			
			// If it si not lent, add Alleluia
			if (! $isLent)
				$readingTxt ['Content'] = "அல்லேலூயா, அல்லேலூயா! {$readingTxt ['Content']} அல்லேலூயா.";
			
			$rdCnt .= "<p class='alleluiaTxt'>{$readingTxt['Content']}</p>";
			
			// Find alternatives available and mark them so
			if (isset ( $readngType [2] ) && intval ( $readngType [2] ) !== 1) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது </h4>" . $rdCnt;
			}
			$rt .= $rdCnt;
		}
		return $rt;
	}
	
	/**
	 *
	 * Returns HTML formated texts for Sequences.
	 * The text of sequences are formatted as they appear in the Tamil Lectionary.
	 *
	 * @param array $readings
	 *        	- Readings list
	 * @return string - Returns HTML formated texts for Sequences
	 */
	function getSequenceTxt($readings) {
		$rt = '';
		$readingTxt = $this->database->get ( 'readings__text', '*', [ 
				'refKey' => $readings [4] 
		] );
		
		// introRes field for sequences contains any notices to be displayed before sequence text
		if (! empty ( $readingTxt ['introRes'] ))
			$rt .= "<div class='clrDay notice'>{$readingTxt['introRes']}</div>";
		
		// General fix for sequence text
		$rdCnt = str_replace ( '<ol>', "<ol class='sequenceTxt'>", $readingTxt ['Content'] );
		if (strpos ( $rdCnt, '<ol>' ) === false) {
			$rdCnt = str_replace ( '§§', "</p><p class='sequenceTxt'>", $rdCnt );
			$rdCnt = "<p class='sequenceTxt'>$rdCnt</p>";
		}
		$rdCnt = str_replace ( '§', '<br/>', $rdCnt );
		
		$rt .= $rdCnt;
		return $rt;
	}
	
	/**
	 * adds HTML tags to notice text, if it is not empty.
	 *
	 * @param string $notice
	 *        	- text to be displayed
	 * @return string - HTML formatted input text
	 */
	function formatNotice($notice) {
		return ! empty ( $notice ) ? "<div class='clrDay italics notice'>$notice</div>" : "";
	}
	
	/**
	 * For ferial days where redings are replaced, this function returns a note to be displayed with that information.
	 *
	 * @param array $currentDay
	 *        	- Current day readings (all events including alternatives)
	 * @param array $evtID
	 *        	- Current event for which note is to be displayed, if any.
	 * @return string - note to be displayed. (No formating)
	 */
	function getReadingsReplacedNotice($currentDay, $evtID) {
		$notice = '';
		// If reading replaced key is set in ferial day.
		if (isset ( $currentDay [$evtID] ['readings_proper_feast_key'] )) {
			$replacedFrom = $currentDay [$evtID] ['readings_proper_feast_key'];
			
			// FIXME This will be later on needed for retriving reading using `usedby` field. But such dependency ideally should not exist
			$this->replaceFrom_code = $currentDay [$replacedFrom] ['code'];
			
			// Special case for Dedication of the basilicas of Saints Peter and Paul (Nov 11) where all readings will be replaced.
			$firstKey = TamilLectionaryUtil::array_key_first ( $currentDay [$evtID] ['readings'] );
			if (preg_match ( "/^\d\.\d\d9/", $firstKey ) == 1) {
				$notice = "இன்றைய வாசகங்கள் <a href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'k', $replacedFrom ) . "'>{$currentDay[$replacedFrom]['ta_name']}</a> நினைவுக்கு உரியது.";
			}
			
			// other memories which have proper readings (first reading or gospel to be used today
			$replacedReadings = array_filter ( $currentDay [$evtID] ['readings'], function ($readingsType) {
				return preg_match ( "/^\d\.\d\d1/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (! empty ( $replacedReadings )) {
				$firstKey = intval ( TamilLectionaryUtil::array_key_first ( $replacedReadings ) );
				$notice .= "{$this->readingType[intval($firstKey)]} <a href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'k', $replacedFrom ) . "'>{$currentDay[$replacedFrom]['ta_name']}</a> நினைவுக்கு உரியது.";
			}
		} else {
			// This is to display a not in memory from where we take the ferial day's replacement
			$readings_proper = array_filter ( $currentDay [$evtID] ['readings'], function ($readingsType) {
				return preg_match ( "/^\d\.\d\d1/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (! empty ( $readings_proper )) {
				$firstKey = TamilLectionaryUtil::array_key_first ( $readings_proper );
				$notice = 'இன்றைய ' . $this->readingType [intval ( $firstKey )] . ' இந்த நினைவுக்கு உரியது.';
			}
		}
		return $notice;
	}
	
	/**
	 * This function prints out readings for Easter Vigil.
	 *
	 * @param array $currtDay
	 * @return string - HTML formated readings of Easter Vigil
	 */
	function getEasterVigil($currtDay) {
		// 'LW06-6Sat'
		$readingType = [ 
				'1' => 'முதல் வாசகம்',
				'2' => 'இரண்டாம் வாசகம்',
				'3' => 'மூன்றாம் வாசகம்',
				'4' => 'நான்காம் வாசகம்',
				'5' => 'ஐந்தாம் வாசகம்',
				'6' => 'ஆறாம் வாசகம்',
				'7' => 'ஏழாம் வாசகம்',
				'8' => 'திருமுகம்',
				'9' => 'நற்செய்தி வாசகம்' 
		];
		$ret = '';
		
		/**
		 * Notes to be displayed
		 */
		$notices = $this->database->select ( 'readings__notes', '*', [ 
				'dayID' => $currtDay ['code'] 
		] );
		$ret .= $this->formatNotice ( $notices [0] ['Content'] );
		
		/**
		 * Readings: For easter vigil, all readings are coupled with a psalm
		 * and stored in the database with that relation based on the Type column
		 */
		
		for($i = 1; $i <= 9; $i ++) {
			// Reading
			$readings = array_filter ( $currtDay ['readings'], function ($readingsType) use ($i) {
				return preg_match ( "/^1\.$i/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			foreach ( $readings as $key => $value ) {
				unset ( $readings [$key] );
				$readings [preg_replace ( '/(\d\.)(\d)(.*)/', '${1}1${3}', $key )] = $value;
			}
			$currReadings = $this->getReadingsTxt ( $readings, $currtDay ['code'] );
			
			// Some special cases
			if ($i == 9) // For Gospel
				$currReadings .= $this->getReadingsTxt ( [ 
						6 => $currtDay ['readings'] [6] 
				], $currtDay ['code'] );
			elseif ($i == 3) // After 'crossing of the red sea' reading, no ஆண்டவரின் அருள்வாக்கு
				$currReadings = str_replace ( "<p class='readingTxt'>ஆண்டவரின் அருள்வாக்கு.</p>", '', $currReadings );
			
			$SecTitle = $readingType [$i]; // Add Heading to current reading
			$currReadings = "<p class='clrDay readingsTitle'>$SecTitle</p>$currReadings";
			$ret .= "<div class='readings' data-readingName='$SecTitle' id='readTxt$i'>$currReadings</div>";
			
			if ($i == 9) // No responsorial after Gospel
				break;
			
			// Responsorial
			$responsorial = array_filter ( $currtDay ['readings'], function ($readingsType) use ($i) {
				return preg_match ( "/^2\.$i\.*/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			// This modification of array key is done to use getResponsorialTxt so that அல்லது can be avoided in the return text
			foreach ( $responsorial as $key => $value ) {
				unset ( $responsorial [$key] );
				$k_ = preg_replace ( '/(\d\.)(\d)(.*)/', '${1}1${3}', $key );
				$k_ = preg_replace ( '/2.12/', '2.2', $k_ );
				$responsorial [$k_] = $value;
			}
			$currReadings = $this->getResponsorialTxt ( $responsorial, $currtDay ['code'] );
			
			if ($i == 7) {
				$nt = $this->formatNotice ( $notices [1] ['Content'] );
				$currReadings = str_replace ( "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>", $nt, $currReadings );
			}
			
			$currReadings = "<p class='clrDay readingsTitle'>பதிலுரைப் பாடல்</p>$currReadings";
			$ret .= "<div class='readings' data-readingName='பதிலுரைப் பாடல்' id='readRes$i'>$currReadings</div>";
		}
		
		// Add Day Title
		$title = "<h4 class='dayTitle clrDay'>{$currtDay['ta_name']}</h4>";
		$ret = $title . $ret;
		
		// Set Colour Value
		$ret = str_replace ( 'clrDay', 'clr' . $currtDay ['color'], $ret );
		return $ret;
	}
	/**
	 * This function prints out readings for Christmas
	 *
	 * @param array $currtDay
	 * @param int $altReadings
	 *        	- other alternatives (Eg., Vigil mass, Day mass, Morning masses etc.,)
	 * @return string - HTML formated readings of Easter Vigil
	 */
	function getChristmas($currtDay, $altReadings) {
		$rt = '';
		
		if ($altReadings < 1 || $altReadings > 4)
			$altReadings = 1;
		
		$ChristmasNames = [ 
				1 => 'திருவிழிப்புத் திருப்பலி',
				2 => 'இரவில் திருப்பலி',
				3 => 'விடியற்காலைத் திருப்பலி',
				4 => 'பகலில் திருப்பலி' 
		];
		
		$currtDay ['readings'] = $currtDay ['readings'] ['Nativity of the Lord ' . $altReadings];
		$currtDay ['ta_name'] = $currtDay ['ta_name'] . ' <br/><small>' . $ChristmasNames [$altReadings] . '</small>';
		
		$rt .= "<br/>";
		for($i = 0; $i < 4; $i ++) {
			$rt .= " <a class='altMass' href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'l', $i ) . "'> {$ChristmasNames [$i+1]} </a> |";
		}
		$rt .= $this->getSingleEvent ( $currtDay );
		
		// Changing notice for evening mass
		if ($altReadings == 1) {
			$notices = $this->database->select ( 'readings__notes', '*', [ 
					'dayID[~]' => $currtDay ['code'] . '%' 
			] );
			$rt = str_replace ( $notices [0] ['Content'], $notices [1] ['Content'], $rt );
		}
		
		return $rt;
	}
	
	/**
	 * Frames the commons notice to be displayed for saints whose feast day reading are to be taken from commons
	 *
	 * @param string $cmnsTxt
	 * @return string
	 */
	function getCommonsNotice($cmnsTxt) {
		$rt_arr = [ ];
		
		// If multiple commons option avalibale link to them one by one
		$commns = explode ( ' or ', $cmnsTxt );
		foreach ( $commns as $comnsRef ) {
			$rt1 = '';
			// ~ symbol specifies a specific option within the given commons,
			// eg: அறச்செயலில் ஈடுபட்டோர், கல்விப் பணியாற்றியோர் etc.,
			if (strpos ( $comnsRef, '~' ) !== false) {
				$rt1 = substr ( $comnsRef, 0, strpos ( $comnsRef, '~' ) );
				$rt2 = substr ( $comnsRef, strpos ( $comnsRef, '~' ) + 1 );
				$rt1 = TamilLectionaryUtil::$commonsList [$rt1] . ' (' . TamilLectionaryUtil::$commonsSubList [$rt2] . ')';
			} else {
				$rt1 = TamilLectionaryUtil::$commonsList [$comnsRef];
			}
			// TODO Add votive mass readings in DB
			if ($comnsRef !== '_VM-HolyName') {
				$comnsRef = "<a href='{$_SERVER['PHP_SELF']}?" . TamilLectionaryUtil::formHyperLink ( 'commons', $comnsRef ) . "'>$rt1</a>";
			} else {
				$comnsRef = $rt1;
			}
			array_push ( $rt_arr, $comnsRef );
		}
		
		return implode ( ' அல்லது ', $rt_arr );
	}
	/**
	 * Get and display commons readings list
	 *
	 * @param string $commonsCode
	 * @return string - HTML formated readings
	 */
	function getCommons($commonsCode) {
		// TODO Should display only the subcategory of readings as recieved in $subType
		$commonsCode_ = explode ( '~', $commonsCode . '~', 2 );
		$commonsCode = $commonsCode_ [0];
		$subType = intval ( $commonsCode_ [1] );
		
		$readingType = [ 
				'1' => "<p class='readingsTitle clrDay commonsTitle'>முதல் வாசகங்கள்</p> <p  class='readingsTitle commonsSubTitle'>பழைய ஏற்பாட்டிலிருந்து</p>",
				'2' => "<p class='readingsTitle commonsSubTitle'>பாஸ்கா காலத்தில்</p> <p class='readingsTitle clrDay commonsTitle'>முதல் வாசகங்கள்</p> <p  class='readingsTitle commonsSubTitle'>புதிய ஏற்பாட்டிலிருந்து</p>",
				'3' => "<p class='readingsTitle clrDay commonsTitle'>பதிலுரைப் பாடல்கள்</p>",
				'4' => "<p class='readingsTitle clrDay commonsTitle'>இரண்டாம் வாசகங்கள்</p>",
				'5' => "<p class='readingsTitle clrDay commonsTitle'>நற்செய்திக்கு முன் வாழ்த்தொலிகள்</p>",
				'6' => "<p class='readingsTitle clrDay commonsTitle'>நற்செய்தி வாசகங்கள்</p>" 
		];
		
		$readingList_ = $this->database->select ( 'readings__list', [ 
				'type',
				'ref' 
		], [ 
				'dayID' => $commonsCode 
		] );
		
		// Reorganize the reding list for easy processing (type=>ref)
		$readingList = [ ];
		foreach ( $readingList_ as $value ) {
			$readingList [$value ['type']] = $value ['ref'];
		}
		
		/**
		 * Readiings
		 */
		$allReadings = '';
		
		for($i = 1; $i < 8; $i ++) {
			// Filter readings of a single type
			$readings = array_filter ( $readingList, function ($readingsType) use ($i) {
				return preg_match ( "/^$i\.*/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (empty ( $readings ))
				continue;
			
			$currReadings = '';
			switch ($i) {
				case 1 : // First Reading
				case 2 : // First Reading - Pashca
				case 4 : // Second Reading
				case 6 : // Gospel Reading
					$currReadings_ = '';
					foreach ( $readings as $key => $value ) {
						
						// Find if this reading is of type short alternative
						$ix = substr ( str_pad ( $key, 5, '0' ), 4, 1 );
						
						if ($ix !== "1") { // if not short alternative, then print title and subtype
						                   // Find the count of reading and set it as title
							$cnt = intval ( substr ( str_pad ( $key, 4, '0' ), 2, 2 ) );
							$currReadings_ .= "<p class='clrDay readingsTitle commonsTitle'>$cnt</p>";
							
							// Find out if readings are proper to sub type [அறச்செயலில் ஈடுபட்டோர் திருப்பலியில்...]
							if (isset ( $key [5] )) {
								$currReadings_ .= $this->formatNotice ( TamilLectionaryUtil::$commonsSubList_ [$key [5]] );
							}
						}
						$currReadings_ .= $this->getReadingsTxt ( [ 
								$i . '.1' . $ix => $value 
						], $commonsCode );
					}
					
					$currReadings .= $readingType [$i] . $currReadings_;
					break;
				case 3 : // Responsorial
					
					$currReadings_ = '';
					
					foreach ( $readings as $key => $value ) {
						// Find the count of Alleluia and set it as title
						$cnt = intval ( substr ( str_pad ( $key, 4, '0' ), 2, 2 ) );
						$currReadings_ .= "<p class='clrDay readingsTitle commonsTitle'>$cnt</p>";
						
						$currReadings_ .= $this->getResponsorialTxt ( [ 
								$i => $value 
						], $commonsCode );
					}
					
					$currReadings .= $readingType [$i] . $currReadings_;
					break;
					
					break;
				case 5 : // Alleluia
					$currReadings_ = '';
					
					foreach ( $readings as $key => $value ) {
						// Find the count of Alleluia and set it as title
						$cnt = intval ( substr ( str_pad ( $key, 4, '0' ), 2, 2 ) );
						$currReadings_ .= "<span class='clrDay readingsTitle commonsTitle'>$cnt. </span>";
						
						$currReadings_ .= $this->getAlleluiaTxt ( [ 
								$i => $value 
						], $commonsCode, false );
					}
					
					$currReadings .= $readingType [$i] . $currReadings_;
					break;
			}
			// Wrap in a DIV tag to have uniformity with `getDay()` output
			$allReadings .= "<div class='readings' data-readingName='" . strip_tags ( $readingType [$i] ) . "' id='read$i'>$currReadings</div>";
		}
		// Add Day Title
		$DayTitle = "<h4 class='dayTitle clrDay'>" . TamilLectionaryUtil::$commonsList [$commonsCode] . "</h4>";
		$allReadings = $DayTitle . $allReadings;
		
		// Replace Colour Value
		$allReadings = str_replace ( 'clrDay', 'clrCrimson', $allReadings );
		
		return $allReadings;
	}
}

?>