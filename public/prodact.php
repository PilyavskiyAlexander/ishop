<!-- <?php //session_start ?> 
<?php require_once('../includes/functions.php'); //Подключения функций PHP ?>-->
<?php require_once('../includes/db.php'); //Подключения к обьекту БД ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style_for_forms.css">
	<link rel="stylesheet" href="css/style_one_prodact.css">
	<!-- <script src="javascript/function_admin.js" type="text/javascript" charset="utf-8" async defer></script> -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
</head>
<body>
<?php include('views/header.php'); //Подключения шаблона хедера ?>

<div id="content">
	<div id="content_inside">
		<?php include('views/prodact_page.php');?>
	</div>
</div>

<?php include('views/footer.php'); //Подключения шаблона футера ?>


<script src="javascript/controller.js" type="text/javascript" charset="utf-8" async defer></script>
</body>
</html>