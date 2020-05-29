<?php
/**
 * Tamil-Catholic-Lectionary 1.0
 * TamilLectionaryUtil - Utility class to help with most commonly used functions
 * @author Br. Jayarathina Madharasan SDR
 */
class TamilLectionaryUtil {
	
	/**
	 * Lectionary reading are stored in DB without space.
	 * Hence they are formatted before displaying/printing them.
	 *
	 * @param string $verse
	 *        	- Verse to be formated. Eg: 1 சாமு 2:1.4-5.6-7.8
	 * @return string - Formated Verse. Eg: 1 சாமு 2: 1. 4 - 5. 6 - 7. 8
	 */
	public static function formatVerseToPrint($verse) {
		$rt = trim ( $verse );
		
		$rt = preg_replace ( '/(\.)/', '${1} ', $rt, - 1, $count );
		if ($count === 0) { // If there is a dot '.' it means it is responsorial verse.
			$rt = preg_replace ( '/(,)/', '${1} ', $rt );
		}
		
		// Not the eligant way to code this. But hey! It gets it done....
		$rt = preg_replace ( '/யூதா/', 'யூதா ', $rt ); // Space after semi colon
		$rt = preg_replace ( '/(;)/', '${1} ', $rt ); // Space after semi colon
		$rt = preg_replace ( '/(காண்க)/', ' ${1} ', $rt );
		$rt = preg_replace ( '/(\d+:)/', ' ${1} ', $rt ); // Space after chapter number and colon
		$rt = preg_replace ( '/^(\d+)/', '${1} ', $rt ); // Space after digits at start of verse eg: 1சாமு
		$rt = preg_replace ( '/(\()/', ' ${1}', $rt ); // Space before ( -> எஸ் (கி)
		$rt = preg_replace ( '/\s\s+/', ' ', $rt ); // Excess space
		                                            
		// Verse after '~' is not to be printed or shown
		$rt = explode ( '~', $rt );
		return $rt [0];
	}
	
	/**
	 * Find out whether the given date falls in lent in the current year
	 *
	 * @param int $yr
	 *        	- Year
	 * @param int $mnth
	 *        	- Month
	 * @param int $dt
	 *        	- Date
	 * @return boolean - True if it false in lent else false
	 */
	public static function isItInLent($yr, $mnth, $dt) {
		// Easter Date
		$eastertideStarts = new DateTime ( $yr . '-03-21' );
		$eastertideStarts->modify ( '+ ' . easter_days ( $yr ) . ' days' );
		
		// Ash Wednesday
		$lentStart = clone $eastertideStarts;
		$lentStart->modify ( '-46 days' );
		
		$givenDate = new DateTime ( "$yr-$mnth-$dt" );
		
		return ($givenDate >= $lentStart && $givenDate < $eastertideStarts);
	}
	
	/**
	 *
	 * This expands bible relefence to its full to use in readings.
	 * For example எண் 6:22-27 will be expanded to எண்ணிக்கை நூலிலிருந்து வாசகம் 6: 22-27
	 *
	 * @param string $readingCode
	 * @return boolean|string - Returns `false` if the reference is not from the bible or in standard format, else returns the formated verse.
	 */
	public static function expandBibleRef($readingCode) {
		$fVerse = TamilLectionaryUtil::formatVerseToPrint ( $readingCode );
		if (strlen ( $readingCode ) === 0)
			return false; // For alleluia
		if (strpos ( $fVerse, ' ', 1 ) === 1) {
			$fVerse = substr_replace ( $fVerse, '', 1, 1 );
		}
		$pieces = explode ( ' ', $fVerse, 2 );
		if (isset ( TamilLectionaryUtil::$tamilAbbr [$pieces [0]] )) {
			$fVerse = TamilLectionaryUtil::$tamilAbbr [$pieces [0]] . ' வாசகம் ' . $pieces [1];
		} else {
			return FALSE;
		}
		return $fVerse;
	}
	
	/**
	 * Gets the first key of an array
	 * This function is supported only in PHP 7.3.0 and above.
	 * For lower version this acts as substitue
	 *
	 * @param array $tempArr
	 * @return string the first key of array
	 */
	public static function array_key_first($tempArr) {
		if (! function_exists ( 'array_key_first' )) {
			reset ( $tempArr );
			return key ( $tempArr );
		} else
			return array_key_first ( $tempArr );
	}
	
