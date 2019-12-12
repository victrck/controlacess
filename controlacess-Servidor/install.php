<?php
	//Conectando ao Banco de Dados
    $servername = "localhost";
    $Nome = "root";		//user do phpmyadmin
    $password = "";			//password do phpmyadmin
    $dbname = "";
    
	$conn = new mysqli($servername, $Nome, $password, $dbname);

	// Criando a database
	$sql = "CREATE DATABASE nodemculog";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	echo "<br>";

	$dbname = "nodemculog";
    
	$conn = new mysqli($servername, $Nome, $password, $dbname);

	// Criando as tabelas
	$sql = "CREATE TABLE IF NOT EXISTS `logs` (
  		`id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  		`CardNumber` double DEFAULT NULL,
  		`Name` varchar(100) DEFAULT NULL,
  		`Matricula` double NOT NULL,
  		`DateLog` date DEFAULT NULL,
  		`TimeIn` time DEFAULT NULL,
  		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";

	if ($conn->query($sql) === TRUE) {
	    echo "Table logs created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}
echo "<br>";
	$sql = "CREATE TABLE IF NOT EXISTS `users` (
 		`id` int(11) NOT NULL AUTO_INCREMENT,
 		`Nome` varchar(100) NOT NULL,
 		`Matricula` double DEFAULT NULL,
 		`Permissao` varchar(30) DEFAULT NULL,
 		`TempoEntrada` time DEFAULT NULL,
 		`TempoSaida` time DEFAULT NULL,
 		`CardID` double NOT NULL,
 		`CardID_select` tinyint(1) NOT NULL,
 		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";

	if ($conn->query($sql) === TRUE) {
	    echo "Table users created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}
echo "<br>";
	$sql = "CREATE TABLE IF NOT EXISTS `admin` (
 		`id` int(11) NOT NULL AUTO_INCREMENT,
 		`user` varchar(30) NOT NULL,
 		`senha` varchar(30) NOT NULL,
 		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";

	if ($conn->query($sql) === TRUE) {
	    echo "Table admin created successfully";
	} else {
	    echo "Error creating table: " . $conn->error;
	}
echo "<br>";
    $sql = "INSERT INTO admin(user, senha) VALUES('admin','root')";
    if ($conn->query($sql) === TRUE) {
	    echo "Admin criado com sucesso";
	} else {
	    echo "Error creating table: " . $conn->error;
	}

	$conn->close();
?>