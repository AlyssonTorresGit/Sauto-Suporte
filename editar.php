<?php
// Conectar ao banco de dados
require_once 'config.php';

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
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    
        if (isset($_GET['resolver']) && $_GET['resolver'] == 1) {
            $row['status'] = '1'; // Correção: status como string numérica
        }
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
    <link rel="stylesheet" href="estilos/editar.css">
    <script url="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main>
        <h1>Editar Dados</h1>
        <form id="formEditar" class="editarDados" action="atualizar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <label for="titulo">Título:</label>
                <input type="text" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" required><br>

            <label for="descricao">Descrição:</label>
                <textarea rows="15" name="descricao"><?php echo htmlspecialchars($row['descricao']); ?></textarea><br>

            <label for="resolucao">Resolução:</label>
                <textarea rows="15" name="resolucao"><?php echo htmlspecialchars($row['resolucao']); ?></textarea><br>

            <div class="status-container">
                <label>Status:</label><br>
                    <input type="radio" id="resolvido" name="status" value="1" <?php if ($row['status'] == '1') echo 'checked'; ?>>
                <label class="resolvido" for="resolvido">Resolvido</label>
                    <input type="radio" id="nao_resolvido" name="status" value="0" <?php if ($row['status'] == '0') echo 'checked'; ?>>
                <label class="nao_resolvido" for="nao_resolvido">Não resolvido</label>
            </div>

            <label>Imagem Atual:</label><br>
                <img class="imagem" id="imagemAtual" src="<?php echo $row['imagem']; ?>" width="200"><br>

            <label for="nova_imagem">Nova Imagem (opcional):</label>
                <input type="file" name="nova_imagem" accept="image/*" id="novaImagemInput"><br>

            <div id="previewContainer" style="display: none; margin-top: 10px;">
                <p>Prévia da Nova Imagem:</p>
                <img class="imagem" id="preview" src="" alt="Prévia da nova imagem" style="max-width: 500px; border: 2px solid #000;">
            </div>

            <div class="botao-container-salvar-alteracao">
                <button class="destaque-btn btn-salvar" type="submit">Salvar</button>
                <a href="lista.php" class="destaque-btn btn-abortar" onclick="return confirmarCancelar();">Cancelar</a>
                <script>
                    function confirmarCancelar() {
                    return confirm("Tem certeza que deseja cancelar as alterações?");
                 }
                </script>
            </div>    
        </form>
    </main>

<script>
// Pré-visualizar nova imagem
document.getElementById('novaImagemInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            document.getElementById('previewContainer').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Validação antes de enviar
document.getElementById('formEditar').addEventListener('submit', function(event) {
    const status = document.querySelector('input[name="status"]:checked');
    if (!status) {
        event.preventDefault();
        
        Swal.fire({
            icon: 'warning',
            title: 'Status obrigatório',
            text: 'Por favor, selecione se está resolvido ou não resolvido antes de salvar!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok, vou marcar!'
        });

       /* alert('Por favor, selecione se está resolvido ou não resolvido.');
    }*/
});

// ESC para voltar
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        window.history.back();
    }
});
</script>

</body>
</html>
