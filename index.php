<?php

define('ASSETS_PATH', __DIR__.'/assets');
define('MODULES_PATH', __DIR__.'/modules');
define('SYSTEM_PATH', __DIR__.'/system');

require(SYSTEM_PATH.'/config/config.php');
require(__DIR__.'/modules/modules.php');

$modules = new Modules();

$segments = array(
	'module' => '',
	'page' => '',
	'action' => array()
);

$modules->database();
$modules->info_user();

if($modules->is_logged_in){
	$segments['module'] = empty($_GET['m']) ? MODULE_DEFAULT : $_GET['m'];
} else {
	$segments['module'] = empty($_GET['m']) ? 'login' : $_GET['m'];
}

$segments['page'] = empty($_GET['p']) ? PAGE_DEFAULT : $_GET['p'];

$modules->load($segments['module'], $segments['page']);