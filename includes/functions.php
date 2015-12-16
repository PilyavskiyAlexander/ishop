<?php 
  	// Проверка пройшло ли соеденения с БД
	function confirm_query($result_set){
		if (!$result_set) {
			die("Не удалось подключится к базе данных!");
		}
	}
	// **********************************
	function sanitizeString($var){
		$var = stripcslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		return $var;
	}
	function sanitizeMYSQL($connection, $var){
		$var = $connection->real_escape_string($var);
		$var = sanitizeString($var);
		return $var;
	}
	

	function request_url()
{
  $result = ''; // Пока результат пуст
  $default_port = 80; // Порт по-умолчанию
 
  // А не в защищенном-ли мы соединении?
  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
    // В защищенном! Добавим протокол...
    $result .= 'https://';
    // ...и переназначим значение порта по-умолчанию
    $default_port = 443;
  } else {
    // Обычное соединение, обычный протокол
    $result .= 'http://';
  }
  // Имя сервера, напр. site.com или www.site.com
  $result .= $_SERVER['SERVER_NAME'];
 
  // А порт у нас по-умолчанию?
  if ($_SERVER['SERVER_PORT'] != $default_port) {
    // Если нет, то добавим порт в URL
    $result .= ':'.$_SERVER['SERVER_PORT'];
  }
  // Последняя часть запроса (путь и GET-параметры).
  $result .= $_SERVER['REQUEST_URI'];
  // Уфф, вроде получилось!
  return $result;
}

function get_new_hash(){
  if (isset($_COOKIE['hash'])){
  $hash=$_COOKIE['hash'];
  }
  else{
  $hash=md5(1000, 10000000);

  $database->open_connection();
  
  $query="INSERT INTO new_hash 
  (hash) 
  VALUES('$hash')";

  $database->query($query);
  }
  setcookie("hash", $hash, time()+3600);
  
}
?>