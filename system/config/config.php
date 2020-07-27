<?php

define('__URL__','http://localhost');
define('MODULE_DEFAULT','home');
define('PAGE_DEFAULT','index');

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','mpho');

class Config {

	public $library = NULL;
	public $helper =  NULL;
	public $token = NULL;
	public $ip =  NULL;

	public function __construct(){

		require SYSTEM_PATH.'/config/csrf_token.php';
		$this->token = new Csrf_Token();

		require SYSTEM_PATH.'/library/loader.php';
		$this->library = new Library_Loader();

		require SYSTEM_PATH.'/helper/loader.php';
		$this->helper = new Helper_Loader();

		$this->getIPaddress();

	}

	public function getIPaddress(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		$this->ip = $ipaddress;
	}

}