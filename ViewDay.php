<?php
header ( 'Content-Type: text/html; charset=utf-8' );
include_once 'lib/TamilLectionary/TamilLectionary.php';
include_once 'lib/TamilLectionary/TamilLectionaryHTML.php';

$year = (isset ( $_GET ['y'] )) ? intval($_GET ['y']) : date ( "Y" );
$month = (isset ( $_GET ['m'] )) ? intval($_GET ['m']) : date ( "n" );
$date = (isset ( $_GET ['d'] )) ? intval($_GET ['d']) : date ( "j" );
$key = (isset ( $_GET ['k'] )) ? intval( $_GET ['k'] ) : 0;

$altReadings = (isset ( $_GET ['l'] )) ? intval($_GET ['l']) : 0;

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

<?php

$CalcGen = new TamilLectionary ( $year, parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );
$printer = new TamilLectionaryHTML ( $CalcGen->fullYear, $CalcGen->curYear );

if(isset ( $_GET ['commons'])){
	echo $printer->getCommons($_GET ['commons']);
}else{
	echo $printer->getDay ( $date, $month, $key, $altReadings );
}



?>