<?php
require_once("../../includes/config.php");
require_once("../../includes/db.php");
$hash=$_COOKIE['hash'];
$pr_id=$_GET['prodact_id'];

$database->open_connection();
			$query="SELECT * 
				FROM new_hash 
				WHERE hash='$hash'";

			$result=$database->query($query);

			while($row=$result->fetch_array()){
			$hash_id = $row["id"];
			}

// Покупка нового товара, и проверка на то что такого товара еще нет в списке, если есть - количество меняется
			$num_how_much='';
			$query="SELECT * FROM cart WHERE prodact_id='$pr_id' AND hash_id='$hash_id'";
			$result=$database->query($query);
			while($row=$result->fetch_array()){
				$num_how_much = $row["num_how_much"];
			}

			if($num_how_much!=''||!empty($num_how_much)){
										
					$num_how_much++;

					$query="UPDATE cart
					SET num_how_much = '$num_how_much'
					WHERE prodact_id='$pr_id' AND hash_id='$hash_id'";
					$result=$database->query($query);
					
			}
			else{
					$query="INSERT INTO cart
					(prodact_id, hash_id)
					VALUES ('$pr_id', '$hash_id')";
					$result=$database->query($query);
			}
			


?>	


