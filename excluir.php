<?php
// Conectar ao banco de dados
require_once 'config.php'; // faltava ponto e vírgula aqui!

if (isset($_POST['id']) && isset($_POST['imagem'])) {
    $id = $_POST['id'];
    $imagem = $_POST['imagem'];

    try {
        // Primeiro: buscar nome da imagem pelo ID (garantia extra)
        $stmt = $conn->prepare("SELECT imagem FROM uploads WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['imagem'])) {
            $caminhoArquivo = __DIR__ . '/uploads/' . $row['imagem'];

            if (file_exists($caminhoArquivo)) {
                if (!unlink($caminhoArquivo)) {
                    echo "Erro ao excluir o arquivo.<br>";
                }
            }
        }

        // Agora sim: excluir o registro no banco
        $stmt = $conn->prepare("DELETE FROM uploads WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: lista.php");
            exit();
        } else {
            echo "Erro ao excluir os dados.";
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

} else {
    echo "Dados inválidos.";
}
?>
