<?php

require_once ('../mods/medoo.php');
require_once ('../lib/TamilLectionaryUtil.php');
include_once 'menu.php';

$vers = '';

if(isset($_POST['frmVrsEdit'])){
	print_r($_POST);
	
	if(!empty($_POST['txtCnt'])){
		
		$cnt = $database->update('readings__text', array('Content' => $_POST['txtCnt']), array (
				'refKey' => trim( $_POST['verseID'] ),
		));
		
		if($cnt == 0){
			$database->insert('readings__text', array(
					'Content' => trim($_POST['txtCnt']),
					'refKey' => trim($_POST['verseID'])));
			echo 'INSERTED NEW ROW';
		}else{
			echo 'Updated Successfully';
		}
		
	}
	
	
}

if(isset($_GET['vs'])){
	$vers = strip_tags($_GET['vs']);
}




$listWD = $database->get ( 'readings__text', '*', array (
				'refKey' => $vers,
) );

$cnt = '';

if(isset($listWD['Content'])){
	$cnt = $listWD['Content'];
}else{
	
	$ver = $vers;
	
	
	
	$TLUtil = new TamilLectionaryUtil ();
	
	echo $TLUtil->formatVerseToPrint( $ver );
	
	if (strpos ( $ver, ' ', 1 ) === 1) {
		$ver = substr_replace ( $ver, '', 1, 1 );
	}
	$pieces = explode ( ' ', $ver, 2 );
	
	
	//lib\TamilLectionaryUtil.php
	
}


















?>
“ ” ‘ ’ ℣ ℟ § ⒫

<form action="edit.php" method="post">
 Verse ID: <input type="text" name="verseID" value='<?=$vers?>'><br>
 
 <textarea name='txtCnt' style="height: 500px;"><?=$cnt?></textarea><br>
 
<input type="submit" name='frmVrsEdit'>
</form>

<style>

textarea
{
    border:1px solid #999999;
    width:98%;
    margin:5px 0;
    padding:1%;
}

</style>