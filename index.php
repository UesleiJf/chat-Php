<?php
session_start();
require_once("config.php"); 
require_once("functions.php");

//Pega o nome e a sala que o usuário soliciou entrar
$nome = isset($_POST["txtNome"])?strip_tags($_POST["txtNome"]):"";
$sala = isset($_POST["slSala"])?(int)$_POST["slSala"]:1;
 
//Se o nome não estiver em branco, executa uma rotina de limpeza delete_olde_entries() e inicia o chat.
if(!empty($nome)){
    delete_old_entries();
    start_chat();
}

?>
<html>
<head>
<title>Chat</title>
  <link href="bootstrap-4.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/estilo.css" rel="stylesheet">
<style>
.tab{
    background-color:#000;
    color:#FFF;
    font-size:12px;
    font-weight:bold;
    padding:4px;
}
</style>
</head>
<body>
<div style="text-align:center">
 
<h1 class="h3 mb-3 font-weight-normal">Chat Online</h1>
 
<hr />
 

 
<form action="index.php" method="post">
  <div class="divcentralizar">
    <h6 class="font-weight-normal">Informe seu nome e a sala</h6>
    <input type="text" name="txtNome" id="txtNome" class="form-control margininferior" placeholder="Nome" required autofocus>
    <label class="alinharesquerda">Sala</label>
    <select class="btn btn-info dropdown-toggle alinharesquerda" type="button" name="slSala" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="Sala" required>
    <?php
    //Lista todas as salas cadastradas no banco de dados
    $tbSala = $conn->prepare("select * from salas");
    $tbSala->execute();
    while($linha=$tbSala->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='$linha[id_sala]'>$linha[nm_sala]</option>";
    }
    ?>
    </select>
    <label class="alinhardireita">
    <input type="submit" name="btnEntrar" id="btnEntrar" value="Entrar" class="btn btn-success"/>
    </label>
  </div>
</form>
 
 
</div>
</body>
</html>