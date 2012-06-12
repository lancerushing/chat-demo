<?php


require_once 'lib/UserAccount.php';
require_once 'lib/Bcrypt.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {

		$crypt = new Bcrypt();
		$input = $_POST;
		// create account
		$userAccount = UserAccount::getByEmailAddress($input['email']);
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
	<h1>Please Login</h1>

	<form action="/login" method="post">
		<label>Email
			<input type="text" name="email">
		</label>
		<label>Password
			<input type="password" name="password">
		</label>
		<button type="submit">Login</button>

	</form>
	or
	<a href="/create-account">Create Account</a>
</div>
<?php
require_once "templates/footer.php";

?>

