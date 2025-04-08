<?php
// Conexão com banco
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID não especificado.";
    exit;
}

$sql = "SELECT * FROM uploads WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "Erro não encontrado.";
    exit;
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalhes do Erro</title>
  <style>
    
  </style>
</head>
<body>
  <div class="container">
    <h1><?= htmlspecialchars($row['titulo']) ?></h1>
    <p><strong>Suporte:</strong> <?= htmlspecialchars($row['suporte']) ?></p>

    <div class="descricao">
      <h3>Descrição do Erro:</h3>
      <p><?= nl2br(htmlspecialchars($row['descricao'])) ?></p>
    </div>

    <div class="imagem-detalhe">
      <img src="<?= $row['imagem'] ?>" alt="Imagem do erro">
    </div>

    <div class="resolucao">
      <h3>Resolução:</h3>
      <p><?= nl2br(htmlspecialchars($row['resolucao'])) ?></p>
    </div>

    <div class="btn-container">
      <a href="editar.php?id=<?= $row['id'] ?>">
        <img src="imagens-icones/alterar.JPG" alt="Editar">
      </a>

      <form method="POST" action="excluir.php" onsubmit="return confirmarExclusao();">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="imagem" value="<?= $row['imagem'] ?>">
        <button type="submit" style="background: none; border: none; padding: 0;">
          <img src="imagens-icones/excluir.JPG" alt="Excluir">
        </button>
      </form>
    </div>

    <a class="back-link" href="lista.php">← Voltar para a Lista</a>
  </div>

  <script>
    function confirmarExclusao() {
      return confirm("Tem certeza que deseja excluir este item?");
    }
  </script>
</body>
</html>