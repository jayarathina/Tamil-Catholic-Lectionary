<?php
/**
 * RomanLectionary 1.0
 * This function get the year and settings and creates a json file to generate a calendar
 * @author Br. Jayarathina Madharasan SDR
 */
require_once 'mods/Medoo.php';
include_once 'lib/includeExternal.php';
include_once 'lib/FeastNameFramer.php';
class TamilLectionarySingleDay {

	private $calcConfig, $database;

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

	function printDayReading($dayCode, $cYear) {
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
						// break 3;
					}
				}
			}
		}
	}

	function getDayHTML($dayDetails) {
		print_r ( $dayDetails );
		if (isset ( $dayDetails ['readingList'] )) {
			$sql = "SELECT `refKey`, `Content` FROM `readings__text` WHERE `refKey` IN ('" . implode ( "','", array_values ( $dayDetails ['readingList'] ) ) . "')";
			$readings = $this->database->query ( $sql )->fetchAll ( PDO::FETCH_KEY_PAIR );
			// print_r ( $red );
			
			/*
			 *
			 *
			 * Array
			 * (
			 * [code] => OW16-1Mon
			 * [rank] => 13.4
			 * [color] => green
			 * [name] => பொதுக்காலம் 16ஆம் வாரம் - திங்கள்
			 * [readingList] => Array
			 * (
			 * [dayID] => OW16-1Mon 1
			 * [reading1] => விப14:5-18
			 * [psalms] => விப15:1bc-2.3-4.5-6
			 * [reading2] =>
			 * [alleluia] => திபா95:8
			 * [gospel] => மத்12:38-42
			 * )
			 *
			 * )
			 *
			 *
			 */
			
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
				$dayDat = array ();
				
				if (preg_match ( '/.* ([1|2|A|B|C])$/', $dayDetails ['readingList'] ['dayID'], $matches ) === 1) {
					$dayDat ['title-H2'] = $yearCat [$matches [1]];
				}
				
				$dayDat ['reading1'] = $dayDetails ['readingList'] ['reading1'];
				$dayDat ['psalms'] = $dayDetails ['readingList'] ['psalms'];
				$dayDat ['reading2'] = $dayDetails ['readingList'] ['reading2'];
				$dayDat ['alleluia'] = $dayDetails ['readingList'] ['alleluia'];
				$dayDat ['gospel'] = $dayDetails ['readingList'] ['gospel'];
				
				// $dayDat['title-H2']
				
				return $this->printHTML ( $dayDat, $readings );
			}
		} else {
			// displayCommons()
		}
	}

	function printHTML($dayDat, $readings) {
		$rt = '';
		$rt .= "<h1>{$dayDat['title-H1']}</h1>";
		if (isset ( $dayDat ['title-H2'] ))
			$rt .= "<h2>{$dayDat['title-H2']}</h2>";
		
		$rt .= "";
		
		$listArrBefore = array (
				'reading1' => 'முதல் வாசகம்',
				'psalms' => 'பதிலுரைப் பாடல்',
				'reading2' => 'இரண்டாம் வாசகம்',
				'alleluia' => 'நற்செய்திக்கு முன் வசனம்',
				'gospel' => 'நற்செய்தி வாசகம்' 
		);
		$listArrAfter = array (
				'reading1' => 'இது ஆண்டவர் வழங்கும் அருள்வாக்கு.',
				'psalms' => '',
				'reading2' => 'இது ஆண்டவர் வழங்கும் அருள்வாக்கு.',
				'alleluia' => '',
				'gospel' => 'இது கிறிஸ்து வழங்கும் நற்செய்தி.' 
		);
		$listArr = array (
				'reading1',
				'psalms',
				'reading2',
				'alleluia',
				'gospel' 
		);
		
		foreach ( $listArr as $value ) {
			
			if (! empty ( $dayDat [$value] )) {
				
				if (isset ( $readings [$dayDat [$value]] )) {
					
					$rt .= "<h3>" . $listArrBefore [$value] . "</h3>";
					$rt .= "<h4>" . $dayDat [$value] . "</h4>";
					$rt .= "<p>" . $readings [$dayDat [$value]] . "</p>";
					$rt .= "<p>" . $listArrAfter [$value] . "</p>";
				} else {
					$rt .= "<h4>" . $dayDat [$value] . "</h4>";
				}
			}
		}
		
		$rt = str_replace ( "§", "<br/>", $rt );
		$rt = str_replace ( "℟", " - பல்லவி<br/><br/>", $rt );
		
		return $rt;
	}

	private $tamilAbbr = array (
			'தொநூ' => 'தொடக்க நூலிலிருந்து',
			'விப' => 'விடுதலைப் பயண நூலிலிருந்து',
			'லேவி' => 'லேவியர் நூலிலிருந்து',
			'எண்' => 'எண்ணிக்கை நூலிலிருந்து',
			'இச' => 'இணைச்சட்ட நூலிலிருந்து',
			'யோசு' => 'யோசுவா நூலிலிருந்து',
			'நீத' => 'நீதித்தலைவர்கள் நூலிலிருந்து',
			'ரூத்' => 'ரூத்து நூலிலிருந்து',
			'1 சாமு' => 'சாமுவேலின் முதல் நூலிலிருந்து',
			'2 சாமு' => 'சாமுவேலின் இரண்டாம் நூலிலிருந்து',
			'1 அர' => 'அரசர்கள் முதல் நூலிலிருந்து',
			'2 அர' => 'அரசர்கள் இரண்டாம் நூலிலிருந்து',
			'1 குறி' => 'குறிப்பேடு முதல் நூலிலிருந்து',
			'2 குறி' => 'குறிப்பேடு இரண்டாம் நூலிலிருந்து',
			'எஸ்ரா' => 'எஸ்ரா நூலிலிருந்து வாசகம்',
			'நெகே' => 'இறைவாக்கினர் நெகேமியா நூலிலிருந்து',
			'எஸ்' => 'எஸ்தர் நூலிலிருந்து வாசகம்',
			'யோபு' => 'யோபு நூலிலிருந்து',
			'திபா' => 'திருப்பாடல் நூலிலிருந்து',
			'நீமொ' => 'நீதிமொழிகள் நூலிலிருந்து',
			'சஉ' => 'சபை உரையாளர் நூலிலிருந்து',
			'இபா' => 'இனிமைமிகு பாடலிலிருந்து',
			'எசா' => 'இறைவாக்கினர் எசாயா நூலிலிருந்து',
			'எரே' => 'இறைவாக்கினர் எரேமியா நூலிலிருந்து',
			'புல' => 'புலம்பல் நூலிலிருந்து வாசகம்',
			'எசே' => 'இறைவாக்கினர் எசேக்கியேல் நூலிலிருந்து',
			'தானி' => 'இறைவாக்கினர் தானியேல் நூலிலிருந்து',
			'ஓசே' => 'இறைவாக்கினர் ஓசேயா நூலிலிருந்து',
			'யோவே' => 'இறைவாக்கினர் யோவேல் நூலிலிருந்து',
			'ஆமோ' => 'இறைவாக்கினர் ஆமோஸ் நூலிலிருந்து',
			'ஒப' => 'இறைவாக்கினர் ஒபதியா நூலிலிருந்து',
			'யோனா' => 'இறைவாக்கினர் யோனா நூலிலிருந்து',
			'மீக்' => 'இறைவாக்கினர் மீக்கா நூலிலிருந்து',
			'நாகூ' => 'இறைவாக்கினர் நாகூம் நூலிலிருந்து',
			'அப' => 'இறைவாக்கினர் அபக்கூக்கு நூலிலிருந்து',
			'செப்' => 'இறைவாக்கினர் செப்பனியா நூலிலிருந்து',
			'ஆகா' => 'இறைவாக்கினர் ஆகாய் நூலிலிருந்து',
			'செக்' => 'இறைவாக்கினர் செக்கரியா நூலிலிருந்து',
			'மலா' => 'இறைவாக்கினர் மலாக்கி நூலிலிருந்து வாசகம்',
			'தோபி' => '',
			'யூதி' => '',
			'எஸ் (கி)' => 'எஸ்தர் (கி) நூலிலிருந்து வாசகம்',
			'சாஞா' => 'சாலமோனின் ஞான நூலிலிருந்து',
			'சீஞா' => 'சீராக்கின் ஞான நூலிருந்து',
			'பாரூ' => 'இறைவாக்கினர் பாரூக்கு நூலிலிருந்து',
			'தானி (இ)' => 'இறைவாக்கினர் தானியேல் (இ) நூலிலிருந்து',
			'1 மக்' => 'மக்கபேயர் இரண்டாம் நூலிலிருந்து',
			'2 மக்' => 'மக்கபேயர் இரண்டாம் நூலிலிருந்து',
			
			'மத்' => '✠ மத்தேயு எழுதிய நற்செய்தியிலிருந்து',
			'மாற்' => '✠ மாற்கு எழுதிய நற்செய்தியிலிருந்து',
			'லூக்' => '✠ லூக்கா எழுதிய நற்செய்தியிலிருந்து',
			'யோவா' => '✠ யோவான் எழுதிய நற்செய்தியிலிருந்து',
			'திப' => 'திருத்தூதர் பணிகள் நூலிலிருந்து',
			'உரோ' => 'திருத்தூதர் பவுல் உரோமையருக்கு எழுதிய திருமுகத்திலிருந்து',
			'1 கொரி' => 'திருத்தூதர் பவுல் கொரிந்தியருக்கு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2 கொரி' => 'திருத்தூதர் பவுல் கொரிந்தியருக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'கலா' => 'திருத்தூதர் பவுல் கலாத்தியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'எபே' => 'திருத்தூதர் பவுல் எபேசியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'பிலி' => 'திருத்தூதர் பவுல் பிலிப்பியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'கொலோ' => 'திருத்தூதர் பவுல் கொலோசையருக்கு எழுதிய திருமுகத்திலிருந்து',
			'1 தெச' => 'திருத்தூதர் பவுல் தெசலோனிக்கருக்கு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2 தெச' => 'திருத்தூதர் பவுல் தெசலோனிக்கருக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'1 திமொ' => 'திருத்தூதர் பவுல் திமொத்தேயுவுக்கு எழுதிய முதல்  திருமுகத்திலிருந்து',
			'2 திமொ' => 'திருத்தூதர் பவுல் திமொத்தேயுவுக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'தீத்' => 'திருத்தூதர் பவுல் தீத்துக்கு எழுதிய திருமுகத்திலிருந்து',
			'பில' => 'திருத்தூதர் பவுல் பிலமோனுக்கு எழுதிய திருமுகத்திலிருந்து',
			'எபி' => 'எபிரேயருக்கு எழுதப்பட்ட திருமுகத்திலிருந்து',
			'யாக்' => 'திருத்தூதர் யாக்கோபு எழுதிய திருமுகத்திலிருந்து',
			'1 பேது' => 'திருத்தூதர் பேதுரு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2 பேது' => 'திருத்தூதர் பேதுரு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'1 யோவா' => 'திருத்தூதர் யோவான் எழுதிய முதல் திருமுகத்திலிருந்து',
			'2 யோவா' => 'திருத்தூதர் யோவான் எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'3 யோவா' => 'திருத்தூதர் யோவான் எழுதிய மூன்றாம் திருமுகத்திலிருந்து',
			'யூதா' => 'திருத்தூதர் யூதா எழுதிய திருமுகத்திலிருந்து',
			'திவெ' => 'திருத்தூதர் யோவான் எழுதிய திருவெளிப்பாட்டிலிருந்து' 
	);
}