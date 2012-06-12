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