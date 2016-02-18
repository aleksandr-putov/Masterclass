<?php

class model_db{

	private static $instance;
	public $DB;
	private function __construct(){

		//$this->DB = new PDO('mysql:host=localhost;dbname=not_yongsters_db', 'root');
		$this->DB = new PDO('mysql:host=localhost;dbname=srv26364_young', 'srv26364_mcadmin', 'mcb8419a');
		$this->DB->exec("SET NAMES utf8");
	}

	public static function get_instance(){
		if (!isset(self::$instance))
			self::$instance = new model_db();
		return self::$instance;
	}

}

?>