<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario de pesquisa comandos sqls</title>
</head>
<body>
    <header>
        <form class="lista" method="GET">
            <input class="campo-pesquisa" type="text" name="pesquisa" placeholder="Pesquisar título..." value="<?= htmlspecialchars($pesquisa) ?>">
            <button class="btn-consultar" type="submit">Consultar</button>
            <a href="upload_comandos.php" class="btn-incluir"><i data-lucide="plus"></i>Adicionar Novo Comando</a>
        </form>
    </header>
</body>
</html>