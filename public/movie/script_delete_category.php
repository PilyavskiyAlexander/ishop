<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$category_name = sanitizeString($_POST["category_name"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="DELETE FROM category 
WHERE category_name = '$category_name'
LIMIT 1";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

header("Location: ../admin.php");

?>	

