<?php

$layout = [
	'title' => 'Đăng nhập mPho',
	'description' => '',
	'keywords' => '',
	'css' => [
		'login'
	]
];

if($this->is_logged_in){
	header('location:/home');
}

$this->layout('default:header',$layout);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['user']) OR empty($_POST['password']) OR !isset($_POST['user']) OR !isset($_POST['password'])){
		$this->error = 'Vui lòng nhập đầy đủ thông tin';
	} else {
		$user = strip_tags(addslashes($_POST['user']));
		$password = strip_tags(addslashes($_POST['password']));
		$check = $this->db->query('SELECT `password`,`salt`,`id` FROM `users` WHERE `email` = "'.$user.'" OR `account_name` = "'.$user.'"');
		if($check->num_rows != 0){
			$check = $check->fetch_array();
			if(password_verify($password, $check['password'])){
				
				@session_start();
				$_SESSION['user_id'] = $check['id'];

				if(isset($_POST['remember'])){
					setcookie('uli',$check['id'].'%'.md5($check['password'].$check['salt']),time()+60*60*24*30,'/'); // User Login Information
				}

			} else {
				$this->error = 'Mật khẩu không chính xác';
			}
		} else {
			$this->error = 'Tài khoản không tồn tại';
		}
	}
}

$this->template('login','index');

$this->layout('default:footer');