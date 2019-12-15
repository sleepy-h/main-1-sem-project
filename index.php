<?php
require('db.php');
session_start();
if (isset($_POST['username']) or isset($_SESSION['login'])) {
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
			$res=$result1->fetch_row();//set $session values and show user page
			$_SESSION['email']=$res[2];
			$_SESSION['login']=$res[3];
			$_SESSION['password']=$res[4];
			$_SESSION['name']=$res[6];
			$_SESSION['surname']=$res[5];
			$_SESSION['university']=$res[7];
			$_SESSION['country']=$res[10];
			$_SESSION['department']=$res[8];
			$_SESSION['city']=$res[9];
			$_SESSION['photopath']=$res[11];
			show_page_log();
		} else {
			if ($result2->num_rows){
				$res=$result2->fetch_row();//set $session values and show user page
				$_SESSION['email']=$res[2];
				$_SESSION['login']=$res[3];
				$_SESSION['password']=$res[4];
				$_SESSION['name']=$res[6];
				$_SESSION['surname']=$res[5];
				$_SESSION['university']=$res[7];
				$_SESSION['country']=$res[10];
				$_SESSION['department']=$res[8];
				$_SESSION['city']=$res[9];
				$_SESSION['photopath']=$res[11];
				show_page_log();
			} else {
				show_page_nlog('неправильная почта и пароль');	
			}
		}
	} else {
			$login = stripslashes($_SESSION['login']);
 			$login = mysqli_real_escape_string($conn,$login);
 			$password = stripslashes($_SESSION['password']);
 			$password = mysqli_real_escape_string($conn,$password);
			$query= "SELECT * FROM `accounts` WHERE login='$login' and password='$password';";
		if (($conn->query($query))->num_rows){
			show_page_log();
			// show user page 
		} else {
			session_unset();
			show_page_nlog('неправильная почта и пароль');
		}
	}
} else {
	show_page_nlog('');
}
function show_page_nlog($error){
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
		</div>
		<div class="main">
			<div class="right-menu">	
				<div class="form">
					<form class="login-form" method="POST">
						<input type="text" placeholder="Почта" name="username" />
						<input type="password" placeholder="Пароль" name="password" />
						<button>Авторизация</button>
						<p class="error">'.$error.'</p>
						<p class="message">Не зарегистрированы? <br><a href="registration.php">Создайте пользователя!</a></p>
					</form>
				</div>
			</div>
			<div class="main-menu">
				<form class="intro">
					<h2>Добро пожаловать на leсture-hall</h2>
					<h4>Мы поможем вам познать новое или стать учителем других падаванов.Открывайте для себя новые горизонты познания, приобретая современые знания, позволяющие вам реализовать все свои мечты.</h4>
					<h3>Вперед за мечтой, падаван.</h3>
				</form>
			</div>
		</div>
		<div id="footer">
			<p>МГТУ имени Н.Э.Баумана - ИУ4-13Б - Косьянов Олег Вячеславич</p>
		</div>
	</body>
</html>';
}
function show_page_log(){
	echo ' <!DOCTYPE html>
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
			<p><a href="settings.php">Настройки</a></p>
			<p><a href="logout.php">Выйти</a></p>
		</div>
		<div class="main">
			<div class="right-menu">
				<div class="form">
					<form class="account-form" style="font-family: sans-serif;">
						<h3 style="color: black;" >'.$_SESSION['login'].'</h3>
						<h5 style="color: gray;">'.$_SESSION['surname'].' '.$_SESSION['name'].'</h5>
						<h5 style="color: gray;">'.$_SESSION['university'].' / '.$_SESSION['department'].'</h5>
						<h5 style="color: gray;">'.$_SESSION['country'].' / '.$_SESSION['city'].'</h5>
						<img src="'.$_SESSION['photopath'].'" alt="" />
						<h4>Top 5 your corses:</h4>
						<ol style="color: green;">
							<li>first</li>
							<li>second</li>
							<li>third</li>
							<li>fourth</li>
							<li>fifth</li>
						</ol>
						<h4>Top 5 corses:</h4>
						<ol style="color: green;">
							<li>first</li>
							<li>second</li>
							<li>third</li>
							<li>fourth</li>
							<li>fifth</li>
						</ol>
					</form>
				</div>
			</div>
			<div class="main-menu">
				<form class="intro">
					<h2>Добро пожаловать на leсture-hall</h2>
					<h4>Мы поможем вам познать новое или стать учителем других падаванов.Открывайте для себя новые горизонты познания, приобретая современые знания, позволяющие вам реализовать все свои мечты.</h4>
					<h3>Вперед за мечтой, падаван.</h3>
				</form>
			</div>
		</div>
		<div id="footer">
			<p>МГТУ имени Н.Э.Баумана - ИУ4-13Б - Косьянов Олег Вячеславич</p>
		</div>
	</body>
</html>';
}
?>