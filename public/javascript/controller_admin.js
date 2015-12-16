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