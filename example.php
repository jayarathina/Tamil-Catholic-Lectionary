<?php
header('Content-Type: text/html; charset=utf-8');

$IS_ADMIN = ! TRUE;

include_once 'lib/TamilLectionary.php';
include_once 'lib/TamilLectionaryRenderHTML.php';

?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" type="text/css" href="styles/style_year.css">
	</head>
<body>
<?php

$tamilLect = new TamilLectionary (null, parse_ini_file ( 'settings.ini' ) );

$RenderHTML = new TamilLectionaryRenderHTML();

echo $RenderHTML->renderHTML($tamilLect->rcy);

?>