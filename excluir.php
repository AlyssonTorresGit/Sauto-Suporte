<?php
// Conectar ao banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db = "upload_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if (isset($_POST['id']) && isset($_POST['imagem'])) {
    $id = $_POST['id'];
    $imagem = $_POST['imagem'];

    // Buscar o nome da imagem no banco (garantia extra)
    $sql = "SELECT imagem FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagem);
    $stmt->fetch();
    $stmt->close();

    // Se houver imagem e ela existir fisicamente, exclui
    if (!empty($imagem)) {
        $caminhoArquivo = __DIR__ . '/uploads/' . $imagem;

        if (file_exists($caminhoArquivo)) {
            if (!unlink($caminhoArquivo)) {
                echo "Erro ao excluir o arquivo.<br>";
            }
        }
    }

    // Agora sim: exclui o registro do banco independentemente de ter imagem ou não
    $sql = "DELETE FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao excluir os dados.";
    }

    $stmt->close();
} else {
    echo "Dados inválidos.";
}

$conn->close();
?>