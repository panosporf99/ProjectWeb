<?php include('Gab.php') ?>


<DOCTYPE html>
<html>
<head>
	<title>Registration</title>
</head>
<body>

	<div class="container">
		
		<div class="header">
			
			<h2>Register</h2>
			
		</div>
		
		<form action="Registration.php" method="post" accept-charset="utf-8">
		
			<!--<?php include('erros.php') ?> -->
			
			
			<div>
			
				<label for="username">Username : </label>
				<input type="text" name="username" placeholder="Username..." required>
												
			</div>
			
		<div>
				<label for="email">Email : </label>
				<input type="email" name="email" placeholder="Email..." required>
				
				
				
		</div>
		
		<div>
		
				<label for="password">Password</label>
				<input type="password" name="password_1" placeholder="Password..." required>				
								
		</div>
		<div>
		
				<label for="password">Confirm Password</label>
				<input type="password" name="password_2" placeholder="ConfirmPassword..." required>								
				
		</div>
		
		<button type="submit" name="reg_user"> Submit </button>
		
		<p>Already a user?<a href="login.php"><b><br>Log in</b></a></p>
										
		
		
		</form>
		
	
	
	</div>

</body>
</html>