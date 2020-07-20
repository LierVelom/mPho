<?php

define('ASSETS_PATH', __DIR__.'/assets');
define('MODULES_PATH', __DIR__.'/modules');
define('SYSTEM_PATH', __DIR__.'/system');

require(SYSTEM_PATH.'/config/config.php');
$config = new Config();

$segments = array(
	'module' => '',
	'page' => array()
);

$segments['module'] = empty($_GET['m']) ? MODULE_DEFAULT : $_GET['m'];

$segments['page'] = empty($_GET['p']) ? PAGE_DEFAULT : $_GET['p'];

require(__DIR__.'/modules/modules.php');

$modules = new Modules();
$modules->load($segments['module'], $segments['page']);