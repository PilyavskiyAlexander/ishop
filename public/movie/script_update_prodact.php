<?php require_once("../../includes/db.php"); ?>
<?php require_once("../../includes/functions.php"); ?>
<?php
$num = uniqid();
move_uploaded_file($_FILES['userfile']['tmp_name'], "../images/".$num.$_FILES['userfile']['name']);

$image_src = "images/".$num.$_FILES['userfile']['name'];

$name_of = $database->escape_value($_POST["name_of"]);
$price = $database->escape_value($_POST["price"]);
$code = $database->escape_value($_POST["code"]);
$label= $database->escape_value($_POST["label"]);
$category_name= $database->escape_value($_POST["category_name"]);
// Выше - для таблицы prodact_list

// Ниже для таблицы prodact_description
$description = $database->escape_value($_POST["description"]);
$material= $database->escape_value($_POST["material"]);
$sizes = $database->escape_value($_POST["sizes"]);
$color= $database->escape_value($_POST["color"]);
$manufacturer = $database->escape_value($_POST["manufacturer"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="SELECT*FROM category WHERE category_name='$category_name'";

// ООП Запрос из обьекта $database класса из includes/db.php
$result=$database->query($query);

while($row=$result->fetch_array()){
$category = $row["category"];
}

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query .= "UPDATE prodact_list "; 
$query .= "SET ";
if (""!==($_POST["image_src"])){
	$query .= "image_src = '$image_src', "; 
}
if (""!==($_POST["name_of"])){
	$query .= "name_of = '$name_of', "; 
}
if (""!==($_POST["price"])){
	$query .= "price = '$price', "; 
}
if (""!==($_POST["label"])){
	$query .= "label = '$label', "; 
}
if (""!==($_POST["category"])){
	$query .= "category = '$category' "; 
}
$query .= "WHERE code = $code";

$prodact_id = $database->insert_prodact_id();

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);

$query .= "UPDATE prodact_description "; 
$query .= "SET ";
if (""!==($_POST["description"])){
	$query .= "description = '$description', "; 
}
if (""!==($_POST["name_of"])){
	$query .= "title = '$name_of', "; 
}
if (""!==($_POST["material"])){
	$query .= "material = '$material', "; 
}
if (""!==($_POST["sizes"])){
	$query .= "sizes = '$sizes', "; 
}
if (""!==($_POST["color"])){
	$query .= "color = '$color' "; 
}
if (""!==($_POST["manufacturer"])){
	$query .= "manufacturer = '$manufacturer', "; 
}
if (""!==($_POST["category"])){
	$query .= "category = '$category', "; 
}

$query .= "WHERE prodact_id = $prodact_id";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);
$database->close_connection();


header("Location: ../admin.php");

?>	

