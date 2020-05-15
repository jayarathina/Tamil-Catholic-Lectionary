<?php

/**
 * Displayes a day with all the readings properly formatted.
 *
 * @author Br. Jayarathina Madharasan SDR
 *
 */
use Medoo\Medoo;
require_once 'lib/Medoo.php';
require_once 'lib/dbConfig.php';

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
	 * @param number $evtID
	 *        	- ID of the event you want readings of.
	 *        	ID is 0 for the default readings.
	 *        	Other memories and optional memories are numbered consecutively.
	 * @return string - HTML formated day's readings (of specified $evtID)
	 */
	function getDay($date, $month, $evtID = 0) {
		// For safety, if improper numbers are passsed on
		if (! isset ( $this->fullYear [$month] [$date] ))
			return '';
		
		// For ferial days where redings are replaced, a note is displayed saying so.
		$notice = $this->getReadingsReplacedNotice ( $this->fullYear [$month] [$date], $evtID );
		return $this->getSingleEvent ( $this->fullYear [$month] [$date] [$evtID], TamilLectionaryUtil::isItInLent ( $this->currYear, $month, $date ), $notice );
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
	function getSingleEvent($currtDay, $isLent, $notice = '') {
		switch ($currtDay ['code']) {
			case 'LW06-6Sat' : // Easter Vigil has special formating
				return $this->getEasterVigil ( $currtDay );
				break;
		}
		print_r ( $currtDay );
		
		// FIXME Vigil masses have to be printed properly
		if (isset ( $currtDay ['readings'] ['Day'] ))
			$currtDay ['readings'] = $currtDay ['readings'] ['Day'];
		
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
		
		for($i = 0; $i < 10; $i ++) {
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
					print_r ( $readings );
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
		$DayTitle = "<h4 class='dayTitle clr{$currtDay['color']}'>{$currtDay['ta_name']}</h4>";
		$DayType = isset ( $currtDay ['type'] ) ? "<div class='daySubTitle clrDay'>" . TamilLectionaryUtil::$tamilFeastType [$currtDay ['type']] . "</div>" : '';
		
		$allReadings = $DayTitle . $DayType . $this->formatNotice ( $notice ) . $allReadings;
		// Replace Colour Value
		$allReadings = str_replace ( 'clrDay', 'clr' . $currtDay ['color'], $allReadings );
		
		return $allReadings;
	}
	
	/**
	 * This function prints out readings for Easter Vigil.
	 *
	 * @param array $currtDay
	 *        	readings list
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
			
			// This modification of array key is done to use getResponsorialTxt so that அல்லது can be avoided
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
			$rdCnt .= '<p>' . str_replace ( '✠', "<span class='clrDay'>✠</span>", $refExpanded ) . '</p>';
			$rdCnt .= "<p class='readingTxt'>" . str_replace ( '§', '</p><p class="readingTxt">', $readingTxt ['Content'] ) . "</p>";
			$rdCnt .= "<p class='readingTxt'>ஆண்டவரின் அருள்வாக்கு.</p>";
			
			// find out if alternative readings are available, and make them so
			if (isset ( $readngType [3] ) && intval ( $readngType [3] ) == 1) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது குறுகிய வாசகம்</h4>" . $rdCnt;
			} elseif (isset ( $readngType [2] ) && intval ( $readngType [2] ) > 1) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
			}
			
			$rt .= $rdCnt;
		}
		return $rt;
	}
	
	/**
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
			foreach ( $rdCnt_temp as &$value ) {
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
			if (TamilLectionaryUtil::expandBibleRef ( $value ) !== false) {
				$rdCnt .= '<span>' . TamilLectionaryUtil::formatVerseToPrint ( $value ) . '</span>';
			}
			
			if ($isLent) {
				$rdCnt .= "<p class='alleluiaTxt'>{$readingTxt['Content']}</p>";
			} else {
				$rdCnt .= "<p class='alleluiaTxt'>அல்லேலூயா, அல்லேலூயா! {$readingTxt ['Content']} அல்லேலூயா.</p>";
			}
			
			// Find alternatives available and mark them so
			if (isset ( $readngType [2] ) && intval ( $readngType [2] ) !== 0) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
			}
			$rt .= $rdCnt;
		}
		return $rt;
	}
	function getSequenceTxt($readings) {
		$rt = '';
		$readingTxt = $this->database->get ( 'readings__text', '*', [ 
				'refKey' => $readings [4] 
		] );
		
		if (! empty ( $readingTxt ['introRes'] ))
			$rt .= "<div class='clrDay notice'>{$readingTxt['introRes']}</div>";
		
		// Gen fix for sequence text
		$rdCnt = str_replace ( '<ol>', "<ol class='sequenceTxt'>", $readingTxt ['Content'] );
		if (strpos ( $rdCnt, '<ol>' ) === false) {
			$rdCnt = str_replace ( '§§', "</p><p class='sequenceTxt'>", $rdCnt );
			$rdCnt = "<p class='sequenceTxt'>$rdCnt</p>";
		}
		$rdCnt = str_replace ( '§', '<br/>', $rdCnt );
		
		$rt .= $rdCnt;
		return $rt;
	}
	function getCommonsNotice($cmnsTxt) {
		$rt_arr = [ ];
		
		$commonsList = [ 
				'_Church' => 'கோவில் நேர்ந்தளிப்பு அண்டு நாள்',
				'_Mary' => 'தூய கன்னி மரியா',
				'_Martyr' => 'மறைச்சாட்சியர்',
				'_Pastor' => 'மறைப்பணியாளர்',
				'_Doctor' => 'மறைவல்லுநர்',
				'_Virgin' => 'கன்னியர்',
				'_Saint' => 'புனிதர், புனிதையர்',
				'_VM-HolyName' => 'இயேசுவின் திருப்பெயர் - நேர்ச்சித் திருப்பலி (வாசக நூல் IV)' 
		];
		
		$commonsSunList = [ 
				'1' => 'அறச்செயலில் ஈடுபட்டோர்',
				'2' => 'கல்விப் பணியாற்றியோர்',
				'3' => 'கைம்பெண்கள்',
				'4' => 'திருத்தந்தை',
				'5' => 'துறவியர்',
				'6' => 'மறைபரப்புப் பணியாளர்' 
		];
		
		$commns = explode ( ' or ', $cmnsTxt );
		foreach ( $commns as $comnsRef ) {
			$rt1 = '';
			
			if (strpos ( $comnsRef, '~' ) !== false) {
				$rt1 = substr ( $comnsRef, 0, strpos ( $comnsRef, '~' ) );
				$rt2 = substr ( $comnsRef, strpos ( $comnsRef, '~' ) + 1 );
				$rt1 = $commonsList [$rt1] . " ($commonsSunList[$rt2])";
			} else {
				$rt1 = $commonsList [$comnsRef];
			}
			// TODO Add votive mass readings in DB
			if ($comnsRef !== '_VM-HolyName') {
				$comnsRef = "<a href='commons.php?t=$comnsRef'>$rt1 பொது</a>";
			} else {
				$comnsRef = $rt1;
			}
			
			array_push ( $rt_arr, $comnsRef );
		}
		return implode ( ' அல்லது ', $rt_arr );
	}
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
			$firstKey = array_key_first ( $currentDay [$evtID] ['readings'] );
			if (preg_match ( "/^\d\.\d\d9/", $firstKey ) == 1) {
				$notice = "இன்றைய வாசகங்கள் <a href='{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&k=$replacedFrom'>{$currentDay[$replacedFrom]['ta_name']}</a> நினைவுக்கு உரியது.";
			}
			
			// other memories which have proper readings (first reading or gospel to be used today
			$replacedReadings = array_filter ( $currentDay [$evtID] ['readings'], function ($readingsType) {
				return preg_match ( "/^\d\.\d\d1/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (! empty ( $replacedReadings )) {
				$firstKey = intval ( array_key_first ( $replacedReadings ) );
				$notice .= "{$this->readingType[intval($firstKey)]} <a href='{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}&k=$replacedFrom'>{$currentDay[$replacedFrom]['ta_name']}</a> நினைவுக்கு உரியது.";
			}
		} else {
			// This is to display a not in memory from where we take the ferial day's replacement
			$readings_proper = array_filter ( $currentDay [$evtID] ['readings'], function ($readingsType) {
				return preg_match ( "/^\d\.\d\d1/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (! empty ( $readings_proper )) {
				$firstKey = array_key_first ( $readings_proper );
				$notice = 'இன்றைய ' . $this->readingType [intval ( $firstKey )] . ' இந்த நினைவுக்கு உரியது.';
			}
		}
		return $notice;
	}
}

?>