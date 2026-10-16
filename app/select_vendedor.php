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
    <title>Relatorio Vendedor</title>
</head>
<body>
    <?php include __DIR__ .'/../includes/header.php';?>
    <main>
        <h1>Vendedores cadastrados no sistema.</h1>
        <?php 
        relatorio_vendedor($conexao);
        ?>
    </main>
    <?php include __DIR__ .'/../includes/footer.php';?>
</body>
</html>