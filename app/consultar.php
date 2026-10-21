<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>Seja bem-vindo a página de CONSULTAS: </h1>
    <h2>Escolha o que você quer: </h2>
    <a href="select_W.php">Consultar Produtos</a> <br>
    <a href="consultar_cliente.php">Consultar Clientes</a> <br>
    <a href="consultar_vendedor.php">Consultar Vendedor</a> <br>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>