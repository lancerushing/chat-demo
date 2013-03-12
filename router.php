<?php

echo 'foo';

error_reporting(E_ALL | E_STRICT);

if (isset($_SERVER['REQUEST_URI'] )) {
	if ($_SERVER['REQUEST_URI'] === "/") {
		$_SERVER['REQUEST_URI'] = "/index";
	}
	$test_file_name = __DIR__ . '/routes' . $_SERVER['REQUEST_URI'] . '.php';
	if(is_file($test_file_name)) {
		require_once $test_file_name;
		return ;
	}

}

header("HTTP/1.0 404 Not Found");
echo "<h1>Not Found</h1>";
