<?php
include_once 'menu.php';
$ReadingListWD_ = $database->select ( 'readings__list', '*', array (
		'dayID[~]' => 'CW%' 
) );

$ReadingList = array ();

foreach ( $ReadingListWD_ as $key => $value ) {
	$ReadingList [$value ['dayID']] = $value;
}

$arrWeekDay = array (
		'0Sun',
		'1Mon',
		'2Tue',
		'3Wed',
		'4Thu',
		'5Fri',
		'6Sat' 
);
?>

<html>
<head>
<meta charset="utf-8">
<title>Tamil Catholic Lectonary</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<table cellspacing="0">
		<thead>
			<tr>
				<th>குறி</th>
				<th>முதல் வாச.</th>
				<th>பதிலுரை</th>
				<th>இரண்டாம் வாச.</th>
				<th>அல்லேலூயா</th>
				<th>நற்செய்தி</th>
			</tr>
		</thead>

		<tbody>
 
 <?php
	
	foreach ( $ReadingList as $Daykey => $ReadingVal ) {
		print_row ( $Daykey, $ReadingVal );
	}
	
	?>
		</tbody>
	</table>
</body>
</html>