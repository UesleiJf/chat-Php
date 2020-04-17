<?php
session_start();
require_once("config.php"); 
 
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
    </select>
    <label class="alinhardireita">
    <input type="submit" name="btnEntrar" id="btnEntrar" value="Entrar" class="btn btn-success"/>
    </label>
  </div>
</form>
 
 
</div>
</body>
</html>