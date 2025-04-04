<?php
// Conectar ao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados
if (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['descricao'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $resolucao = $_POST['resolucao'] ?? '';

    // Verifica se uma nova imagem foi enviada
    if (!empty($_FILES['nova_imagem']['name'])) {
        $imagem = "uploads/" . basename($_FILES['nova_imagem']['name']);
        move_uploaded_file($_FILES['nova_imagem']['tmp_name'], $imagem);

        // Atualizar com nova imagem
        $sql = "UPDATE uploads SET titulo = ?, descricao = ?, resolucao = ?, imagem = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $titulo, $descricao, $resolucao, $imagem, $id);
    } else {
        // Atualizar sem modificar a imagem
        $sql = "UPDATE uploads SET titulo = ?, descricao = ?, resolucao = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titulo, $descricao, $resolucao, $id);
    }

    if ($stmt->execute()) {
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao atualizar.";
    }

    $stmt->close();
} else {
    echo "Dados inválidos.";
}

$conn->close();
?>