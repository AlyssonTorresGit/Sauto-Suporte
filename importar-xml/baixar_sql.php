<?php
// baixar_sql.php - Gera o download do arquivo .sql

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["sql"])) {
    $conteudoSQL = $_POST["sql"];
    $nomeArquivo = "comandos_" . date("Y-m-d_H-i-s") . ".sql";

    header("Content-Type: application/sql");
    header("Content-Disposition: attachment; filename=\"$nomeArquivo\"");
    header("Content-Length: " . strlen($conteudoSQL));
    echo $conteudoSQL;
    exit;
} else {
    echo "Nada para baixar.";
}