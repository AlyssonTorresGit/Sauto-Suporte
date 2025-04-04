<?php
// Conectar ao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Verifica se o ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do item no banco
    $sql = "SELECT * FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Se encontrou o item, exibe o formulário
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Item não encontrado.";
        exit();
    }

    $stmt->close();
} else {
    echo "ID não fornecido.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Editar Dados</h2>
        <form class="editarDados" action="atualizar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required><br>

            <label for="descricao">Descrição:</label>
            <textarea rows="15" name="descricao" required><?php echo $row['descricao']; ?></textarea><br>

            <label for="resolucao">Resolução:</label>
            <textarea rows="15" name="resolucao"><?php echo $row['resolucao']; ?></textarea><br>
                <!-- Exibe a imagem atual -->
            <label>Imagem Atual:</label><br>
            <img class="imagem" id="imagemAtual" src="<?php echo $row['imagem']; ?>" width="200"><br>
                <!-- Input para nova imagem -->
            <label for="nova_imagem">Nova Imagem (opcional):</label>
            <input type="file" name="nova_imagem" accept="image/*" id="novaImagemInput"><br>
            <!-- Prévia da nova imagem -->
            <div id="previewContainer" style="display: none; margin-top: 10px;">
                <p>Prévia da Nova Imagem:</p>
                <img class="imagem" id="preview" src="" alt="Prévia da nova imagem" style="max-width: 300px; border: 2px solid #000;">
            </div>

            <div class="botao-container-salvar-alteracao">
                <button class="destaque-btn btn-salvar" type="submit">
                    <img src="imagens-icones/salvar.JPG" alt="salvar">
                </button>
                <a href="lista.php" class="destaque-btn btn-abortar">
                    <img src="imagens-icones/abortar.JPG" alt="retornar">
                </a>
            </div>    
        </form>
    </main>
</body>
</html>