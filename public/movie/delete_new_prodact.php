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


			$query="DELETE FROM cart
				WHERE hash_id=$hash_id AND id=$pr_id LIMIT 1";

			$result=$database->query($query);


?>	
<script>
window.close();
</script>

