// Смена размеров екранов
	if($('body').width()>1270){
    $('body').css('overflow-x', 'hidden');
  }

  $(window).resize(function(){
  if($('body').width()>1270){
  	$('body').css('overflow-x', 'hidden');
  }
  else{
  	$('body').css('overflow-x', 'scroll');
  }
});
	
// *******************************************
$('#header_user').on('click', function(e){
    var Div = $('<div id="block_identify"></div>').css("width", "100%").css("height", "100%").css("position", "absolute").css("left", "0").css("top", "0").css("zIndex", "1000");

    $('body').append(Div);

    var entrance = $('<form class="form-3" method="POST" action="index.php"><img src="images/small_icons/close_registration.png" id="close_registration" alt="Закрыть"><p class="clearfix"><label for="login">Електронная почта<input type="text" name="name" id="login" placeholder="Електронная почта"></label></p><p class="clearfix"><label for="password">Пароль<input type="password" name="password" id="password" placeholder="Пароль"></label></p><p class="clearfix"><input type="checkbox" name="remember" id="remember"><label for="remember">Запомнить меня</label></p><p class="clearfix"><input type="submit" name="submit" value="Войти"></p><p id="registration">У меня нет аккаунта</p></form>');

    $('#block_identify').append(entrance);

    $('#registration').on('click', function(e){
      $('.form-3').remove();
      var block_registration = $('<form class="form-3" method="POST" action="index.php"><img src="images/small_icons/close_registration.png" id="close_registration" alt="Закрыть"><p class="clearfix"><label for="login">Имя<input type="text" name="login" id="login" placeholder="Имя"></label></p><p class="clearfix"><label for="email">Електронная почта<input type="email" name="email" id="email" placeholder="Електронная почта"></label></p><p class="clearfix"><label for="password">Пароль<input type="password" name="password" id="password" placeholder="Пароль"></label></p><p class="clearfix"><label for="repeat_password">Повторите пароль<input type="password" name="repeat_password" id="repeat_password" placeholder="Повторите пароль"></label></p><p class="clearfix"><input type="checkbox" name="remember" id="remember"><label for="remember">Запомнить меня</label></p><p class="clearfix"><input type="submit" name="submit" value="Регистрация"></p></form>');

    $('#block_identify').append(block_registration);
    $('#close_registration').on('click', function(e){
      $('#block_identify').remove();
    })
    })

    $('#close_registration').on('click', function(e){
      $('#block_identify').remove();
    })

  })

// Войдите в личный кабинет
// console.log($('#header_user').text());
if(($('#my_user').text())!=='Войдите в личный кабинет'){
  $('#my_user').on('mouseover', function(e) {
    // event.preventDefault();
    var exit_from = $('<div id="exit_from_user" style="position: relative; top: -5px; right: 0px; margin-bottom: 50px; width: 90px; height: 35px; line-height: 35px; text-align: center; background: #f00; color: #fff; border: 1px solid #ddd; border-radius: 5px;">Выход</div>');
    $('#header_user').append(exit_from);
    $('#header_user').on('mouseleave', function(e) {
      $('#exit_from_user').remove();
    });
    $('#exit_from_user').on('click', function(e){
      // window.open('movie/user_exit.php');
      // location.reload();
      window.location = 'movie/user_exit.php';
      // <?php
      //  setcookie('name', null, time()-5184000);
      // ?>

    })

  });
}
$('#basket').on('click', function(e){
  e.preventDefault();

  var Div = $('<div id="block_identify"></div>').css("width", "100%").css("height", "100%").css("position", "absolute").css("left", "0").css("top", "0").css("zIndex", "1000");

    $('body').append(Div);

  $("#block_identify").load( "movie/get_user_basket.php");
  
  $(".delete_this_prodact_from_cart").on("click", function(e){
    // setTimeout(function(){
    // $("#user_basket").remove();
    // //$("#block_identify").load( "movie/get_user_basket.php");
    // }, 400);
    var some_prodact_id = $(this).attr('data-id');
    var mynewurl2 = "movie/get_user_basket.php?prodact_id="+some_prodact_id;
    setTimeout(function(){
    $("#user_basket").remove();
    $("#block_identify").load(mynewurl2);
    }, 400);
  })
})


$('#search').keyup(function() {
  var searchField = $('#search').val();
  var myExp = new RegExp(searchField, "i");
  $.getJSON('json/data.json', function(data) {
    var output = '<ul class="searchresults">';
    $.each(data, function(key, val) {
      if ((val.name.search(myExp) != -1) ||
      (val.bio.search(myExp) != -1)) {
        output += '<a href='+val.href+'><li>';
        output += '<img src="'+ val.imgsrc+'" alt="'+ val.name +'" />';
        output += '<h6>'+ val.name +'</h6><span>'+val.reknown+' грн.</span><br>';
        output += '<p>'+ val.bio +'</p>';
        output += '</li></a>';
      }
    });
    output += '</ul>';
    if($('#search').val()==""){
      output='';
    }
    $('#update').html(output);

  }); //get JSON
});
$('#header_seach').focusout(function(event) {
  if($('#search').val()===""){
      output=$('#search').val();
      $('#update').html(output);
  }
  
});
