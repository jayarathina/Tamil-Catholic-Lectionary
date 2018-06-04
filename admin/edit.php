<?php
require_once ('../lib/TamilLectionaryUtil.php');

include_once 'menu.php';

$vers = '';

if (isset ( $_POST ['frmVrsEdit'] )) {
	print_r ( $_POST );

	if (! empty ( $_POST ['txtCnt'] )) {

		$txtC = $_POST ['txtCnt'];
		$txtC = str_replace ( 'br', '§', $txtC );

		$cnt = $database->update ( 'readings__text', array (
				'Content' => $txtC
		), array (
				'refKey' => trim ( $_POST ['verseID'] )
		) );

		if ($cnt == 0) {
			$database->insert ( 'readings__text', array (
					'Content' => trim ( $txtC ),
					'refKey' => trim ( $_POST ['verseID'] )
			) );
			echo 'INSERTED NEW ROW';
		} else {
			die ( 'Updated Successfully' );
		}
	}
}

if (isset ( $_GET ['vs'] )) {
	$vers = strip_tags ( $_GET ['vs'] );
}

$listWD = $database->get ( 'readings__text', '*', array (
		'refKey' => $vers
) );

$cnt = '';

if (isset ( $listWD ['Content'] )) {
	$cnt = $listWD ['Content'];
} elseif (isset ( $_GET ['vs'] )) {

	$ver = (new TamilLectionaryUtil ())->formatVerseToPrint ( $vers );

	if (strpos ( $ver, ' ', 1 ) === 1) {
		$ver = substr_replace ( $ver, '', 1, 1 );
	}
	$pieces = explode ( ' ', $ver, 2 );

	$bk = $tamilAbbr [$pieces [0]];

	$chvs = explode ( ':', $pieces [1] );
	$ch = $chvs [0];

	$chvs = explode ( '-', $chvs [1] );

	if (sizeof($chvs) == 2 && is_numeric ( $chvs [0] . $chvs [1] )) {
		$vsSt = str_pad ( $bk, 2, '0', STR_PAD_LEFT ) . str_pad ( $ch, 3, '0', STR_PAD_LEFT ) . str_pad ( trim ( $chvs [0] ), 3, '0', STR_PAD_LEFT );
		$vsEn = str_pad ( $bk, 2, '0', STR_PAD_LEFT ) . str_pad ( $ch, 3, '0', STR_PAD_LEFT ) . str_pad ( trim ( $chvs [1] ), 3, '0', STR_PAD_LEFT );
	} else {
		$vsSt = 0;
		$vsEn = 0;
	}
	include_once '../lib/dbConfig.php';

	$database = new Medoo ( array (
			'database_type' => 'mysql',
			'database_name' => 'liturgy_bible',
			'server' => 'localhost',
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset' => 'utf8',
			'prefix' => ''
	) );

	$readText = $database->select ( 't_verses', 'verse', [
			"id[<>]" => [
					$vsSt,
					$vsEn
			]
	] );

	$readText = implode ( ' ', $readText );
	// @formatter:off
	$readText = str_replace ( ['⁽','⁾','⒯', '⒣','␢', '❮', '❯','₍', '₎', '⦃', '⦄', '⦅', '⦆', '␢', 'Same as above', '*'], '', $readText );
	// @formatter:on
	$readText = str_replace ( '⒫', "\r\n§", $readText );
	$readText = str_replace ( '§ ', "§", $readText );

	$readText = preg_replace ( '!\s+!', ' ', $readText );

	$readText = trim ( $readText, '§' );
	$readText = trim ( $readText );

	$cnt = $readText;
}

?>
“ ” ‘ ’ ℣ ℟ § ⒫ அக்காலத்தில்

<form action="edit.php" method="post">
	Verse ID: <input type="text" name="verseID" value='<?=$vers?>'><br>

	<textarea name='txtCnt' style="height: 500px;"><?=$cnt?></textarea>
	<br> <input type="submit" name='frmVrsEdit'>
</form>

<style>
textarea {
	border: 1px solid #999999;
	width: 98%;
	margin: 5px 0;
	padding: 1%;
}
</style><?php

?>