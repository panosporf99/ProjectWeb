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
	
	//$passwordHash = password_verify($password, $row['Userspwd']);
	
	$query = "SELECT * FROM users WHERE Usersusername ='$username'";// AND Userspwd='$passwordHash'
	
	$result = mysqli_query($db, $query);
	$numRows=mysqli_num_rows($result);
	
	if ($numRows === 1){
		$row = mysqli_fetch_assoc($result);
		if(password_verify($password,$row['Userspwd'])){
			echo "Password verified";
			header('location:index.php');
		}
		else{
			alertBox("Wrong password. Type the right one");
			echo "Wrong password. Type the right one";
		}
		/*$_SESSION['username'] = $username;
		$_SESSION['success'] = "Logged in successfully";
		header('location: index.php');*/

	}else
	{
		alertBox("No User found. You must Register first dude!!!");
		echo "No User found. You must Register first dude!!!";
	}
}
?>