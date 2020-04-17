<?php
//Informações para conexão com o banco de dados
$servidor = "localhost";
$tipo_servidor = "mysql";
$nome_do_banco = "chat";
$usuario = "root";
$senha = "root";
 

//instancia um objeto da classe PDO chamado $conn
$conn = new PDO("$tipo_servidor:host=$servidor;dbname=$nome_do_banco",$usuario,$senha);