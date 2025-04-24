<?php
 //CONFIGURAÇÃO DO BANCO
 $host = "sql204.infinityfree.com";
 $user = "if0_38826779";
 $pass = "KtfE8K8gYWz";
 $db = "if0_38826779_meu_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (isset($_POST['id'], $_POST['titulo'], $_POST['descricao'], $_POST['status'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $resolucao = $_POST['resolucao'] ?? '';
    $status = $_POST['status'];

    // Debug: Remover depois
    // echo "Status recebido: $status";

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
    echo "Dados inválidos.";
}

$conn->close();
?>