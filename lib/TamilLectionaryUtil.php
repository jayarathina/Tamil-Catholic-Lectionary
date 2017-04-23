<?php
class TamilLectionaryUtil {
	function function_name() {
		;
	}
	
	/**
	 * Lectionary reading are stored in DB without space. Hence they are formatted before displaying/printing them. 
	 * @param string $verse - Verse to be formated. Eg: 1 சாமு 2: 1. 4 - 5. 6 - 7. 8
	 * @return string - Formated Verse. Eg: 1 சாமு 2: 1. 4 - 5. 6 - 7. 8
	 */
	function formatVerseToPrint($verse) {
		$rt = trim ( $verse );
		
		$rt = preg_replace ( '/(\.)/', '${1} ', $rt, -1, $count );
		if($count === 0){//If there is a dot '.' it means it is responsorial verse.
			$rt = preg_replace ( '/(,)/', '${1} ', $rt );
		}
		
		//Not the eligant way to code this. But hey! It gets work done....
		$rt = preg_replace ( '/(;)/', '${1} ', $rt );//Space after semi colon
		$rt = preg_replace ( '/(காண்க)/', ' ${1} ', $rt );
		$rt = preg_replace ( '/(\d+:)/', ' ${1} ', $rt );//Space after chapter number and colon
		$rt = preg_replace ( '/^(\d+)/', '${1} ', $rt );//Space after digits at start of verse eg: 1சாமு
		$rt = preg_replace ( '/(\()/', ' ${1}', $rt );// Space before ( -> எஸ் (கி)
		$rt = preg_replace('/\s\s+/', ' ', $rt);//Excess space
		return $rt;
	}
	
}