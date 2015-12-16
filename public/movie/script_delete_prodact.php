<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$code = sanitizeString($_POST["code"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();
$query="DELETE FROM prodact_list 
WHERE code = $code
LIMIT 1";
// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

header("Location: ../admin.php");

?>	

