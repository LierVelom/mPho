<?php


class Csrf_Token {

	private $_csrf_token_name = 'cms-token-name';
	private $_csrf_token_value = NULL;

	public function __construct(){

		$this->create_token();
		$this->check_token();

	}

	private function create_token(){
		@session_start();
		if(!isset($_SESSION[$this->_csrf_token_name])){
			$this->_csrf_token_value = bin2hex(random_bytes(64));
			$_SESSION[$this->_csrf_token_name] = $this->_csrf_token_value;
		} else {
			$this->_csrf_token_value = $_SESSION[$this->_csrf_token_name];
		}
	}

	private function check_token(){
		@session_start();
		if($_SERVER['REQUEST_METHOD'] == 'POST'/* OR $_SERVER['REQUEST_METHOD'] == 'GET'*/){
			if(!isset($_SESSION[$this->_csrf_token_name]) OR !isset($_POST[$this->_csrf_token_name])){
				die('Invalid Token 1'.$_POST[$this->_csrf_token_name]);
			} else if($_SESSION[$this->_csrf_token_name] != $_POST[$this->_csrf_token_name]){
				die('Invalid Token');
			}
			// Limit access
			// if(isset($_COOKIE['ltp']) AND $_COOKIE['ltp'] == 1){
			// 	// echo print_r(isset($_COOKIE['ltp']));
			// 	setcookie('ltp',1,5,'/'); // Limit time post
			// 	$_SESSION['ltp_times'] = 1;
			// } else {
			// 	if(isset($_SESSION['ltp_times;']$_SESSION['ltp_times'] > 20){
			// 		die('Limited time access');
			// 		setcookie('bltu',1,10,'/');
			// 	} else {
			// 		$ltp = (int)$_SESSION['ltp_times'] + 1;
			// 		$_SESSION['ltp_times'] = $ltp;
			// 		setcookie('ltp',1,5,'/');
			// 	}
			// }
			// echo $_SESSION['ltp_times'];
			// if(isset($_COOKIE['bltu'])){
			// 	die('Limited time access');
			// }
		}
	}

	public function get($type){
		return $this->{'_csrf_token_'.$type};
	}	

}