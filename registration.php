<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="registration.css">
		<title>Регистрация</title>
	</head>
	<body>
		<div class="header">
				<p><a href="#">Главная страница</a></p>
				<p><a href="#">Список курсов</a></p>
				<p><a href="#">Создать свой курс</a></p>
				<p><a href="#">Выйти</a></p>
			</div>
			<div class="main">
				<div class="form">
					<form class="registration-form" method='POST'>
						<h3>Страница регистрации</h3>
						<input type="text" placeholder="Имя" name='name'>
						<input type="text" placeholder="Фамилия" name="surname">
						<input type="text" placeholder="Логин" name="login">
						<input type="text" placeholder="Почта" name="email">
						<input type="password" placeholder="Пароль" name='password1'>
						<input type="password" placeholder="Повторите Пароль" name="password2">
						<button>Регистрация</button>
<?php
	require('db.php');
	$regexp = ["email" => "/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u",
		"password" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[%\$#@&\*\^\|\/~\{\}\[\]\\\])[A-Za-z\d%\$#@&\*\^\|\/~\{\}\[\]\\\]{8,}$/",
		"login" => "/^([A-Za-z]{1})([A-Za-z\d\_]{5,})$/"];
	if (isset($_REQUEST['name'])){
		$name = stripslashes($_REQUEST['name']);
		$name = mysqli_real_escape_string($conn,$name); 
		$surname = stripslashes($_REQUEST['surname']);
		$surname = mysqli_real_escape_string($conn,$surname); 
		$email = stripslashes($_REQUEST['email']);
		$email = mysqli_real_escape_string($conn,$email);
		$login = stripslashes($_REQUEST['login']);
		$login = mysqli_real_escape_string($conn,$login);
		$password1 = stripslashes($_REQUEST['password1']);
		$password1 = mysqli_real_escape_string($conn,$password1);
		$password2 = stripslashes($_REQUEST['password2']);
		$password2 = mysqli_real_escape_string($conn,$password2);
		if (preg_match($regexp["email"], $email)) {
			if (preg_match($regexp["password"], $password1)) {
				if (preg_match($regexp["login"], $login)){
					if ($password1===$password2){
						$sql = "SELECT * FROM `accounts` WHERE `email`='$email';";
						if(($conn->query($sql))->num_rows){
							echo "<p>Ошибка:на данную почту есть зарегистрированный аккаунт.</p>";
						} else {
							$sql = "SELECT * FROM `accounts` WHERE `login`='$login';";
							if (($conn->query($sql))->num_rows){
								echo "<p>Ошибка:данный логин уже используется.</p>";
							} else {
								$sql = "INSERT into `accounts` (status , email , login , password, surname,name,university, department, sity, country)
									VALUES (2,'$email','$login','".md5($password1)."','$surname','$name','','','','');";
								if($conn->query($sql) === TRUE){
								echo "<h3>You are registered successfully.</h3><br/>Click here to <a href='/'>Login</a>";
								} else {
									echo "Error: " . $sql . "<br>" . $conn->error. "<br>";
								}
							}
						}
					} else {
						echo "<p>Ошибка:пароли не совпадают, введите повторно.</p>";
					}
				} else {
					echo "<p>Ошибка:неправильный логин.Логин состоит минимум из 6 символов, состоящее из латинских букв, цифр, и символа '_'.Обязательно начинается с латинской букв.</p>";
				}
			} else {
			echo "<p>Ошибка:неправильный пароль.Необходимо минимум 8 символов, где одна строчная и одна заглавная буква и одна цифра</p>";
			} 
		} else {
			echo "<p>Ошибка:неправильная почта.</p>";
		}
	}
	$conn->close();
?>
					</form>
				</div>
			</div>
		</div>
		<div id="footer">
			<p>МГТУ имени Н.Э.Баумана - ИУ4-13Б - Косьянов Олег Вячеславич</p>
		</div>
	</body>
</html>