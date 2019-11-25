<?php
	$servername = "localhost";
	$username = "id11700650_sleepy_admin";
	$password = "123456";
	$dbname = "id11700650_lecture";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
    	die("Connection failed: " . $conn->connect_error); 

//if !($conn->query($sql) === TRUE) {
//    echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
//}


?>
