<?php
require_once 'lib/UserAccount.php';
require_once 'lib/Bcrypt.php';
require_once 'lib/Redis.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$crypt = new Bcrypt();
	$input = $_POST;
	// create account
	$userAccount = UserAccount::getByEmailAddress($redis, $input['email']);
	if ($userAccount !== FALSE) {
		if ($crypt->verify($input['password'], $userAccount->password)) {
			session_start();
			$_SESSION['account'] = $userAccount;

			header("Location: /");
		}
	}

	echo "<h2>Invalid Login</h2>";
	exit;
}

require_once "templates/header.php";
?>
<div id="loginForm">
	<h2>Please Login</h2>

	<form action="/login" method="post">
		<fieldset>
			<label for="email">Email</label>
			<input type="text" id="email" name="email">

			<label for="password">Password</label>
			<input type="password" id="password" name="password">

			<button type="submit">Login</button>
		</fieldset>
	</form>
	or
	<a href="/create-account">Create Account</a>
</div>
<?php
require_once "templates/footer.php";
