<?php
 //CONFIGURAÇÃO DO BANCO
//  $host = "sql204.infinityfree.com";
//  $user = "if0_38826779";
//  $pass = "KtfE8K8gYWz";
//  $db = "if0_38826779_meu_site";

// $conn = new mysqli($host, $user, $pass, $db);
// if ($conn->connect_error) {
//     die("Erro na conexão: " . $conn->connect_error);
// }

require_once 'config.php'

$query = $_GET['query'];
$sql = "SELECT * FROM uploads WHERE titulo LIKE '%$query%' OR descricao LIKE '%$query%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . $row['titulo'] . "</h3>";
        echo "<p>" . $row['descricao'] . "</p>";
        echo "<img src='" . $row['imagem'] . "' width='200'>";
        echo "<p>" . $row['resolucao'] . "</p>";
        echo "</div>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>