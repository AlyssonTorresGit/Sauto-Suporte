<?php
require 'config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Se for envio de edição
    if (isset($_POST['titulo']) && isset($_POST['suporte'])) {
        $titulo = trim($_POST['titulo']);
        $suporte = trim($_POST['suporte']);

        if (!empty($titulo) && !empty($suporte)) {
            $sql = "UPDATE comandos SET titulo = :titulo, suporte = :suporte WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':titulo' => $titulo,
                ':suporte' => $suporte,
                ':id' => $id
            ]);

            header("Location: comandos.php");
            exit;
        }
    }

    // Busca comando atual
    $sql = "SELECT * FROM comandos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $comando = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$comando) {
        header("Location: comandos.php");
        exit;
    }
} else {
    header("Location: comandos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Comando</title>
    <link rel="stylesheet" href="listar.css">
</head>
<body>

<h1>Editar Comando</h1>

<form method="POST" class="lista">
    <input type="text" name="titulo" value="<?= htmlspecialchars($comando['titulo']) ?>" required class="campo-pesquisa">
    <input type="text" name="suporte" value="<?= htmlspecialchars($comando['suporte']) ?>" required class="campo-pesquisa">
    <button type="submit">Salvar Alterações</button>
    <a href="comandos.php" class="btn-detalhes">Cancelar</a>
</form>

</body>
</html>
