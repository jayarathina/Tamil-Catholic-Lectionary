<?php
header ( 'Content-Type: text/html; charset=utf-8' );
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

Please not that this is a work in progress.<br/>
 💚 - Denotes Text has been entered in DB<br/>
 💗 - Text is yet to be entered.<br/>
 
 You can help too. Please Contact me if you can spare a couple of minutes.


<?php
// @formatter:on
$time_start = microtime ( true );

$tamilLect = new TamilLectionary ();
$filePath = $tamilLect->computeReadings( null, parse_ini_file ( 'settings.ini' ) );

$RenderHTML = new TamilLectionaryRenderHTML ();
echo $RenderHTML->renderHTML ($filePath);

echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
?>