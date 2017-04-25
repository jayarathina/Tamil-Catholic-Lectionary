<?php
header ( 'Content-Type: text/html; charset=utf-8' );
$time_start = microtime ( true );
$IS_ADMIN = ! TRUE;
$IS_ADMIN = TRUE;

include_once 'lib/TamilLectionary.php';
include_once 'lib/TamilLectionaryRenderHTML.php';
// @formatter:off
?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="styles/style_year.css">
</head>
<body>
<?php
// @formatter:on
$tamilLect = new TamilLectionary ();
$filePath = $tamilLect->computeReadings( null, parse_ini_file ( 'settings.ini' ) );

$RenderHTML = new TamilLectionaryRenderHTML ();
echo $RenderHTML->renderHTML ($filePath);
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
?>