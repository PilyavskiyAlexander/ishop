<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$login = sanitizeString($_POST["login"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="DELETE FROM admins 
WHERE admin = '$login'
LIMIT 1";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

header("Location: ../admin.php");

?>	

