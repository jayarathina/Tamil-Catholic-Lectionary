<?php
header ('Content-Type: text/html; charset=utf-8' );
include_once 'lib/TamilLectionary/TamilLectionary.php';
include_once 'lib/TamilLectionary/TamilLectionaryHTML.php';

$cDateF = new DateTime ();
if (isset ( $_GET ["dt"] )) {
	try {
		$cDateF = new DateTime ( $_GET ["dt"] );
	}
	catch(Exception $e) {
		$cDateF = new DateTime ();
	}
}

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

$CalcGen = new TamilLectionary ( $cDateF->format ( 'Y' ), parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );
$printer = new TamilLectionaryHTML ( $CalcGen->fullYear, $CalcGen->curYear );

if(isset ( $_GET ['commons'])){
	echo $printer->getCommons($_GET ['commons']);
}else{
	echo $printer->getDay ( $cDateF->format ( 'j' ), $cDateF->format ( 'n' ), $key, $altReadings );
}



?>