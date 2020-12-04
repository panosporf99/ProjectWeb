<?php

class Checker {
  private static $instance = null;
  
  private function __construct(){}
 
  public static function getInstance()
  {
    if (self::$instance == null)
    {
      self::$instance = new Checker();
    }
 
    return self::$instance;
  }
  
  public function checkPass($password){
	  
	  if(strLen($password) < 8){
		  return False;
	  }
	  
	  $stringArray = str_split($password);

	$digitFlag = False;
	$symbolFlag = False;
	$upperFlag = False;
				
	foreach($stringArray as $letter){
		
		if(is_numeric($letter)){
			$digitFlag = True;			
		}
		
		//converts given letter to caps, if equal to uncapped letter, then letter was in caps:
		if(strtoupper($letter) == $letter){
			
			$upperFlag = True;			
			}
		$letterOrd = ord($letter);
		
		if(($letterOrd >= 33 && $letterOrd <= 47) ||
			($letterOrd >= 58 && $letterOrd <= 64) || 
			($letterOrd >= 91 && $letterOrd <= 96) ||
			($letterOrd >= 123 && $letterOrd <= 126)){
				
			$symbolFlag = True;			
		}
		
		if ($digitFlag == True && $symbolFlag == True && $upperFlag == True){
			return True;
		}
		
	}
	
	
	return False;
	
  }
  
  
}

function alertBox($message) { 
      
    echo "<script>alert('$message');</script>"; 
} 


session_start();


$checker= Checker::getInstance();




if ($_SERVER["REQUEST_METHOD"]==="POST"){
	
	
	$Uusername=$_POST["username"];
	$Uemail=$_POST["email"];
	$Upassword1=$_POST["password_1"];
	$Upassword2=$_POST["password_2"];
	
	//connect to db
	$db = mysqli_connect("localhost","root","","web") or die("Unable to connect");
	
	if (!$db)
    {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
	
	 //cleanup for db:
    $username = mysqli_real_escape_string($db, $Uusername);
    $email = mysqli_real_escape_string($db, $Uemail);
    $password_1 = mysqli_real_escape_string($db, $Upassword1);
    $password_2 = mysqli_real_escape_string($db, $Upassword2);
	
	//check db for existing user or email
	$user_check="SELECT * FROM users WHERE Usersusername='$username' or Usersemail = '$email' LIMIT 1";
	$rslt= mysqli_query($db, $user_check);
	
	
	
	if($password_1 != $password_2){
		alertBox("Passwords must match brooo!!!");
	}elseif(checker::checkPass($password_1) != 1){
		alertBox("Passwords must contain at least one number, one symbol, one capital letter and be more than 8 characters");
	}else{
		
		if($chk){
			if($rslt->num_rows === 1){
					alertBox("There is a username or email already registered. Change that USERNAME OR EMAIL!!!");
			}		
		}
		
		
		$pwd= password_hash($password_1,PASSWORD_DEFAULT);
		$result = "INSERT into users(Usersusername,Usersemail,Userspwd) VALUES ('$username','$email','$pwd')"; 
		mysqli_query($db,$result);
		header('location:index.php');
	}	
}


?>