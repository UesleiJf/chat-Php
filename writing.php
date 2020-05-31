<?php
   //Verifica se a sessão existe
   if(!isset($_SESSION["user"])){
       header("Location: index.php");
       exit();
   }
?>
<table width="558" border="0" cellpadding="0" cellspacing="0" class="tabelasemborda">
   <tr class="tabelasemborda">
      <td width="350" class="tabelasemborda">
        <label>
          <textarea name="txtMensagem" cols="55" rows="3" id="txtMensagem" style="resize: none"></textarea>
        </label>
      </td>
      <td  width="154" class="centro tabelasemborda">
        <input type="submit" name="btnEnviar" id="btnEnviar" value="Enviar" class="btn btn-success"/>
      </td>
   </tr>
</table>