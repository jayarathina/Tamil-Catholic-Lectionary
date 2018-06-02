<?php
header ( 'Content-Type: text/html; charset=utf-8' );
include_once 'lib/TamilLectionarySingleDay.php';
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/style_day.css">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="Daily Mass Reading in Tamil">
		<meta name="keywords" content="Tamil Lectionary, Tamil Catholic, Tamil Mass Reading">
		<meta name="author" content="Jayarathina Madarasan">
	</head>
<body>
<?php 
if (! isset ( $_GET ['cd'] ) || ! isset ( $_GET ['dt'] )) {
	die ();
}

$dayCode = $_GET ['cd'];
$cDate = $_GET ['dt'];

$singleDay = new TamilLectionarySingleDay(parse_ini_file ( 'settings.ini' ));

echo $singleDay->printDayReading($dayCode, $cDate);

?>
</body>
</html>