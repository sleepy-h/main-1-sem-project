<?php
	$message='';
	session_start();
	require('db.php');
	if (isset($_SESSION['login']) and isset($_SESSION['password'])){
		$login_m = stripslashes($_SESSION['login']);
	 	$login_m = mysqli_real_escape_string($conn,$login_m);
	 	$password = stripslashes($_SESSION['password']);
	 	$password = mysqli_real_escape_string($conn,$password);
	 	$query= "SELECT * FROM `accounts` WHERE login='$login_m' and password='$password';";
		if (!(($conn->query($query))->num_rows)) {
			session_unset();
			header("Location: /");
		}
	} else {
		session_unset();
		header("Location: /");
	}
	$regexp = ["email" => "/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u",
		"password" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/",
		"login" => "/^([A-Za-z]{1})([A-Za-z\d\_]{5,})$/"];
	if (isset($_REQUEST['login'])){
		if ($_REQUEST['password1']!='' or $_REQUEST['password2']!=''){
			if ($_REQUEST['password1']!='' and $_REQUEST['password1']!=''){
					$password1 = stripslashes($_REQUEST['password1']);
					$password1 = mysqli_real_escape_string($conn,$password1);
					$password2 = stripslashes($_REQUEST['password2']);
					$password2 = mysqli_real_escape_string($conn,$password2);
					if (preg_match($regexp["password"], $password1)){
						if ($password1===$password2){
							$sql = "UPDATE accounts SET password='".md5($password1)."'' WHERE login='$login_m' and password='$password';";
							if($conn->query($sql) === TRUE){
								$message=$message.'<p class="message">Пароль успешно изменен</p>';
								$_SESSION['password']=md5($password1);
							} else {
								show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
								exit();
							}
						} else {
							$message=$message.'<p class="error">Ошибка:пароли не совпадают, введите повторно.</p>';
						}
					} else {
						$message=$message.'<p class="error">Ошибка:неправильный пароль.Необходимо минимум 8 символов, где одна строчная и одна заглавная буква и одна цифра</p>';
					}
			} else {
				$message=$message."<p class='error'>Ошибка:пароль введен только один раз</p>";
			}
		}
	   	if ($_REQUEST['email']!=''){
	   		$email = stripslashes($_REQUEST['email']);
			$email = mysqli_real_escape_string($conn,$email);
			if (preg_match($regexp["email"], $email)) {
				$sql = "SELECT * FROM `accounts` WHERE `email`='$email';";
				if(($conn->query($sql))->num_rows){
					$message=$message."<p class='error'>Ошибка:на данную почту есть зарегистрированный аккаунт.</p>";
				} else {
					$sql = "UPDATE accounts SET email='$email' WHERE login='$login_m' and password='$password';";
					if($conn->query($sql) === TRUE){
						$_SESSION['email'] = $email;
						$message=$message.'<p class="message">Почта успешна изменена</p>';
					} else {
					show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
					exit();
					}
				}
			} else {
				$message=$message.'<p class="error">Ошибка:неправильная почта.</p>';
			}
		}
		if($_REQUEST['login']!=''){
			$login = stripslashes($_REQUEST['login']);
			$login = mysqli_real_escape_string($conn,$login);
			if (preg_match($regexp["login"], $login)) {
				$sql = "SELECT * FROM `accounts` WHERE `login`='$login';";
				if(($conn->query($sql))->num_rows){
					$message=$message."<p class='error'>Ошибка:Данный логин уже используется.</p>";
				} else {
					$sql = "UPDATE accounts SET login='$login' WHERE login='$login_m' and password='$password';";
					if($conn->query($sql) === TRUE){
						$_SESSION['login'] = $login;
						$message=$message.'<p class="message">Логин успешно изменен</p>';
					} else {
					show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
					exit();
					}
				}
			} else {
				$message=$message."<p class='error'>Ошибка:неправильный логин.Логин состоит минимум из 6 символов, состоящее из латинских букв, цифр, и символа '_'.Обязательно начинается с латинской букв.</p>";
			}
		}
		if ($_REQUEST['name']!='') {
			$name = stripslashes($_REQUEST['name']);
			$name = mysqli_real_escape_string($conn,$name);
			if($name===''){
				$message=$message.'<p class="error">Ошибка:You shall not pass with this name</p>';
			} else {
				$sql = "UPDATE accounts SET name='$name' WHERE login='$login_m' and password='$password';";
				if($conn->query($sql) === TRUE){
					$_SESSION['name']=$name;
					$message=$message.'<p class="message">Имя успешно изменено</p>';
				} else {
					show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
					exit();
				}
			}
		}
		if ($_REQUEST['surname']!='') {
			$surname = stripslashes($_REQUEST['surname']);
			$surname = mysqli_real_escape_string($conn,$surname);
			if($surname===''){
				$message=$message.'<p class="error">Ошибка:You shall not pass with this surname</p>';
			} else {
				$sql = "UPDATE accounts SET surname='$surname' WHERE login='$login_m' and password='$password';";
				if($conn->query($sql) === TRUE){
					$_SESSION['surname']=$surname;
					$message=$message.'<p class="message">Фамилия успешна изменена</p>';
				} else {
					show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
					exit();
				}
			}
		}
		if ($_REQUEST['university']!='') {
			$university = stripslashes($_REQUEST['university']);
			$university = mysqli_real_escape_string($conn,$university);
			$sql = "UPDATE accounts SET university='$university' WHERE login='$login_m' and password='$password';";
			if($conn->query($sql) === TRUE){
				$_SESSION['university']=$university;
				$message=$message.'<p class="message">Университет успешно изменен</p>';
			} else {
				show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
				exit();
			}
		}
		if ($_REQUEST['department']!='') {
			$department = stripslashes($_REQUEST['department']);
			$department = mysqli_real_escape_string($conn,$department);
			$sql = "UPDATE accounts SET department = '$department' WHERE login='$login_m' and password='$password';";
			if($conn->query($sql) === TRUE){
				$_SESSION['department'] = $department;
				$message=$message.'<p class="message">Факультет(Кафедра) успешно(а) изменен(а)</p>';
			} else {
				show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
				exit();
			}
		}
		if ($_REQUEST['country']!='') {
			$country = stripslashes($_REQUEST['country']);
			$country = mysqli_real_escape_string($conn,$country);
			$sql = "UPDATE accounts SET country='$country' WHERE login='$login_m' and password='$password';";
			if($conn->query($sql) === TRUE){
				$_SESSION['country'] = $country;
				$message=$message.'<p class="message">Страна успешна изменена</p>';
			} else {
				show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
				exit();
			}
		}
		if ($_REQUEST['city']!='') {
			$city = stripslashes($_REQUEST['city']);
			$city = mysqli_real_escape_string($conn,$city);
			$sql = "UPDATE accounts SET city='$city' WHERE login='$login_m' and password='$password';";
			if($conn->query($sql) === TRUE){
				$_SESSION['city'] = $city;
				$message=$message.'<p class="message">Город успешно изменен</p>';
			} else {
				show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
				exit();
			}
		}
		if( !empty( $_FILES['image']['name'] ) ) {
			$uploadname=basename($_FILES['image']['name']);
			$uploadpath='files/'.md5(file_get_contents( $_FILES['image']['tmp_name']).'lecture').$uploadname;
			if( substr($_FILES['image']['type'], 0, 5)=='image' ) {
				if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadpath)) { //перемещение загруженного файла из временной папки сервера в папку, которую указали (uploadpath)
	        		$sql="UPDATE accounts SET photopath='$uploadpath' WHERE login='$login_m' and password='$password';";//составляем запрос на запись в базу имя и путь к файлу
	        		if($conn->query($sql) === TRUE){
						$_SESSION['photopath'] = $uploadpath;
						$message=$message.'<p class="message">Аватарка успешно изменена</p>';
					} else {
						show_page("<p class='error'>Error: " . $sql . "</p><p class='error'>" . $conn->error."</p>");
						exit();
					}
				} else {
					$message=$message."<p class='error'>Ошибка: проблема при загрузке файла<p>";
				}
			}
		}
	}
	$conn->close();
	show_page($message);

	function show_page($message){
		echo '
	<!DOCTYPE html>
	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="settings.css">
			<title>Настройки</title>
		</head>
		<body>
			<div class="header">
					<p><a href="/">Главная страница</a></p>
					<p><a href="#">Список курсов</a></p>
					<p><a href="#">Создать свой курс</a></p>
					<p><a href="logout.php">Выйти</a></p>
				</div>
				<div class="main">
					<div class="form">
						<form enctype="multipart/form-data" class="change-form" method="POST">
							<h3>Страница Настройки</h3>
							<p class="name_input">Имя</p>
							<input type="text" placeholder="'.$_SESSION['name'].'" name="name">
							<p class="name_input">Фамилия</p>
							<input type="text" placeholder="'.$_SESSION['surname'].'" name="surname">
							<p class="name_input">Логин</p>
							<input type="text" placeholder="'.$_SESSION['login'].'" name="login">
							<p class="name_input">Почта</p>
							<input type="text" placeholder="'.$_SESSION['email'].'" name="email">
							<p class="name_input">Университет</p>
							<input type="text" placeholder="';
							if ($_SESSION['university']){
								echo $_SESSION['university'];
							} else {
								echo 'Университет';
							}
							echo '" name="university">
							<p class="name_input">Факультет/Кафедра</p>
							<input type="text" placeholder="';
							if ($_SESSION['department']){
								echo $_SESSION['department'];
							} else {
								echo 'Факультет/Кафедра';
							}
							echo '" name="department">
							<p class="name_input">Страна</p>
							<input type="text" placeholder="';
							if ($_SESSION['country']){
								echo $_SESSION['country'];
							} else {
								echo 'Страна';
							}
							echo '" name="country">
							<p class="name_input">Город</p>
							<input type="text" placeholder="';
							if ($_SESSION['city']){
								echo $_SESSION['city'];
							} else {
								echo 'Город';
							}
							echo '" name="city">
							<p class="name_input">Пароль</p>
							<input type="password" placeholder="Пароль" name="password1">
							<input type="password" placeholder="Повторите Пароль" name="password2">
							<input type="file" name="image" />
							<button>Изменить</button>';
		echo $message;
		echo'
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