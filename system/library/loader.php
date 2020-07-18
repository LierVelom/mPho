<?php

class Library_Loader{

	public function load($library, $data = array()){
		if(empty($this->{$library})){
			require_once SYSTEM_PATH . '/library/includes/'.$library.'.php';
			$this->{$library} = new $library($data);
		}
	}

}