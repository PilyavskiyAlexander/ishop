<?php require_once("../includes/db.php"); ?>

<?php
echo '<div id="content_navigation"> <ul>';

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="SELECT*FROM category";

// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);

confirm_query($result);

while($row=$result -> fetch_array()){
$category_name = $row["category_name"];
$category = $row["category"];
echo <<< NAME
<a href="index.php?category={$category}">
	<li>{$category_name}</li>
</a>
NAME;
}

echo '</ul> </div>';
$database->close_connection();
?>