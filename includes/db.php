<?php
require_once("config.php");

class MySQLDatabase {
	
	private $connection;
	
	function __construct() {
	  $this->open_connection();
	}
 
	// Открываем соеденения
	public function open_connection() {
		$this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		
		if (!$this->connection) {
			// die("Не удалось подключится к базе данных: " . mysql_error());
		} 
	}

	// Закрываем соеденения
	public function close_connection() {
		if(isset($this->connection)) {
			$this->connection->close();
		}
	}

	public function query($query) {
		$result=$this->connection -> query($query);
	 	return $result;
	}
	
	// Выбор товаров с базы данных по id
	public function find_all_prodacts() {
		$query="SELECT * 
				FROM prodact_list ";
		return $query;
	}
	
	// Выбор всех товаров
	public function find_prodact_by_id($id) {
		
		$id=$this->escape_value($id);
		$query="SELECT * 
				FROM prodact_list 
				WHERE id='$id' 
				LIMIT 1";
		return $query;
	}
	
	// Проверка значения для безопасного запроса в SQL
	public function escape_value($value) {
		$value=$this->connection->real_escape_string($value);
		return $value;
	}
	
	// Возврат id последнего добавленого элемента
	public function insert_prodact_id() {
		$prodact_id=$this->connection->insert_id;
	 	return $prodact_id;
	}

	// Проверка на наличия ошибок
	public function find_error(){
		$my_error = $this->connection->connect_error;
		return $my_error;
	}

	// // "Методы которые позволяют изменить базу данных без проблем с кодом
 //  public function fetch_array($result_set) {
 //    return mysql_fetch_array($result_set);
 //  }
  
 //  public function num_rows($result_set) {
 //   return mysql_num_rows($result_set);
 //  }
  
  // public function insert_id() {
  //   // Выбор по id
  //   return mysql_insert_id($this->connection);
  // }
  
 //  public function affected_rows() {
 //    return mysql_affected_rows($this->connection);
 //  }
	
	// private function confirm_query($result) {
	// 	if (!$result) {
	// 		die("Database query failed: " . mysql_error());
	// 	}
	// }
	
}

$database = new MySQLDatabase();

?>