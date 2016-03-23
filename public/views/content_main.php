<?php

$database->open_connection();
					$query="SELECT * ";
					$query.="FROM prodact_list ";
					
						if (isset($_GET['category'])){
					$category = $_GET['category'];
					$query.="WHERE category='$category'";
					}

$result=$database->query($query);

					$all_rows = mysqli_num_rows($result);

					$per_page = 12; //Количество постов на 1-й странице

					$page = !empty($_GET['page']) ? $_GET['page'] : 1;
					$offset=$per_page*($page - 1);


					$query="SELECT * ";
					$query.="FROM prodact_list ";
						if (isset($_GET['category'])){
					$category = $_GET['category'];
					$query.="WHERE category='$category'";
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
	$rating = $row["rating"];

	switch ($rating) {
    case "10":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png');;
        break;
    case "9":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/half_full_star.png');;
        break;
    case "8":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/empty_star.png');;
        break;
    case "7":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/half_full_star.png', 'images/empty_star.png');;
        break;
    case "6":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/empty_star.png', 'images/empty_star.png');;
        break;
    case "5":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/half_full_star.png', 'images/empty_star.png', 'images/empty_star.png');;
        break;
    case "4":
        $arr = array('images/full_star.png', 'images/full_star.png', 'images/empty_star.png', 'images/empty_star.png', 'images/empty_star.png');;
        break;
    case "3":
        $arr = array('images/full_star.png', 'images/half_full_star.png', 'images/empty_star.png', 'images/empty_star.png', 'images/empty_star.png');;
        break;
    case "2":
        $arr = array('images/full_star.png', 'images/empty_star.png', 'images/empty_star.png', 'images/empty_star.png', 'images/empty_star.png');;
        break;
}

	// $arr = array('images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png', 'images/full_star.png');
	
	echo "<div class='flow_of_goods'>
		<div class='block_image'><a href='prodact.php?id={$id}'><img src='{$image_src}' alt='Что-то'></a><img src='{$label}' alt='Акция'></div>
		<div class='block_title'><a href='prodact.php?id={$id}'>{$name_of}</a></div>
		<div class='block_price'><p>{$price} <span>грн.</span></p><span class='bye_this' data-byeid='$id'>Купить</span></div>
		<div class='block_else'><p>Код: {$code}</p><a href='prodact.php?id={$id}#reviews'>Отзывы</a></div>
		<div class='block_stars'><img src='{$arr[0]}' style='width: 15px;'><img src='{$arr[1]}' style='width: 15px;'><img src='{$arr[2]}' style='width: 15px;'><img src='{$arr[3]}' style='width: 15px;'><img src='{$arr[4]}' style='width: 15px;'></div>
		</div>";
	}
	$pages = $all_rows/$per_page;

	if ($pages>1){
		echo "<div id='pagination'>";
	for ($page=1; $page < $pages+1; $page++) { 
		echo "<a href='index.php?page={$page}' class=\"number_of_the_pages\">{$page} </a>";
	}
	echo "</div>";
	}

$database->close_connection();
	echo "<div id='for_new_prodact_in_basket'></div>";
?>
<script>
$(".bye_this").on('click', function(e) {
		var bye_id = $(this).attr('data-byeid');
		var mynewprodact = "movie/get_new_prodact.php?prodact_id="+bye_id;
		$("#for_new_prodact_in_basket").load(mynewprodact);

		// Открытия корзины после доавления
		var Div = $('<div id="block_identify"></div>').css("width", "100%").css("height", window.innerHeight+'px').css("position", "absolute").css("left", "0").css("top", window.pageYOffset+ 'px').css("zIndex", "1000");

    	$('body').append(Div);

  		$(".delete_this_prodact_from_cart").on("click", function(e){
    
   			var some_prodact_id = $(this).attr('data-id');
    		var mynewurl2 = "movie/get_user_basket.php?prodact_id="+some_prodact_id;
	    		setTimeout(function(){
	    		$("#user_basket").remove();
	    		$("#block_identify").load(mynewurl2);
	    		}, 400);
    
  		})

  		setTimeout(function(){$("#block_identify").load( "movie/get_user_basket.php")}, 400);
});
</script>