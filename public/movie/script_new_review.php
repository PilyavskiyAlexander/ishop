<?php require_once("../../includes/db.php");
require_once("../../includes/functions.php");

$prodact_id = $database->escape_value($_GET["prodact_id"]);
$assessment = $database->escape_value($_POST["rating"]);
$customer_name = $database->escape_value($_POST["your_name"]);
$review = $database->escape_value($_POST["your_review"]);

// ООП Запрос из обьекта $database класса из includes/db.php
$database->open_connection();

$query="INSERT INTO reviews 
(customer_name, review, assessment, prodact_id) 
VALUES('$customer_name', '$review', '$assessment', '$prodact_id')";

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);


$query="SELECT AVG(assessment), prodact_id FROM reviews GROUP BY prodact_id HAVING prodact_id=$prodact_id";
$result=$database->query($query);
while($row=$result -> fetch_array()){
	$rating = $row['AVG(assessment)'];
}


$rating=round($rating*2);
$rating=(int)($rating);

$query = "UPDATE prodact_list 
		   SET rating = '$rating'
		   WHERE id='$prodact_id'"; 

// ООП Запросы из обьекта $database класса из includes/db.php
$result=$database->query($query);



$database->close_connection();

header("Location: ../prodact.php?id={$prodact_id}#reviews");