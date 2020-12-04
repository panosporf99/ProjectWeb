<?php include('LoginBackend.php') ?>

<DOCTYPE html>
<html>
<head>
	<title>Log In</title>
</head>
<body>

	<div class="container">
		
		<div class="header">
			
			<h2>Login In</h2>
			
		</div>
		
		<form action="login.php" method="post" accept-charset="utf-8">
			
			
			<div>
			
				<label for="username">Username : </label>
				<input type="text" name="username" placeholder="Username..."required>
												
			</div>
			
		
		
		<div>
		
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Password..." required>				
								
		</div>
		
		
		<button type="submit" name="login_user"> Log In </button>
		
		<p>Not a user?<a href="Registration.php"><b><br>Register Here</b></a></p>
										
		
		</form>
	
	</div>

</body>
</html>