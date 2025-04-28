<?php

//CONFIGURAÇÃO DO BANCO
// $host = "sql204.infinityfree.com";
// $user = "if0_38826779";
// $pass = "KtfE8K8gYWz";
// $db   = "if0_38826779_meu_site";

$host = "localhost";
$user = "root";
$pass = "";
$db   = "upload_site";

try {
    // Conexão com o banco de dados usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Configura o PDO para lançar exceções em caso de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

// Variáveis globais
// $base_url = "http://alyssontorres.42web.io/";
$base_url = "http://localhost/Sauto-Suporte/";
$versao_sistema = "1.0";

?>