<?php 
// CONFIGURAÇÃO DO BANCO
// $host = "sql204.infinityfree.com";
// $user = "if0_38826779";
// $pass = "KtfE8K8gYWz";
// $db   = "if0_38826779_meu_site";


// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "upload_site";

require_once 'config.php';

//Conexão com o MySQL
$conn = new mysqli($host, $user, $pass, $db);

//Verifica a conexão
if ($conn->connect_error){
    die("Erro na conexão com o banco de dados: " . $conn->connect_erro);
}

//Variaveis Globais
$base_url = "http://alyssontorres.42web.io/";
$versão_sistema = "1.0";

?>