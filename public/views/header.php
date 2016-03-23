<?php
session_start();
// <!-- Все контролери js находятся в файле controller.js -->
// Делаем хеш для посетителей
 if (isset($_COOKIE['hash'])){
  $hash=$_COOKIE['hash'];
  }
  else{
  $hash=md5(uniqid(rand(), true));

  $database->open_connection();
  
  $query="INSERT INTO new_hash 
  (hash) 
  VALUES('$hash')";

  $database->query($query);
  }
  setcookie("hash", $hash, time()+3600);
  
 // *****************
$dnkjnvzskdjv="Войдите в личный кабинет";

if(isset($_POST['name'])){
	$email = $_POST['name'];
	$password = $_POST['password'];
	if(isset($_POST['remember'])){
		$remember = $_POST['remember'];
	}
		
	$database->open_connection();

		$query="SELECT*FROM clients WHERE email='$email'";

	$result=$database->query($query);

		while($row=$result -> fetch_array()){
			$pw = $row["password"];;
			$name = $row["name"];
		}
	if($password==$pw){
		$dnkjnvzskdjv=$name;

		if(isset($_POST['remember'])){
			setcookie('name', $name, time()+5184000, '/');
		}
		else{
			setcookie('name', $name, 0, '/');
		}
		
	}
}

// Блок регистрации нового пользователя
if(isset($_POST['login'])){
	$name = $_POST['login'];
	$email = $_POST['email'];
	$password = $_POST['password'];

		$database->open_connection();

		$query="INSERT INTO clients 
		(name, email, password) 
		VALUES('$name', '$email', '$password')";

		$database->query($query);

// Оставатся в системе или нет

		if(isset($_POST['remember'])){
			setcookie('name', $name, time()+5184000, '/');
			$come_back = request_url();
			header("Location: $come_back");
		}
		else{
			setcookie('name', $name, 0, '/');
			$come_back = request_url();
			header("Location: $come_back");
		}

// Если ошибок нет - успешная регистрация, если есть - вывод ошибки
		if(empty($database->find_error())){
			$_SESSION['message_for_user']="Вы успешно зарегестрировались $name!";
		}
		else{
			$_SESSION['message_for_user']="Что-то пошло не так! Попробуйте зайти через форму входа, если не получится зарегистрируйтесь еще раз!";
		}
}

// Сообщения пользователю о регистрации
// if(isset($_SESSION['message_for_user'])){
// 	echo ""$_SESSION['message_for_user'];
// }

if(isset($_COOKIE['name'])){
	$dnkjnvzskdjv=$_COOKIE['name'];
}

?>
<?php

echo <<< HEADER
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Интернет супермаркет</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style_one_prodact.css">
	<link rel="stylesheet" href="css/style_for_forms.css">
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
</head>
<header>
	<div id="banner_header"></div>
	<div id="header_menu">
		<div id="header_line_up">
			<div id="header_user"><span id="my_user">$dnkjnvzskdjv</span></div>
			<nav>
				<p><img src="images/small_icons/tel.header.png" alt="">(044) 537-02-22, (044) 503-80-80, 0 800 503-808</p>
				<ul>
					<a href="#">
						<li>Вопросы и ответы</li>
					</a>
					<a href="#">
						<li>Кредит</li>
					</a>
					<a href="#">
						<li>Доставка и оплата</li>
					</a>
					<a href="#">
						<li>Гарантия</li>
					</a>
					<a href="#">
						<li>Контакты</li>
					</a>
				</ul>
			</nav>
		</div>
		<div id="header_line_bottom">
			<div id="header_logo">
				<a href="index.php" title="Интернет супермаркет"><img src="images/small_icons/header_logo.png" alt="Интернет магазин"></a>
			</div>
			<div id="header_seach">
				<div id="header_seach_inside">
				<form action="search_script.php" method="POST" accept-charset="utf-8">
				<input autocomplete="off" type="search" name="search" id="search" placeholder="Поиск" value="" tabindex="1">
				<a href="#"><input type="submit" value="Найти"></a>
				</form>
				</div>
				<div id="update"></div>
			</div>
			<div id="header_user_buttons">
			<a href="#" id="basket">Корзина</a>
			</div>
		</div>
	</div>
</header>

HEADER;
?>

