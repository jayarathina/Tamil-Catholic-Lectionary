<a href='0AW.php'>Advent</a> | 
<a href='1CW.php'>Christmas</a> | 
<a href='3LW.php'>Lent</a> | 
<a href='4EW.php'>Easter</a> | 
<a href='5OW.php'>Ordinary</a> | 
<a href='6Saints.php'>Saints</a> | 
<a href='../example.php'>Year</a> | 

<?php 

function print_row($Daykey, $ReadingVal) {
	if (! isset ( $ReadingVal ['reading2'] )) {
		$ReadingVal ['reading2'] = '';
	}

	echo '<tr>';
	echo '<td>' . $Daykey . '</td>';
	echo '<td>' . sanitizeVerse ( $ReadingVal ['reading1'] ) . '</td>';
	echo '<td>' . sanitizeVerse ( $ReadingVal ['psalms'] ) . '</td>';
	echo '<td>' . sanitizeVerse ( $ReadingVal ['reading2'] ) . '</td>';
	echo '<td>' . sanitizeVerse ( $ReadingVal ['alleluia'] ) . '</td>';
	echo '<td>' . sanitizeVerse ( $ReadingVal ['gospel'] ) . '</td>';
	echo '</tr>';
}

function sanitizeVerse($verse) {
	if (empty ( $verse ))
		return '';

		$verse = explode ( 'அல்லது', $verse );

		if (sizeof ( $verse ) == 1) {
			$ver = addspacetoVerse ( $verse [0] );
			$verse = check_verse_all( $verse[0]) . "<a href='edit.php?vs={$verse[0]}'>$ver</a>";
		} else {
			foreach ( $verse as &$val ) {
				$val1 = addspacetoVerse ( $val );
				$val = check_verse_all( $val) . "<a href='edit.php?vs={$val}'>$val1</a>";
			}
			$verse = implode ( '<br/><small>அல்லது</small><br/>', $verse );
		}
		return $verse;
}

function addspacetoVerse($verse) {
	$rt = trim ( $verse );

	$rt = preg_replace ( '/(\.)/', '${1} ', $rt, -1, $count );
	if($count === 0){//If there is a dot '.' it means it is responsorial verse.
		$rt = preg_replace ( '/(,)/', '${1} ', $rt );
	}
	
	//Not the eligant way to code this. But hey! It gets work done....
	$rt = preg_replace ( '/(;)/', '${1} ', $rt );//
	$rt = preg_replace ( '/(காண்க)/', ' ${1} ', $rt );
	$rt = preg_replace ( '/(\d+:)/', ' ${1} ', $rt );//Space after chapter colon
	$rt = preg_replace ( '/^(\d+)/', '${1} ', $rt );//Space after digits at start of verse eg: 1சாமு
	$rt = preg_replace ( '/(\()/', ' ${1}', $rt );// Space before ( -> எஸ் (கி)
	$rt = preg_replace('/\s\s+/', ' ', $rt);//Excess space
	return $rt;
}


$database = new medoo ( array (
		'database_type' => 'mysql',
		'database_name' => 'liturgy_lectionary',
		'server' => 'localhost',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8'
) );

function check_verse_all($verse) {

	if( empty( $verse) ){
		return;
	}

	$listWD = $GLOBALS ['database']->count ( 'readings__text', '*', array (
			'AND' => array (
					'refKey' => $verse,
					'Content[!]' => ''
			)
	) );

	if ($listWD > 0) {
		return  '💚 '; //✅
	} else {
		return '💗';
	}
}


$tamilAbbr = array (
		'தொநூ' => 1,
		'விப' => 2,
		'லேவி' => 3,
		'எண்' => 4,
		'இச' => 5,
		'யோசு' => 6,
		'நீத' => 7,
		'ரூத்' => 8,
		'1சாமு' => 9,
		'2சாமு' => 10,
		'1அர' => 11,
		'2அர' => 12,
		'1குறி' => 13,
		'2குறி' => 14,
		'எஸ்ரா' => 15,
		'நெகே' => 16,
		'எஸ்' => 17,
		'யோபு' => 18,
		'திபா' => 19,
		'நீமொ' => 20,
		'சஉ' => 21,
		'இபா' => 22,
		'எசா' => 23,
		'எரே' => 24,
		'புல' => 25,
		'எசே' => 26,
		'தானி' => 27,
		'ஓசே' => 28,
		'யோவே' => 29,
		'ஆமோ' => 30,
		'ஒப' => 31,
		'யோனா' => 32,
		'மீக்' => 33,
		'நாகூ' => 34,
		'அப' => 35,
		'செப்' => 36,
		'ஆகா' => 37,
		'செக்' => 38,
		'மலா' => 39,
		'தோபி' => 40,
		'யூதி' => 41,
		'எஸ் (கி)' => 42,
		'சாஞா' => 43,
		'சீஞா' => 44,
		'பாரூ' => 45,
		'தானி (இ)' => 46,
		'1மக்' => 47,
		'2மக்' => 48,
		'மத்' => 49,
		'மாற்' => 50,
		'லூக்' => 51,
		'யோவா' => 52,
		'திப' => 53,
		'உரோ' => 54,
		'1கொரி' => 55,
		'2கொரி' => 56,
		'கலா' => 57,
		'எபே' => 58,
		'பிலி' => 59,
		'கொலோ' => 60,
		'1தெச' => 61,
		'2தெச' => 62,
		'1திமொ' => 63,
		'2திமொ' => 64,
		'தீத்' => 65,
		'பில' => 66,
		'எபி' => 67,
		'யாக்' => 68,
		'1பேது' => 69,
		'2பேது' => 70,
		'1யோவா' => 71,
		'2யோவா' => 72,
		'3யோவா' => 73,
		'யூதா' => 74,
		'திவெ' => 75
);
?>