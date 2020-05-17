<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'lib/TamilLectionary/TamilLectionary.php';
include_once 'lib/TamilLectionary/TamilLectionaryUtil.php';
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="year.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
<body>
<table>
<?php
$year = date ( "Y" );

if (isset ( $_GET ['year'] )) {
	if (preg_match ( "/^(19|20)\d{2}$/", $_GET ['year'] ) == 1) { // Years between 1900-2099
		$year = $_GET ['year'];
	}
}

$CalcGen = new TamilLectionary ( $year, parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );

//Print year with previous and next links
$rows = "<tr><th colspan=3> <a class='arrowRight' href='index.php?year=" . ($year - 1) . "'>◄</a> $CalcGen->curYear <a class='arrowLeft' href='index.php?year=" . ($year + 1) . "'>►</a> </th></tr>";
foreach ( $CalcGen->fullYear as $month => $value ) {
	//Month Name
	$rows .= '<tr> <th colspan="3">' . TamilLectionaryUtil::$tamilMonthFull [$month] . '</th> </tr>';
	foreach ( $value as $days => $feasts ) {
		foreach ( $feasts as $key => $fet ) {
			$rows .= '<tr class="Col' . $fet ['color'] . '">';
			if ($key == 0) {
				$rows .= "<td class='dt' rowspan=" . sizeof ( $feasts ) . ">" . str_pad ( $days, 2, "0", STR_PAD_LEFT ) . "</td>";
			}
			
			$type = isset ( $fet ['type'] ) &&  $fet ['type'] !== 'All Souls' ? ' (' . TamilLectionaryUtil::$tamilFeastType [$fet ['type']] . ')' : '';
			
			$rows .= "<td class='col ColD{$fet ['color']}'></td>";
			$rows .= "<td><a class='dayTitle' href='ViewDay.php?d=$days&m=$month&y=$year&k=$key'>{$fet ['ta_name']}$type</a></td>";
			$rows .= '</tr>';
		}
	}
}
echo $rows;

?>

</table>
</body>