	/**
	 * This encodes parameter to use in hyperlink.
	 * This is to avoid duplicate values when using in hyperlink.
	 *
	 * @param string $paramKey
	 *        	- variable name
	 * @param string $val
	 *        	- value to be assigned
	 * @param string $uriParams
	 *        	- Current list of parameters
	 * @return string
	 */
	public static function formHyperLink($paramKey, $val, $uriParams = null) {
		if (is_null ( $uriParams ))
			$uriParams = $_SERVER ['QUERY_STRING'];
		parse_str ( $uriParams, $params );
		$params [$paramKey] = $val;
		return http_build_query ( $params );
	}
	public static $tamilAbbr = [ 
			'தொநூ' => 'தொடக்க நூலிலிருந்து',
			'விப' => 'விடுதலைப் பயண நூலிலிருந்து',
			'லேவி' => 'லேவியர் நூலிலிருந்து',
			'எண்' => 'எண்ணிக்கை நூலிலிருந்து',
			'இச' => 'இணைச்சட்ட நூலிலிருந்து',
			'யோசு' => 'யோசுவா நூலிலிருந்து',
			'நீத' => 'நீதித்தலைவர்கள் நூலிலிருந்து',
			'ரூத்' => 'ரூத்து நூலிலிருந்து',
			'1சாமு' => 'சாமுவேலின் முதல் நூலிலிருந்து',
			'2சாமு' => 'சாமுவேலின் இரண்டாம் நூலிலிருந்து',
			'1அர' => 'அரசர்கள் முதல் நூலிலிருந்து',
			'2அர' => 'அரசர்கள் இரண்டாம் நூலிலிருந்து',
			'1குறி' => 'குறிப்பேடு முதல் நூலிலிருந்து',
			'2குறி' => 'குறிப்பேடு இரண்டாம் நூலிலிருந்து',
			'எஸ்ரா' => 'எஸ்ரா நூலிலிருந்து வாசகம்',
			'நெகே' => 'இறைவாக்கினர் நெகேமியா நூலிலிருந்து',
			'எஸ்' => 'எஸ்தர் நூலிலிருந்து வாசகம்',
			'யோபு' => 'யோபு நூலிலிருந்து',
			'திபா' => 'திருப்பாடல்', // 'திருப்பாடல் நூலிலிருந்து',
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
			
			'தோபி' => 'தோபித்து நூலிலிருந்து வாசகம்',
			'யூதி' => 'யூதித்து நூலிலிருந்து வாசகம்',
			'எஸ் (கி)' => 'எஸ்தர் (கி) நூலிலிருந்து வாசகம்',
			'சாஞா' => 'சாலமோனின் ஞான நூலிலிருந்து',
			'சீஞா' => 'சீராக்கின் ஞான நூலிருந்து',
			'பாரூ' => 'இறைவாக்கினர் பாரூக்கு நூலிலிருந்து',
			'தானி (இ)' => 'இறைவாக்கினர் தானியேல் (இ) நூலிலிருந்து',
			'1மக்' => 'மக்கபேயர் இரண்டாம் நூலிலிருந்து',
			'2மக்' => 'மக்கபேயர் இரண்டாம் நூலிலிருந்து',
			
			'மத்' => '✠ மத்தேயு எழுதிய நற்செய்தியிலிருந்து',
			'மாற்' => '✠ மாற்கு எழுதிய நற்செய்தியிலிருந்து',
			'லூக்' => '✠ லூக்கா எழுதிய நற்செய்தியிலிருந்து',
			'யோவா' => '✠ யோவான் எழுதிய நற்செய்தியிலிருந்து',
			'திப' => 'திருத்தூதர் பணிகள் நூலிலிருந்து',
			'உரோ' => 'திருத்தூதர் பவுல் உரோமையருக்கு எழுதிய திருமுகத்திலிருந்து',
			'1கொரி' => 'திருத்தூதர் பவுல் கொரிந்தியருக்கு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2கொரி' => 'திருத்தூதர் பவுல் கொரிந்தியருக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'கலா' => 'திருத்தூதர் பவுல் கலாத்தியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'எபே' => 'திருத்தூதர் பவுல் எபேசியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'பிலி' => 'திருத்தூதர் பவுல் பிலிப்பியருக்கு எழுதிய திருமுகத்திலிருந்து',
			'கொலோ' => 'திருத்தூதர் பவுல் கொலோசையருக்கு எழுதிய திருமுகத்திலிருந்து',
			'1தெச' => 'திருத்தூதர் பவுல் தெசலோனிக்கருக்கு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2தெச' => 'திருத்தூதர் பவுல் தெசலோனிக்கருக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'1திமொ' => 'திருத்தூதர் பவுல் திமொத்தேயுவுக்கு எழுதிய முதல்  திருமுகத்திலிருந்து',
			'2திமொ' => 'திருத்தூதர் பவுல் திமொத்தேயுவுக்கு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'தீத்' => 'திருத்தூதர் பவுல் தீத்துக்கு எழுதிய திருமுகத்திலிருந்து',
			'பில' => 'திருத்தூதர் பவுல் பிலமோனுக்கு எழுதிய திருமுகத்திலிருந்து',
			'எபி' => 'எபிரேயருக்கு எழுதப்பட்ட திருமுகத்திலிருந்து',
			'யாக்' => 'திருத்தூதர் யாக்கோபு எழுதிய திருமுகத்திலிருந்து',
			'1பேது' => 'திருத்தூதர் பேதுரு எழுதிய முதல் திருமுகத்திலிருந்து',
			'2பேது' => 'திருத்தூதர் பேதுரு எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'1யோவா' => 'திருத்தூதர் யோவான் எழுதிய முதல் திருமுகத்திலிருந்து',
			'2யோவா' => 'திருத்தூதர் யோவான் எழுதிய இரண்டாம் திருமுகத்திலிருந்து',
			'3யோவா' => 'திருத்தூதர் யோவான் எழுதிய மூன்றாம் திருமுகத்திலிருந்து',
			'யூதா' => 'திருத்தூதர் யூதா எழுதிய திருமுகத்திலிருந்து',
			'திவெ' => 'திருத்தூதர் யோவான் எழுதிய திருவெளிப்பாட்டிலிருந்து' 
	];
	public static $tamilDayFull = [ 
			'ஞாயிறு',
			'திங்கள்',
			'செவ்வாய்',
			'புதன்',
			'வியாழன்',
			'வெள்ளி',
			'சனி' 
	];
	public static $tamilDayShort = [ 
			'ஞா',
			'தி',
			'செ',
			'பு',
			'வி',
			'வெ',
			'ச' 
	];
	public static $tamilMonthFull = [ 
			'',
			'சனவரி',
			'பிப்ரவரி',
			'மார்ச்',
			'ஏப்ரல்',
			'மே',
			'ஜூன்',
			'ஜூலை',
			'ஆகஸ்ட்',
			'செப்டம்பர்',
			'அக்டோபர்',
			'நவம்பர்',
			'டிசம்பர்' 
	];
	public static $tamilMonthShort = [ 
			'',
			'சன',
			'பிப்',
			'மார்',
			'ஏப்',
			'மே',
			'ஜூன்',
			'ஜூலை',
			'ஆக',
			'செப்',
			'அக்',
			'நவ',
			'டிச' 
	];
	public static $tamilFeastType = [ 
			'' => '',
			'Solemnity' => 'பெருவிழா',
			'Solemnity-PrincipalPartron-Place' => 'பெருவிழா',
			'Feast-Lord' => 'விழா',
			'Feast' => 'விழா',
			'Feast-PrincipalPartron-Place' => 'விழா',
			'Mem' => 'நினைவு',
			'Mem-Mary' => 'நினைவு',
			'OpMem' => 'வி.நினைவு',
			'Commomeration' => 'நினைவுக்காப்பு',
			'All Souls' => '' 
	];
	public static $commonsList = [ 
			'_Church' => 'கோவில் நேர்ந்தளிப்பு அண்டு நாள்',
			'_Mary' => 'தூய கன்னி மரியா - பொது',
			'_Martyr' => 'மறைச்சாட்சியர் - பொது',
			'_Pastor' => 'மறைப்பணியாளர் - பொது',
			'_Doctor' => 'மறைவல்லுநர் - பொது',
			'_Virgin' => 'கன்னியர் - பொது',
			'_Saint' => 'புனிதர், புனிதையர் - பொது',
			'_VM-HolyName' => 'இயேசுவின் திருப்பெயர் - நேர்ச்சித் திருப்பலி (வாசக நூல் IV)' 
	];
	public static $commonsSubList = [ 
			'0' => '',
			'1' => 'அறச்செயலில் ஈடுபட்டோர்',
			'2' => 'கல்விப் பணியாற்றியோர்',
			'3' => 'கைம்பெண்கள்',
			'4' => 'திருத்தந்தை',
			'5' => 'துறவியர்',
			'6' => 'மறைபரப்புப் பணியாளர்' 
	];
	public static $commonsSubList_ = [ 
			'0' => '',
			'1' => 'அறச்செயலில் ஈடுபட்டோர் திருப்பலியில்',
			'2' => 'கல்விப் பணியாற்றியோர்',
			'3' => 'கைம்பெண்கள் திருப்பலியில்',
			'4' => 'திருத்தந்தைக்குரிய  திருப்பலியில்',
			'5' => 'துறவியர் திருப்பலியில்',
			'6' => 'மறைபரப்புப் பணியாளர் திருப்பலியில்' 
	];
}