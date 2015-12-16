<?php 
require_once("../../includes/db.php");
require_once("../../includes/functions.php");

$category_name = sanitizeString($_POST["category_name"]);
$new_name = sanitizeString($_POST["new_name"]);
$category = sanitizeString($_POST["category"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query = "UPDATE category  
SET category_name = '$new_name', category = '$category'  
WHERE category_name = '$category_name'";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

header("Location: ../admin.php");

?>	

