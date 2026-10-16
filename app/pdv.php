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
    <title>Document</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>Seja bem-vindo a página de CADASTROS: </h1>
    <h2>Escolha o que você quer: </h2>
    <a href="/projeto_integrador/app/venda.php"> Realizar venda</a> <br>
    <a href="/projeto_integrador/app/select_vendas.php"> Vendas realizadas</a> <br>

</body>

</html>