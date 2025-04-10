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
    $suporte = $conn->real_escape_string($_POST['suporte'] ?? 'Anônimo');
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $resolucao = $conn->real_escape_string($_POST['resolucao']);
    $status = (int)($_POST['status'] ?? 0);

    $caminhoImagem = ""; // valor padrão se não enviar imagem
    $nomeImagemcompleto = ""; 


    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== 4) {
        // Verifica se não deu erro
        if ($_FILES['imagem']['error'] === 0) {
            $pasta = "uploads/";
            $nomeImagem = time() . "_" . substr(md5(uniqid()), 0 , 9);
           
            $extencao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $caminhoImagem = $pasta . $nomeImagem. '.'.$extencao;
            $nomeImagemcompleto = $nomeImagem. '.'.$extencao;

            if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoImagem)) {
                echo "Erro ao enviar o arquivo.";
                exit;
            }
        } else {
            echo "Erro ao enviar o arquivo.";
            exit;
        }
    }

    $sql = "INSERT INTO uploads (suporte, titulo, descricao, imagem, resolucao, status) 
            VALUES ('$suporte', '$titulo', '$descricao', '$nomeImagemcompleto', '$resolucao', $status)";

    if ($conn->query($sql) === TRUE) { 
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}

$conn->close();
?>






<!-- <?php
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
    $status = (int)($_POST['status'] ?? 0); // Captura o valor do select (0 ou 1)

    $imagem = $_FILES['imagem']; 
    $pasta = "uploads/";
    $nomeImagem = time() . "_" . basename($imagem["name"]);
    $caminhoImagem = $pasta . $nomeImagem;

    if (move_uploaded_file($imagem["tmp_name"], $caminhoImagem)) {
        $sql = "INSERT INTO uploads (suporte, titulo, descricao, imagem, resolucao, status) 
                VALUES ('$suporte', '$titulo', '$descricao', '$caminhoImagem', '$resolucao', $status)";
        
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
?> -->