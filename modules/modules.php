<?php

class Modules extends Config {

	// public $library = NULL;
	// public $helper =  NULL;
	// public $token = NULL;
	// public $ip =  NULL;

	protected $db = NULL;
	public $is_logged_in = false;

	public function load($module,$page){
		
		$module_path = MODULES_PATH.'/includes/'.$module.'/'.$page.'.php';

		if(file_exists($module_path)){

			require $module_path;

		} else {
			die('Can\'t find module '.$module_path);
		}
	}

	public function database(){

		require_once SYSTEM_PATH.'/config/database.php';

	}

	public function info_user(){

		if(isset($_SESSION['user_id'])){
			$user_id = strip_tags(addslashes($_SESSION['user_id']));
			$check = $this->db->query('SELECT `id` FROM `users` WHERE `id` = "'.$user_id.'"');
			if($check->num_rows == 0){
				unset($_SESSION['user_id']); 
			} else {
				$this->is_logged_in = true;
			}
		} else {
			if(!isset($_COOKIE['uli']) OR $_COOKIE['uli'] == NULL){
				
			} else {
				$cookie_data = explode('%',$_COOKIE['uli']);
				// echo var_dump($cookie_data);
				$get_from_id = $this->db->query('SELECT `password`,`salt` FROM `users` WHERE `id` = "'.$cookie_data[0].'"');
				if($get_from_id->num_rows > 0){
					$user_secure = $get_from_id->fetch_assoc();
					if($cookie_data[1] === md5($user_secure['password'].$user_secure['salt'])){
						$this->is_logged_in = true;
						$_SESSION['user_id'] = $cookie_data[0];
					} else {
						unset($_COOKIE['uli']);
						setcookie('uli','',-1*time()+60*60*24*30);
					}
				}
			}
		}

		if($this->is_logged_in){
			$user_id = strip_tags(addslashes($_SESSION['user_id']));
			$this->user = $this->db->query('SELECT `id`,`ip`,`browser`,`verification`,`email`,`account_name`,`name`,`rights`,`gender`,`coin`,`voucher`,`level`,`exp`,`opr`,`cc`,`vip` FROM `users` WHERE `id` = "'.$user_id.'"');
		}

	}

	public function template($module,$page){
		$path = MODULES_PATH .'/templates/'.$module.'/'.$page.'.phtml';
		if(file_exists($path)){
			require $path;
		} else {
			return 'Invaild Templates'.$page;
		}
	}

	public function asset($type,$file){

		return __URL__ . '/assets/'.$type.'/'.$file;

	}

	public function layout($set,$data = array()){

		$set = explode(':', $set);

		include MODULES_PATH . '/layout/'.$set[0].'/'.$set[1].'.phtml'; 

	}

}