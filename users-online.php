<?php
//Verifica se a sessão existe
if(!isset($_SESSION["user"])){
    header("Location: index.php");
    exit();
}
 
//Cria a lista com todos os usuários online na respectiva sala.
 
$tbUsers = $conn->prepare("select * from usuarios where id_sala=:sala");
$tbUsers->bindParam(":sala", $_SESSION["sala"], PDO::PARAM_STR);
$tbUsers->execute();
 
echo "<select name='slUsers' id='slUsers' size='30' style='width:180px' >";
while($l_users = $tbUsers->fetch(PDO::FETCH_ASSOC)){
    echo "<option value='$l_users[nm_usuario]' " . isSelected($to, $l_users["nm_usuario"]) . ">$l_users[nm_usuario]</option>";
}
echo "</select>";
?>