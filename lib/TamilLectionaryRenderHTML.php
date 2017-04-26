<?php

/**
 * RomanLectionary 1.0
 * @author Br. Jayarathina Madharasan SDR
 */
include_once 'lib/TamilLectionaryUtil.php';
class TamilLectionaryRenderHTML {

	private $TLUtil;

	function __construct() {
		$this->TLUtil = new TamilLectionaryUtil ();
	}

	/**
	 *
	 * @param string $fileName
	 *        	- Name of the file generated by TamilLectionary Class
	 * @return string Feast listings formated as HTML code
	 */
	function renderHTML($fileName) {
		if (! file_exists ( $fileName ))  return '';
		
		$txtCnt = file_get_contents ( $fileName );
		$rcy = json_decode ( $txtCnt, true );
		
		$feastType = array (
				'Solemnity' => 'பெருவிழா',
				'Solemnity-PrincipalPartron-Place' => 'பெருவிழா',
				
				'Feast-Lord' => 'விழா',
				'Feast' => 'விழா',
				'Feast-PrincipalPartron-Place' => 'விழா',
				
				'Mem' => 'நினைவு',
				'OpMem' => 'வி.நினைவு',
				'Commomeration' => 'நினைவுக்காப்பு' 
		);
		
		$resultHTML = '<tr> <th colspan="8">' . $rcy ['currentYear'] . '</th> </tr>';
		$resultHTML .= '<tr>';
		$resultHTML .= '<th colspan="2">நாள் </th>';
		$resultHTML .= '<th>திருநாட்கள்</th>';
		$resultHTML .= '<th>முதல் வாசகம்</th>';
		$resultHTML .= '<th>பதிலுரைப் பாடல்</th>';
		$resultHTML .= '<th>இரண்டாம் வாசகம்</th>';
		$resultHTML .= '<th>நற்செய்திக்கு முன் வாழ்த்தொலி</th>';
		$resultHTML .= '<th>நற்செய்தி</th>';
		$resultHTML .= '</tr>';
		
		foreach ( $rcy ['fullYear'] as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				foreach ( $feasts as $fet ) {
					$dayHTML = '';
					
					$calendarSuffix = isset ( $fet ['calendar'] ) ? $rcy ['calcConfig'] ['calendarSuffix'] [$fet ['calendar']] . ' ' : ''; // Calendar suffix for feasts of particular calendar
					$type = isset ( $fet ['type'] ) && 'All Souls' !== $fet ['type'] ? " <small>($calendarSuffix{$feastType [$fet ['type']]})</small>" : ''; // Type of feast: Solemnity, feast etc.,
					
					$rowStart = "<tr><td class='dt'>" . $this->TLUtil->tamilMonthShort [$month] . ' ' . $days . "</td> <td class='col ColD{$fet ['color']}'></td>";
					
					if (isset ( $fet ['readingList_multiple'] )) { // Multiple readings for same event could be present like Christmas or vigil masses
						
						if ('LW06-6Sat' == $fet ['code'] || 'LW06-0Sun' == $fet ['code']) {
							// FIXME Palm sunday and Easter Vigil should have seperate links
							$readingListMultiple = $fet ['readingList_multiple'] [0];
							$rowHeading = "<td class='Col{$fet ['color']} dayTitle'><a href='viewDay.php?cdm={$readingListMultiple['dayID']}&yr={$rcy['currentYear']}'>{$readingListMultiple['name']} $type</a></td>";
							$dayHTML .= $rowStart . $rowHeading . '</tr>';
						} else
							
							foreach ( $fet ['readingList_multiple'] as $readingListMultiple ) {
								$dayID_Vigil = $readingListMultiple ['dayID'];
								$rowHeading = "<td class='Col{$fet ['color']} dayTitle'><a href='viewDay.php?cdm={$readingListMultiple['dayID']}&yr={$rcy['currentYear']}'>{$readingListMultiple['name']} $type</a></td>";
								$dayHTML .= $rowStart . $rowHeading . $this->processRow ( $fet ['color'], $readingListMultiple ) . '</tr>';
							}
					}
					
					$rowHeading = "<td class='Col{$fet ['color']} dayTitle'><a href='viewDay.php?cd={$fet ['code']}&yr={$rcy['currentYear']}'>{$fet ['name']}$type</a></td>";
					if (isset ( $fet ['readingList'] )) {
						$dayHTML .= $rowStart . $rowHeading . $this->processRow ( $fet ['color'], $fet ['readingList'] ) . '</tr>';
					} elseif (isset ( $fet ['readingList_Proper'] ['common'] )) { // No reading is mentioned in lectionary; Have to choose on on own from commons
						$dayHTML .= $rowStart . $rowHeading . $this->processRowSaintsCommon ( $fet ) . '</tr>';
					}
					$resultHTML .= $dayHTML;
				}
			}
		}
		return '<table>' . $resultHTML . '</table>';
	}

	/**
	 * Function to prepare table row of readings for a given day
	 */
	function processRow($dayCol, $readingsList) {
		// @formatter:off
		$readingListSection = array ('reading1', 'psalms', 'reading2', 'alleluia', 'gospel');
		// @formatter:on
		$rowTD = '';
		foreach ( $readingListSection as $readingListVal ) {
			$rowTD .= "<td class='Col$dayCol'>" . $this->processVerse ( $readingsList [$readingListVal] ) . '</td>';
		}
		return $rowTD;
	}

	/**
	 * Function to process saints feasts which do not have recomended reading mentioned in lectionary.
	 */
	function processRowSaintsCommon($fet) {
		$dayHTML = "<td  class='Col{$fet ['color']}' colspan='5'>";
		
		$saintsCommon = explode ( 'or', $fet ['readingList_Proper'] ['common'] );
		foreach ( $saintsCommon as &$saintsCommonVal ) {
			if ($GLOBALS ['IS_ADMIN']) {
				$saintsCommonVal = "<a href='saintsCommon.php?com={$saintsCommonVal}'>$saintsCommonVal - பொது</a>";
			} else {
				$saintsCommonVal = $saintsCommonVal . ' - பொது';
			}
		}
		$saintsCommon = implode ( ' <i>அல்லது</i> ', $saintsCommon );
		$dayHTML .= $saintsCommon . '</td>';
		return $dayHTML;
	}

	/**
	 * Sperates verses (if multiple are available), formats them and adds hyperlink to them.
	 *
	 * @param unknown $verse        	
	 * @return string
	 */
	function processVerse($verse) {
		$verse = explode ( 'அல்லது', $verse );
		
		foreach ( $verse as &$val ) {
			$fVerse = $this->TLUtil->formatVerseToPrint ( $val );
			if ($GLOBALS ['IS_ADMIN']) { // If admin then add hyperlink to edit
				$val = $this->isTheVerseEnteredinDB ( $val ) . "<a href='admin/edit.php?vs=$val'>$fVerse</a>";
			} else {
				$val = $this->isTheVerseEnteredinDB ( $val ) . $fVerse;
			}
		}
		
		$verse = implode ( '<br/>அல்லது<br/>', $verse );
		
		return $verse;
	}

	/**
	 *
	 * This function is tem function to check whether a perticular verse in entered in DB or not.
	 * This is a temporary function. And will be removed when the project has metured for production.
	 *
	 * @return void|string - If verse is entered, it returns a green heart emoji (💚) else a red one (💗).
	 *         This is displayed with color in the browser.
	 */
	function isTheVerseEnteredinDB($verse) {
		if (empty ( $verse ))
			return;
		return '';
		$database = new medoo ( array (
				'database_type' => 'mysql',
				'database_name' => 'liturgy_lectionary',
				'server' => 'localhost',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8' 
		) );
		
		$listWD = $database->count ( 'readings__text', '*', array (
				'AND' => array (
						'refKey' => $verse,
						'Content[!]' => '' 
				) 
		) );
		
		return $listWD == 0 ? '💗' : '💚 ';
	}
}