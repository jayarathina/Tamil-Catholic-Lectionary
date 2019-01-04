<?php
header('Content-Type: text/html; charset=utf-8');

include_once ('lib/RomanCalendar/RomanCalendar.php');
include_once ('lib/RomanCalendar/RomanCalendarRenderHTML_TA.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
<body>

<?php

$CalcGen = new RomanCalendar (2019, parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );

$rcYr = $CalcGen->rcy;

$rHTML = new RomanCalendarRenderHTML_TA ();
$rHTML->printYearHTML ( $rcYr );

?>