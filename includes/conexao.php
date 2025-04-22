<?php 
// configuração do banco
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site"

//Criação conexão
$conn = new mysqli($host, $user, $pass, $db);

//verifica conexão e se há algum erro
if ($conn->connect_error){
    die("erro na conexão: " . $conn->connect_error);
}
?>