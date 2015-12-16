<?php 
require_once("../../includes/db.php");
require_once("../../includes/functions.php");


$category_name = sanitizeString($_POST["category_name"]);
$category = sanitizeString($_POST["category"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="INSERT INTO category 
(category_name, category) 
VALUES('$category_name', '$category')";

// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);

header("Location: ../admin.php");

?>	
