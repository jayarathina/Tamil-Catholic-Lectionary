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

?>