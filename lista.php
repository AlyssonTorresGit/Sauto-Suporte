<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

// Inserção de sugestões
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['enviarSugestao'])) {
    $nome = $_POST['nome'] ?? 'Anônimo';
    $sugestao = $_POST['sugestao'] ?? '';

    if (!empty($sugestao)) {
        $stmt = $conn->prepare("INSERT INTO sugestoes (nome, sugestao, data_envio) VALUES (?, ?, NOW())");
        $stmt->execute([$nome, $sugestao]);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sauto Suporte</title>
  <link rel="stylesheet" href="estilos/lista.css">
  <link rel="stylesheet" href="header.css">
<head>
<body>
    
<?php include 'includes/templates/form_lista.php'?>
<?php include 'includes/templates/menu_navegacao.php'?>

<div class="painel-duplo">
  <!-- COLUNA DE ERROS -->
  <div class="coluna-erros">
    <div id="resultados">
      <?php
      $query = $_GET['query'] ?? null;
      if (isset($query)) {
          $sql = "SELECT * FROM uploads WHERE titulo LIKE :query OR descricao LIKE :query ORDER BY id DESC";
          $stmt = $conn->prepare($sql);
          $stmt->execute(['query' => "%$query%"]);
      } else {
          $sql = "SELECT * FROM uploads ORDER BY id DESC";
          $stmt = $conn->query($sql);
      }

      if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              echo "<div class='blocoLista'>";
              echo "<a href='detalhes.php?id=" . $row['id'] . "' class='clique-detalhe'>";
              echo "<div class='miniatura-titulo'>";
              $imagem = !empty($row['imagem']) ? 'uploads/' . $row['imagem'] : 'imagens/sem-imagem.jpeg';
              echo "<img src='" . $imagem . "' alt='Miniatura'>";
              echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";
              echo "</div></a>";

              echo "<div class='acoes-direita'>";
              $status = $row['status'] ? "<span class='tag-resolvido'>Resolvido</span>" : "<span class='tag-pendente'>Não Resolvido</span>";
              echo $status;

              if ($row['status'] == 0) {
                  echo "<a class='btn-resolver' href='editar.php?id=" . $row['id'] . "&resolver=1'>Resolver</a>";
              }

              echo "<a class='btn-detalhes' href='detalhes.php?id=" . $row['id'] . "'>Detalhes</a>";
              echo "</div>";
              echo "</div>";
          }
      } else {
          echo "Nenhum resultado encontrado.";
      }
      ?>
    </div>
  </div>

  <!-- -------------------------------COLUNA DE SUGESTÕES------------------- -->
  <aside class="lista-sugestoes">
    <h2>Erros e Sugestões de Melhorias para correções futuras</h2>
    <form method="POST" action="" style="margin-bottom: 20px;">
        <input type="text" name="nome" placeholder="Seu nome" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
        <textarea name="sugestao" placeholder="Digite sua sugestão..." required style="width: 100%; padding: 8px; height: 100px;"></textarea>
        <button type="submit" name="enviarSugestao" style="margin-top: 10px; padding: 8px 12px;">Enviar Sugestão</button>
    </form>

    <form method="GET" style="margin-bottom: 15px;">
      <label for="filtro">Filtrar por:</label>
      <select name="filtro" id="filtro" onchange="this.form.submit()" style="margin-left: 10px;">        
          <option value="todas" <?= ($_GET['filtro'] ?? '') === 'todas' ? 'selected' : '' ?>>Todas</option>
          <option value="pendentes" <?= ($_GET['filtro'] ?? '') === 'pendentes' ? 'selected' : '' ?>>Pendentes</option>
          <option value="resolvidas" <?= ($_GET['filtro'] ?? '') === 'resolvidas' ? 'selected' : '' ?>>Resolvidas</option>
      </select>
    </form>

    <?php
    $filtro = $_GET['filtro'] ?? 'todas';

    if ($filtro === 'pendentes') {
        $sqlSugestoes = "SELECT * FROM sugestoes WHERE resolvido = 0 ORDER BY data_envio DESC";
        echo "<h3>Sugestões Pendentes</h3>";
    } elseif ($filtro === 'resolvidas') {
        $sqlSugestoes = "SELECT * FROM sugestoes WHERE resolvido = 1 ORDER BY data_envio DESC";
        echo "<h3>Sugestões Resolvidas</h3>";
    } else {
        $sqlSugestoes = "SELECT * FROM sugestoes ORDER BY data_envio DESC";
        echo "<h3>Todas as Sugestões</h3>";
    }

    $stmtSugestoes = $conn->query($sqlSugestoes);

    if ($stmtSugestoes->rowCount() > 0) {
        while ($sug = $stmtSugestoes->fetch(PDO::FETCH_ASSOC)) {
            $classe = $sug['resolvido'] ? 'resolvida' : 'pendente';
            echo "<div class='sugestao-box $classe'>";
            echo "<strong>" . htmlspecialchars($sug['nome']) . ":</strong> ";
            echo "<p>" . nl2br(htmlspecialchars($sug['sugestao'])) . "</p>";
            echo "<small>Enviado em: " . $sug['data_envio'] . "</small>";

            if (!$sug['resolvido']) {
                echo "<form method='POST' action='marcar_resolvido.php' style='margin-top:10px;'>";
                echo "<input type='hidden' name='id' value='" . $sug['id'] . "'>";
                echo "<label style='display:block; margin-top:5px;'>
                        <input type='checkbox' name='resolvido' value='1'>
                        Marcar como Resolvido
                      </label>";
                // echo "<textarea name='observacao' placeholder='Observação do admin...' style='width: 100%; margin-top: 5px;'>" . htmlspecialchars($sug['observacao']) . "</textarea>";
                echo "<textarea name='observacao' placeholder='Observação do admin...' style='width: 100%; margin-top: 5px;'>" . htmlspecialchars($sug['observacao'] ?? '') . "</textarea>";
                echo "<button type='submit' style='margin-top: 5px;'>Atualizar</button>";
                echo "</form>";
            } else {
                echo "<p style='color: green; margin-top: 5px;'><strong>Status:</strong> Resolvido</p>";
                if (!empty($sug['observacao'])) {
                    echo "<p><strong>Obs:</strong> " . htmlspecialchars($sug['observacao']) . "</p>";
                }
            }

            echo "</div>";
        }
    } else {
        echo "<p>Nenhuma sugestão encontrada para este filtro.</p>";
    }

    ?>
  </aside>
</div>

<script>
  function confirmarExclusao() {
    return confirm("Tem certeza que deseja excluir este item?");
  }
</script>

</body>
</html>
