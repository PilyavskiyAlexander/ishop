<?php
require_once("../../../includes/db.php");
require_once("../../../includes/functions.php");

echo <<< END
<div id="block">
	<ul id="menu_list">
		<li  class="active">Новая категория</li>
		<li>Изменить категорию</li>
		<li>Удалить категорию</li>
	</ul>

<form action="movie/script_new_category.php" method="POST">
			<br>
			<input type="text" required	name="category_name" placeholder=" Названия категории"><br>
			<input type="text" required	name="category" placeholder=" Cсылка на страницу категории"><br>
			<br>
			<input type="submit" style="margin: 0 auto; align: centre;">
</form>
END;
?>
<?php
echo '<form action="movie/script_update_category.php" method="POST" style="display: none">
		<br>
		<br>
				<input list="category_name" name="category_name"><br>
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
			<input type="text" name="new_name" required placeholder="Новое названия категории"><br>
			<input type="text" name="category" required placeholder="Ссылка на страницу категории"><br>
						
			<br>
			<input type="submit" value="Изменить" style="margin: 0 auto; align: centre;">
</form>';
?>
<?php
echo '<form action="movie/script_delete_category.php" method="POST" style="display: none">
			<br>
				<input list="category_name" name="category_name"><br>
				<datalist id="category_name">';

// ООП Запрос из обьекта $database класса из includes/db.php
					$database->open_connection();

					$query="SELECT*FROM category";

// ООП Запрос из обьекта $database класса из includes/db.php
					$result=$database->query($query);


					while($row=$result -> fetch_array()){
					$category_name = $row["category_name"];
					$id = $row["id"];
					echo "<option>{$category_name}</option>";
					}
				
			echo	'</datalist>
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