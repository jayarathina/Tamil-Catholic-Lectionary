<?php
/**
 * RomanLectionary 1.0
 * This function get the year and settings and creates a json file to generate a calendar
 * @author Br. Jayarathina Madharasan SDR
 */
require_once 'mods/Medoo.php';
include_once 'lib/includeExternal.php';
include_once 'lib/FeastNameFramer.php';
include_once 'lib/TamilLectionaryUtil.php';
class TamilLectionarySingleDay {

	private $calcConfig, $database, $readingsText, $currentDate;

	function __construct($calcConfig) {
		$this->calcConfig = $calcConfig;
		
		$this->database = new Medoo ( array (
				'database_type' => 'mysql',
				'database_name' => 'liturgy_lectionary',
				'server' => 'localhost',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8' 
		) );
	}

	function printDayReading($dayCode, $cDate) {
		$this->currentDate = $cDate;
		$cYear = substr ( $cDate, - 4 );
		
		$fileName = $this->calcConfig ['feastsListLoc'] . $cYear . '/' . 'year.json';
		
		if (! file_exists ( $fileName )) {
			http_response_code ( 404 );
			die ( 'Invalid URL' );
		}
		
		$txtCnt = file_get_contents ( $fileName );
		$rcy = json_decode ( $txtCnt, true );
		
		$done = false;
		foreach ( $rcy ['fullYear'] as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				foreach ( $feasts as $fet ) {
					if (strcmp ( $fet ['code'], $dayCode ) === 0) {
						return $this->getDayHTML ( $fet );
						break 3;
					}
				}
			}
		}
	}

	function getDayHTML($dayDetails) {
		// print_r ( $dayDetails );
		if (isset ( $dayDetails ['readingList'] )) {
			
			// Break alternative verses
			$readL = array ();
			foreach ( $dayDetails ['readingList'] as $val ) {
				$val1 = explode ( 'அல்லது', $val );
				foreach ( $val1 as $value ) {
					$v = explode('~', $value )[0];
					array_push ( $readL, trim ( $v ) );
				}
			}
			
			$readL = implode ( "','", array_values ( $readL ) );
			$sql = "SELECT `refKey`, `Content` FROM `readings__text` WHERE `refKey` IN ('" . $readL . "')";
			$this->readingsText = $this->database->query ( $sql )->fetchAll ( PDO::FETCH_KEY_PAIR );
			
			/*
			 * Array
			 * (
			 * * [code] => OW16-1Mon
			 * * [rank] => 13.4
			 * * [color] => green
			 * * [name] => பொதுக்காலம் 16ஆம் வாரம் - திங்கள்
			 * * [readingList] => Array
			 * * (
			 * * * [dayID] => OW16-1Mon 1
			 * * * [reading1] => விப14:5-18
			 * * * [psalms] => விப15:1bc-2.3-4.5-6
			 * * * [reading2] =>
			 * * * [alleluia] => திபா95:8
			 * * * [gospel] => மத்12:38-42
			 * * )
			 * *
			 * )
			 */
			
			$dayDat = array ();
			$dayDat ['title-H1'] = $dayDetails ['name'];
			$dayDat ['title-H2'] = '';
			
			if (isset ( $dayDetails ['readingList'] ['dayID'] )) {
				$yearCat = array (
						'1' => 'முதல் ஆண்டு',
						'2' => 'இரண்டாம் ஆண்டு',
						'A' => 'முதல் ஆண்டு',
						'B' => 'இரண்டாம் ஆண்டு',
						'C' => 'மூன்றாம் ஆண்டு' 
				);
				
				if (preg_match ( '/.* ([1|2|A|B|C])$/', $dayDetails ['readingList'] ['dayID'], $matches ) === 1) {
					$dayDat ['title-H2'] = $yearCat [$matches [1]];
				}
				
				$dayDat ['reading1'] = $dayDetails ['readingList'] ['reading1'];
				$dayDat ['psalms'] = $dayDetails ['readingList'] ['psalms'];
				$dayDat ['reading2'] = $dayDetails ['readingList'] ['reading2'];
				$dayDat ['alleluia'] = $dayDetails ['readingList'] ['alleluia'];
				$dayDat ['gospel'] = $dayDetails ['readingList'] ['gospel'];
				
				$dayDat ['color'] = $dayDetails ['color'];
				
				return $this->printHTML ( $dayDat );
			}
		} else {
			// displayCommons()
			print_r ( $dayDetails );
		}
	}

	function printHTML($dayDat) {
		$rt = "<h1 class='clrDef'>{$dayDat['title-H1']}</h1>";
		
		if (isset ( $dayDat ['title-H2'] ))
			$rt .= "<h2 class='clrDef'>{$dayDat['title-H2']}</h2>";
		
		$listArrBefore = array (
				'reading1' => 'முதல் வாசகம்',
				'psalms' => 'பதிலுரைப் பாடல்',
				'reading2' => 'இரண்டாம் வாசகம்',
				'alleluia' => 'நற்செய்திக்கு முன் வசனம்',
				'gospel' => 'நற்செய்தி வாசகம்' 
		);
		
		// முதல் வாசகம்
		$rt .= $this->formatReading ( 'முதல் வாசகம்', $dayDat ['reading1'] );
		
		// பதிலுரைப் பாடல்
		if (! empty ( $dayDat ['psalms'] )) {
			$rtTemp = "<h4 class='clrDef'>பதிலுரைப் பாடல்</h4>";
			$verses = explode ( 'அல்லது', $dayDat ['psalms'] );
			
			foreach ( $verses as &$ver ) {
				$TLUtil = new TamilLectionaryUtil ();
				$psalmText = $this->database->get ( 'readings__text_psalms', array (
						'ResponseVs',
						'Response' 
				), array (
						"refKey" => $ver 
				) );
				
				$rtTemp .= '<h5>' . $TLUtil->formatVerseToPrint ( $ver ) . ' (பல்லவி: ' . $psalmText ['ResponseVs'] . ') </h5>';
				$rtTemp .= '<p style="font-style:italic;"><span class="clrDef" >பல்லவி:</span> ' . $psalmText ['Response'] . '</p>';
				
				if (isset ( $this->readingsText [$ver] )){
					$rtTemp .= $this->readingsText [$ver];
				}elseif (isset ( $this->readingsText [explode('~', $ver )[0]] )){
					$rtTemp .= $this->readingsText [explode('~', $ver )[0]];
				}
			}
		}
		$rtTemp = str_replace ( '℟', ' - <span class="clrDef">பல்லவி</span></p><p>', $rtTemp );
		$rtTemp = str_replace ( "§", "<br/>", $rtTemp );
		
		$rt .= '<p>'.$rtTemp.'</p>';
		
		// இரண்டாம் வாசகம்
		$rt .= $this->formatReading ( 'இரண்டாம் வாசகம்', $dayDat ['reading2'] );
		
		// அல்லேலூயா
		if (! empty ( $dayDat ['alleluia'] )) {
			$rtT = "<h4 class='clrDef'>நற்செய்திக்கு முன் வாழ்த்தொலி</h4>";
			$verses = explode ( 'அல்லது', $dayDat ['alleluia'] );
			foreach ( $verses as &$ver ) {
				$rtTemp = '';
				if ($this->expandBibleRef ( $ver ) !== false) { // To Check whether verse is from bible or not
					$TLUtil = new TamilLectionaryUtil ();
					$rtTemp .= ' (' . $TLUtil->formatVerseToPrint ( $ver ) . ')';
				}
				if (isset ( $this->readingsText [$ver] )) {
					$rtTemp .= "<p class='alleluiaTxt'>அல்லேலூயா, அல்லேலூயா! " . $this->readingsText [$ver] . ' அல்லேலூயா.</p>';
				}
				$ver = $rtTemp;
			}
			
			$rtT .= implode ( '<h4 class="clrDef">அல்லது</h4>', $verses );
			if ($this->isItLentSeason ()) { // No alleluia during lent
				$rtT = str_replace ( 'நற்செய்திக்கு முன் வாழ்த்தொலி', 'நற்செய்திக்கு முன் வசனம்', $rtT );
				$rtT = str_replace ( "<p class='alleluiaTxt'>அல்லேலூயா, அல்லேலூயா! ", "<p class='alleluiaTxt'>", $rtT );
				$rtT = str_replace ( ' அல்லேலூயா.</p>', '', $rtT );
			}
			$rt .= $rtT;
		}
		// நற்செய்தி வாசகம்
		$rt .= $this->formatReading ( 'நற்செய்தி வாசகம்', $dayDat ['gospel'] );
		
		$colsD = array (
				'red' => 'clrRed',
				'white' => 'clrWhite',
				'green' => 'clrGreen',
				'rose' => 'clrRose',
				'purple' => 'clrPurple' 
		);
		
		// Change color of the text based on todays color
		$rt = str_replace ( 'clrDef', 'clr' . $dayDat ['color'], $rt );
		
		return $rt;
	}

	/**
	 * Formats first, second and gospel reading
	 *
	 * @param string $readingHeading        	
	 * @param string $readingCd        	
	 * @return string - Formated reading
	 */
	function formatReading($readingHeading, $readingCd) {
		if (empty ( $readingCd ))
			return '';
		$rt = "<h3 class='clrDef'>$readingHeading</h3>";
		$verses = explode ( 'அல்லது', $readingCd );
		foreach ( $verses as &$ver ) {
			$ver = $this->formatReadingText ( $ver );
		}
		$rt .= implode ( '<hr class="clrDef"/><h4 class="clrDef">அல்லது</h4>', $verses );
		return $rt;
	}

	/**
	 * Reading Text is retrived here from database and formated
	 *
	 * @param unknown $readingCode        	
	 * @return string
	 */
	function formatReadingText($readingCode) {
		$rdTxt = '';
		if (isset ( $this->readingsText [$readingCode] ))
			$rdTxt = $this->readingsText [$readingCode];
		
		$rdHeading = '';
		
		if (strpos ( $rdTxt, '---' ) !== false) {
			$rdHeading = explode ( '---', $rdTxt, 2 );
			
			$rdTxt = trim ( $rdHeading [1] );
			$rdHeading = trim ( $rdHeading [0] );
		}
		
		$fTxt = '';
		$fTxt .= "<h4 class='readingHeading'>" . $rdHeading . "</h4><div style='clear:both;'></div>";
		$fTxt .= "<p>" . $this->expandBibleRef ( $readingCode ) . "</p>";
		$fTxt .= "<p class='readingTxt'>" . $rdTxt . "</p>";
		$fTxt .= "<p  class='readingTxt'>ஆண்டவரின் அருள்வாக்கு.</p>";
		
		$fTxt = str_replace ( "§", "</p><p class='readingTxt'>", $fTxt );
		
		return $fTxt;
	}

	/**
	 * This expands bible relefence to its full.
	 * For example எண் 6:22-27 will be expanded to எண்ணிக்கை நூலிலிருந்து வாசகம் 6: 22-27
	 *
	 * @param string $readingCode        	
	 * @return boolean|mixed - Returns false if the reference is not from the bible or in standard format. Else returns the formated verse.
	 */
	function expandBibleRef($readingCode) {
		$TLUtil = new TamilLectionaryUtil ();
		$fVerse = $TLUtil->formatVerseToPrint ( $readingCode );
		
		if (strpos ( $fVerse, ' ', 1 ) === 1) {
			$fVerse = substr_replace ( $fVerse, '', 1, 1 );
		}
		
		$pieces = explode ( ' ', $fVerse, 2 );
		
		if (isset ( $TLUtil->tamilAbbr [$pieces [0]] )) {
			$fVerse = $TLUtil->tamilAbbr [$pieces [0]] . ' வாசகம் ' . $pieces [1];
		} else {
			return FALSE;
		}
		
		$fVerse = str_replace ( '✠', '<span class="clrDef">✠</span>', $fVerse );
		return $fVerse;
	}

	/**
	 *
	 * @todo Depending on need this function may be moved to a general library. Probably TamilLectionaryUtil.php
	 * @return boolean returns true if current date is in lenten season else returns false.
	 */
	function isItLentSeason() {
		$cYear = substr ( $this->currentDate, - 4 );
		
		$eastertideStarts = new DateTime ( $cYear . '-03-21' );
		$eastertideStarts->modify ( '+ ' . easter_days ( $cYear ) . ' days' ); // Lent Ends
		
		$lentStart = clone $eastertideStarts;
		$lentStart->modify ( '-46 days' );
		
		$todaysDate = new DateTime ( $cYear . '-' . substr ( $this->currentDate, 2, 2 ) . '-' . substr ( $this->currentDate, 0, 2 ) );
		
		return ($lentStart <= $todaysDate && $todaysDate < $eastertideStarts);
	}
}