<?php
require('db.php');
session_start();
if (isset($_POST['username']) or isset($_SESSION['username'])) {
	if (isset($_POST['username'])) {
		$username = stripslashes($_REQUEST['username']);
 		$username = mysqli_real_escape_string($conn,$username);
 		$password = stripslashes($_REQUEST['password']);
 		$password = mysqli_real_escape_string($conn,$password);
		$query1 = "SELECT * FROM `accounts` WHERE email='$username' and password='".md5($password)."';";
		$query2 = "SELECT * FROM `accounts` WHERE login='$username' and password='".md5($password)."';";
		$result1 = $conn->query($query1);
		$result2 = $conn->query($query2);
		if($result1->num_rows) {
			echo "res1";
			print_r($result1->fetch_row());//set $session values and show user page
		} else {
			if ($result2->num_rows){
				echo "res2";
				print_r($result2->fetch_row());//set $session values and show user page
			} else {
				show_page('неправильная почта и пароль');	
				$_SESSION['login'] = '';
				$_SESSION['password'] = '';
			}
		}
	} else {
		$query= "SELECT * FROM `accounts` WHERE email='".$_SESSION['username']."' and password='".$_SESSION['password']."';";
		if (($conn->query($query))->num_rows){
			// show user page 
		}
	}
} else {
	show_page('');
}
function show_page($error){
	echo' 
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="index.css">
		<title>Главная страница</title>
	</head>
	<body>
		<div class="header">
			<p><a href="/">Главная страница</a></p>
			<p><a href="#">Список курсов</a></p>
			<p><a href="#">Создать свой курс</a></p>
			<p><a href="#">Выйти</a></p>
		</div>
		<div class="main">
			<div class="right-menu">	
				<div class="form">
					<form class="login-form" method="POST">
						<input type="text" placeholder="Почта" name="username" />
						<input type="password" placeholder="Пароль" name="password" />
						<button>Авторизация</button>';
						echo "<p class='error'>".$error."</p>";
						echo '
						<p class="message">Не зарегистрированы? <br><a href="registration.php">Создайте пользователя!</a></p>
					</form>
				</div>
			</div>
		</div>
		<div id="footer">
			<p>МГТУ имени Н.Э.Баумана - ИУ4-13Б - Косьянов Олег Вячеславич</p>
		</div>
	</body>
</html>';
}
?>