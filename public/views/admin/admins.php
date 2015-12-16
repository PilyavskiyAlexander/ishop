<?php

print <<< END
<div id="block">
	<ul id="menu_list">
		<li  class="active">Новый Админ</li>
		<li>Изменить пароль</li>
		<li>Удалить Админа</li>
	</ul>

<form action="movie/script_new_admin.php" method="POST">
			<br>
			<input type="text" required	name="login" placeholder=" Логин"><br>
			<input type="password" required	name="password" placeholder=" Пароль"><br>
			
			<br>
			<input type="submit" value="Создать" style="margin: 0 auto; align: centre;">
</form>
	
<form action="movie/script_update_admin.php" method="POST" style="display: none">
		<br>
			<input type="text" required	name="login" placeholder="Логин в котором нужно ИЗМЕНИТЬ пароль">
			<br>
	
		<br>
	
			<input type="password" name="password" placeholder="Новый пароль"><br>
			<br>						
			<br>
			<input type="submit" value="Изменить" style="margin: 0 auto; align: centre;">
</form>


<form action="movie/script_delete_admin.php" method="POST" style="display: none">
			<br>
	
			<input type="text" required	name="login" placeholder=" Введите логин пользователя для удаления "><br>
			
			<br>
	
	<input type="submit" value="Удалить" style="margin: 0 auto; align: centre;">
</form>

</div>
	
END;

?>
<script>
	// Переключения подвкладок (Добавить, Удалить, Изменить)

	$("#menu_list li").on('click', function (e){
		shange_content_inside(this);
	})
	
</script>