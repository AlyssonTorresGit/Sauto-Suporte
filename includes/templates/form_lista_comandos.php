<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comandos sqls</title>
    <link rel="stylesheet" href="includes/templates/header.css">
</head>
    <header>
        <form class="lista" method="GET">
            <input class="campo-pesquisa" type="text" name="pesquisa" placeholder="Pesquisar Comandos..." value="<?= htmlspecialchars($pesquisa) ?>">
            <button class="btn-consultar" type="submit">Consultar</button>
            <a href="upload_comandos.php" class="btn-incluir"><i data-lucide="plus"></i>Incluir</a>
        </form>
    </header>

</html>