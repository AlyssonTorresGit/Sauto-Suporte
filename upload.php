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
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];
    $resolucao = $_POST['resolucao'];

    $pasta = "uploads/";
    $nomeImagem = time() . "_" . basename($imagem["name"]);
    $caminhoImagem = $pasta . $nomeImagem;

    if (move_uploaded_file($imagem["tmp_name"], $caminhoImagem)) {
        $sql = "INSERT INTO uploads (titulo, descricao, imagem, resolucao) VALUES ('$titulo', '$descricao', '$caminhoImagem', '$resolucao')";
        
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