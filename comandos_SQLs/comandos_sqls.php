<?php
// conexão com o banco de dados
require '../config.php';

// buscar todos os comandos
$sql = "SELECT * FROM comandos ORDER BY id DESC";
$stmt = $pdo->query($sql);
$comandos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Comandos SQLs</title>
    <link rel="stylesheet" href="estilos/listar.css"> <!-- usa seu CSS -->
</head>
<body>

<h1>Gerenciar Comandos SQLs</h1>

<!-- Formulário para adicionar novo comando -->
<form method="POST" action="salvar_comando.php" class="lista">
    <input type="text" name="titulo" placeholder="Título do Comando" required class="campo-pesquisa">
    <input type="text" name="suporte" placeholder="Nome do Suporte" required class="campo-pesquisa">
    <button type="submit">Adicionar</button>
</form>

<!-- Lista de comandos cadastrados -->
<div class="painel-duplo">
    <div class="coluna-erros">

        <?php foreach ($comandos as $comando): ?>
            <div class="blocoLista">
                <div class="info">
                    <h3><?= htmlspecialchars($comando['titulo']) ?></h3>
                    <p><strong>Suporte:</strong> <?= htmlspecialchars($comando['suporte']) ?></p>
                </div>

                <div class="acoes-direita">
                    <a href="editar_comando.php?id=<?= $comando['id'] ?>" class="btn-editar">Editar</a>
                    <a href="excluir_comando.php?id=<?= $comando['id'] ?>" class="btn-resolver" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

</body>
</html>
