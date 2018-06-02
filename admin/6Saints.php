<?php
require_once ('../mods/medoo.php');
include_once 'menu.php';

// Prefix 'general' is added to table name to avoid unnecessary securtiy risk
$ReadingList = $database->select ( 'generalcalendar__saintscommon', '*');

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
				<th>வாச.</th>
				<th>பகுப்பு.</th>
			</tr>
		</thead>

		<tbody>
 
 <?php
	
 foreach ($ReadingList as $value) {
 	echo '<tr>';
 	echo '<td>'.$value['dayID'].'</td>';
 	echo '<td>'.check_verse_all( $value['refKey']) . "<a href='edit.php?vs={$value['refKey']}'>{$value['refKey']}</a>" .'</td>';
 	echo '<td>'.$value['Category'].'</td>';
 	echo '</tr>';
 }
	?>
		</tbody>
	</table>
</body>
</html>