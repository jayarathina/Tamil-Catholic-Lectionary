<?php
/**
 * RomanLectionary 1.0
 * @author Br. Jayarathina Madharasan SDR
 */
require_once 'mods/Medoo.php';
include_once '../Roman-Calendar/Lib/RomanCalendar.php'; //This is roman calendar library available at: https://github.com/jayarathina/Roman-Calendar
include_once 'lib/FeastNameFramer.php';

class TamilLectionary {

	public $rcy;

	private $database;

	function __construct($year = null, $calcConfig) {
		$this->database = new medoo ( array (
				'database_type' => 'mysql',
				'database_name' => 'liturgy_lectionary',
				'server' => 'localhost',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8' 
		) );
				
		$rc = new RomanCalendar ($year, $calcConfig );
		
		$setNames = new FeastNameFramer($this->database);
		
		$this->rcy = $setNames->setDayNames($rc->rcy);
		
		print_r ( $this->rcy->fullYear );
	}

}