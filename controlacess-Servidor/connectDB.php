<?php
/* Configurações de conexão ao banco de dados*/
	$servername = "localhost";
    $Nome = "root";		//user do phpmyadmin	
    $password = "";			//password do phpmyadmin
    $dbname = "nodemculog";
    
	$conn = new mysqli($servername, $Nome, $password, $dbname);
	global $conn;
	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>