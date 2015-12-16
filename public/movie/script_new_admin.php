<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$login = sanitizeString($_POST["login"]);
$password = sanitizeString($_POST["password"]);

$password=crypt(crypt($password, "qw"), "12");

$hash = password_hash(crypt($password, "qw"), PASSWORD_BCRYPT, ["cost" => 8]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="INSERT INTO admins 
(admin, password, hash) 
VALUES('$login', '$password', '$hash')";
// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);

$database->close_connection();

header("Location: ../admin.php");

?>	
