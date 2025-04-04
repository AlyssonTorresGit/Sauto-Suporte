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

// Verifica se os dados foram recebidos corretamente
if (isset($_POST['id']) && isset($_POST['imagem'])) {
    $id = $_POST['id'];
    $imagem = $_POST['imagem'];

    // Buscar o nome da imagem no banco de dados
    $sql = "SELECT imagem FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($imagem);
    $stmt->fetch();
    $stmt->close();

    if ($imagem) {
        // Definir o caminho da pasta de uploads dentro do htdocs
        $caminhoArquivo = __DIR__ .'/'. $imagem;
        

        // Verifica se o arquivo existe e tenta excluir
        if (file_exists($caminhoArquivo)) {
            if (unlink($caminhoArquivo)) {
                echo "Arquivo excluído com sucesso!<br>";
            } else {
                echo "Erro ao excluir o arquivo.<br>";
            }
        } else {
            echo "Arquivo não encontrado.<br>";
        }

    // // Caminho completo da imagem
    
    // $caminhoArquivo = __DIR__ . "/uploads/".$imagem;

    // // Verifica se o arquivo existe e o exclui
    // if (file_exists($caminhoArquivo)) {
    //     unlink($caminhoArquivo);
     //}

    // Deletar os dados do banco de dados
    $sql = "DELETE FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona para a lista após a exclusão
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao excluir os dados.";
    }

    $stmt->close();}
} else {
    echo "Dados inválidos.";
}

$conn->close();
?>