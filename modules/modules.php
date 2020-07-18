<?php

class Modules {

	public function load($module,$page){
		
		$module_path = MODULES_PATH.'/includes/'.$module.'/'.$page.'.php';

		if(file_exists($module_path)){

			require $module_path;

		} else {
			die('Can\'t find module '.$module_path);
		}
	}

	public function template($module,$page){
		$path = MODULES_PATH .'/templates/'.$module.'/'.$page.'.phtml';
		if(file_exists($path)){
			include $path;
		} else {
			return 'Invaild Templates'.$page;
		}
	}

	public function assets($type,$file){}

}