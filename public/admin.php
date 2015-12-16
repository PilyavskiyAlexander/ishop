<?php session_start() ?>

<?php require_once('../includes/functions.php'); //Подключения функций PHP ?>
<?php require_once("../includes/db.php"); ?>
<?php  
$name_of_my_admin="";
$hash_of_my_admin="";
if(isset($_COOKIE['hash_by_my_admin'])){
	$hash=$_COOKIE['hash_by_my_admin'];
	$database->open_connection();

			$query="SELECT hash 
				FROM admins 
				WHERE hash='$hash'";

			$result=$database->query($query);

			while($row=$result->fetch_array()){
			$name_of_my_admin = $row["hash"];
			}
			if($name_of_my_admin!=$hash){
				header("Location: admin_authorization.php");
			}
}
if($name_of_my_admin==$hash&&$name_of_my_admin!=""){
	
}
else{
	header("Location: admin_authorization.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Панель администратора</title>
	<link rel="stylesheet" href="css/style_admin.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="javascript/function_admin.js" type="text/javascript" charset="utf-8" async defer></script>
	
</head>
<body>

<header>
	<a href="index.php" title="На сайт"><img src="images/small_icons/header_logo.png" alt="Logo"></a>
	<p>Панель Администратора <a href="admin_authorization.php?offadmin=1">Выход</a></p>
</header>
<div id="content">
	<nav>
		<ul>
			<a href="views/admin/tovar.php">
				<li>Товар</li>
			</a>
			<a href="views/admin/category.php">
				<li>Категории</li>
			</a>
			<a href="views/admin/admins.php">
				<li>Админы</li>
			</a>

		</ul>
	</nav>
<!-- Подгружаем AJAX -> контент работы с базами данных в #shange_content-->
<script>
	$('#content nav ul a').on('click', function(e){
		e.preventDefault();
		shange_content_ajax(this);
	})


</script>
<!-- ********************************* -->

	<article>
		<div id="shange_content">
			
		</div>
		<aside>

		</aside>
	</article>
</div>
<footer align="center">
<img src="images/small_icons/pilyavskiy.png" height="100">	
</footer>
<script src="javascript/controller_admin.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>