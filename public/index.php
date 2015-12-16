
<?php require_once('../includes/functions.php'); //Подключения функций PHP ?>
<?php require_once('../includes/db.php'); //Подключения к обьекту БД ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
	<!-- <script src="javascript/function_admin.js" type="text/javascript" charset="utf-8" async defer></script> -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
</head>
<body>
<?php include('views/header.php'); //Подключения шаблона хедера ?>

<div id="content">
	<div id="content_inside">
		<?php include('views/navigation.php'); //Подключения шаблона навигации ?>

		<div id="content_main">
		<?php include('views/content_main.php'); //Подключения шаблона контента ?>
		</div>
	</div>
</div>

<?php include('views/footer.php'); //Подключения шаблона футера ?>


<script src="javascript/controller.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>