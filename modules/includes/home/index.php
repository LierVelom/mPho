<?php

$layout = [
	'title' => 'Mỹ Phố',
	'description' => '',
	'keywords' => ''
];

$this->layout('default:header',$layout);

$this->template('home','index');

$this->layout('default:footer');
