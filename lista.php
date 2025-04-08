<?php
// 🔧 CONFIGURAÇÃO DO BANCO
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

// 📩 Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['enviarSugestao'])) {
    $nome = $_POST['nome'] ?? 'Anônimo';
    $sugestao = $_POST['sugestao'] ?? '';

    if (!empty($sugestao)) {
        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $nome = $conn->real_escape_string($nome);
        $sugestao = $conn->real_escape_string($sugestao);

        $conn->query("INSERT INTO sugestoes (nome, sugestao, data_envio) VALUES ('$nome', '$sugestao', NOW())");

        $conn->close();

        // Evita reenvio ao atualizar
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
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    .painel-duplo {
      display: flex;
      gap: 20px;
      align-items: flex-start;
      flex-wrap: wrap;
    }

    .coluna-erros {
      flex: 2;
      min-width: 300px;
    }

    .lista-sugestoes {
      flex: 1;
      background-color: #f1f1f1;
      padding: 15px;
      border-radius: 10px;
      max-height: 80vh;
      overflow-y: auto;
      min-width: 250px;
    }

    .sugestao-box {
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 6px;
    }

    .pesquisa {
      margin-top: 0;
    }

    .lista {
      margin-bottom: 20px;
    }

    .campo-pesquisa {
      padding: 8px;
      width: 200px;
    }

    .blocoLista {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      background: #fff;
    }

    .divImagemView {
      margin-top: 10px;
    }

    .btn-consultar img,
    .btn-inclur img {
      height: 20px;
    }
    .sugestao-box.resolvida {
     background-color: #e0ffe0;
     border-left: 5px solid green;
    }
    .sugestao-box.pendente {
    border-left: 5px solid orange;
    }
  </style>
</head>
<body>

  <h1 class="pesquisa">Base de Conhecimentos - Sauto Suporte</h1>
  <h2 class="pesquisa">Pesquisar Erros</h2>
  <form class="lista" method="GET">
    <input class="campo-pesquisa" type="text" name="query" placeholder="Digite sua pesquisa">
    <button class="btn-consultar" type="submit">
      <img src="imagens-icones/consultar.JPG" alt="consultar">
    </button>
    <a class="btn-inclur" href="upload.html">
      <img src="imagens-icones/incluir.JPG" alt="incluir">
    </a>
  </form>

  <div class="painel-duplo">
    <!-- COLUNA DE ERROS -->
    <div class="coluna-erros">
         <div id="resultados">
            <?php
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db = "upload_site";

            $conn = new mysqli($host, $user, $pass, $db);
            if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
            }

            $query = $_GET['query'] ?? null;
            if (isset($query)) {
            $sql = "SELECT * FROM uploads WHERE titulo LIKE '%$query%' OR descricao LIKE '%$query%' ORDER BY id DESC";
            } else {
            $sql = "SELECT * FROM uploads ORDER BY id DESC";
            }
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
            echo "<div class='blocoLista'>";
            echo "<h3 class='tiltulo-lista'>" . $row['titulo'] . "</h3>";
            echo "<p><strong>Suporte:</strong> " . htmlspecialchars($row['suporte']) . "</p>";
            echo "<p>" . $row['descricao'] . "</p>";
            echo "<div class='divImagemView'>";
            echo "<img class='imagem img-preview' src='" . $row['imagem'] . "' width='200'>";
            echo "</div>";
            echo "<p>" . $row['resolucao'] . "</p>";

            echo "<form class='formEditarExcluir' method='POST' action='excluir.php' onsubmit='return confirmarExclusao();'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='hidden' name='imagem' value='" . $row['imagem'] . "'>";
            echo "<div class='container'>";
            echo "<a href='editar.php?id=" . $row['id'] . "' class='destaque-btn btn-QSaoImagens btn btn-editar'>";
            echo "<img src='imagens-icones/alterar.JPG' alt='Alterar'>";
            echo "</a>";
            echo "<button type='submit' class='destaque-btn btn-QSaoImagens btn btn-excluir'>";
            echo "<img src='imagens-icones/excluir.JPG' alt='Excluir'>";
            echo "</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            }
            } else {
            echo "Nenhum resultado encontrado.";
            }

            $conn->close();
            ?>
      </div>
    </div>

    <!-- COLUNA DE SUGESTÕES -->
    <aside class="lista-sugestoes">
    <!-- Formulário de envio -->
    <form method="POST" action="" style="margin-bottom: 20px;">
        <input type="text" name="nome" placeholder="Seu nome" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
        <textarea name="sugestao" placeholder="Digite sua sugestão..." required style="width: 100%; padding: 8px; height: 100px;"></textarea>
        <button type="submit" name="enviarSugestao" style="margin-top: 10px; padding: 8px 12px;">Enviar Sugestão</button>
    </form>

    <h2>Erros, Sugestões e Melhorias</h2>
    <form method="GET" style="margin-bottom: 15px;">
    <label for="filtro">Filtrar por:</label>
    <select name="filtro" id="filtro" onchange="this.form.submit()" style="margin-left: 10px;">
        <option value="todas" <?= ($_GET['filtro'] ?? '') === 'todas' ? 'selected' : '' ?>>Todas</option>
        <option value="pendentes" <?= ($_GET['filtro'] ?? '') === 'pendentes' ? 'selected' : '' ?>>Pendentes</option>
        <option value="resolvidas" <?= ($_GET['filtro'] ?? '') === 'resolvidas' ? 'selected' : '' ?>>Resolvidas</option>
    </select>
</form>


    <?php
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
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
    
    $resultSugestoes = $conn->query($sqlSugestoes);
    
    if ($resultSugestoes->num_rows > 0) {
        while ($sug = $resultSugestoes->fetch_assoc()) {
            $classe = $sug['resolvido'] ? 'resolvida' : 'pendente';
            echo "<div class='sugestao-box $classe'>";
            echo "<strong>" . htmlspecialchars($sug['nome']) . ":</strong> ";
            echo "<p>" . nl2br(htmlspecialchars($sug['sugestao'])) . "</p>";
            echo "<small>Enviado em: " . $sug['data_envio'] . "</small>";
    
            // Formulário de atualização
            if (!$sug['resolvido']) {
                echo "<form method='POST' action='marcar_resolvido.php' style='margin-top:10px;'>";
                echo "<input type='hidden' name='id' value='" . $sug['id'] . "'>";
                echo "<label style='display:block; margin-top:5px;'>
                        <input type='checkbox' name='resolvido' value='1'>
                        Marcar como Resolvido
                      </label>";
                echo "<textarea name='observacao' placeholder='Observação do admin...' style='width: 100%; margin-top: 5px;'>" . htmlspecialchars($sug['observacao']) . "</textarea>";
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
    
    $conn->close();
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