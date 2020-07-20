<?php

class Database {

	public $is_logged;

	public function __construct(){

		if(!$this->connect()){
			die('Unable to connect database');
		}

	}

	private function connect(){

		$mysqli = new Mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME );

		if($mysqli->connect_errno){

			return false;

		} else {

			return true;

		}

	}

}