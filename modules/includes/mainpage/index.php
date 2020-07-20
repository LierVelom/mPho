<?php

$layout = array(
	'title' => 'Trang Chủ',
	'description' => '',
	'keywords' => ''
);

$this->layout('default:header',$layout);

$this->template('mainpage','index');

$this->layout('default:footer');