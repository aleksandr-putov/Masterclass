<?php

class model_db{

	private static $instance;
	public $DB;
	private function __construct(){

		//$this->DB = new PDO('mysql:host=localhost;dbname=not_yongsters_db', 'root');
		$this->DB = new PDO('mysql:host=localhost;dbname=master_class', 'root');
		$this->DB->exec("SET NAMES utf8");

	}

	public static function get_instance(){
		if (!isset(self::$instance))
			self::$instance = new model_db();
		return self::$instance;
	}

}

?>