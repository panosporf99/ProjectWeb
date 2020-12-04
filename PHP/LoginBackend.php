<?php


function alertBox($message) { 
      
    echo "<script>alert('$message');</script>"; 
} 



	//connect to db
	$db = mysqli_connect("localhost","root","","web") or die("Unable to connect");
	
	if (!$db)
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
	
if ($_SERVER["REQUEST_METHOD"] == "POST"){//isset($_POST['login']

	$Lusername=$_POST["username"];	
	$Lpassword1=$_POST["password"];	   
	$username= mysqli_real_escape_string($db,$Lusername);
	$password= mysqli_real_escape_string($db,$Lpassword1);
	
	$password = password_hash($password, PASSWORD_DEFAULT);
	
	$query = "SELECT * FROM users WHERE Usersusername ='$username' AND Userspwd='$password'";
	
	$result = mysqli_query($db, $query);
	
	if (mysqli_num_rows($result) === 1)
	{
		$_SESSION['username'] = $username;
		$_SESSION['success'] = "Logged in successfully";
		header('location: index.php');

	}
	else
	{
		alertBox("Wrong username/password combination.Please try again.");
	}
}
?>