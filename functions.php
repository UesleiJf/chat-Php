<?php
//--------------------------------------------------------------------Funções específicas do Chat:
 
//Cria as interações na tabela interações.
function interagir($from, $to, $sala, $chat){
    global $conn;
    
    $now = date("Y-m-d H:i:s");
    
    $tbInt = $conn->prepare("insert into interacoes values(:nome, :sala, :data, :chat, :to)");
    $tbInt->bindParam(":nome", $from, PDO::PARAM_STR);
    $tbInt->bindParam(":sala", $sala, PDO::PARAM_INT);
    $tbInt->bindParam(":data", $now, PDO::PARAM_STR);
    $tbInt->bindParam(":chat", $chat, PDO::PARAM_STR);
    $tbInt->bindParam(":to", $to, PDO::PARAM_STR);
    $tbInt->execute();
}
 
//Insere o usuário na tabela ususarios, configura as sessões, cria a interação de entrada na sala e redireciona o usuário para a página principal do chat.
function start_chat(){
    global $conn, $nome, $sala;
    
    $unique_name = get_unique_name($nome,$nome);
    $now = date("Y-m-d H:i:s");
    
    //Insere o usuario no banco
    $insert = $conn->prepare("insert into usuarios(nm_usuario, id_sala, dt_refresh) values(:nm,:sala, :now)");
    $insert->bindParam(":nm", $unique_name, PDO::PARAM_STR);
    $insert->bindParam(":sala", $sala, PDO::PARAM_INT); 
    $insert->bindParam(":now", $now, PDO::PARAM_STR);       
    $insert->execute();
    $_SESSION["user"] = $conn->lastInsertId();
    $_SESSION["user_name"] = $unique_name;
    $_SESSION["sala"] = $sala;
    $_SESSION["data_logon"] = $now;
    interagir($_SESSION["user_name"], "", $_SESSION["sala"], "Entrou na sala.");
    header("Location: chat.php");
    
}
 
 
//Função que garante um nome única na respectiva sala. Caso o nome já existe, essa função insere um underline no final do nome e vai incrementando valores até que o nome gerado não tenha sido utiliado por outro usuário ativo na sala.
function get_unique_name($nome_original, $nome_alterado, $repetido=1){
    global $conn, $sala;
    
    $tbUsers = $conn->prepare("select count(*) as total from usuarios where id_sala =:sala and nm_usuario =:nm");
    $tbUsers->bindParam(":sala",$sala, PDO::PARAM_INT);
    $tbUsers->bindParam(":nm",$nome_alterado, PDO::PARAM_STR);  
    $tbUsers->execute();
    $linha = $tbUsers->fetch(PDO::FETCH_ASSOC);
    
    if($linha["total"]>0){
        echo $nome_alterado;
        echo "<br>";
        return get_unique_name($nome_original, $nome_original . "_" . $repetido, ($repetido+1));
    }else{
        return $nome_alterado;  
    }
}
 
 
// Exclui os usuários onde não houve refresh na página há mais de 16 segundos.
function delete_offline_users(){
    global $conn;
    
    $now = date("Y/m/d H:i:s");
    $past16s = makeDataTime($now, 0,0,0,0,0,-16);
    
    //Seleciona usuarios ativos
    $ativos = $conn->prepare("select id_usuario from usuarios where dt_refresh > :dt");
    $ativos->bindParam(":dt", $past16s, PDO::PARAM_STR);
    $ativos->execute();
    $ativos = $ativos->fetchAll(PDO::FETCH_NUM|PDO::FETCH_COLUMN);
    $ativos_ = "";
    
    if(count($ativos)<=0) return;
    
    $ativos = implode(",", $ativos);
 
    //Pega dados dos usuarios e cria interacao de saída
    $tbUser = $conn->prepare("select nm_usuario, id_sala from usuarios where id_usuario not in($ativos)");
    $tbUser->execute();
    while($l = $tbUser->fetch(PDO::FETCH_ASSOC)){
        interagir($l["nm_usuario"], "", $l["id_sala"], "Saiu da sala.");
    }
    
    //Exclui usuarios inativos
    $del = $conn->prepare("delete from usuarios where id_usuario not in($ativos)");
    $del->execute();    
}
 
//Exclui interações antigas, criadas há 10 horas atrás ou mais.
function delete_old_entries(){
    global $conn;
    
    $now = date("Y/m/d H:i:s");
    $past10h = makeDataTime($now, 0,0,0,-10,0,0);
    
    //Excluir Interações antigas (10 horas)
    $del = $conn->prepare("delete from interacoes where dt_interacao < :dt");
    $del->bindParam(":dt", $past10h, PDO::PARAM_STR);
    $del->execute();
}
 
//Como o nome sugere, retorna o nome de uma dada sala. Deve-se passar o id da sala que desejas o nome, como parâmetro.
function pega_nome_sala($id_sala){
    global $conn;
    
    $tbSala = $conn->prepare("select nm_sala from salas where id_sala=:id");
    $tbSala->bindParam(":id", $id_sala, PDO::PARAM_INT);
    $tbSala->execute();
    $l = $tbSala->fetch(PDO::FETCH_ASSOC);
    return $l["nm_sala"];
}
 
//--------------------------------------------------------------------Funções gerais:
function makeData($data, $anoConta,$mesConta,$diaConta){
   $ano = substr($data,0,4);
   $mes = substr($data,5,2);
   $dia = substr($data,8,2);
   return date('Y-m-d',mktime (0, 0, 0, $mes+($mesConta), $dia+($diaConta), $ano+($anoConta))); 
}
 
function makeDataTime($data, $anoConta,$mesConta,$diaConta, $horaConta, $minutoConta, $segundoConta){
   $ano = substr($data,0,4);
   $mes = substr($data,5,2);
   $dia = substr($data,8,2);
   $hora = substr($data,11,2);
   $minuto = substr($data,14,2);
   $segundo = substr($data,17,2);
   
   return date('Y-m-d H:i:s',mktime ($hora+($horaConta), $minuto+($minutoConta), $segundo+($segundoConta), $mes+($mesConta), $dia+($diaConta), $ano+($anoConta)));  
}
 
function isSelected($campo, $varCampo){
    if($campo==$varCampo) return " selected=selected ";
    return "";
}
 
function isEmpty($campo,$name){
    global $msg;
    if(str_replace(" ","",$campo)==""){
       $msg = "O campo " . $name . " não foi preenchido corretamente! A ação foi cancelada!";
       return true; 
    }
    return false;
}
 
 
function isValidEmail($value){
    $pattern = "/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/";
    return preg_match($pattern, $value);
}
 
 
function isDate($date){
    $char = strpos($date, "/")!==false?"/":"-";
    $date_array = explode($char,$date);
    if(count($date_array)!=3) return false;
    return checkdate($date_array[1],$date_array[0],$date_array[2])?($date_array[2] . "-" . $date_array[1] . "-" . $date_array[0]):false;
}
 
?>