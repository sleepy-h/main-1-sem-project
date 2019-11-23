<?php
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
    	die("Connection failed: " . $conn->connect_error); 

    $sql="CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(6) unsigned NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `university`  varchar(20),
  `department` varchar(7),
  `sity` varchar(20),
  `country` varchar(20)
)DEFAULT charset=utf8;";


if ($conn->query($sql) === TRUE) {
    echo "Table created successfully". "<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
}
?>