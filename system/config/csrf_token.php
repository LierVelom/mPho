<?php

class Csrf_Token {

	private $_csrf_token_name = 'cms-token-name';
	private $_csrf_token_value;

	public function __construct(){

		$this->create();
		$this->check();

	}

	private function create(){
		@session_start();
		if(!isset($_SESSION[$this->_csrf_token_name])){
			$this->_csrf_token_value = bin2hex(random_bytes(32));
			$_SESSION[$this->_csrf_token_name] = $this->_csrf_token_value;
		}
	}

	private function check(){
		@session_start();
		if($_SERVER['REQUEST_METHOD'] == 'POST'/* OR $_SERVER['REQUEST_METHOD'] == 'GET'*/){
			$method = '_'.$_SERVER['REQUEST_METHOD'];
			if(!isset($_SESSION[$this->_csrf_token_name]) OR !isset(${$method}[$this->_csrf_token_name])){
				die('Invalid Token ');
			} else if($_SESSTION[$this->_csrf_token_name] != ${$method}[$this->_csrf_token_name]){
				die('Invalid Token');
			}
		}
	}

	public function get($type){
		return $this->{'_csrf_token_'.$type};
	}

}