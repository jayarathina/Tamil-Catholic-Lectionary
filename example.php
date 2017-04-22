<?php
header('Content-Type: text/html; charset=utf-8');

include_once 'lib/TamilLectionary.php';

?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>
<body>
<pre>
<?php

$tamilLect = new TamilLectionary (2016, parse_ini_file ( 'settings.ini' ) );

?>