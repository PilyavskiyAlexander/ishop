<?php 
require_once("../../../includes/db.php");
require_once("../../../includes/functions.php");



echo '<div id="block">
	<ul id="menu_list">
		<li  class="active">Новый товар</li>
		<li>Изменить товар</li>
		<li>Удалить товар</li>
	</ul>';
echo '<form action="movie/script_new_prodact.php" method="POST" enctype="multipart/form-data">
			<br>
			<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />
    		<input name="userfile" type="file" ><br>

			<input type="text" required	name="name_of" placeholder=" Названия товара"><br>
			<input type="text" required	name="price" placeholder=" Цена"><br>
			<textarea required	name="description" placeholder=" Описания товара"></textarea><br>
			<input type="text" required	name="material" placeholder=" Материал"><br>
			<input type="text" required	name="sizes" placeholder=" Размеры"><br>
			<input type="text" required	name="color" placeholder=" Цвет"><br>
			<input type="text" required	name="manufacturer" placeholder=" Производитель"><br>
			<input type="text" required	name="code" placeholder=" Код товара"><br>
			<input type="text" required	name="label" placeholder=" Ссылка на акцию(лейбел)"><br>
			<input list="category_name" name="category_name" placeholder="Категория"><br>
					<datalist id="category_name">';
					// ООП Запрос из обьекта $database класса из includes/db.php
					$database->open_connection();

					$query="SELECT*FROM category";

					// ООП Запрос из обьекта $database класса из includes/db.php
					$result=$database->query($query);

					while($row=$result -> fetch_array()){
					$category_name = $row["category_name"];
					echo "<option>{$category_name}</option>";
					}
	echo		' </datalist> <br>
			<br>
			<input type="submit" style="margin: 0 auto; align: centre;">
</form>';

echo '<form action="movie/script_update_prodact.php" method="POST" style="display: none" id="update_tovar">
		<br>
			<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />
    		<input name="userfile" type="file" ><br>

			<input type="text" required	name="name_of" placeholder=" Названия товара"><br>
			<input type="text" required	name="price" placeholder=" Цена"><br>
			<textarea required	name="description" placeholder=" Описания товара"></textarea><br>
			<input type="text" required	name="material" placeholder=" Материал"><br>
			<input type="text" required	name="sizes" placeholder=" Размеры"><br>
			<input type="text" required	name="color" placeholder=" Цвет"><br>
			<input type="text" required	name="manufacturer" placeholder=" Производитель"><br>
			<input type="text" required	name="code" placeholder=" Код товара"><br>
			<input type="text" required	name="label" placeholder=" Ссылка на акцию(лейбел)"><br>
			<input list="category_name" name="category_name" placeholder="Категория"><br>
					<datalist id="category_name">';
					// ООП Запрос из обьекта $database класса из includes/db.php
					$database->open_connection();

					$query="SELECT*FROM category";

					// ООП Запрос из обьекта $database класса из includes/db.php
					$result=$database->query($query);

					while($row=$result -> fetch_array()){
					$category_name = $row["category_name"];
					echo "<option>{$category_name}</option>";
					}
	echo		' </datalist> <br>
			<br>
			<input type="submit" style="margin: 0 auto; align: centre;">
</form>


<form action="movie/script_delete_prodact.php" method="POST" style="display: none">
			<br>
	
			<input type="text" required	name="code" placeholder=" Код товара который нужно удалить "><br>
			
			<br>
	
	<input type="submit" value="Удалить" style="margin: 0 auto; align: centre;">
</form>

</div>';
	
?>
<script>
// Переключения подвкладок (Добавить, Удалить, Изменить)
	$("#menu_list li").on('click', function (e){
		shange_content_inside(this);
	})
</script>

<?php
echo '<table sortable>
	<caption>Менеджер товаров</caption>
	<thead>
		<tr>
			<th>ред.</th>
			<th>Изображения</th>
			<th>Названия</th>
			<th>Цена</th>
			<th>Код товара</th>
			<th>Лейбел</th>
			<th>Категория</th>
			<th>Описания</th>
			<th>Материал</th>
			<th>Размер</th>
			<th>Цвет</th>
			<th>Производитель</th>
			<th>удал.</th>
		</tr>
	</thead>
	<tbody>';
	// ООП Запрос из обьекта $database класса из includes/db.php
					$database->open_connection();
					$query="SELECT*FROM prodact_list JOIN prodact_description ON prodact_list.id=prodact_description.prodact_id ORDER BY name_of";
					// ООП Запрос из обьекта $database класса из includes/db.php
					$result=$database->query($query);
					
					while($row=$result -> fetch_array()){
					echo '<tr>';
					$id = $row["id"];

					echo "<td><a href='#block'> <img src='images/small_icons/edit.png' height='30px' title='Редактировать' class='edit_tovar' data-id=".$id."></a></td>";
					$image_src = $row["image_src"];
					$name_of = $row["name_of"];
					$price = $row["price"];
					$code = $row["code"];
					$label = $row["label"];
					$category = $row["category"];
					// Ниже для таблицы prodact_description
					$description = $row["description"];
					$material= $row["material"];
					$sizes = $row["sizes"];
					$color= $row["color"];
					$manufacturer = $row["manufacturer"];
					

					echo "<td><img src=".$image_src." alt=".$name_of." title=".$name_of." height='50px'></td>";
					echo "<td data-id=".$id.">{$name_of}</td>";
					echo "<td data-id=".$id.">{$price}</td>";
					echo "<td data-id=".$id.">{$code}</td>";
					echo "<td data-id=".$id.">{$label}</td>";
					echo "<td data-id=".$id.">{$category}</td>";
					echo "<td data-id=".$id.">{$description}</td>";
					echo "<td data-id=".$id.">{$material}</td>";
					echo "<td data-id=".$id.">{$sizes}</td>";
					echo "<td data-id=".$id.">{$color}</td>";
					echo "<td data-id=".$id.">{$manufacturer}</td>";
					echo "<td> <a href='movie/script_delete_prodact_table.php?id={$id}' target='_blank' class='delete_prodact'> <img src='images/small_icons/delete.png' title='Удалить' height='30px'></a></td>";
					echo '</tr>';
					}
		
			
		
echo	'</tbody>
</table>';

?>
<script>
// Изменяем товар в таблице товаров
	$(".edit_tovar").on('click', function(e){
		edit_content_table(this);
	})

	$(".delete_prodact").on('click', function(e){
		setTimeout(function(){
			$('#shange_content').load('views/admin/tovar.php');
		}, 1000);
		
	})
</script>
<!-- 
<script>
	$("td").one('click', function (e){
		var text_input = $(this).text();
		$(this).html('<textarea name="a">'+text_input+'</textarea>');
	})
</script> -->
<?php //require_once("../../javascript/function_admin.js"); ?>