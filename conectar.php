<?php   
$database   = "localhost"; // SERVER   
$dbname     = "miqtekudo"; // DATABASE 
$usuario    = "root"; // USER
$dbsenha    = ""; // PASSWORD

$URL_GERAL  = "http://localhost/oldprojects/friendsapp_2013/"; // SYSTEM URL

$conexao    = mysqli_connect($database, $usuario, $dbsenha, $dbname);

if ($conexao) {
      if(mysqli_select_db($conexao, $dbname)){
            print "";
      }else{
            print "Não foi possível selecionar o Banco de Dados";
      }
}else{
      print "Erro ao conectar o MySQL";
}
?>