<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'lib/TamilLectionary/TamilLectionary.php';
include_once 'lib/TamilLectionary/TamilLectionaryHTML.php';

$year = date ( "Y" );
if (isset ( $_GET ['y'] )) {
	$year2 = $_GET ['y'];
}


$year = (isset ( $_GET ['y'] )) ? $_GET ['y'] : date ( "Y" );
$month = (isset ( $_GET ['m'] )) ? $_GET ['m'] : date ( "n" );
$date = (isset ( $_GET ['d'] )) ? $_GET ['d'] : date ( "j" );
$key = (isset ( $_GET ['k'] )) ? $_GET ['k'] : 0;

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
<body>

<?php
$CalcGen = new TamilLectionary ($year, parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );
$printer = new TamilLectionaryHTML($CalcGen->fullYear, $CalcGen->curYear);



echo $printer->getDay($date, $month, $key); 
?>