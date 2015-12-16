<?php require_once('../includes/functions.php'); //Подключения функций PHP ?>
<?php require_once("../includes/db.php"); ?>
<?php
if(isset($_POST["name"])){


$login = sanitizeString($_POST["name"]);
$password = sanitizeString($_POST["password"]);

$password=crypt(crypt($password, "qw"), "12");

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="SELECT * FROM admins";
// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);
while($row=$result->fetch_array()){
			$login2 = $row["admin"];
			$password2 = $row["password"];
			$hash = $row["hash"];

	if($login==$login2&&$password==$password2){
		setcookie("hash_by_my_admin", $hash, time()+60*60*60);
		header("Location: admin.php");
	}
}
	
$database->close_connection();

}
if(isset($_GET['offadmin'])){
	if($_GET['offadmin']==1){
		setcookie("hash_by_my_admin", "", time()-60*60*60);
		header("Location: admin_authorization.php");
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель администратора</title>
	<link rel="stylesheet" href="css/style_admin.css">
	<link rel="stylesheet" href="css/style_for_forms.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="javascript/function_admin.js" type="text/javascript" charset="utf-8" async defer></script>
	<style>
		body{
			background: black;
		}
		#password,
		#login{
			float: none;
			margin: 10px 120px;
		}
	</style>
</head>
<body>

<form class="form-3" method="POST" action="admin_authorization.php">
<p class="clearfix">
<input type="text" name="name" id="login" placeholder="Логин"></p>
<p class="clearfix"><input type="password" name="password" id="password" placeholder="Пароль"></p>
<p class="clearfix"><input type="submit" name="submit" value="Войти" style="width: 270px; margin: 0 120px; padding-bottom: 25px;"></p>
</form>


</body>
</html>