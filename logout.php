<?php
	//Destrói a sessão e redireciona o usuário para a página de início do chat.
	session_start();
	session_destroy();
	header("Location: index.php");
?>