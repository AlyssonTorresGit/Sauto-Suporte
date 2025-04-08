<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = intval($_POST['id']);
$status = isset($_POST['status']) ? 'feito' : 'pendente';
$observacao = $conn->real_escape_string($_POST['observacao_admin']);

$sql = "UPDATE sugestoes SET status='$status', observacao_admin='$observacao' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: lista.php"); // ou a página que exibe as sugestões
    exit();
} else {
    echo "Erro ao atualizar sugestão: " . $conn->error;
}

$conn->close();
?>