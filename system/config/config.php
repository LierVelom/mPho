<?php

define('_URL_','http://localhost');
define('MODULE_DEFAULT','mainpage');
define('PAGE_DEFAULT','index');

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','mpho');

class Config {

	public $library;
	public $helper;
	public $token;
	public $template;

	public function __construct(){

		require SYSTEM_PATH.'/config/csrf_token.php';
		$this->token = new Csrf_Token();

		require SYSTEM_PATH.'/library/loader.php';
		$this->library = new Library_Loader();

		require SYSTEM_PATH.'/helper/loader.php';
		$this->helper = new Helper_Loader();

	}

}