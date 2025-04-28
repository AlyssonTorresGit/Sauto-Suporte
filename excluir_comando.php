<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM comandos_sqls WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: ' . $base_url . 'lista_comandos.php?sucesso=excluido');
        exit;
    }
}

header('Location: ' . $base_url . 'lista_comandos.php');
exit;
?>
