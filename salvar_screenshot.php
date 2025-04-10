<?php
if (isset($_FILES['screenshot'])) {
    $pasta = "imagens/temp/";
    if (!file_exists($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nome = "screenshot_" . time() . ".png";
    $caminho = $pasta . $nome;

    if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $caminho)) {
        echo "http://sauto-suporte/detalhes.php/$caminho"; // <-- coloque o link completo pro seu site
    } else {
        http_response_code(500);
        echo "Erro ao salvar a imagem.";
    }
}
?>