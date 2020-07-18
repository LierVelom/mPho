<?php

class Helper_Loader{
	public function load($helper){
		require_once SYSTEM_PATH . '/helper/includes/'.$helper.'.php';
	}
}