<?php
   session_start();
   require_once("config.php");
   require_once("functions.php");
    
   //Verifica se a sessão existe
   if(!isset($_SESSION["user"])){
       header("Location: index.php");
       exit();
   }

 ?>
<html>
   <head>
      <META HTTP-EQUIV="Refresh" CONTENT="6;URL=interacao.php">
   </head>
   <body onLoad="pageScroll()">
      <script>
         // horizontal and vertical scroll increments
         //scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
         function pageScroll() {
         window.scrollBy(0,1000000); 
         }
          
      </script>
      <?php
         //Atualiza data do refresh
         $now = date("Y-m-d H:i:s");
         $tbUp = $conn->prepare("update usuarios set dt_refresh =:refresh where id_usuario=:id");
         $tbUp->bindParam(":refresh", $now, PDO::PARAM_STR);
         $tbUp->bindParam(":id", $_SESSION["user"], PDO::PARAM_INT);
         $tbUp->execute();
          
         //Exclui os usuários inativos
         delete_offline_users();
          
         //Lista todas as entradas desde que o usuario entrou.
         $tbChat = $conn->prepare("select nm_usuario, ds_interacao, nm_destinatario, DATE_FORMAT(dt_interacao, '%H:%i:%s') as dt_interacao from interacoes where dt_interacao >= :data and id_sala=:sala order by dt_interacao ASC");
         $tbChat->bindParam(":data", $_SESSION["data_logon"], PDO::PARAM_STR);
         $tbChat->bindParam(":sala", $_SESSION["sala"], PDO::PARAM_INT);
         $tbChat->execute();
          
         while($lChat = $tbChat->fetch(PDO::FETCH_ASSOC)){
             $chat = $lChat["nm_destinatario"] == ""?strip_tags($lChat["ds_interacao"]):"fala com <strong>$lChat[nm_destinatario]:</strong><span style='color:#006699'> " . strip_tags($lChat["ds_interacao"]) . "</span>";
             echo "<div style='font-family:tahoma;font-size:12px;padding:4px;'>";

             echo "<strong class='corusuario'>
                      $lChat[nm_usuario]
                  </strong> $chat <span style='color:#cccccc'>$lChat[dt_interacao]</span>";
             echo "</div>";
         }
      ?>
   </body>
</html>