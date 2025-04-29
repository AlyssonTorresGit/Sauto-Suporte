<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
?>

<?php
include 'config.php'; // Conexão PDO

// Lógica de busca
$pesquisa = $_GET['pesquisa'] ?? '';
$sql = "SELECT id, titulo FROM comandos_sqls";
if (!empty($pesquisa)) {
    $sql .= " WHERE titulo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$pesquisa%"]);
} else {
    $stmt = $conn->query($sql);
}

$comandos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Comandos SQL</title>
    <link rel="stylesheet" href="estilos/lista_comandos.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            lucide.createIcons();
        });
    </script>
</head>
<body>
    <header>
        <h1 class="pesquisa">Comandos SQL</h1>
        <form class="lista" method="GET">
            <input class="campo-pesquisa" type="text" name="pesquisa" placeholder="Pesquisar título..." value="<?= htmlspecialchars($pesquisa) ?>">
            <button class="btn-consultar" type="submit">Consultar</button>
            <a href="upload_comandos.php" class="btn-incluir"><i data-lucide="plus"></i>Adicionar Novo Comando</a>
        </form>
        <nav class="menu-navegacao">
            <ul>
            <li><a href="listar.php">Lista</a></li>
            <li><a href="lista_comandos.php">Comando SQLs</a></li>
            <li><a href="importar_xml.php">Importar XMLs</a></li>
            <li><a href="tutoriais.php">Tutoriais</a></li>
            <li><a href="novidades.php">Novidades</a></li>
            <li><a href="#">sugestoes</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="lista-comandos">
            <?php foreach ($comandos as $comando): ?>
                <div class="comando-item">
                    <a href="detalhes_comando.php?id=<?= $comando['id'] ?>">
                        <?= htmlspecialchars($comando['titulo']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
