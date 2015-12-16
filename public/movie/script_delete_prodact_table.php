<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$id = sanitizeString($_GET["id"]);
// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();
$query="DELETE FROM prodact_list 
WHERE id = $id
LIMIT 1";
// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();

?>
<script>
	window.close();
</script>	

