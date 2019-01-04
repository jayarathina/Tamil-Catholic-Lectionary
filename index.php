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

Please not that this is a work in progress.<br/>
 💚 - Denotes Text has been entered in DB<br/>
 💗 - Text is yet to be entered.<br/>
 
 You can help too. Please Contact me if you can spare a couple of minutes. All you need to do is copy and paste. 😉


<?php
// Test Cases
// 2019 Immaculate conception on sunday
// 2018 annunciaion during holy week
// 1967 st joseph during holy week
// 2017 St. Joseph during lent sunday
// 2014 Immaculate Hrt coincided with Saint Irenaeus, 28 June
// 2015 Immaculate Hrt coincided with Saint Anthony of Padua, 13 June

$CalcGen = new RomanCalendar (2019, parse_ini_file ( 'lib/RomanCalendar/settings.ini' ) );

$rcYr = $CalcGen->rcy;

$rHTML = new RomanCalendarRenderHTML_TA ();
$rHTML->printYearHTML ( $rcYr );

?>