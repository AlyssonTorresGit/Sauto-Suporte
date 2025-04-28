<?php
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: lista_comandos.php');
    exit;
}

// Buscar os dados atuais
$stmt = $conn->prepare("SELECT * FROM comandos_sqls WHERE id = ?");
$stmt->execute([$id]);
$comando = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comando) {
    echo "Comando não encontrado!";
    exit;
}

// Se enviou o formulário para editar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $suporte = $_POST['suporte'] ?? '';
    $comando_sql = $_POST['comando'] ?? '';
    $instrucoes = $_POST['instrucoes'] ?? '';

    if (!empty($titulo) && !empty($suporte) && !empty($comando_sql)) {
        $stmt = $conn->prepare("UPDATE comandos_sqls SET titulo = ?, suporte = ?, comando = ?, instrucoes = ? WHERE id = ?");
        $stmt->execute([$titulo, $suporte, $comando_sql, $instrucoes, $id]);
        header('Location: ' . $base_url . 'detalhes_comando.php?id=' . $id . '&sucesso=editado');
        exit;
    } else {
        $erro = "Preencha os campos obrigatórios: Título, Suporte e Comando.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Comandos SQL</title>
    <link rel="stylesheet" href="upload_comando.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
    <!-- <style>
        .botao-editar {
            display: inline-block;
            background-color: #0077b6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
}

        .botao-editar:hover {
              background-color: #005f86;
}
        .botao-abortar {
            display: inline-block;
            background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .botao-abortar:hover {
            background-color: #5a6268;
        }
    </style> -->
</head>
<body>
    <h1>Editar Comandos SQL</h1>

    <?php if (!empty($erro)): ?>
        <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="titulo">Título*:</label><br>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($comando['titulo']) ?>" required><br><br>

        <label for="suporte">Suporte*:</label><br>
        <input type="text" id="suporte" name="suporte" value="<?= htmlspecialchars($comando['suporte']) ?>" required><br><br>

        <label for="comando">Comando SQL*:</label><br>
        <textarea id="comando" name="comando" rows="8" required><?= htmlspecialchars($comando['comando']) ?></textarea><br><br>

        <label for="instrucoes">Instruções (opcional):</label><br>
        <textarea id="instrucoes" name="instrucoes" rows="6"><?= htmlspecialchars($comando['instrucoes']) ?></textarea><br><br>

        <button type="submit">Salvar Alterações</button>
        <a href="detalhes_comando.php?id=<?= $comando['id'] ?>" class="botao-abortar" onclick="return confirm('Tem certeza que deseja cancelar a edição? As alterações não serão salvas.')">Abortar Edição</a>
    </form>

    <a href="detalhes_comando.php?id=<?= $comando['id'] ?>" class="botao-voltar">Cancelar</a>
</body>
</html>
