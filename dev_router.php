<?php

error_reporting(E_ALL | E_STRICT);

$test_file_name = __DIR__ . '/routes' . $_SERVER['REQUEST_URI'] . '.php';
if(is_file($test_file_name)) {
	require_once $test_file_name;
	return ;
}

return FALSE;