<?php
require_once("../includes/config.php");
require_once("../includes/db.php");
			/*** Новый товар ***/
			class NewProdact
			{
				function NavDisplay($name=null, $code=null){
					echo '<figcaption>'.$name.'</figcaption>';
					echo '<div id="prodact_code">Код товара<br><span>'.$code.'</span></div>';
					echo '<nav> <ul> <a href=""><li> Все о товаре </li></a> <a href="#figure"><li> Фото </li></a><a href="#description"><li> Характеристики </li></a>  <a href="#section"><li> Цена </li></a> <a href="#delivery"><li> Доставка </li></a> <a href="#reviews"><li> Отзывы </li></a> </ul> </nav>';
								}
				function ImgDisplay($name=null, $img_src=null){
					
					echo '<figure id="figure"><img src="'.$img_src.'" title="'.$name.'"></figure>';
				}
				function PriceDisplay($id, $price=null, $small_description=null){
					echo '<section id="section"> <aside><div id="bye_this"><p>'.$price.' <span>грн.</span></p><span class="bye_this_prodact" data-byethisid="'.$id.'">Купить</span></div></aside><div>'.$small_description.'
						
					</div> </section>';
				}
				function DeliveryDisplay(){
					echo '<div id="delivery">';
					echo '<span>Доставка</span> <i>По Хмельницкому </i><br>Самовывоз из нашего магазина <br>Курьером по адресу <br> <i>В регионах </i><br>− самовывоз из точки выдачи <br>− из пункта службы доставки <br>− курьером по адресу <br> <span>Оплата</span> Наличными, Безналичными, Кредит, Visa/MasterCard <br><span>Гарантия</span> 12 месяцев <br> обмен/возврат товара в течение 14 дней';
					echo '</div>';
				}
				function DescriptionDisplay($name, $description, $material, $sizes, $color, $manufacturer, $category){
					echo '<div id="description">';
					echo '<h2>Описание: '.$name.'</h2>';
					echo "<div>{$description}</div>";

					echo '<h2>Технические характеристики: '.$name.'</h2>';
					echo '<table>';
					echo '<tr><td>Материал</td><td>'.$material.'</td></tr>';
					echo '<tr><td>Размеры</td><td>'.$sizes.'</td></tr>';
					echo '<tr><td>Цвет</td><td>'.$color.'</td></tr>';
					echo '<tr><td>Производитель</td><td>'.$manufacturer.'</td></tr>';
					echo '<tr><td>Категория</td><td>'.$category.'</td></tr>';
					echo '</table>';
					echo '</div>';
				}
				function ReviewsDisplay($arr, $id){
					echo '<div id="reviews">';
					echo '<h3 id="all_reviews">Отзывы покупателей</h3><h3 id="write_new_reviews">Написать отзыв</h3>';
					echo "<div id='reviews_of_clients'>";
					foreach ($arr as $buyer => $review) {
						echo '<div id="one_coment">';
						echo '<h6><img src="images/small_icons/shopping_cart.png" alt="">'.$buyer.'</h6>';
						echo "<div>{$review}</div>";
						echo '</div>';
					}
					echo "</div>";
					echo "<form id=\"your_new_review\" action=\"movie/script_new_review.php?prodact_id={$id}\" method=\"POST\">
								<div id=\"your_new_review_for_img\">
									<img src='images/empty_star.png' alt='Плохо' title='Плохо'>
									<img src='images/empty_star.png' alt='Неплохо' title='Неплохо'>
									<img src='images/empty_star.png' alt='Нормально' title='Нормально'>
									<img src='images/empty_star.png' alt='Хорошо' title='Хорошо'>
									<img src='images/empty_star.png' alt='Очень хорошо' title='Очень хорошо'>
								</div>
								<input type=\"hidden\" name=\"rating\" value=''>
								<input type=\"text\" name=\"your_name\" required placeholder=\"Ваше имя\">
								<textarea name=\"your_review\" id=\"your_review\" required placeholder=\"Ваш отзыв\"></textarea>
								<input type=\"submit\" value=\"Отправить\">
							  </form>";
					echo '</div>';
				}

				function __construct($id, $name, $img_src, $price, $description, $arr, $small_description, $code, $material, $sizes, $color, $manufacturer, $category)
				{
					$this->NavDisplay($name, $code);
					$this->ImgDisplay($name, $img_src);
					$this->PriceDisplay($id, $price, $small_description);
					$this->DeliveryDisplay();
					$this->DescriptionDisplay($name, $description, $material, $sizes, $color, $manufacturer, $category);
					$this->ReviewsDisplay($arr, $id);
				}
			}

		$database->open_connection();
		$id = sanitizeString($_GET['id']);
		$id = $database->escape_value($_GET['id']);
			
		$query=$database->find_prodact_by_id($id);

		$result=$database->query($query);
			
	while($row=$result -> fetch_array()){
	$image_src = $row["image_src"];
	$name_of = $row["name_of"];
	$price = $row["price"];
	$code = $row["code"];
	$label =  $row["label"];
	}

		$query="SELECT * 
				FROM prodact_description 
				WHERE prodact_id='$id' 
				LIMIT 1";

	$result=$database->query($query);

	while($row=$result->fetch_array()){
	$material = $row["material"];
	$sizes = $row["sizes"];
	$color = $row["color"];
	$manufacturer = $row["manufacturer"];
	$category = $row["category"];
	$description = $row["description"];
	}
	$database->find_error();
	$small_description = "Материал: $material; Размеры: {$sizes}; Цвет: {$color}; Производитель: {$manufacturer}; Категория: {$category};";

	$query="SELECT * 
				FROM reviews 
				WHERE prodact_id='$id'";

	$result=$database->query($query);

	$arr = array();
	
	while($row=$result->fetch_array()){
		$customer_name = $row["customer_name"];
		$review = $row["review"];
		$assessment = $row["assessment"];
		$arr[$customer_name]=$review;
	}

		$page= new NewProdact($id, $name_of, $image_src, $price, $description, $arr, $small_description, $code, $material, $sizes, $color, $manufacturer, $category);

