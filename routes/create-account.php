<?php

require_once 'lib/AccountVerifier.php';
require_once 'lib/UserAccount.php';
require_once 'lib/Bcrypt.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$verifier = new AccountVerifier();
	$verifier->verifyInput($_POST);
	if (count($verifier->errors) === 0) {
		$crypt = new Bcrypt();
		$input = $_POST;
		// create account
		$userAccount = new UserAccount();
		$userAccount->email = $input['email'];
		$userAccount->password = $crypt->hash($input['password1']); 
		$userAccount->firstName = $input['first_name'];
		$userAccount->lastName = $input['last_name'];
		$userAccount->save();

		echo "<h2>Account Created</h2>";
		exit;
	} else {
		// show errors
		echo '<pre>';
		print_r($verifier->errors);
		die();
	}

}


require_once "templates/header.php";
?>

<div id="createAccount">
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

	or <a href="/login">Login</a>
</div>

<?php
require_once "templates/footer.php";
?>
