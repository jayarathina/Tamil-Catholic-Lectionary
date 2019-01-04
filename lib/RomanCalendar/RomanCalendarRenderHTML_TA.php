<?php

/**
 * RomanCalendar 3.0
 * @author Br. Jayarathina Madharasan SDR
 *
 * The data for a single year is processed and displayed in html format.
 * 
 */

include_once 'lib/TamilLectionary/FeastNameFramer.php';

class RomanCalendarRenderHTML_TA {
	private $rcy;
	function printYearHTML(RomanCalendarYear $rcy) {
		
		$fnf = new FeastNameFramer();
		
		$this->rcy = $rcy;
		
		//$this->setDayNames ();
		
		$rows = '<tr> <th colspan="3">' . $rcy->currentYear . '</th> </tr>';
		foreach ( $this->rcy->fullYear as $month => $value ) {
			foreach ( $value as $days => $feasts ) {
				$tempDt2 = new DateTime ( $rcy->__get ( 'currentYear' ) . "-$month-$days" );
				foreach ( $feasts as $fet ) {
					$feastName = $fnf->getSingleTitle($fet ['code'], $rcy->calcConfig ['feastSettings'] ['EPIPHANY_ON_A_SUNDAY'], $rcy->calcConfig ['calendars']);
					
					$rows .= '<tr class="Col' . $fet ['color'] . '">';
					$rows .= '<td class="dt">' . $tempDt2->format ( 'd M' ) . '</td>';
					$type = isset ( $fet ['type'] ) ? ' (' . $fet ['type'] . ')' : '';
					$rows .= '<td class="col ColD' . $fet ['color'] . '"></td><td class="dayTitle">' . $feastName . $type . '</td>';
					$rows .= '</tr>';
				}
			}
		}
		echo "<table>$rows</table>";
	}
	
	/**
	 * Set names in the place of codes.
	 * This has to be language specific. Here an english language example is given.
	 * For feast names, one has to derive it from the database. For weekday codes names can be set here.
	 */
	function setDayNames() {
		foreach ( $this->rcy->fullYear as $monthVal => $dateList ) {
			foreach ( $dateList as $datVal => $dayFeastList ) {
				
				foreach ( $dayFeastList as $feastIndex => $singleFeas ) {
					
					if (preg_match ( "/^[C|L|E|O|A]W\d{2}-/", $singleFeas ['code'] ) === 1) {
						$this->rcy->fullYear [$monthVal] [$datVal] [$feastIndex] ['name'] = $this->getSingleTitle ( $singleFeas ['code'] );
					} else {
						// Localization has to be done here. Depending upon the requirement, get data even from database.
						$this->rcy->fullYear [$monthVal] [$datVal] [$feastIndex] ['name'] = $singleFeas ['code'];
					}
				}
			}
		}
	}
}

?>