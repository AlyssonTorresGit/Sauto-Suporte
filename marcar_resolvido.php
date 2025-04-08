<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $resolvido = isset($_POST['resolvido']) ? 1 : 0;
    $observacao = $_POST['observacao'] ?? '';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    // Protegendo contra SQL Injection
    $id = (int)$id;
    $observacao = $conn->real_escape_string($observacao);

    $sql = "UPDATE sugestoes SET resolvido = $resolvido, observacao = '$observacao' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: lista.php"); // Redireciona de volta para a tela de sugestões
        exit();
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Requisição inválida.";
}
?>