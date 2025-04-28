<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $suporte = $_POST['suporte'] ?? 'Anônimo';
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $resolucao = $_POST['resolucao'] ?? '';
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 0;

    $caminhoImagem = "";
    $nomeImagemcompleto = "";

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== 4) {
        if ($_FILES['imagem']['error'] === 0) {
            $pasta = "uploads/";
            $nomeImagem = time() . "_" . substr(md5(uniqid()), 0, 9);
            $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
            $nomeImagemcompleto = $nomeImagem . '.' . $extensao;
            $caminhoImagem = $pasta . $nomeImagemcompleto;

            if (!move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoImagem)) {
                echo "Erro ao enviar o arquivo.";
                exit;
            }
        } else {
            echo "Erro ao enviar o arquivo.";
            exit;
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO uploads (suporte, titulo, descricao, imagem, resolucao, status)
                                VALUES (:suporte, :titulo, :descricao, :imagem, :resolucao, :status)");
        $stmt->bindParam(':suporte', $suporte);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':imagem', $nomeImagemcompleto);
        $stmt->bindParam(':resolucao', $resolucao);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

        header("Location: lista.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao inserir: " . $e->getMessage();
    }
}
?>
