<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /projeto_integrador/login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>stockhub</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include __DIR__ . '/includes/header.php'; ?>
    <h1>Gestão de Estoque</h1>
    <h2>Seja bem-vindo</h2>
    <p>Esse sistema serve para gestão de Estoque</p>
    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>

</html>