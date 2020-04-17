<?php
session_start();
require_once("config.php");
require_once("functions.php");
 
//Verifica se a sessão existe
if(!isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}
 
//Verifica se o usuário já foi excluído do banco
$tbUser = $conn->prepare("select count(*) as total from usuarios where id_usuario=:id");
$tbUser->bindParam(":id",$_SESSION["user"], PDO::PARAM_INT);
$tbUser->execute();
$linha = $tbUser->fetch(PDO::FETCH_ASSOC);
if($linha["total"] < 1){
    session_destroy();
    header("Location: index.php");
    exit(); 
}
 
//Pega o nome do destinatário da mensagem
$to = isset($_POST["slUsers"])?$_POST["slUsers"]:"";
 
//Verifica se o usuário enviou alguma mensagem, caso positivo, ele chama a função interagir passando os dados do respectivo usuário como parâmetro.
 
if(isset($_POST["btnEnviar"]) && isset($_POST["txtMensagem"])){
    interagir($_SESSION["user_name"], $to, $_SESSION["sala"], strip_tags($_POST["txtMensagem"]) );
}
 
?>
<html>
<head>
<title>Chat</title>
<!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
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
<div class="cabecalho">
    <h1>Chat Online</h1>
</div>

<div style="text-align:center">
 

 
<h2 style="color:#0C3">Você está na Sala <?php echo pega_nome_sala($_SESSION["sala"]);?> 
<a class="btn btn-danger" href="sair.php">Sair da Sala</a></h2>
 
<hr />
<form action="chat.php" method="post">
<table width="709" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="516"><iframe src="interacao.php" width="500px" height="500px" frameborder="0" scrolling="yes"></iframe> </td>
    <td width="4"> </td>
    <td width="189"><?php require_once("users-online.php");?> </td>
  </tr>
  <tr>
    <td colspan="3"><?php require_once("writing.php");?> </td>
    </tr>
</table>
</form>
</div>
</body>
</html>