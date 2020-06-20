<?php
	//Informações para conexão com o banco de dados
	$servidor = "localhost";
	$tipo_servidor = "mysql";
	$nome_do_banco = "chat";
	$usuario = "root";
	$senha = "root";
	
	$conn = new PDO(
		"$tipo_servidor:host=$servidor;dbname=$nome_do_banco",$usuario,$senha, 
			array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false,
	        	PDO::ATTR_EMULATE_PREPARES => false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES tf8', // UTF-8 para acentuação
			));