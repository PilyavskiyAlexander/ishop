<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$login = sanitizeString($_POST["login"]);
$password = sanitizeString($_POST["password"]);

$password=crypt(crypt($password, "qw"), "12");

$hash = password_hash(crypt($password, "qw"), PASSWORD_BCRYPT, ["cost" => 8]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query = "UPDATE admins  
SET password = '$password', hash = '$hash'  
WHERE admin = '$login'";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

header("Location: ../admin.php");

?>	