echo "<div id='for_new_prodact_in_basket'></div>";
?>
<script>
$(".bye_this_prodact").on('click', function(e) {
		var bye_this_id = $(this).attr('data-byethisid');
		var mynewprodact = "movie/get_new_prodact.php?prodact_id="+bye_this_id;
		$("#for_new_prodact_in_basket").load(mynewprodact);
		
// Открытия корзины после доавления
		var Div = $('<div id="block_identify"></div>').css("width", "100%").css("height", "100%").css("position", "absolute").css("left", "0").css("top", "0").css("zIndex", "1000");

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


$("#write_new_reviews").on('click', function(e){
	$("#reviews_of_clients").css('display', 'none');
	$("#your_new_review").css('display', 'block');

	var rating = 0;

	$("#your_new_review_for_img img").on("click", function(e){
	if(this==$("#your_new_review_for_img img")[0]){
		$(this).attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(3)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(4)").attr('src', 'images/empty_star.png');
		rating = 1;
		$("input[type=hidden]").attr('value', rating);
	}
	else if(this==$("#your_new_review_for_img img")[1]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(3)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(4)").attr('src', 'images/empty_star.png');

		rating = 2;
		$("input[type=hidden]").attr('value', rating);
	}	
	else if(this==$("#your_new_review_for_img img")[2]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(3)").attr('src', 'images/empty_star.png');
		$("#your_new_review_for_img img:eq(4)").attr('src', 'images/empty_star.png');
		rating = 3;
		$("input[type=hidden]").attr('value', rating);
	}	
	else if(this==$("#your_new_review_for_img img")[3]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(4)").attr('src', 'images/empty_star.png');
		rating = 4;
		$("input[type=hidden]").attr('value', rating);
	}	
	else if(this==$("#your_new_review_for_img img")[4]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(3)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
		rating = 5;
		$("input[type=hidden]").attr('value', rating);
	}	
	
	})

	$("#your_new_review_for_img img").on("mouseover", function(e){
	if((rating==0)&this==$("#your_new_review_for_img img")[0]){
		$(this).attr('src', 'images/full_star.png');	
	}
	else if((rating==0)&this==$("#your_new_review_for_img img")[1]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
	}	
	else if((rating==0)&this==$("#your_new_review_for_img img")[2]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
	}	
	else if((rating==0)&this==$("#your_new_review_for_img img")[3]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
	}	
	else if((rating==0)&this==$("#your_new_review_for_img img")[4]){
		$("#your_new_review_for_img img:eq(0)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(1)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(2)").attr('src', 'images/full_star.png');
		$("#your_new_review_for_img img:eq(3)").attr('src', 'images/full_star.png');
		$(this).attr('src', 'images/full_star.png');
	}	
	

	$("#your_new_review_for_img img").on("mouseleave", function(e){
	if(rating==0){$("#your_new_review_for_img img").attr('src', 'images/empty_star.png')};
	})
	})
	
})
$("#all_reviews").on('click', function(e){
	$("#reviews_of_clients").css('display', 'block');
	$("#your_new_review").css('display', 'none');
})

</script>