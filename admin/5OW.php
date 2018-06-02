<?php
require_once ('../mods/medoo.php');
include_once 'menu.php';

// Prefix 'general' is added to table name to avoid unnecessary securtiy risk
$ReadingListWD_ = $database->select ( 'readings__list', '*', array (
		'dayID[~]' => 'OW%'
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
	
	$Daykeys = array ();
	
	for($wkNo = 1; $wkNo < 35; $wkNo ++) {
		$dayNo = ($wkNo == 1)?1:0;
		for(; $dayNo < 7; $dayNo ++) {
			$Daykey = 'OW' . str_pad ( $wkNo, 2, '0', STR_PAD_LEFT ) . '-' . $arrWeekDay [$dayNo];
			$dayisset = false;
			if (isset ( $ReadingList [$Daykey] )) {
				array_push ( $Daykeys, $Daykey );
				$dayisset = true;
			}
			for($charNo = 65; $charNo < 68; $charNo ++) {
				$Daykey2 = $Daykey . ' ' . chr ( $charNo );
				if (isset ( $ReadingList [$Daykey2] )) {
					array_push ( $Daykeys, $Daykey2 );
					$dayisset = true;
				}
			}
			
			for($yearNo = 1; $yearNo < 3; $yearNo ++) {
				$Daykey2 = $Daykey . ' ' . $yearNo;
				if (isset ( $ReadingList [$Daykey2] )) {
					array_push ( $Daykeys, $Daykey2 );
					$dayisset = true;
				}
			}
			if (! $dayisset) {
				echo ( 'UHHHHH???' . $Daykey);
			}
		}
	}
	
	foreach ( $Daykeys as $Daykey ) {
		$ReadingVal = $ReadingList [$Daykey];
		print_row ( $Daykey, $ReadingVal );
		unset ( $ReadingList [$Daykey] );
	}
	
	foreach ( $ReadingList as $Daykey => $ReadingVal ) {
		print_row ( $Daykey, $ReadingVal );
	}
	
	?>
		</tbody>
	</table>
</body>
</html>