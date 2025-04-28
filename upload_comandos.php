<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
?>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $suporte = $_POST['suporte'] ?? '';
    $comando = $_POST['comando'] ?? '';
    $instrucoes = $_POST['instrucoes'] ?? '';

    if (!empty($titulo) && !empty($suporte) && !empty($comando)) {
        $stmt = $conn->prepare("INSERT INTO comandos_sqls (titulo, suporte, comando, instrucoes) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $suporte, $comando, $instrucoes]);
        header('Location: ' . $base_url . 'lista_comandos.php?sucesso=adicionado');
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
    <title>Adicionar Comando SQL</title>
    <link rel="stylesheet" href="estilos/upload_comandos.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</head>
<body>
    <h1>Adicionar Novo Comando SQL</h1>

    <?php if (!empty($erro)): ?>
        <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="titulo">Título*:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="suporte">Suporte*:</label><br>
        <input type="text" id="suporte" name="suporte" required><br><br>

        <label for="comando">Comando SQL*:</label><br>
        <textarea id="comando" name="comando" rows="8" required></textarea><br><br>

        <label for="instrucoes">Instruções (opcional):</label><br>
        <textarea id="instrucoes" name="instrucoes" rows="6"></textarea><br><br>

        <button type="submit">Salvar Comando</button>
    </form>

    <a href="lista_comandos.php" class="botao-voltar">Voltar</a>
</body>
</html>
