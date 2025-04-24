<?php 
 //CONFIGURAÇÃO DO BANCO
 $host = "sql204.infinityfree.com";
 $user = "if0_38826779";
 $pass = "KtfE8K8gYWz";
 $db = "if0_38826779_meu_site";

//Criação conexão
$conn = new mysqli($host, $user, $pass, $db);

//verifica conexão e se há algum erro
if ($conn->connect_error){
    die("erro na conexão: " . $conn->connect_error);
}
?>