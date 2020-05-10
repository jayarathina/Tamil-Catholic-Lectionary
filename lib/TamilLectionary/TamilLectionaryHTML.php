<?php
use Medoo\Medoo;
require_once 'lib/Medoo.php';
require_once 'lib/dbConfig.php';

include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
class TamilLectionaryHTML {
	public $fullYear;
	private $readingType = [ 
			'1' => 'முதல் வாசகம்',
			'2' => 'பதிலுரைப் பாடல்',
			'3' => 'இரண்டாம் வாசகம்',
			'4' => '',
			'5' => '',
			'6' => 'நற்செய்தி வாசகம்',
			'7' => '',
			'8' => '',
			'9' => '' 
	];
	function __construct($year) {
		$this->fullYear = $year;
	}
	function getDay($date, $month, $evtID = 0) {
		return $this->getSingleEvent ( $this->fullYear [$month] [$date] [$evtID] );
	}
	function getSingleEvent($currtDay) {
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
		$database = new Medoo ( [ 
				'database_type' => 'mysql',
				'database_name' => DB_NAME,
				'server' => 'localhost',
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'charset' => 'utf8' 
		] );
		
		$rt = '';
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) ]}</h4>";
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $database->get ( 'readings__text', '*', [ 
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
			
			//find out if alternative readings are available, and make them so 
			preg_match ( '/^\d\.(\d)$/', $readngType, $matches, PREG_OFFSET_CAPTURE );
			if (! empty ( $matches )) {
				if ($matches [1] [0] !== '1') {
					$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
				}
			}
			
			//find out if short readings are available, and make them so 
			preg_match ( '/^\d\.\d(\d)$/', $readngType, $matches, PREG_OFFSET_CAPTURE );
			if (! empty ( $matches )) {
				if ($matches [1] [0] !== '1')
					$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது குறுகிய வாசகம்</h4>" . $rdCnt;
			}
			$rt .= $rdCnt;
		}
		return $rt;
	}
	
	function getResponsorialTxt($readings, $usedBy = null) {
		$database = new Medoo ( [
				'database_type' => 'mysql',
				'database_name' => DB_NAME,
				'server' => 'localhost',
				'username' => DB_USER,
				'password' => DB_PASSWORD,
				'charset' => 'utf8'
		] );
		
		$rt = '';
		$rt .= "<h4 class='clrDay'>{$this->readingType[ intval( array_key_first ( $readings ) ) ]}</h4>";
		
		foreach ( $readings as $readngType => $value ) {
			$readingTxt = $database->get ( 'readings__text', '*', [
					'refKey' => $value,
					'usedBy' => $usedBy
			] );
			
			//Give spaing to verses
			$refTxt = TamilLectionaryUtil::formatVerseToPrint ( $value );
			
			//If alternative response is set (அல்லது:...), then extract it.
			$altResponse = '';
			preg_match('/(.*)\( *அல்லது *:?(.*?)\)/', $readingTxt['introRes'], $matches);
			if(!empty($matches)){
				$readingTxt['introRes'] = $matches[1];
				$altResponse =  "<br/><span class='clrDay'>அல்லது :</span>" . $matches[2];
			}

			//Seperate the response verse ref from responce text.
			$responseTxt = $readingTxt['introRes'];
			$responseRef = '';
			preg_match('/(.*)§(.*)/', $readingTxt['introRes'], $matches);
			if(!empty($matches)){
				$responseTxt = $matches[1];
				$responseRef = ' (பல்லவி: ' . $matches[2] .')';
			}
			
			$rdCnt = '';
			$rdCnt .= '<span class="clrDay italics">' . $refTxt . $responseRef .'</span>';
			$rdCnt .= "<p><span class='clrDay italics' >பல்லவி:</span> $responseTxt $altResponse</p>";

			//Format individual Verses
			$rdCnt_temp = str_replace ( '℟', " - <span class='clrDay'>பல்லவி</span><br/><br/>§", $readingTxt ['Content'] );
			$rdCnt_temp = explode ( '§', $rdCnt_temp );
			$rdCnt_temp = array_filter ( $rdCnt_temp );//remove empty values
			foreach ( $rdCnt_temp as &$value ) {
				$value = trim ( $value );
				$t = explode ( ' ', $value, 2 );
				$value = '<div>' . $t [0] . '</div><div>' . $t [1] . '</div>';
			}
			$rdCnt_temp = implode ( '', $rdCnt_temp );
			
			//Enclose the formated veses into psalmText class
			$rdCnt .= '<div class="psalmText">' . $rdCnt_temp . '</div>';
			
			//Find alternatives psalms available and mark them so
			preg_match ( '/^\d\.(\d)$/', $readngType, $matches, PREG_OFFSET_CAPTURE );
			if (! empty ( $matches )) {
				if ($matches [1] [0] !== '1') {
					$rdCnt = "<hr class='clrDay'/><h4 class='clrDay italics'>அல்லது</h4>" . $rdCnt;
				}
			}
			
			$rt .= $rdCnt;
		}
		
		return $rt;
	}
	
}

?>