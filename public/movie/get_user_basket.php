<?php
require_once("../../includes/config.php");
require_once("../../includes/functions.php");
require_once("../../includes/db.php");
$hash=$database->escape_value($_COOKIE['hash']);

echo '<div id="user_basket">
	
	<p>Корзина</p><img src="images/small_icons/close_registration.png" alt="Закрыть корзину" title="Закрыть корзину" id="close_basket">
		<table>
		<thead>
			<tr>
				<td style="width: 40px"></td>
				<td style="width: 200px"></td>
				<td style="width: 400px; font-size: 12px;"></td>
				<td style="width: 120px; font-size: 12px;">К-во</td>
				<td style="width: 120px; font-size: 12px;">Сумма</td>
			</tr>
</thead>';
		

			$database->open_connection();

			$query="SELECT * 
				FROM new_hash 
				WHERE hash='$hash'";

			$result=$database->query($query);

			while($row=$result->fetch_array()){
			$hash_id = $row["id"];
			}
// Удаления товара
			if(isset($_GET['some_prodact_id'])){
			$pr_id=$_GET['some_prodact_id'];
			
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
			}
// Добавления количества единиц товара
			if(isset($_GET['num'])){
				$num = $_GET['num'];
				$prodact_id = $_GET['prodact_id'];
				$query="UPDATE cart
					SET num_how_much = '$num'
					WHERE prodact_id='$prodact_id' AND hash_id='$hash_id'";
				$result=$database->query($query);
			}

// Список покупок
			$query="SELECT * 
				FROM prodact_list JOIN cart ON prodact_list.id=cart.prodact_id 
				WHERE hash_id='$hash_id'";

			$result=$database->query($query);

			static $all_price = 0;
			static $number_of = 1;
			
			while($row=$result->fetch_array()){
			$id=$row["id"];
			$prodact_id = $row["prodact_id"];
			$price = $row["price"];
			$name = $row["name_of"];
			$image_src = $row["image_src"];
			$num_how_much=$row["num_how_much"];
			
			$price_off_one = $price*$num_how_much;
			$all_price+=$price_off_one;
			echo '<tr>
				<td style="width: 40px"><img src="images/small_icons/close_registration2.png" width="20px" data-id="'.$id.'" alt="Удалить товар" title="Удалить товар" class="delete_this_prodact_from_cart"></td>
				<td style="width: 200px"><img src="'.$image_src.'" width="180px" alt=""></td>
				<td style="width: 360px">'.$name.' <br> Цена: '.$price.'грн.</td>
				<td style="width: 160px; line-height: 50px; vertical-align: center;"><input type="number" name="'.$prodact_id.'" value="'.$num_how_much.'"></td>
				<td style="width: 120px">'.number_format($price_off_one, 2, '.', " ").'</td>
			</tr>';
			$number_of++;
			}

			
			

$all_price = number_format($all_price, 2, '.', " ");
			
echo <<< BEG
		</table>
		<article>
			<section> <p>Продолжить покупки</p> </section>
			<section><span>Итого: $all_price грн.</span><p>Оформить заказ</p></section>
		</article>
	</div>
BEG;
?>


<script>
// Закрытия корзины
	$('#close_basket').on('click', function(e){
		$('#block_identify').remove();
	})

// Продолжить покупки
	$('#user_basket article section p:first-child').on('click', function(e){
		$('#block_identify').remove();
	})

// Удаления продукта из корзины
	$(".delete_this_prodact_from_cart").on("click", function(e){
		var some_prodact_id = $(this).attr('data-id');
		var mynewurl2 = "movie/get_user_basket.php?some_prodact_id="+some_prodact_id;
		setTimeout(function(){
		$("#block_identify").load(mynewurl2);
		}, 100);
	})

// Изменения количества товаров в корзине
	$("input[type=number]").on("change", function(){
			var num = $(this).val();
			var prodact_id = $(this).attr('name');
					// $num_how_much = a;
					// alert(prodact_id);
					// alert(num);
			var mynewurl = "movie/get_user_basket.php?prodact_id="+prodact_id+"&num="+num;
			$("#block_identify").load(mynewurl);
	})

</script>

