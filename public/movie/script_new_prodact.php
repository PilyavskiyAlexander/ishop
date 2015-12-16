<?php require_once("../../includes/db.php");
require_once("../../includes/functions.php");


header("Location: ../admin.php");
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

$query="INSERT INTO prodact_list 
(image_src, name_of, price, code, label, category, rating) 
VALUES('$image_src', '$name_of', '$price', '$code', '$label', '$category', '10')";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);

$prodact_id = $database->insert_prodact_id();

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();
$query="INSERT INTO prodact_description
(description, title, material, sizes, color, manufacturer, category, prodact_id) 
VALUES('$description', '$name_of', '$material', '$sizes', '$color', '$manufacturer', '$category_name', '$prodact_id')";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);

$database->close_connection();

// Ничего не трогать, очень чуствителен к пробелам и т.д.
// *********************************************************
$st=',
{
    "name":"'.$name_of.'",
    "imgsrc":"'.$image_src.'",
    "reknown":"'.$price.'",
    "bio":"'.$description.'",
    "href":"prodact.php?id='.$prodact_id.'"
}
]';

$filename = fopen('../json/data.json', "r+");
fseek($filename, -2, SEEK_END);
fwrite($filename, $st);
fclose($filename);
// *********************************************************
?>	