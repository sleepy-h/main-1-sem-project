<?php
	$servername = "localhost";
	$username = "id11700650_sleepy_admin";
	$password = "123456";
	$dbname = "id11700650_lecture";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
    	die("Connection failed: " . $conn->connect_error); 
    $sql="CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `status` int(1)unsigned NOT NULL,
  `email` varchar(40) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(33) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `university`  varchar(20),
  `department` varchar(10),
  `city` varchar(20),
  `country` varchar(20),
  `photopath` varchar(80), 
  PRIMARY KEY (`id`)
)DEFAULT charset=utf8;";
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully". "<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
}
	$sql="INSERT INTO `accounts`(`status`, `email`, `login`, `password`, `surname`, `name`, `university`, `department`, `city`, `country`,`photopath`) VALUES 
  (0,'cookie.witn.jam@gmail.com','sleepy','993d4cf31414bb99aaa2194ea970ba68','Kosyanov','Oleg','','','','','files/ava.png');";
 if ($conn->query($sql) === TRUE) {
    echo "Insert value in table successfully". "<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
} 
?>