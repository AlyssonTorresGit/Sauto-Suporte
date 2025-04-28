<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: lista_comandos.php');
    exit;
}

// Se for exclusão (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir'])) {
    $stmt = $conn->prepare("DELETE FROM comandos_sqls WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: lista_comandos.php');
    exit;
}

// Buscar o comando
$stmt = $conn->prepare("SELECT * FROM comandos_sqls WHERE id = ?");
$stmt->execute([$id]);
$comando = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comando) {
    echo "Comando não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Comando</title>
    <link rel="stylesheet" href="estilos/detalhes_comandos.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</head>
<body>
    <h1><?= htmlspecialchars($comando['titulo']) ?></h1>

    <p><strong>Suporte:</strong> <?= htmlspecialchars($comando['suporte']) ?></p>
    <p><strong>Comando SQL:</strong><br><pre><?= htmlspecialchars($comando['comando']) ?></pre></p>

    <?php if (!empty($comando['instrucoes'])): ?>
        <p><strong>Instruções:</strong><br><?= nl2br(htmlspecialchars($comando['instrucoes'])) ?></p>
    <?php endif; ?>

    <a href="upload_comando.php" class="botao-adicionar">Adicionar Novo Comando</a><br><br>
    
    <!-- Formulário para Excluir -->
    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este comando?');">
        <a href="editar_comando.php?id=<?= $comando['id'] ?>" class="botao-editar">Editar Comando</a><br><br>
        <button type="submit" name="excluir" class="botao-excluir">Excluir Comando</button>
    </form><br>

    <a href="lista_comandos.php" class="botao-voltar">Voltar para Lista</a>
</body>
</html>

