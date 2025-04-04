<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sauto Suporte</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="lista.css">
</head>
<body>
    <main class="erros">
        <h1 class="h1-pesquisa">Bibliotéca de erros - Sauto Suporte</h1>
        <h2 class="h2-pesquisa">Pesquisar Erros</h2>
        <form class="lista" method="GET">
            <input class="campo-pesquisa" type="text" name="query" placeholder="Digite sua pesquisa">
            <button class="destaque-btn btn-QSaoImagens btn-consultar" type="submit">
                <img src="imagens-icones/consultar.JPG" alt="consultar">
            </button>
            <a class="destaque-btn btn-QSaoImagens btn-inclur" href="upload.html">
                <img src="imagens-icones/incluir.JPG" alt="incluir">
            </a>
        </form>
    

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
        // Verifica se há uma pesquisa
        $query = $_GET['query'] ?? null; 
        if(isset($query)){
            $sql = "SELECT * FROM uploads WHERE titulo LIKE '%$query%' OR descricao LIKE '%$query%' ORDER BY id DESC";
        }else{
            $sql = "SELECT * FROM uploads ORDER BY id DESC";
        }
        $result = $conn->query($sql);
        // Exibir os resultados    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                echo "<div class='blocoLista'>";
                echo "<h3 class='tiltulo-lista'>" . $row['titulo'] . "</h3>";
                echo "<p>" . $row['descricao'] . "</p>";
                
                echo "<div class='divImagemView'>";
                echo "<img class='imagem img-preview' src='" . $row['imagem'] . "' width='200'>";
                echo "</div>";
                
                
                echo "<p>" . $row['resolucao'] . "</p>";

            // Formulário para excluir o registro
                echo "<form class='formEditarExcluir' method='POST' action='excluir.php' onsubmit='return confirmarExclusao();'>";
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<input type='hidden' name='imagem' value='" . $row['imagem'] . "'>";
                echo '<div class="container">';
                echo "<a href='editar.php?id=" . $row['id'] . "' class='destaque-btn btn-QSaoImagens btn btn-editar'>";
                echo "<img src='imagens-icones/alterar.JPG' alt='Alterar'>";
                echo "</a>";
                
                echo "<button type='submit' class='destaque-btn btn-QSaoImagens btn btn-excluir'>";
                echo "<img src='imagens-icones/excluir.JPG' alt='Excluir'>";
                echo "</button>";
                echo '</div>';
                echo "</form>";
                echo "</div>";
                
            }
        } else {
            echo "Nenhum resultado encontrado.";
        }

        $conn->close();
        ?>
    </div> 
    </main>
    <!-- corfirmar se realmente quer excluir os dados-->
    <script>
        function confirmarExclusao() {
            return confirm("Tem certeza que deseja excluir este item?");
        }
    </script>
</body>
</html>