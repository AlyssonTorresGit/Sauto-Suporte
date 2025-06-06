<?php
// Conexão com banco
require_once 'config.php';

 $conn = new mysqli($host, $user, $pass, $db);
 if ($conn->connect_error) {
     die("Erro na conexão: " . $conn->connect_error);
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID não especificado.";
    exit;
}

// $sql = "SELECT * FROM uploads WHERE id = :id";
// $stmt = $conn->prepare($sql);
// $stmt->execute(['id' => $id]);
// $row = $stmt->fetch(PDO::FETCH_ASSOC);

// if (!$row) {
//     echo "Erro não encontrado.";
//     exit;
// }

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
  <link rel="stylesheet" href="estilos/detalhes.css">
</head>
<body>
  
  <div class="container">
    <h1>Detalhes</h1>
    <h2><?= htmlspecialchars($row['titulo']) ?></h2>
    <p><strong>Criado por Suporte:</strong> <?= htmlspecialchars($row['suporte']) ?></p>

    <div class="descricao">
      <h3>Descrição do Erro:</h3>
      <p><?= nl2br(htmlspecialchars($row['descricao'])) ?></p>
    </div>
<?php
$imagem = $row['imagem'];
$caminho = "uploads/" . $imagem;
$caminhoImagem = (empty($imagem) || !file_exists($caminho)) ? "imagens/sem-imagem.jpeg" : $caminho;
?>

<div class="imagem-detalhe">
  <img src="<?= $caminhoImagem ?>" alt="Imagem do erro">
</div>


    <!-- <div class="imagem-detalhe">
      <img src="uploads/<?= $row['imagem'] ?>" alt="Imagem do erro">
    </div> -->

    <div class="resolucao">
      <h3>Resolução:</h3>
      <p><?= nl2br(htmlspecialchars($row['resolucao'])) ?></p>
    </div>

    <div class="btn-container">
      <a href="editar.php?id=<?= $row['id'] ?>">Editar</a>

      <form method="POST" action="excluir.php" onsubmit="return confirmarExclusao();">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="imagem" value="<?= $row['imagem'] ?>">
        <button type="submit" class="botao-excluir">Excluir</button>
      </form>
    </div>

    <a class="back-link" href="lista.php">← Voltar para a Lista</a>
  </div>

  <script>
    function confirmarExclusao() {
      return confirm("Tem certeza que deseja excluir este item?");
    }
  </script>
  <script>
  document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
      window.history.back(); // Volta para a página anterior
    }
  });
</script>

</body>
</html>