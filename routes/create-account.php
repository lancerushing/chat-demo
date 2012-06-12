<?php

require_once 'lib/AccountVerifier.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$verifier = new AccountVerifier();
	$verifier->verifyInput($_POST);
	if (count($verifier->errors) === 0) {
		// create account
	} else {
		// show errors
		echo '<pre>';
		print_r($verifier->errors);
		die();
	}

}



?>
<!DOCTYPE html>
<html>
<head>
	<title>Please Create an Account</title>
</head>
<body>
	<h1>Create an Account</h1>

	<form action="/create-account" method="post">
		<label>First Name
			<input type="text" name="first_name">
		</label>
		<label>Last Name
			<input type="text" name="last_name">
		</label>
		<label>Email
			<input type="text" name="email">
		</label>
		<label>Password
			<input type="password" name="password1">
		</label>
		<label>Password Again
			<input type="password" name="password2">
		</label>

		<button type="submit">Create Account</button>

	</form>
</body>
</html>