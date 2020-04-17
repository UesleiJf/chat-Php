<?php
session_start();
require_once("config.php"); 
 
?>
<html>
<head>
<title>Chat</title>
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
 
<h1>Chat Online</h1>
 
<hr />
 
Escolha um Nickname e a Sala
 
<form action="index.php" method="post">
<table width="200" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="70" class="tab">Nome</td>
    <td width="130">
        <input type="text" name="txtNome" id="txtNome" />
    </td>
   </tr>
  <tr>
    <td class="tab">Sala</td>
    <td>
    <select name="slSala"></select>
    </td>
    </tr>
  <tr>
    <td> </td>
    <td><label>
      <input type="submit" name="btnEntrar" id="btnEntrar" value="Entrar" />
    </label></td>
    </tr>
</table>
</form>
 
 
</div>
</body>
</html>