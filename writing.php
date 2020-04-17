<?php
//Verifica se a sessão existe
if(!isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}
 
?>
 
<table width="558" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="377"><label>
      <textarea name="txtMensagem" cols="60" rows="3" id="txtMensagem"></textarea>
    </label></td>
    <td width="27"> </td>
    <td width="154"><input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar Mensagem" style="padding-left:4px" /></td>
  </tr>
</table>