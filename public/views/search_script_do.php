<?php

$database->open_connection();
					$query="SELECT * ";
					$query.="FROM prodact_list ";
					
						if (isset($_POST['search'])){
					$search = $_POST['search'];
					$query.="WHERE name_of LIKE '%$search%'";
					}

$result=$database->query($query);

					$all_rows = mysqli_num_rows($result);

					$per_page = 12; //Количество постов на 1-й странице

					$page = !empty($_GET['page']) ? $_GET['page'] : 1;
					$offset=$per_page*($page - 1);


					$query="SELECT * ";
					$query.="FROM prodact_list ";
					
						if (isset($_POST['search'])){
					$search = $_POST['search'];
					$query.="WHERE name_of LIKE '%$search%'";
					}
					$query.="LIMIT $per_page ";
					$query.="OFFSET $offset";
	$result=$database->query($query);
			

	while($row=$result -> fetch_array()){
	$id= $row["id"];
	$image_src = $row["image_src"];
	$name_of = $row["name_of"];
	$price = $row["price"];
	$code = $row["code"];
	$label =  $row["label"];
	$arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png');
	echo "<div class='flow_of_goods'>
		<div class='block_image'><a href='prodact.php?id={$id}'><img src='{$image_src}' alt='Что-то'></a><img src='{$label}' alt='Акция'></div>
		<div class='block_title'><a href='prodact.php?id={$id}'>{$name_of}</a></div>
		<div class='block_price'><p>{$price} <span>грн.</span></p><a href=\"movie/get_new_prodact.php?prodact_id=$id\" target=\"_blank\"><span class='bye_this'>Купить</span></a></div>
		<div class='block_else'><p>Код: {$code}</p><a href='prodact.php?id={$id}#reviews'>Отзывы</a></div>
		<div class='block_stars'><img src='{$arr[0]}' style='width: 15px;'><img src='{$arr[1]}' style='width: 15px;'><img src='{$arr[2]}' style='width: 15px;'><img src='{$arr[3]}' style='width: 15px;'><img src='{$arr[4]}' style='width: 15px;'></div>
		</div>";
	}
	$pages = $all_rows/$per_page;

	if ($pages>1){
		echo "<div style=\"width: 100%; height: 40px; text-align: center;\">";
	for ($page=1; $page < $pages+1; $page++) { 
		echo "<a href='index.php?page={$page}' class=\"number_of_the_pages\">{$page} </a>";
	}
	echo "</div>";
	}

$database->close_connection();
?>