<?php
// CONFIGURAÇÃO DO BANCO
require_once 'config.php';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Agora valida apenas o que é realmente obrigatório
if (!empty($_POST['id']) && !empty($_POST['titulo']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'] ?? ''; // opcional
    $resolucao = $_POST['resolucao'] ?? ''; // opcional
    $status = $_POST['status'];

    if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] === 0) {
        $nomeUnico = uniqid() . "_" . basename($_FILES['nova_imagem']['name']);
        $imagem = "uploads/" . $nomeUnico;
        move_uploaded_file($_FILES['nova_imagem']['tmp_name'], $imagem);

        $sql = "UPDATE uploads SET titulo = ?, descricao = ?, resolucao = ?, imagem = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $titulo, $descricao, $resolucao, $imagem, $status, $id);
    } else {
        $sql = "UPDATE uploads SET titulo = ?, descricao = ?, resolucao = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $titulo, $descricao, $resolucao, $status, $id);
    }

    if ($stmt->execute()) {
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Por favor, preencha o Título e selecione o Status antes de salvar.');
        window.history.back();
    </script>";
}

$conn->close();
?>
