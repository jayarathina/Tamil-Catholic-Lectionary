<?php
header ( 'Content-Type: text/html; charset=utf-8' );

include_once 'lib/TamilLectionarySingleDay.php';
?>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="styles/style_day.css">
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