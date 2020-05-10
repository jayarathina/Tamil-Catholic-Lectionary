<?php
use Medoo\Medoo;
require_once 'lib/Medoo.php';
require_once 'lib/dbConfig.php';

include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
class TamilLectionaryHTML {
	public $fullYear;
	public $currYear;
	private $readingType = [ 
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
	function getDay($date, $month, $evtID = 0) {
		return $this->getSingleEvent ( $this->fullYear [$month] [$date] [$evtID], TamilLectionaryUtil::isItInLent ( $this->currYear, $month, $date ) );
	}
	function getSingleEvent($currtDay, $isLent) {
		
		//FIXME Vigil masses have to be printed properly
		if(isset($currtDay['readings']['Day']))
			$currtDay['readings'] = $currtDay['readings']['Day'];
		
		// There is a doubt whether Alleluia is sung during lent on Solemnities
		// Currently we follow Tamil Lectionary, so we sing it on solemnities.
		if (isset ( $currtDay ['type'] ) && $currtDay ['type'] == 'Solemnity')
			$isLent = false;
		
		$ret = '';
		
		for($i = 1; $i < 10; $i ++) {
			$readings = array_filter ( $currtDay ['readings'], function ($readingsType) use ($i) {
				return preg_match ( "/^$i\.*/", $readingsType );
			}, ARRAY_FILTER_USE_KEY );
			
			if (empty ( $readings ))
				continue;
			
			switch ($i) {
				case 1 : // First Reading
				case 3 : // Second Reading
				case 6 : // Gospel Reading
					$ret .= $this->getReadingsTxt ( $readings, $currtDay ['code'] );
					break;
				case 2 : // Responsorial
					$ret .= $this->getResponsorialTxt ( $readings, $currtDay ['code'] );
					break;
				case 4 : // Sequence
					$ret .= $this->getSequenceTxt ( $readings );
					break;
				case 5 : // Alleluia
					$ret .= $this->getAlleluiaTxt ( $readings, $currtDay ['code'], $isLent );
					break;
				default :
					print_r ( $readings );
					break;
			}
		}
		
		// Add Day Title
		$ret = "<h4 class='dayTitle clr{$currtDay['color']}'>{$currtDay['ta_name']}</h4>" . $ret;
		// Set Colour Value
		$ret = str_replace ( 'clrDay', 'clr' . $currtDay ['color'], $ret );
		
		return $ret;
	}
	function getReadingsTxt($readings, $usedBy = null) {
		$rt = '';
		// Set Heading
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) ]}</h4>";
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => $usedBy 
			] );
			
			$refExpanded = TamilLectionaryUtil::expandBibleRef ( $value );
			
			$rdCnt = '';
			$rdCnt .= "<span class='readingHeading'>{$readingTxt['introRes']}</span><br/>";
			$rdCnt .= "<div style='clear:both;'></div>";
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
	function getResponsorialTxt($readings, $usedBy = null) {
		$rt = '';
		
		// Set Heading
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) ]}</h4>";
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => $usedBy 
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
			
			// Find alternatives available and mark them so
			if (isset ( $readngType [2] ) && intval ( $readngType [2] ) !== 0) {
				$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
			}
			
			$rt .= $rdCnt;
		}
		
		return $rt;
	}
	function getAlleluiaTxt($readings, $usedBy = null, $isLent = false) {
		$rt = '';
		
		// Set Heading
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) . $isLent]}</h4>";
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $this->database->get ( 'readings__text', '*', [ 
					'refKey' => $value,
					'usedBy' => $usedBy 
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
		
		// Set Heading
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) ]}</h4>";
		
		$readingTxt = $this->database->get ( 'readings__text', '*', [
				'refKey' => $readings[4]
		] );
		
		$rt .= "<div class='clrDay italics'>{$readingTxt['introRes']}</div>";
		
		$rdCnt = str_replace ( '<ol>', "<ol class='sequenceTxt'>", $readingTxt['Content']);
		if( strpos($rdCnt, '<ol>') === false){
			$rdCnt = str_replace ( '§§', "</p><p class='sequenceTxt'>", $rdCnt);
			$rdCnt = "<p class='sequenceTxt'>$rdCnt</p>";
		}
		$rdCnt = str_replace ( '§', '<br/>', $rdCnt);

		$rt .= $rdCnt;
		return $rt;
	}
}

?>