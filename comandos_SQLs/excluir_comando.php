<?php
require '../config.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql = "DELETE FROM comandos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}

header("Location: comandos.php");
exit;
?>
