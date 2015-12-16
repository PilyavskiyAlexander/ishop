// <!-- Подгружаем AJAX -> контент работы с базами данных в #shange_content-->
function shange_content_ajax(e){

		if ($('#content nav a')[0]==e){
			$('#shange_content').load('views/admin/tovar.php');
		}
		else if ($('#content nav a')[1]==e){
			$('#shange_content').load('views/admin/category.php');
		}
		else if ($('#content nav a')[2]==e){
			$('#shange_content').load('views/admin/admins.php');
		}
}
// *******************************************************************

// Переключения подвкладок (Добавить, Удалить, Изменить)
function shange_content_inside(e){
	$("#block form").css('display', 'none');
		
		$("#menu_list li").removeClass('active');
		if(e==$("#menu_list li")[0]){
			$("#block form:eq(0)").css('display', 'block');
		}
		else if(e==$("#menu_list li")[1]){
			$("#block form:eq(1)").css('display', 'block');	
		}
		else if(e==$("#menu_list li")[2]){
			$("#block form:eq(2)").css('display', 'block');
		}
		$(e).addClass('active');
}
// ********************************************************************

// Изменяем товар в таблице товаров
function edit_content_table(e){
		$("#block form").css('display', 'none');
		$("#block form:eq(1)").css('display', 'block');
		$("#menu_list li").removeClass('active');
		$("#menu_list li:eq(1)").addClass('active');
		var arr = $(e).parent().parent().parent().children();
		var arr_input = $("#update_tovar input");

		var texta = $(arr[7]).text();
		$("#update_tovar textarea").text(texta);
		
		var code = $(arr[6]).text();
		$(arr_input[0]).attr('value', code);

		// var image_src = $(arr[1]).children().attr('src');
		// $(arr_input[1]).attr('value', image_src);

		var name_of = $(arr[2]).text();
		$(arr_input[2]).attr('value', name_of);

		var price = $(arr[3]).text();
		$(arr_input[3]).attr('value', price);

		var code = $(arr[4]).text();
		$(arr_input[8]).attr('value', code);

		var category = $(arr[6]).text();
		$(arr_input[10]).attr('value', category);

		var label = $(arr[5]).text();
		$(arr_input[9]).attr('value', label);

		var material = $(arr[8]).text();
		$(arr_input[4]).attr('value', material);

		var sizes = $(arr[9]).text();
		$(arr_input[5]).attr('value', sizes);

		var color = $(arr[10]).text();
		$(arr_input[6]).attr('value', color);

		var manufacturer = $(arr[11]).text();
		$(arr_input[7]).attr('value', manufacturer);
}
// ********************************************************************

