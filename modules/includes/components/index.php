<?php

$layout = [
	'title' => 'Trang Chủ',
	'description' => '',
	'keywords' => '',
	'css' => [
		'login'
	]
];

$this->layout('default:header',$layout);

$this->template('components','alert');
$this->template('components','badge');
$this->template('components','button');

$this->layout('default:footer');