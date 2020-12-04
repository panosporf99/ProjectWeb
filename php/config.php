<?php

$user = "root";
$pass = "";
$db= "web";

$db = new mysqli ("localhost", $user , $pass , $db) or die("Unable to connect");
$db->query ('SET CHARACTER SET utf8');
$db->query ('SET COLLATION_CONNECTION=utf8_general_ci');
echo "Hello";	
?>