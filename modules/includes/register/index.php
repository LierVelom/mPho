<?php

$layout = [
	'title' => 'Tạo tài khoản Mỹ Phố',
	'description' => '',
	'keywords' => '',
	'css' => [
		'register'
	]
];

if($this->is_logged_in){
	header('location:/');
}

$this->layout('default:header',$layout);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	$this->error = array();

	if(isset($_POST['email']) AND isset($_POST['account']) AND isset($_POST['name']) AND isset($_POST['password']) AND isset($_POST['repassword']) AND isset($_POST['gender']) AND isset($_POST['captcha'])){

		$email = strip_tags(addslashes($_POST['email']));
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$this->error['email'] = 'Địa chỉ email không hợp lệ';
		}

		$account = strip_tags(addslashes($_POST['account']));
		if(!preg_match('/^[a-zA-Z0-9\_]{5,32}$/',$account)){
			$this->error['account'] = 'Tên tài khoản từ 5-32 ký tự, chỉ gồm các chữ cái tiếng Anh, số và dấu _';
		} else {
			if($this->db->query('SELECT `id` FROM `users` WHERE `account_name` = "'.$account.'"')->num_rows > 0){
				$this->error['account'] = 'Tên tài khoản đã được dụng, vui lòng chọn tên tài khoản khác';
			}
		}

		$name = strip_tags(addslashes($_POST['name']));
		if(mb_strlen($name) < 5 OR mb_strlen($name) > 20){
			$this->error['name'] = 'Bút danh phải từ 5-20 ký tự';
		}

		$password = strip_tags(addslashes($_POST['password']));
		$repassword = strip_tags(addslashes($_POST['repassword']));
		if(mb_strlen($password) < 8 OR mb_strlen($password) > 32){
			$this->error['password'] = 'Mật khẩu có độ dài từ 8-32 ký tự';
		} else {
			if($password !== $repassword){
				$this->error['repassword'] = 'Mật khẩu không trùng khớp';
			}
		}

		$gender = strip_tags(addslashes($_POST['gender']));
		if(!is_numeric($gender) OR $gender > 3 OR $gender < 0){
			$this->error['gender'] = 'Vui lòng chọn đúng đồng loại!';
		}

		$captcha = strip_tags(addslashes(strtolower($_POST['captcha'])));
		if($captcha != strtolower($_SESSION['captcha'])){
			$this->error['captcha'] = 'Mã xác nhận không chính xác';
		}

		if(count($this->error) == 0){
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$browser = addslashes($_SERVER['HTTP_USER_AGENT']);
			$salt = bin2hex(random_bytes(64));

			$user_set = [
				'coin' => 100,
				'voucher' => 0,
				'vip' => 0
 			];

 			$insert = $this->db->query('INSERT INTO `users` SET 
 				`ip` = "'.$this->ip.'",
 				`email` = "'.$email.'",
 				`account_name` = "'.$account.'",
 				`password` = "'.$hashed_password.'",
 				`salt` = "'.$salt.'"
 				`name` = "'.$name.'",
 				`rights` = 0,
 				`gender` = "'.$gender.'",
 				`browser` = "'.$browser.'",
 				`created_at` = now()
 			');

 			header('location:/login&a');

		}

	} else {

		$this->error[] = 'Vui lòng điền đầy đủ thông tin';

	}

}

$this->template('register','index');

$this->layout('default:footer');