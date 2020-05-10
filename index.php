<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'lib/TamilLectionary/TamilLectionary.php';
include_once 'lib/TamilLectionary/TamilLectionaryHTML.php';

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
<body>

<?php

$CalcGen = new TamilLectionary (date("Y"), parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );

/* * /
print_r($CalcGen->fullYear);
die();
/* */

$printer = new TamilLectionaryHTML($CalcGen->fullYear);

echo $printer->getDay(29, 3);


?>