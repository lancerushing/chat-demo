<?php

error_reporting(E_ALL | E_STRICT);

if (isset($_SERVER['PATH_INFO'] )) {
	$test_file_name = __DIR__ . '/routes' . $_SERVER['PATH_INFO'] . '.php';
	if(is_file($test_file_name)) {
		require_once $test_file_name;
		return ;
	}

}
return FALSE;