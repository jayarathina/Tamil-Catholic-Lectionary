<?php
if (! isset ( $_GET ['dayID'] )) {
	die ();
}
$settings = parse_ini_file ( 'lib/RomanCalendar/settings.ini' );

//TODO Get Name
//TODO Get Color
//TODO Get Readings

//FIXME RomanCalendar.php line 64 should not use DB directly. It should use dbconfig
?>