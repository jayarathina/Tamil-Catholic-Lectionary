<?php
require_once ('../mods/medoo.php');
include_once 'menu.php';

if(! isset($_GET['cd'])){
	die();
}

$ReadingList = $database->select ( 'readings__list', '*', array (
		'dayID[~]' => $_GET['cd'] . '%'
) );
echo '<pre>';
print_r($ReadingList);
echo '</pre>';

foreach ($ReadingList as $value) {

echo '<table>';
print_row ($_GET['cd'], $value );
echo '</table>';

}