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
  <link rel="stylesheet" href="lista.css">
  <style>
   
  </style>
</head>
<body>

  <h1 class="pesquisa">Base de Conhecimento - Sauto Suporte</h1>
  <h2 class="pesquisa">Pesquisar Erros</h2>
  <form class="lista" method="GET">
    <input class="campo-pesquisa" type="text" name="query" placeholder="Digite sua pesquisa">
    <button class="btn-consultar" type="submit">Consultar</button>
    <a class="btn-inclur" href="upload.html">Incluir
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
                 echo "<img src='" . $row['imagem'] . "' alt='Miniatura'>";
                echo "<div class='info'>";
                echo "<h3>" . htmlspecialchars($row['titulo']) . "</h3>";

                // Tag de resolvido ou não
                $status = $row['resolvido'] ? "<span class='tag-resolvido'>Resolvido</span>" : "<span class='tag-pendente'>Não Resolvido</span>";

                echo $status;

                // Botão para resolver (leva ao editar.php)
                echo "<div class='acoes'>";
                echo "<a class='btn-resolver' href='editar.php?id=" . $row['id'] . "'>Resolver</a>";
                echo "</div>";

                echo "</div>";
                echo "</div>";
            }
            }
             else {
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