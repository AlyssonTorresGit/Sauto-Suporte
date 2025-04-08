<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escapando os dados do formulário
    $suporte = $conn->real_escape_string($_POST['suporte'] ?? 'Anônimo');
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $resolucao = $conn->real_escape_string($_POST['resolucao']);

    $imagem = $_FILES['imagem'];
    $pasta = "uploads/";
    $nomeImagem = time() . "_" . basename($imagem["name"]);
    $caminhoImagem = $pasta . $nomeImagem;

    if (move_uploaded_file($imagem["tmp_name"], $caminhoImagem)) {
        $sql = "INSERT INTO uploads (suporte, titulo, descricao, imagem, resolucao) 
                VALUES ('$suporte', '$titulo', '$descricao', '$caminhoImagem', '$resolucao')";
        
        if ($conn->query($sql) === TRUE) { 
            header("Location: lista.php");
            exit();
        } else {
            echo "Erro: " . $conn->error;
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}

$conn->close();
?>