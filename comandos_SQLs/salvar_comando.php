<?php
require '../config.php';

if (isset($_POST['titulo']) && isset($_POST['suporte'])) {
    $titulo = trim($_POST['titulo']);
    $suporte = trim($_POST['suporte']);

    if (!empty($titulo) && !empty($suporte)) {
        $sql = "INSERT INTO comandos (titulo, suporte) VALUES (:titulo, :suporte)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':suporte' => $suporte
        ]);
    }
}

header("Location: comandos.php");
exit;
?>
