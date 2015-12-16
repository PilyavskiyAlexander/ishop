<?php

// $uploaddir = 'C:\WebServers\home\site.com\www\sandbox4\img';
//$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

foreach($_FILES['userfile']['tmp_name'] as $key => $value) {
	$num = uniqid();
	if (move_uploaded_file($_FILES['userfile']['tmp_name'][$key], "img/".$num.$_FILES['userfile']['name'][$key])) {
    $name = $num.$_FILES['userfile']['name'][$key];
   	
   $mysqli = new mysqli("localhost", "root", "", "base_name");
	$query="INSERT INTO img_list (name)
	VALUES ('$name')";
	$result=$mysqli -> query($query);
    

}